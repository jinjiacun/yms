<?php
namespace Home\Controller;
use Think\Controller;
header('Content-type: text/html; charset=utf-8');
include_once(dirname(__FILE__)."/BaseController.class.php");
class DownloadController extends BaseController {
    /**
    *APP下载
    */
    public function index(){
    	//用户登录信息
    	$this->_login();
    	
        $this->display();
    }
}