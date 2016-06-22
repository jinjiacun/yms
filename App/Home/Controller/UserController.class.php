<?php
namespace Home\Controller;
use Think\Controller;
use Org\ThinkSDK\ThinkOauth;
header('Content-type: text/html; charset=utf-8');
include_once(dirname(__FILE__)."/BaseController.class.php");
class UserController extends BaseController {
    /*
    *第三方登陆
    */
    //登录地址
    public function log_oauth($type = null){

      //保存当前页面的url
      $_SESSION['present_url'] = $_GET['url'];

      empty($type) && $this->error('参数错误');

      //加载ThinkOauth类并实例化一个对象
      //import("ORG.ThinkSDK.ThinkOauth");
      $sns  = ThinkOauth::getInstance($type);

      //跳转到授权页面
      redirect($sns->getRequestCodeURL($type));
    }

    //授权回调地址
    public function callback($type = null, $code = null){
      
      if (I('get.error_code') == '21330') {
        echo "<script>alert('您取消了第三方登录!');location.href='http://www.koubei365.com.cn';</script>";
        exit();
      }
      (empty($type) || empty($code)) && $this->error('参数错误');
      
      //加载ThinkOauth类并实例化一个对象
      //import("ORG.ThinkSDK.ThinkOauth");
      $sns  = ThinkOauth::getInstance($type);

      //腾讯微博需传递的额外参数
      $extend = null;
      if($type == 'tencent'){
        $extend = array('openid' => $this->_get('openid'), 'openkey' => $this->_get('openkey'));
      }

      //请妥善保管这里获取到的Token信息，方便以后API调用
      //调用方法，实例化SDK对象的时候直接作为构造函数的第二个参数传入
      //如： $qq = ThinkOauth::getInstance('qq', $token);

      $token = $sns->getAccessToken($code , $extend, $type);
      //获取当前登录用户信息
      if(is_array($token)){
        $user_info = A('Type', 'Event')->$type($token);
         
        $openid = $token['openid'];
        $type   = $user_info['type'];
        // $nick   = $user_info['nick'];
        // $head   = $user_info['head'];

        //检查用户的openid是否绑定
        if ($type == "SINA") {
            $content = array(
              'logintype' => 6,
              'loginname' => $openid
              );
        }else if($type == "QQ"){
            $content = array(
              'logintype' => 5,
              'loginname' => $openid
              );  
        }else{
            $content = array(
              'logintype' => 4,
              'loginname' => $openid
              );
        }
        $result = $this->_call('User.check_loginname',
                                $content);
        if (200 == $result['status_code']) {
            if (0 == $result['content']['is_exists']) {
                //用户账号已绑定，直接登录
                $userip   = get_client_ip();
                $content_ex = array(
                  'userip' => $userip,
                  'openid' => $openid
                  );
                //微博登陆
                if ($type == "SINA") {
                    $result_ex = $this->_call('User.login_weibo',$content_ex);
                }else if($type == "QQ"){
                //QQ登录
                    $result_ex = $this->_call('User.login_qq',$content_ex);
                }else{
                    $result_ex = $this->_call('User.login_weixin',$content_ex);
                }
                if (200 == $result_ex['status_code']) {
                  if (0 == $result_ex['content']['is_success']) {
                    //登录成功保存用户的nickname和user_id
                    $_SESSION['nickname'] = $result_ex['content']['nickname'];
                    $_SESSION['user_id']  = $result_ex['content']['user_id'];
                    if (session('present_url')) {
                      echo "<script>location.href='".session('present_url')."';</script>";
                    }else{
                      $this->redirect("/Index");
                    }
                    session('present_url',null);
                    exit();
                  }else if (-1 == $result_ex['content']['is_success']) {
                    $this->error("登录失败!");
                    exit();
                  }else if (-2 == $result_ex['content']['is_success']) {
                    $this->error("OpenId参数不合法!");
                    exit();
                  }else if (-3 == $result_ex['content']['is_success']) {
                    $this->error("OpenId不存在或密码错误!");
                    exit();
                  }else if (-4 == $result_ex['content']['is_success']) {
                    $this->error("用户被限制登录!");
                    exit();
                  }else if (-5 == $result_ex['content']['is_success']) {
                    $this->error("用户访问的IP被限制!");
                    exit();
                  }else if (-6 == $result_ex['content']['is_success']) {
                    $this->error("接口报错!");
                    exit();
                  }else if (-100 == $result_ex['content']['is_success']) {
                    $this->error("输入的参数存在空值!");
                    exit();
                  }
                }
            }else if (-1 == $result['content']['is_exists']) {
                //用户未绑定，保存用户的信息到session
                $_SESSION['token'] = $token;
                $_SESSION['user_info']  = $user_info; 
                //跳转到绑定页面
                //$this->redirect("user_binding");
                $this->skip();
            }else if (-2 == $result['content']['is_exists']) {
                $this->error("loginname参数不合法!");
                exit();
            }else if (-3 == $result['content']['is_exists']) {
                $this->error("safekey参数不合法!");
                exit();
            }
        }
      }
    }
    //用户绑定界面
    public function user_binding(){
      
      //获取用户的信息
      $token = session('token');
      $user_info = session('user_info');
      if ($user_info['type'] == "SINA") {
            $content = array(
              'logintype' => 6,
              'loginname' => $token['openid']
              );
      }else if($user_info['type'] == "QQ"){
          $content = array(
            'logintype' => 5,
            'loginname' => $token['openid']
            );  
      }else{
          $content = array(
            'logintype' => 4,
            'loginname' => $token['openid']
            );
      }
      $result = $this->_call('User.check_loginname',
                              $content);
      if (200 == $result['status_code']) {
          if (0 == $result['content']['is_exists']) {
            $this->redirect("/Index");
          }else{
            $this->assign('token',$token);
            $this->assign('user_info',$user_info);
            $this->display();
          }
      }
    }
    /*
    *绑定页面获取用户的信息
    */
    public function user_binding_ex(){
      
      //获取用户的信息
      $token = session('token');
      $user_info = session('user_info');
      
      //第三方用户信息和用户的账号绑定
      $openid     = I('post.openid');
      $mobile     = I('post.mobile');
      $passwd     = I('post.pswd');
      $nickname   = I('post.nickname');
      $head_photo = I('post.head_photo');
      $type       = I('post.type');
      if ($mobile == "") {
        echo 1;
        exit();
      }
      if ($passwd == "") {
        echo 2;
        exit();
      }else if (strlen($passwd) < 6) {
        echo 3;
        exit();
      }else if (strlen($passwd) > 16) {
        echo 4;
        exit();
      }
      $content = array(
        'openid'     => $openid,
        'mobile'     => $mobile,
        'passwd'     => $passwd,
        'nickname'   => urlencode($nickname),
        'head_photo' => $head_photo
        );
      if ($type == 'SINA') {
        $result = $this->_call('User.entry_weibo',$content);
      }else if($type == 'QQ'){
        $result = $this->_call('User.entry_qq',$content);
      }else{
        $result = $this->_call('User.entry_weixin',$content);
      }
      if (200 == $result['status_code']) {
        if (0 == $result['content']['is_success']) {
          //登录成功保存用户的nickname和user_id
          $_SESSION['nickname'] = $result['content']['nickname'];
          $_SESSION['user_id']  = $result['content']['user_id'];
          echo 0;
          exit();
        }else if(-1 == $result['content']['is_success']){
          echo -1;
          exit();
        }else if (-2 == $result['content']['is_success']) {
          echo -2;
          exit();
        }
      }
    }
    //跳过绑定
    public function skip(){
       //获取用户的信息
      $token = session('token');
      $user_info = session('user_info');

      //第三方用户信息和用户的账号绑定
      $openid     = $token['openid'];
      $nickname   = $user_info['nick'];
      $head_photo = $user_info['head'];
      $type       = $user_info['type'];
      $content = array(
        'openid'     => $openid,
        'nickname'   => urlencode($nickname),
        'head_photo' => $head_photo
        );
      if ($type == 'SINA') {
        $result = $this->_call('User.entry_weibo',$content);
      }else if($type == 'QQ'){
        $result = $this->_call('User.entry_qq',$content);
      }else{
        $result = $this->_call('User.entry_weixin',$content);
      }
      if (200 == $result['status_code']) {
        if (0 == $result['content']['is_success']) {
          //登录成功保存用户的nickname和user_id
          $_SESSION['nickname'] = $result['content']['nickname'];
          $_SESSION['user_id']  = $result['content']['user_id'];
          $this->redirect("/Index");
          exit();
        }else if(-1 == $result['content']['is_success']){
          $this->error('操作失败！');
          exit();
        }else if (-2 == $result['content']['is_success']) {
          $this->error('密码错误！');
          exit();
        }
      }
    }
    /**
    *手机wap登录页面
    */
    public function login_wap(){
      $this->display();
    }
    /**
    *登录
    */
    public function login(){
        $mobile   = I('post.mobile');
        $password = I('post.password');
        $userip   = get_client_ip();
        $content = array(
            'mobile' => $mobile,
            'pswd'   => $password,
            'userip' => $userip
            );
        $result = $this->_call('User.login',
                                $content);
        if (200 == $result['status_code']) {
            if (0 == $result['content']['is_success']) {
                $_SESSION['nickname'] = $result['content']['nickname'];
                $_SESSION['user_id']  = $result['content']['user_id'];
                //session('tmpe',null);
                echo 0;
                exit();
            }elseif (-1 == $result['content']['is_success']) {
                echo -1;
                exit();
            }elseif (-2 == $result['content']['is_success']) {
                echo -2;
                exit();
            }elseif (-3 == $result['content']['is_success']) {
                echo -3;
                exit();
            }elseif (-4 == $result['content']['is_success']) {
                echo -4;
                exit();
            }
        }
    }
    /*
    *退出登录
    */
    public function logout(){
        $_SESSION = array(); //清除SESSION值.
        if(isset($_COOKIE[session_name()])){  //判断客户端的cookie文件是否存在,存在的话将其设置为过期.
                setcookie(session_name(),'',time()-1,'/');
        }
        session_destroy();  //清除服务器的sesion文件
        $this->redirect('/Index');
    }
    /** 
     *  
     * 验证码生成 
     */  
    public function verify_c()
    {  
        $Verify = new \Think\Verify();  
        $Verify->fontSize = 18;  
        $Verify->length   = 4;  
        $Verify->useNoise = false;  
        $Verify->codeSet = '0123456789'; 
        $Verify->useImgBg = false; 
        $Verify->useCurve = false; 
        $Verify->imageW = 130;  
        $Verify->imageH = 50;  
        $Verify->expire = 600;  
        $code = $Verify->entry();  
        file_put_contents("./session.code", $code);
    }
    /*
    *判断验证码输入是否正确
    */
    public function check_verify($code, $id = ""){  
        $verify = new \Think\Verify();  
        return $verify->check($code, $id);  
    }
    /*
    *动态判断验证码
    */

