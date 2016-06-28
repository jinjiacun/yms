<?php
namespace Azureadmin\Controller;
use Think\Controller;
include_once(dirname(__FILE__).'/BaseController.class.php');
class IndexController extends BaseController {
    public function _initialize()
    {
        parent::get_dictionary();
	   parent::_initialize();

    	if(null == session('AdminName')
    	|| ''   == session('AdminName'))
    	{
    	    $this->redirect('/Azureadmin/Login/index');
    	}
    }
    
    public function index(){
        if(I('post.submit'))
        {
            $content = array(
                'AdminName' =>I('post.AdminName'),
                'Password'  =>I('post.Password'),
            );
            $result = $this->_call("Comadmin.login",
                                   $content);
            if($result
            && 200 == $result['status_code']
            && 0 == $result['content']['is_success'])
            {
                session('AdminName', I('post.AdminName'));
                $this->echo_message(0,'成功登录', C('admin_url'));
                exit();
            }
            else
            {
                //$this->error("登录失败");
                $this->echo_message(-1,'登录失败');
                exit();
            }
        }
        $this->display();
    }

    public function quit()
    {
	    session('AdminName','');
    	$this->success('成功退出','Login:index');
    }
}