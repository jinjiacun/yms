<?php
namespace Soadmin\Controller;
use Think\Controller;
include_once(dirname(__FILE__).'/BaseController.class.php');
/**
 *接口统计管理
*/
class ApistatController extends BaseController {
     public function _initialize()
    {
	parent::_initialize();
	if(null == session('admin_name')
	|| ''   == session('admin_name'))
	{
	    $this->redirect('/Soadmin/Login/index');
	}
    }
    
    public function get_stat()
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
        if(I('post.submit'))
        {
             if('' != I('post.name'))
             {
                $content['where']['name'] = urlencode(I('post.name'));
                $this->assign('name', I('post.name'));
             }
        }
        $content['order'] = "run_time desc";
        $result = $this->_call('Apistat.get_list', $content);
        $list = array();
        if($result)
        {
            if(200 == $result['status_code'])
            {
                if(isset($result['content']['list'])
                && isset($result['content']['record_count']))
                {
                    $list   = $result['content']['list'];
                    foreach($list as $k=>$v)
                    {
                        $list[$k]['run_time'] = 100*$v['run_time'];
                    }
                    unset($k, $v);
                    $this->assign('list', $list);     
                    $record_count = $result['content']['record_count'];
                    $this->assign('record_count', $record_count);
                    $this->get_page($record_count, 10);
                }
            }
        }
        
        $this->display();
    }
}