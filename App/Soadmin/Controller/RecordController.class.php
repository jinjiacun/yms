<?php
namespace Soadmin\Controller;
use Think\Controller;
include_once(dirname(__FILE__).'/BaseController.class.php');
/**
 *纪录管理
*/
class RecordController extends BaseController {
     public function _initialize()
    {
	parent::_initialize();
	if(null == session('admin_name')
	|| ''   == session('admin_name'))
	{
	    $this->redirect('/Soadmin/Login/index');
	}
    }
    public function exposal_top_list()
    {
        $page_index = 1;
        $page_size  = 10;
        $content    = array();
        if(I('get.p'))
        {
            $page_index = I('get.p');
            $content['page_size'] = $page_size;
            $content['page_index'] = $page_index;
        }
        $content['where']['company_id'] = array("neq",0);
        $res = A('Callapi')->call_api('News.get_list', 
                                    $content,
                                    'text',
                                  null);
        $result = $this->deal_re_call_api($res);

        $list = array();
        if($result)
        {
            if(200 == $result['status_code'])
            {
                if(isset($result['content']['list'])
                && isset($result['content']['record_count']))
                {
                    $list   = $result['content']['list'];   
                    $this->assign('news_list', $list);     
                    $record_count = $result['content']['record_count'];
                    $this->assign('record_count', $record_count);
                    $this->get_page($record_count, 10);
                }
            }
        }
    
        $this->display();
    }
    
    public function com_news_assist_list()
    {
        $this->display();
    }
    
    public function com_top_list()
    {
        $this->display();
    }
    
    public function news_assist_list()
    {
        $this->display();
    }
}
?>