<?php
namespace Azureadmin\Controller;
use Azureadmin\Controller;
include_once(dirname(__FILE__).'/BaseController.class.php');

class ComMessagerController extends BaseController{

	public function ComMessager()
	{
		$this->assign('menu_index', 20);
		$this->display();
	}
}