<?php
namespace Home\Controller;
use Think\Controller;
header('Content-type: text/html; charset=utf-8');
include_once(dirname(__FILE__)."/BaseController.class.php");
class AboutController extends BaseController {
	//关于我们
    public function about_us(){
    	//用户登录返回信息
        $log_result = $this->_call('User.get_login_info',
                                   $content);
        if(200 == $log_result['status_code'] &&
            0 == $log_result['content']['is_success'])
        {
            $userid = $log_result['content']['user_id'];
            $this->assign('login', $log_result['content']);
            $this->assign('userid',$userid);
        }
        print_r($log_result);
        $this->display();
    }
    //联系我们
    public function contact_us(){
    	//用户登录返回信息
        $log_result = $this->_call('User.get_login_info',
                                   $content);
        if(200 == $log_result['status_code'] &&
            0 == $log_result['content']['is_success'])
        {
            $userid = $log_result['content']['user_id'];
            $this->assign('login', $log_result['content']);
            $this->assign('userid',$userid);
        }

        $this->display();
    }
    //帮助中心
    public function help_center(){
    	//用户登录返回信息
        $log_result = $this->_call('User.get_login_info',
                                   $content);
        if(200 == $log_result['status_code'] &&
            0 == $log_result['content']['is_success'])
        {
            $userid = $log_result['content']['user_id'];
            $this->assign('login', $log_result['content']);
            $this->assign('userid',$userid);
        }

        $this->display();
    }
}