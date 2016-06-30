<?php
namespace Azureadmin\Controller;
use Azureadmin\Controller;
include_once(dirname(__FILE__).'/BaseController.class.php');

class LiveRoomStatisticsController extends BaseController{

	public function index()
	{
		$this->assign('menu_index', 19);
		$this->display();
	}
}