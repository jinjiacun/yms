<?php
namespace Azureadmin\Controller;
use Azureadmin\Controller;
include_once(dirname(__FILE__).'/BaseController.class.php');

class ComManagerController extends BaseController{

	public function index()
	{
		
	}

	public function ComTable()
	{
		$this->assign('menu_index', 13);
		$this->display();
	}

	public function ComInit()
	{
		$this->assign('menu_index', 14);
		$this->display();	
	}

	public function ComInit_Oper()
	{
		$this->assign('menu_index', 15);
		$this->display();	
	}	

	public function FriendlyLink()
	{
		$this->assign('menu_index', 16);
		$this->display();	
	}	

	public function ComTable_Img()
	{
		$this->assign('menu_index', 17);
		$this->display();	
	}	
}