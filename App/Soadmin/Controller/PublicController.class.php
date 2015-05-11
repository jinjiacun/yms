<?php
namespace Soadmin\Controller;
use Think\Controller;
include_once(dirname(__FILE__).'/BaseController.class.php');
class PublicController extends BaseController {
	 public function _initialize()
    {
	parent::_initialize();
	if(null == session('admin_name')
	|| ''   == session('admin_name'))
	{
	    $this->redirect('/Soadmin/Login/index');
	}
    }
	public function top()
	{
		$this->display();
	}	

	public function left()
	{
		if(session('admin_name'))
			$this->assign('admin_name', session('admin_name'));
		if('admin' == session('admin_name'))
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
	
	public function pic_chg()
	{
		$this->display();
	}

	public function test_api()
	{
		$begin = microtime(true);

#		$res   = $this->_call("Test.test_api");
		#require_once 'HttpClient.class.php’;
		/*
		$params = array(
				'web'=>'www.baidu.com',
		);
		$pageContents = HttpClient::quickPost(’http://localhost:81/flandy/getpost3.php’, $params);
		*/
		
		
		$flag = 0;
		$post = '';
		$errno = '';
		$errstr = '';
		//要post的数据
		$argv = array(
			   'method'=>'Indexposal.stat_user_amount',
		);
		//构造要post的字符串
		foreach ($argv as $key=>$value) {
			if ($flag!=0) {
			       $post .= "&";
			       $flag = 1;
			}
			$post.= $key."=";
			$post.= urlencode($value);
			$flag = 1;
		}
		$length = strlen($post);
		//创建socket连接
		$fp = fsockopen("192.68.1.131",80,$errno,$errstr,10) or exit($errstr."--->".$errno);
		//构造post请求的头
		$header  = "POST yms_api/index.php/Soapi HTTP/1.1\r\n";
		$header .= "Host:192.168.1.131\r\n";
		//$header .= "Referer:/flandy/post.php\r\n";
		$header .= "Content-Type: application/x-www-form-urlencoded\r\n";
		$header .= "Content-Length: ".$length."\r\n";
		$header .= "Connection: Close\r\n\r\n";
		//添加post的字符串
		$header .= $post."\r\n";
			   
		       
		//发送post的数据
		fputs($fp,$header);
		$inheader = 1;
		while (!feof($fp)) {
			$line = fgets($fp,1024); //去除请求包的头只显示页面的返回数据
			if ($inheader && ($line == "\n" || $line == "\r\n")) {
				$inheader = 0;
			}
			if ($inheader == 0) {
				 echo $line;
			}
		}		       
		fclose($fp);
		       
		$end   = microtime(true);
		var_dump($res);
		echo sprintf("接口调用时间:%s<br/>", $end-$begin);
	}	
} 
