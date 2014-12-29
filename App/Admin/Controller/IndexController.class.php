<?php
namespace Admin\Controller;
use Think\Controller;
include_once(dirname(__FILE__).'/BaseController.class.php');
class IndexController extends BaseController {
    public function index(){
        $this->display();
    }

    public function login()
    {
    	if(I('post.submit'))
    	{
    		session('admin_name', I('post.admin_name'));
    		$this->display('Index:index');
    	}
    	$this->display();
    }
}