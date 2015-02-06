<?php
namespace Soadmin\Controller;
use Think\Controller;
include_once(dirname(__FILE__).'/BaseController.class.php');
/**
 *入库管理
*/
class InexposalController extends BaseController {
     public function _initialize()
    {
	parent::_initialize();
	if(null == session('admin_name')
	|| ''   == session('admin_name'))
	{
	    $this->redirect('/Soadmin/Login/index');
	}
    }
    
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
        if(I('get.submit'))
        {
            if('' != I('get.nature')
            && 0 != I('get.nature'))
            {
                $content['where']['nature'] = I('get.nature');
                $this->assign('nature', I('get.nature'));
            }
            if('' != I('get.trade')
            && 0 != I('get.trade'))
            {
                $content['where']['trade'] = I('get.trade');
                $this->assign('trade', I('get.trade'));
            }
            if('' != I('get.company_name'))
            {
                $content['where']['company_name'] = urlencode(I('get.company_name'));
                $this->assign('company_name', I('get.company_name'));
            }
            $status = I('get.status');
            switch($status)
            {
                case 0:{
                        $content['where']['company_id'] = 0;
                        $content['where']['is_delete'] = 0;
                        $this->assign('status', 0);
                    }
                    break;
                case 1:{
                        $content['where']['company_id'] = array('neq', 0);
                        $content['where']['is_delete'] = 0;
                        $this->assign('status', 1);
                    }
                    break;
                case 2:{
                        $content['where']['is_delete'] = 1;
                        $this->assign('status', 2);
                    }
                    break;
            }
        }
        else
        {
            $content['where']['company_id'] = 0;
            $content['where']['is_delete'] = 0;
            $this->assign('status', 0);
        }
        
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
        
        $this->assign('company_list', $this->_map_company());
        $this->_map_trade_list();
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
        if(I('get.submit'))
        {
            if('' != I('get.nature')
            && 0 != I('get.nature'))
            {
                $content['where']['nature'] = I('get.nature');
                $this->assign('nature', I('get.nature'));
            }
            if('' != I('get.trade')
            && 0 != I('get.trade'))
            {
                $content['where']['trade'] = I('get.trade');
                $this->assign('trade', I('get.trade'));
            }
            if('' != I('get.company_name'))
            {
                $content['where']['company_name'] = urlencode(I('get.company_name'));
                $this->assign('company_name', I('get.company_name'));
            }
            $status = I('get.status');
            switch($status)
            {
                case 0:{
                        $content['where']['company_id'] = 0;
                        $content['where']['is_delete'] = 0;
                        $this->assign('status', 0);
                    }
                    break;
                case 1:{
                        $content['where']['company_id'] = array('neq', 0);
                        $content['where']['is_delete'] = 0;
                        $this->assign('status', 1);
                    }
                    break;
                case 2:{
                        $content['where']['is_delete'] = 1;
                        $this->assign('status', 2);
                    }
                    break;
            }
        }
        else
        {
            $content['where']['company_id'] = 0;
            $content['where']['is_delete'] = 0;
            $this->assign('status', 0);
        }
        $content['where']['type'] = 1;
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
        
        $this->assign('company_list', $this->_map_company());
        $this->_map_trade_list();
        $this->display();
    }
    
    //关联企业
    public function edit()
    {
        $id = I('get.id');
        $company_id = I('get.company_id');
        
        if(I('post.submit'))
        {
            $content = array(
                'id'          =>I('post.id'),
                'company_id'  =>I('post.company_id'),
            );
            $result = $this->_call('Inexposal.chang_relate',
                                   $content);
            if($result
            && 200 == $result['status_code']
            && 0 == $result['is_success'])
            {
                $this->success('成功操作',C('Template_pre')."Inexposal/get_list");
                exit();
            }
        }
        
        
        $this->assign('id', $id);
        $this->assign('company_id', $company_id);
        $this->assign('company_list', $this->_map_company());
        $this->display();    
    }
    
    
    public function view()
    {
        $id = I('get.id');
        if(0>= $id)
        {
            $this->error("参数错误");
            exit();
        }
        
        $result = $this->_call('Inexposal.get_info',array('id'=>$id));
        if($result
        && 200 == $result['status_code']
        )
        {
            $this->assign('obj', $result['content']);
        }
        
        $this->assign('company_list', $this->_map_company());
        $this->_map_trade_list();
        $this->display();
    }
    
    public function view_ex()
    {
         $id = I('get.id');
        if(0>= $id)
        {
            $this->error("参数错误");
            exit();
        }
        $result = $this->_call('Inexposal.get_info_ex',array('id'=>$id));
        if($result
        && 200 == $result['status_code']
        )
        {
            $this->assign('obj', $result['content']);
        }
        
        $this->assign('company_list', $this->_map_company());
        $this->display();
    }
    
    public function delete()
    {
        $content = array(
            'id' =>  I('get.id'),
            'company_id' => I('get.company_id')
        );
        $result = $this->_call("Inexposal.delete", $content);
        
        if($result
        && 200 == $result['status_code']
        && 0 == $result['content']['is_success'])
        {
            $this->success('成功删除', C('Template_pre').'Inexposal/get_list');
            exit();
        }
        else
        {
            $this->error('删除失败');
        }
    }
    
    public function delete_ex()
    {
        $content = array(
            'id' =>  I('get.id'),
            'company_id' => I('get.company_id')
        );
        $result = $this->_call("Inexposal.delete", $content);
        
        if($result
        && 200 == $result['status_code']
        && 0 == $result['content']['is_success'])
        {
            $this->success('成功删除', C('Template_pre').'Inexposal/get_list_ex');
            exit();
        }
        else
        {
            $this->error('删除失败');
        }
    }
    
    
    
    
    
    
    
    
    
    
    
    
    
    
}