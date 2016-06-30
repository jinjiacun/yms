<?php
namespace Azureadmin\Controller;
use Azureadmin\Controller;
include_once(dirname(__FILE__).'/BaseController.class.php');

class ModuleManagerController extends BaseController{
	public function _initialize(){
		parent::_initialize();
		parent::get_dictionary();
		if(null == session('AdminName')
		|| '' == session('AdminName')){
			$this->redirect('/Azureadmin/Login/index');
		}
	}

	public function Index()
	{ 

    $this->assign('menu_index', 8);
    $page_index = 1;
    $page_size  = 20;
    $content    = array();
    if(I('get.p'))
    {
        $page_index = I('get.p');
        $content['page_size'] = $page_size;
        $content['page_index'] = $page_index;
    }
    else
    {
        $content['page_size'] = $page_size;
        $content['page_index'] = $page_index;
    }
    if(session('ComId') != 0)
    {
      $content['where']['ComId'] = session('ComId');
    }
           
    $result = $this->_call('ComModule.get_list', $content);

    $list = array();
    if($result)
    {
        if(200 == $result['status_code'])
        {
            if(isset($result['content']['list'])
            && isset($result['content']['record_count']))
            {
                $list   = $result['content']['list'];   
                $this->assign('list', $list);     
                $record_count = $result['content']['record_count'];
                $this->assign('record_count', $record_count);
                //$this->get_page($record_count, $page_size);
                $this->assign('page', $this->get_page_by_custom(C('controller').'/RoleManager/GetTable', 1, $record_count, $page_size));
            }
        }
    }  

		$this->display();
	}
}