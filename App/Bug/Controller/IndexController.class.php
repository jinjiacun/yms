<?php
namespace Home\Controller;
use Think\Controller;
header('Content-type: text/html; charset=utf-8');
include_once(dirname(__FILE__)."/BaseController.class.php");
class IndexController extends BaseController {
    public function _initialize(){
		parent::_initialize();
		if("" == session('user_id'))
		{		    
		    exit('<script>top.location.href="/bug/Login/index"</script>');
		}
    }
    public function index(){
	    $this->display();
    }
}