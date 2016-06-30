<?php
namespace Azureadmin\Controller;
use Azureadmin\Controller;
include_once(dirname(__FILE__).'/BaseController.class.php');

class UserManagerController extends BaseController{

	public function index()
	{
		$this->assign('menu_index', 12);
		$this->display();
	}
}