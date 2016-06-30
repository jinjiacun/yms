<?php
namespace Azureadmin\Controller;
use Azureadmin\Controller;
include_once(dirname(__FILE__).'/BaseController.class.php');

class LiveRoomManagerController extends BaseController{

	public function index()
	{
		$this->assign('menu_index', 18);
		$this->display();
	}
}