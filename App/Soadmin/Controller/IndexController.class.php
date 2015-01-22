<?php
namespace Soadmin\Controller;
use Think\Controller;
include_once(dirname(__FILE__).'/BaseController.class.php');
class IndexController extends BaseController {
    public function _initialize()
    {
	parent::_initialize();
	if(null == session('admin_name')
	|| ''   == session('admin_name'))
	{
	    $this->redirect('/Soadmin/Login/index');
	}
    }
    
    public function index(){
       $this->display();
    }

    public function login()
    {
	session('admin_name','');
    	$this->success('成功退出','Login:index');
    }
}