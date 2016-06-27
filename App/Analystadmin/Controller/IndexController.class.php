<?php
namespace Analystadmin\Controller;
use Think\Controller;
include_once(dirname(__FILE__).'/BaseController.class.php');
class IndexController extends BaseController {
    public function _initialize()
    {
	parent::_initialize();
	if(null == session('AdminName')
	|| ''   == session('AdminName'))
	{
	    $this->redirect('/Analystadmin/Login/index');
	}
    }
    
    public function index(){
       $this->display();
    }

    public function login()
    {
	session('AdminName','');
    	$this->success('成功退出','Login:index');
    }
}