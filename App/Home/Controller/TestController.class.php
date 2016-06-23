<?php
namespace Home\Controller;
use Think\Controller;
header('Content-type: text/html; charset=utf-8');
include_once(dirname(__FILE__)."/BaseController.class.php");
class TestController extends BaseController {
	public function index()
	{
		 $begin = microtime(true);                                                                                                 
         //$res   = $this->_call("Test.test_api");                                                                     
         $res = $this->_call('Inexposal.stat_user_amount');
   		 $end   = microtime(true);                                                                                              
         var_dump($res);
         echo sprintf("接口调用时间:%s<br/>", $end-$begin); 
	}
}