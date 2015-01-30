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
                        $this->redirect("Index/index");
                    }
                    else
                    {
                        $this->error("登录失败");
                        exit();
                    }
		}
		$this->display();
	}
}