<?php
namespace Azureadmin\Controller;
use Azureadmin\Controller;
include_once(dirname(__FILE__).'/BaseController.class.php');

class ComMessageController extends BaseController{
    public function _initialize()
    {
        parent::_initialize();
        parent::get_dictionary();
        if(null == session('AdminName')
        || ''   == session('AdminName'))
        {
            $this->redirect('/Azureadmin/Login/index');
        }
    }

	public function ComMessage()
	{
		$this->assign('menu_index', 20);
        
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
        
        if(session('ComId')>0){
            $content['where']['ComId'] = session('ComId');
        }

        $content['where']['CMState'] = 1;
        
        $result = $this->_call('ComMessage.get_list', $content);
        unset($content);
        $list = array();
        if($result)
            {
                if($result['status_code'] == 200)
                    {
                        $list   = $result['content']['list'];
                        $this->assign('list', $list);     
                        $record_count = $result['content']['record_count'];
                        $this->assign('record_count', $record_count);
                        $this->assign('page', $this->get_page_by_custom(C('controller').'/CompanyManage/GetTable', 1, $record_count, $page_size));
                    }
            }
        unset($result);
        
		$this->display();
	}

	public function GetComMessageCount(){
	       echo '{"count":0,"html":"\u003cli\u003e\u003ca title=\"\" href=\"javascript:void(0);\"\u003eÃ»ÓÐ×îÐÂÏûÏ¢\u003c/a\u003e\u003c/li\u003e"}';
	}
}