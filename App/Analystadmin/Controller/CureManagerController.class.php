<?php
namespace Analystadmin\Controller;
use Think\Controller;
include_once(dirname(__FILE__).'/BaseController');
#账号诊断管理
class CureManagerController extends BaseController
{
	public function __initialize()
	{
		parent::__initialize();
		if(null == session('AdminName')
		|| '' == session('AdminName'))
		{
			$this->redirect('Analystadmin/Login/Index');
		}
	}

	public function Index()
	{
		$this->display();
	}
}