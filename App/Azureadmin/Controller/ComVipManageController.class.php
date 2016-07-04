<?php
namespace Azureadmin\Controller;
use Azureadmin\Controller;
include_once(dirname(__FILE__).'/BaseController.class.php');

class ComVipManageController extends BaseController{

	public function index()
	{
		$this->assign('menu_index', 9);

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
         
        if(session('ComId')>0)
        {
        	$content['where']['ComId'] = session('ComId');
        }      
        
        $content['order']['CVipId'] = 'asc';

        $result = $this->_call('ComVip.get_list', $content);

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
                    //获取第一个(非0和1等级的)启动和禁用的id，如果不存在就选取默认的
                    $first_start_id = 0;
                    $first_stop_id = 0;
                    foreach($list as $v)
                    {
                    	if($v['VipLevel'] <>0 
                    	&& $v['VipLevel'] <>1)
                    	{
                    		if($first_stop_id ==0
                    		|| $first_start_id ==0)
                    		{
                    			if($v['VipState'] == 1)//状态为启动，控制为禁用
                    			{
                    				$first_stop_id = intval($v['CVipId']);
                    				continue;
                    			}
                    			else if($v['VipState'] ==0)
                    			{
                    				$first_start_id = intval($v['CVipId']);
                    				continue;	
                    			}
                    		}  
                    		else
                    		{
                    			break;
                    		}
                    	}
                    }
                    $this->assign('first_start_id', $first_start_id);
                    $this->assign('first_stop_id', $first_stop_id);
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