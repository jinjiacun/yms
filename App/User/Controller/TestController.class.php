<?php
namespace User\Controller;
use Think\Controller;
include_once(dirname(__FILE__)."/BaseController.class.php");
class TestController extends BaseController {
	public function upload()
	{
		if(I('post.submit'))
		{
			var_dump($_FILES);
		}
		$this->display();
	}
}