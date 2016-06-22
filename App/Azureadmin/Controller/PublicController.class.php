<?php
namespace Azureadmin\Controller;
use Think\Controller;
include_once(dirname(__FILE__).'/BaseController.class.php');
class PublicController extends BaseController {
	 public function _initialize()
    {
	parent::_initialize();
	if(null == session('AdminName')
	|| ''   == session('AdminName'))
	{
	    $this->redirect('/Azureadmin/Login/index');
	}
    }
	public function top()
	{
		$this->display();
	}	

	public function left()
	{
		if(session('AdminName'))
			$this->assign('AdminName', session('AdminName'));
		if('admin' == session('AdminName'))
		{
			$this->assign('is_show', 1);
		}
		$this->display();
	}

	public function mainfra()
	{
		$this->display();
	}
	
	public function err_404()
	{
		$this->display();
	}
	
	public function pop_window()
	{
		$this->display();
	}

	public function pop_value()
	{
		$this->display();
	}

	public function pop_picture()
	{
		$this->display();
	}
} 