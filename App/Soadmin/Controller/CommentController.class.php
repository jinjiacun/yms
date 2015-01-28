<?php
namespace Soadmin\Controller;
use Think\Controller;
include_once(dirname(__FILE__).'/BaseController.class.php');
/**
 *评论管理
*/
class CommentController extends BaseController {
     public function _initialize()
    {
	parent::_initialize();
	if(null == session('admin_name')
	|| ''   == session('admin_name'))
	{
	    $this->redirect('/Soadmin/Login/index');
	}
    }
    //查询
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
        $res = A('Callapi')->call_api('Comment.get_list', 
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
        
        $this->assign('company_list', $this->_map_company());
        $this->display();
    }
    
    public function validate()
    {
        $id = I('get.id');
        if(0< $id)
        {
            $content = array(
                'id'=>$id
            );
            $result = $this->_call('Comment.validate',$content);
            if($result
            && 200 == $result['status_code']
            && 0 == $result['content']['is_success'])
            {
                $this->success('成功操作',C('Template_pre').'Comment/get_list');
            }
        }
    }
    
    public function get_news_list()
    {
        $page_index = 1;
        $page_size  = 15;
        $content    = array();
        if(I('get.p'))
        {
            $page_index = I('get.p');
            $content['page_size'] = $page_size;
            $content['page_index'] = $page_index;
        }
        else
        {
            $page_index = 1;
            $content['page_size'] = $page_size;
            $content['page_index'] = $page_index;
        }
        $res = A('Callapi')->call_api('Comnews.get_list', 
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
                    $this->get_page($record_count, 15);
                }
            }
        }
        
        $this->assign('new_list', $this->_map_news());
        $this->assign('company_list', $this->_map_company());
        $this->display();
    }
    
    public function validate_news()
    {
        $id = I('get.id');
        if(0< $id)
        {
            $content = array(
                'id'=>$id
            );
            $result = $this->_call('Comnews.validate',$content);
            if($result
            && 200 == $result['status_code']
            && 0 == $result['content']['is_success'])
            {
                $this->success('成功操作','Comment/get_news_list');
            }
        }
    }
    
    public function get_exposal_list()
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
        $res = A('Callapi')->call_api('Comexposal.get_list', 
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
    
        $this->assign('exposal_list', $this->_map_exposal());
        $this->display();
    }
    
     public function validate_exposal()
    {
        $id = I('get.id');
        if(0< $id)
        {
            $content = array(
                'id'=>$id
            );
            $result = $this->_call('Comexposal.validate',$content);
            if($result
            && 200 == $result['status_code']
            && 0 == $result['content']['is_success'])
            {
                $this->success('成功操作',C('Template_pre').'Comment/get_exposal_list');
            }
        }
    }
   
    
    //删除
    public function delete()
    {
        $this->display();
    }
}