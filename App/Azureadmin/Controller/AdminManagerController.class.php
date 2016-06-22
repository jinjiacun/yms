<?php
namespace Azureadmin\Controller;
use Think\Controller;
include_once(dirname(__FILE__).'/BaseController.class.php');
class AdminManagerController extends BaseController {
    public function _initialize()
    {
        parent::_initialize();
        if(null == session('AdminName')
        || ''   == session('AdminName'))
        {
            $this->redirect('/Azureadmin/Login/index');
        }
    }

	public function index()
	{
		$this->display();
	}

    public function quit()
    {
        session('AdminName',null);
        $this->redirect("Index/index");
        exit();
    }
}