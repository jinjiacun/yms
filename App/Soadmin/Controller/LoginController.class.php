<?php
namespace Soadmin\Controller;
use Think\Controller;
include_once(dirname(__FILE__).'/BaseController.class.php');
class LoginController extends BaseController {
	public function index()
	{
		if(I('post.submit'))
		{
                    $content = array(
                        'admin_name'=>I('post.admin_name'),
                        'passwd'    =>I('post.passwd'),
                    );
                    $result = $this->_call("Admin.login",
                                           $content);
                    if($result
                    && 200 == $result['status_code']
                    && 0 == $result['content']['is_success'])
                    {
                        session('admin_name', I('post.admin_name'));
                        $this->echo_message(0,'成功登录', C('Template_pre')."Index/index");
                        //$this->redirect("Index/index");
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
        session('admin_name',null);
        $this->redirect("Index/index");
        exit();
    }
}