<?php
namespace Home\Controller;
use Think\Controller;
header('Content-type: text/html; charset=utf-8');
include_once(dirname(__FILE__)."/BaseController.class.php");
class AboutController extends BaseController {
	//关于我们
    public function about_us(){
    	//用户登录返回信息
        $this->_login();

        //曝光平台总数
        $content_dt["where"]['add_blk_amount'] = array('neq',0);
        $result_num = $this->_call('Inexposal.dynamic',
                               $content_dt);
        if (200 == $result_num['status_code']) {
            $record_count = $result_num['content']['flat_form_count'];
            $this->assign('record_count',$record_count);
        }
        $result1 = $this->_call('Company.get_list',
                                $content1);
        if (200 == $result1['status_code']) {
            $w_list = $result1['content']['record_count'];
            $this->assign('w_list',$w_list);
        }
        $time = date('Y-m-d',time());
        $this->assign('time',$time);
        $this->display();
    }
    //联系我们
    public function contact_us(){
    	//用户登录返回信息
        $this->_login();

        $this->display();
    }
    //帮助中心
    public function help_center(){
    	//用户登录返回信息
        $this->_login();
        
        $result1 = $this->_call('Company.get_list',
                                $content1);
        if (200 == $result1['status_code']) {
            $w_list = $result1['content']['record_count'];
            $this->assign('w_list',$w_list);
        }
        $this->display();
    }

    //意见反馈
    public function feedback(){
        //用户登录返回信息
        $this->_login();

        if ($this->is_mobile()) {
            $this->display("feedback_wap");
        }else{
            $this->display();
        }
        
    }
    //意见反馈信息添加
    public function feedback_ex(){
        //意见反馈信息添加
        $content = str_replace(PHP_EOL, '', I('post.content'));
        $pic     = $_FILES['pic']['tmp_name'];
        $contact = I('post.contact');
        $userip  = get_client_ip();
        if ($content == "") {
            echo 6;
            exit();
        }else if (strlen($content) >200) {
            echo 7;
            exit();
        }
        if ($contact =="") {
            echo 8;
            exit();
        }
        //用户照片的上传
        if (!empty($pic)) {
            $fp  = fopen($pic, "rb");
            $fpp = $_FILES['pic']['size'];
            if ($fpp > 409600) {
                echo 4;
                exit();
            }
            $buf = fread($fp, $fpp);
            fclose($fp);
            $filename = $_FILES['pic']["tmp_name"];
            $result = $this->_call('Media.upload', 
                                   array(
                                      'file_name'=>$filename,  #文件名称
                                      'buf'      =>$buf,       #要上传的二进制数据
                                      'file_ext' =>'jpg',      #图片后缀
                                      'module_sn'=>'001010',   #意见反馈图片
                                      ),
                                   'resource',
                                   $fp);
            if($result)
            {
                if(200 == $result['status_code'])
                {
                    if(0 == $result['content']['is_success']){
                        $pic = $result['content']['id'];
                    }else if (-1 == $result['content']['is_success']) {
                        echo 1;
                        exit();
                    }else if (-2 == $result['content']['is_success']) {
                        echo 2;
                        exit();
                    }else if (-3 == $result['content']['is_success']) {
                        echo 3;
                        exit();
                    }else if (-4 == $result['content']['is_success']) {
                        echo 4;
                        exit();
                    }else if (-5 == $result['content']['is_success']) {
                        echo 5;
                        exit();
                    }
                }else{
                    $this->error("图片上传失败");
                    exit();
                }
            }
        }else{
            $pic = 0;
        }
        $content = array(
                'content' => urlencode($content),
                'pic'     => $pic,
                'contact' => $contact,
                'userip'  => $userip
                );
        $result = $this->_call('Ideaback.add',
                                   $content);
        if(200 == $result['status_code']
        &&  0  == $result['content']['is_success'])
        {
            echo 0;
            exit(); 
        }
        else
        {
            echo -1;
            exit();
        }
    }
}