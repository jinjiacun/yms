<?php
namespace Azureadmin\Controller;
use Azureadmin\Controller;
include_once(dirname(__FILE__).'/BaseController.class.php');

class ComVipManageController extends BaseController{

	public function index()
	{
		$this->assign('menu_index', 9);
		$this->display();
	}
}