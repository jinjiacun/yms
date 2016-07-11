<?php
namespace Azureadmin\Controller;
use Azureadmin\Controller;
include_once(dirname(__FILE__).'/BaseController.class.php');

class ComMessageController extends BaseController{

	public function ComMessager()
	{
		$this->assign('menu_index', 20);
		$this->display();
	}

	public function GetComMessageCount(){
	       echo '{"count":0,"html":"\u003cli\u003e\u003ca title=\"\" href=\"javascript:void(0);\"\u003eÃ»ÓÐ×îÐÂÏûÏ¢\u003c/a\u003e\u003c/li\u003e"}';
	}
}