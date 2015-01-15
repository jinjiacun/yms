<?php
namespace Soadmin\Controller;
use Think\Controller;
include_once(dirname(__FILE__).'/BaseController.class.php');
/**
 *入库管理
*/
class InexposalController extends BaseController {
    
    //曝光
    public function get_list()
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
        $content['where'] = array(
            'type'=>0,
        );
        $res = A('Callapi')->call_api('Inexposal.get_list', 
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
                    $this->assign('list', $list);     
                    $record_count = $result['content']['record_count'];
                    $this->assign('record_count', $record_count);
                    $this->get_page($record_count, 10);
                }
            }
        }
        
        $this->display();
    }
    
    //认证申请
    public function get_list_ex()
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
        $content['where'] = array(
            'type'=>1,
        );
        $res = A('Callapi')->call_api('Inexposal.get_list', 
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