<?php
namespace Azureadmin\Controller;
use Azureadmin\Controller;
include_once(dirname(__FILE__).'/BaseController.class.php');

class ModuleVipManagerController extends BaseController{

	public function index()
	{
		$this->assign('menu_index', 10);

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
       
       	$content['order']['MoId'] = 'asc';

        $result = $this->_call('ComModule.get_list', $content);

        $list = array();
        if($result)
        {
            if(200 == $result['status_code'])
            {
                if(isset($result['content']['list'])
                && isset($result['content']['record_count']))
                {
                    $_list   = $result['content']['list'];   
                    $list = array();
                    //区分一二级
                    if(count($_list) >0)
                    {
                    	foreach($_list as $v)
                    	{
                    		if($v['MoPid'] == 0)
                    		{
                    			$list[intval($v['MoId'])] = $v;
                    		}
                    		else
                    		{
                    			$list[intval($v['MoPid'])]['_ex'][] = $v;
                    		}
                    	}
                    }                    
                    $this->assign('list', $list);     
                    $record_count = $result['content']['record_count'];
                    $this->assign('record_count', $record_count);
                    //$this->get_page($record_count, $page_size);
                    $this->assign('page', $this->get_page_by_custom(C('controller').'/CompanyManager/GetTable', 1, $record_count, $page_size));
                }
            }
        }

		$this->display();
	}
}