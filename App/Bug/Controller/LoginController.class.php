<?php
namespace Home\Controller;
use Think\Controller;
header('Content-type: text/html; charset=utf-8');
include_once(dirname(__FILE__)."/BaseController.class.php");
class LoginController extends BaseController {
    public function index(){
	    $this->display();
    }
    /*
    *登录
    */
    public function login(){
    	$admin_name = I('post.username');
        $admin_name = trim($admin_name);
    	$passwd     = I('post.pwd');
    	if ($admin_name == '') {
    		echo 1;
    		exit();
    	}
    	if ($passwd == '') {
    		echo 2;
    		exit();
    	}
    	$content = array(
    		'admin_name' => urlencode($admin_name),
    		'passwd'     => $passwd
    		);
    	$result = $this->_call('Admin.login',$content);
	if(200 == $result['status_code']){
            if(0 == $result['content']['is_success']){
                $user_id = $result['content']['id'];
                //用户id
                $_SESSION['user_id']  = $user_id;
                //角色id
                $_SESSION['role_id']  = $result['content']['role_id'];
                //部门id
                $_SESSION['part_id']  = $result['content']['part_id'];
                //用户id保存到cookie
                $u_map = $this->grtmap($result['content']['id']);
                $u_name = $u_map['admin'][$user_id];
                cookie('c_uid',$u_name,24*3600*5);
        		echo 0;
        	    exit();
            }else if(-1 == $result['content']['is_success']){
                echo -1;
                exit();
            }else if(-2 == $result['content']['is_success']){
                echo -2;
                exit();
            }else if(-3 == $result['content']['is_success']){
                echo -3;
                exit();
            }else{
                echo -4;
                exit();
            }
    	}else{
            echo -4;
            exit();
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
        $this->redirect('Login/index');
    }
}