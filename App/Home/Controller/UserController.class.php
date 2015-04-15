<?php
namespace Home\Controller;
use Think\Controller;
header('Content-type: text/html; charset=utf-8');
include_once(dirname(__FILE__)."/BaseController.class.php");
class UserController extends BaseController {
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
        //$Verify->codeSet = '0123456789'; 
        $Verify->useImgBg = true; 
        $Verify->imageW = 130;  
        $Verify->imageH = 50;  
        //$Verify->expire = 600;  
        $Verify->entry();  
    }
    /*
    *判断验证码输入是否正确
    */
    public function check_verify($code, $id = ""){  
        $verify = new \Think\Verify();  
        return $verify->check($code, $id);  
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
              echo '{
                      "info":"手机号码已存在",
                      "status":"n"
                    }';
              exit();
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
	*用户注册
	*/
    public function user_register(){
        if ($_POST['submit']) {
            $nickname = I('post.nickname');
            $mobile   = I('post.mobile');
            $pswd     = I('post.pswd');
            $verify    = I('param.verify','');
            if ($mobile == "") {
                $this->error("手机号码不能为空！");
            }
            if ($pswd == "") {
                $this->error("密码不能为空！");
            }
            //验证码
            if(!$this->check_verify($verify)){  
                $this->error("亲，验证码输错了哦！",$this->site_url,5);  
            } 
            $content = array(
                'nickname' => urlencode($nickname),
                'mobile'   => $mobile,
                'pswd'     => $pswd,
                );
            $result = $this->_call('User.register',
                                  $content);
            if (200 == $result['status_code']) {
                if (0 == $result['content']['is_success']) {
                    $this->success("注册成功！");
                }
                else if (-1 == $result['content']['is_success']) {
                    $this->error("注册失败！");
                }
                else if (-2 == $result['content']['is_success']) {
                    $this->error("手机号码已存在！");
                }
            }else{
                $this->error("注册失败！");
            }
        }
        $this->display();
    }
    /*
	*验证码
	*/
    public function find_password(){
        $result = $this->_call('User.get_pic_validate',
                                $content);
        $this->assign('yzm',$result['content']);
        $this->display();
    }
    /*
    *密码找回
    */
    public function modify_password(){
        $this->display();
    }
    /*
    *用户中心
    */
    public function user_center(){
        $user_id = I('get.d');
        $content = array(
            'uid' => $user_id
            );
        $result = $this->_call('User.get_info',
                                   $content);
        if(200 == $result['status_code'])
        {
            $us_list = $result['content'];
            $this->assign('us_list', $us_list);
        }
        $this->display();
    }
}