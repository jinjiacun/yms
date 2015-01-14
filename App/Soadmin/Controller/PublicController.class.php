<?php
namespace Soadmin\Controller;
use Think\Controller;
include_once(dirname(__FILE__).'/BaseController.class.php');
class PublicController extends BaseController {

	public function top()
	{
		$this->display();
	}	

	public function left()
	{
		if(session('admin_name'))
			$this->assign('admin_name', session('admin_name'));
		$this->display();
	}

	public function mainfra()
	{
		$this->display();
	}
} 