    public function check_verify_ex(){
        $verify   = I('param.param','');
        
        //验证码
        if(!$this->check_verify($verify)){  
            echo '{
                    "info":"验证码错误",
                    "status":"n"
                  }';
            exit();  
        }else{
            echo '{
                    "info":"验证码正确",
                    "status":"y"
                  }';
            exit();
        }
    }
    /*
    *验证手机
    */
    public function check_mobile(){
        $mobile = I('post.param');
        $content = array('mobile'=>$mobile);
        $res_mobile = $this->_call('User.check_mobile',
                                    $content);
        if (200 == $res_mobile['status_code'])
        {
           if (0 == $res_mobile['content']['is_exists']) {
              if(I('post.ex'))
              {
                echo 1;
                exit();
              } 
              else
              {
                echo '{
                      "info":"手机号码已存在",
                      "status":"n"
                    }';
                exit();
              }
           }else{
              echo '{
                      "info":"可以注册",
                      "status":"y"
                    }';
              exit();
           }
        }
        echo '{
                "info":"手机号码已存在",
                "status":"n"
              }';
    }
    /*
    *验证手机
    */
    public function check_mobile_ex(){
        $mobile = I('post.param');
        $content = array('mobile'=>$mobile);
        $res_mobile = $this->_call('User.check_mobile',
                                    $content);
        if (200 == $res_mobile['status_code'])
        {
           if (0 == $res_mobile['content']['is_exists']) {
              echo '{
                      "info":"手机号码存在",
                      "status":"y"
                    }';
              exit();
           }else{
              echo '{
                      "info":"请输入正确的手机号码",
                      "status":"n"
                    }';
              exit();
           }
        }
   }
	/*
	*用户注册
	*/
    public function user_register(){
        if ($_POST['submit']) {
            $nickname = I('post.nickname');
            $mobile   = I('post.mobile');
            $pswd     = I('post.pswd');
            $verify   = I('post.verify');
            $url      = "";
            $preurl   = $_SESSION['HTTP_REFERER'];
            $agent    = $_SERVER['HTTP_USER_AGENT'];
            $screen   = $_COOKIE['screen'];
            $remark   = "";
            if ($mobile == "") {
                if(I('post.ex'))
                {
                  echo -1;
                  exit();
                }
                else
                {
                  $this->error("手机号码不能为空！");
                  exit();  
                }
            }
            if ($pswd == "") {
                if(I('post.ex'))
                {
                  echo -2;
                  exit();
                }
                else
                {
                  $this->error("密码不能为空！");
                  exit();
                }
            }
            //验证码
            if ($verify == "") {
                if(I('post.ex'))
                {
                  echo -3;
                  exit();
                } 
                else
                {
                  $this->error('验证码不能为空！');
                  exit();
                }
            }
            //$t = $this->check_verify($verify);
            //echo json_encode($t);
            //exit();
            if(I('post.ex'))
            {
              if(!$this->check_verify($verify)){  
                 if(I('post.ex'))
                 {
                  //echo -4;
                  //echo 
                  //exit();
                 }
                 else
                 {
                  $this->error("亲，验证码输错了哦！",$this->site_url); 
                  exit(); 
                 }
             }
            }
            $content = array(
                'nickname' => urlencode($nickname),
                'mobile'   => $mobile,
                'pswd'     => $pswd,
                'url'      => $url,
                'preurl'   => $preurl,
                'agent'    => $agent,
                'screen'   => $screen,
                'remark'   => $remark
                );
            if(I('post.ex'))
            {
              $content['sem'] = 1;
            }
            $result = $this->_call('User.register',
                                  $content);
            if (200 == $result['status_code']) {
                if (0 == $result['content']['is_success']) {
                    $_SESSION['nickname'] = $result['content']['nickname'];
                    $_SESSION['user_id']  = $result['content']['user_id'];
                    //session('tmpe',null);
                    if(I('post.ex'))
                    {
                      echo 1;
                      exit();
                    }
                    else
                    {
                      header("Location: ../user_center.html");
                      exit();
                    }
                }
                else if (-1 == $result['content']['is_success']) {
                    $this->error("注册失败！");
                    exit();
                }
                else if (-2 == $result['content']['is_success']) {
                    $this->error("手机号码已存在！");
                    exit();
                }
            }else{
                $this->error("注册失败！");
                exit();
            }
        }
        if ($this->is_mobile()) {
          $this->display("user_register_wap");
        }else{
            $this->display();
        }
        
    }
    /*
	*验证码
	*/
    public function find_password(){
        $result = $this->_call('User.get_pic_validate',
                                $content);
        $this->assign('yzm',$result['content']);
        if ($_POST['mobile']) {
      		$mobile = I('post.mobile');
          $imagecode = I('post.imagecode');
          $content_ex = array('mobile'=>$mobile,
                               'imagecode'=>$imagecode);
          $result_ex = $this->_call('User.send_validate',$content_ex);
          if (200 == $result_ex['status_code'] &&
           0 == $result_ex['content']['is_success']) {
              $_SESSION['mobile'] = $mobile;
              echo 0;
              exit();
          }else{
              echo -1;
              exit();
          }
    		// $_SESSION['mobile'] = $mobile;
    		// echo "<script>location.href='../User/find_password_ex'</script>";
    	}
      if ($this->is_mobile()) {
        $this->display("find_password_wap");
      }else{
        $this->display();
      }
    }
    /*
    *用户注册协议
    */
    public function xieyi(){
      //判断pc或者手机wap
      if($this->is_mobile()){ 
          $this->display("xieyi_wap");
      }else{
          $this->display();
      }
    }
    /*
  	*手机验证
  	*/
    public function find_password_ex(){
        if ($_POST['submit']) {
    		$message_code = I('post.message_code');
    		$_SESSION['message_code'] = $message_code;
    		echo "<script>location.href='../modify_password.html'</script>";
    	}
    	if ($this->is_mobile()) {
        $this->display("find_password_ex_wap");
      }else{
        $this->display();
      }
      
    }
    /*
    *密码找回
    */
    public function modify_password(){
    	$mobile = session('mobile');
    	$message_code = session('message_code');
    	$this->assign('mobile',$mobile);
    	$this->assign('message_code',$message_code);
      if ($this->is_mobile()) {
        $this->display("modify_password_wap");
      }else{
        $this->display("modify_password");
      }
      
    }
    /*
    *用户中心
    */
    public function user_center(){   
      $userid = session('user_id');
      if ($userid) {
        $content = array(
              'uid' => $userid
              );
        $result = $this->_call('User.get_info',
                                   $content);
        if(200 == $result['status_code'])
        {
            $us_list = $result['content'][0];
            $us_mobile = $us_list['UI_LoginNames'];
            if (strlen($us_mobile) == 11) {
              $this->assign('us_mobile',$us_mobile);
            }
            $this->assign('us_list', $us_list);
        }     
        $this->assign('usid', $userid);
        if ($this->is_mobile()) {
          $this->display('user_center_wap');
        }else{
          $this->display();
        }
        
      }else{
        $this->redirect("/Index");
      }
    }
    //我的评论
    public function user_pl(){
      $userid = session('user_id');
      //我的评论
      $content_pl['page_size']  = 20;
      $content_pl['where'] = array(
            'user_id'   => $userid,
            'is_delete' => 0
            );
      $result_pl = $this->_call('Comment.get_list',$content_pl);
      if (200 == $result_pl['status_code']) {
          $pl_list = $result_pl['content']['list'];
          $pl_count = $result_pl['content']['record_count'];
          foreach ($pl_list as $key => $rs) {
                $pl_list[$key]['add_time'] = date('Y-m-d',$rs['add_time']);
                $pl_list[$key]['content'] = $this->cont($rs['content']);
          }
          echo json_encode(array('list'=>$pl_list,'pl_count'=>$pl_count));
          exit();
      }
    }
    //我的曝光
    public function user_bg(){
      $userid = session('user_id');
      //我的曝光
      $content_bg['page_size'] = 20;
      $content_bg['where'] = array(
          'user_id' => $userid
          );
      $content_bg['where_ex'] = array(
          '_string' => 'user_id ='.$userid.' or is_validate = 1'
          );
      $result_bg = $this->_call('Inexposal.get_list_com',$content_bg);
      if (200 == $result_bg['status_code']) {
          $bg_list = $result_bg['content']['list'];
          $bg_count = $result_bg['content']['record_count'];
          foreach ($bg_list as $key => $vl) {
            $bg_list[$key]['add_time'] = date('Y-m-d H:i:s',$vl['add_time']);
            $bg_list[$key]['sub_count'] = $vl['sub']['record_count'];
          }
          echo json_encode(array('list'=>$bg_list,'bg_count'=>$bg_count));
          exit();
      }
    }
    //我的关注
    public function user_gz(){
        $userid = session('user_id');
        //我的关注
        $content_gz['page_size'] = 20;
          $content_gz['where'] = array(
            'user_id' => $userid
            );
        $result_gz = $this->_call('Attention.get_list',$content_gz);
        if (200 == $result_gz['status_code']) {
            $gz_list = $result_gz['content']['list'];
            $gz_count = $result_gz['content']['record_count'];
            foreach ($gz_list as $key => $vl) {
              $gz_list[$key]['add_time'] = date('Y-m-d',$vl['add_time']);
            }
            echo json_encode(array('list'=>$gz_list,'gz_count'=>$gz_count));
            exit();
        }
    }
    //用户信息修改
    public function information_modify(){

       $nickname = I('post.nickname');
       $uid      = session('user_id');
       $sex      = I('post.sex');
       $birthday = I('post.birthday');
       $job      = I('post.job');
       $address  = I('post.address');
       if ($nickname == "") {
         echo 1;
         exit();
       }
       if ($job == "") {
         echo 2;
         exit();
       }
       if ($address == "") {
         echo 3;
         exit();
       }
       if ($birthday == "") {
         echo 4;
         exit();
       }
       $content = array(
       	'nickname'=>urlencode($nickname),
       	'uid'     =>$uid,
       	'sex'     =>$sex,
       	'birthday'=>$birthday,
       	'job'     =>urlencode($job),
       	'address' =>urlencode($address),
       	);
       $result = $this->_call('User.update',
       	                       $content);
       if (200 == $result['status_code'] &&
           0 == $result['content']['is_success']) {
       	$_SESSION['nickname'] = $nickname;
       	echo 0;
       }else{
       	echo -1;
       }
    }
    /*
    *用户密码修改
    */
    public function update_passwd(){
      $uid      = session('user_id');
      $old_pswd = I('post.old_pswd');
      $new_pswd = I('post.new_pswd');
      if ($old_pswd == "") {
        $this->error('原密码不能为空！');
      }
      if ($new_pswd == "") {
        $this->error('新密码不能为空！');
      }
      $content = array(
        'uid'      => $uid,
        'old_pswd' => $old_pswd,
        'new_pswd' => $new_pswd
        );
      $result = $this->_call('User.update_passwd',$content);
      if (200 == $result['status_code']) {
        if (0 == $result['content']['is_success']) {
          $_SESSION = array(); //清除SESSION值.
          if(isset($_COOKIE[session_name()])){ 
                  setcookie(session_name(),'',time()-1,'/');
          }
          session_destroy();
          echo 0;
        }else if (-1 == $result['content']['is_success']) {
          echo -1;
        }else if (-2 == $result['content']['is_success']) {
          echo -2;
        }else if (-3 == $result['content']['is_success']) {
          echo -3;
        }
      }
    }
    /*
    *用户密码修改
    */
    public function update_passwd_wap(){
      $userid = session('user_id');
      if ($userid > 0) {
        $this->display();
      }else{
        $this->redirect("/Index");
      }  
    }
    /*
    *用户信息修改
    */
    public function information_modify_wap(){
      $userid = session('user_id');
      if ($userid) {
        $content = array(
              'uid' => $userid
              );
        $result = $this->_call('User.get_info',
                                   $content);
        if(200 == $result['status_code'])
        {
            $us_list = $result['content'][0];
            $us_mobile = $us_list['UI_LoginNames'];
            if (strlen($us_mobile) == 11) {
              $this->assign('us_mobile',$us_mobile);
            }
            $this->assign('us_list', $us_list);
        }     
        $this->assign('usid', $userid);
        $this->display();
      }else{
        $this->redirect("/Index");
      }
    }
    /*
    *用户头像上传
    */
    public function touxiang(){
        $uid = session('user_id');
        $pic_1 = $_FILES['N']['tmp_name'];
        $safekey = $this->md5_16($uid."|".date('Ymd')."|souhei975427");
        $fp  = fopen($pic_1, "rb");
        $fpp = $_FILES['N']['size'];
        if ($fpp > 102400) {
          echo -5;
          exit();
        }
        $buf = fread($fp, $fpp);
        fclose($fp);
        $filename = "1.jpg";

        //$filename = $content['file_name'];
        $varname  = "imageUpLoad";
        $key      = "$varname\";filename=\"$filename\"\r\nContent-Type:image/jpeg\r\n";
        $handler  = $key;
        $data_arr[$key]     = $buf;
        $data_arr['uid']     = $uid;
        $data_arr['safekey'] = $safekey;
        $data = $data_arr;
        $res  = $this->post(C('user_url'), $data, $header);
        $result = json_decode($res,ture);
        if (1 == $result['State']) {
          echo 1;
          exit();
        }elseif (0 == $result['State']) {
          echo 0;
          exit();
        }elseif (-1 == $result['State']) {
          echo -1;
          exit();
        }elseif (-2 == $result['State']) {
          echo -2;
          exit();
        }elseif (-3 == $result['State']) {
          echo -3;
          exit();
        }elseif (-4 == $result['State']) {
          echo -4;
          exit();
        }elseif(-5 == $result['State'])
        {
          echo -5;
          exit();
        }
    }
    public function md5_16($str){
              return substr(md5($str),8,16);
    }
    function post($url, $params = false, $header = array()){

        //$cookie_file = tempnam(dirname(__FILE__),'cookie');
        //$cookie_file = __PUBLIC__.'cookies.tmp';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_POST, 1); 
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 60); 
        //curl_setopt($ch, CURLOPT_COOKIEJAR, $cookieFile);
        curl_setopt($ch, CURLOPT_COOKIEJAR, $cookie_file); 
        //curl_setopt($ch, CURLOPT_COOKIEFILE,$cookieFile); 
        curl_setopt($ch, CURLOPT_COOKIEFILE,$cookie_file); 
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1); 
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER,FALSE); 
        curl_setopt($ch, CURLOPT_HTTPGET, true); 
        curl_setopt($ch, CURLOPT_TIMEOUT, 30); 
        if($params !== false){
          curl_setopt($ch, CURLOPT_POSTFIELDS , $params);
        } 
        curl_setopt($ch, CURLOPT_USERAGENT,'Mozilla/5.0 (Windows NT 5.1; rv:21.0) Gecko/20100101 Firefox/21.0'); 
        curl_setopt($ch, CURLOPT_URL,$url); 
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header); 
        $result = curl_exec($ch); 
        curl_close($ch); 
         
        return $result; 
    } 
  
}