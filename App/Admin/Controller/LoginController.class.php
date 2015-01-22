<?php
namespace Soadmin\Controller;
use Think\Controller;
include_once(dirname(__FILE__).'/BaseController.class.php');
class LoginController extends BaseController {
	function function index()
	{
		if(I('post.submit'))
		{
			echo 'jump';
			exit();
			session('admin_name', I('post.admin_name'));
			$this->display('Soadmin:Index');
		}
		else
		{
			$this->display();
		}
	}
}