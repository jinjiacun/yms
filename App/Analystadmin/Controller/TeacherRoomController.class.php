<?php
namespace Analystadmin\Controller;
use Analystadmin\Controller;
include_once(dirname(__FILE__).'/BaseController.class.php');
class TeacherRoomController extends BaseController{
	public function __initialize(){
		parent::__initialize();
		if(null == session('AdminName')
		|| '' == session('AdminName')){
			$this->redirect('Analystadmin/Login/Index');
		}
	}

	public function LiveRoom(){
		$this->display();
	}
}