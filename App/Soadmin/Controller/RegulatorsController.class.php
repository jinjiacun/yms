<?php
namespace Soadmin\Controller;
use Soadmin\Controller;
include_once(dirname(__FILE__).'/BaseController.class.php');
class RegulatorsController extends BaseController {
    public function _initialize()
    {
	parent::_initialize();
	if(null == session('admin_name')
	|| ''   == session('admin_name'))
	{
	    $this->redirect('/Soadmin/Login/index');
	}
    }
    public function add()
    {
        if(I('post.submit'))
        {
            $content = array(
                'type'    => urlencode(I('post.type')),
                'title'   => urlencode(I('post.title')),
                'website' => urlencode(I('post.website')),
                'pic'     => $this->upload('pic','001002'),
                'content' => urlencode(base64_encode(I('post.content'))),
            );
            $result = $this->_call("Regulators.add", $content);
            if($result
            && 200 == $result['status_code']
            && 0   == $result['content']['is_success']
            )
            {
                //$this->success("添加成功", C('Template_pre')."Regulators/get_list");
                $this->echo_message(0,"添加成功", C('Template_pre')."Regulators/get_list");
                exit();
            }
            else
            {
                $this->echo_message(-1,"添加失败");
                exit();   
            }
        }
        
        $this->display();
    }
    
    public function get_list()
    {
        $page_index = 1;
        $page_size  = 10;
        $content    = array();
        
        //批量删除
        if(I('get.del_mul'))
        {
            $id_list = I('post.id');            
            $ids = implode(',', $id_list);
            $content['id'] = array('in', $ids);
            $result = $this->_call('Regulators.delete', $content);
            if($result
            && 200 == $result['status_code']
            && 0 == $result['content']['is_success'])
            {
                $this->echo_message(0, "成功删除", C('Template_pre')."Regulators/get_list");
                exit();
            }
            else{
                $this->echo_message(-1, "删除失败");
                exit();
            }
        }
        
        if(I('get.p'))
        {
            $page_index = I('get.p');
            $content['page_size'] = $page_size;
            $content['page_index'] = $page_index;
        }
        if(I('get.submit'))
        {
            if('' != I('get.title'))
            {
                $content['where']['title'] = array('like', '%'.urlencode(I("get.title")).'%');
                $this->assign('title', I('get.title'));
            }
            if(0 != I('get.type'))
            {
                $content['where']['type'] = I('get.type');
                $this->assign('type', I('get.type'));
            }
        }
        
        $result = $this->_call('Regulators.get_list', 
                                    $content);

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
    
    public function edit()
    {
        $id = I('get.id');
        if(I('post.submit'))
        {
            $content['where'] = array(
                'id'=>I('post.id'),
            );
            $content['data'] = array(
                'type'    =>I('post.type'),
                'title'   =>urlencode(I('post.title')),
                'website' =>urlencode(I('website')),
                'content' =>urlencode(base64_encode(I('content'))),
            );
            $pic = $this->upload("pic", "001002");
            if(0< $pic)
            {
                $content['data']['pic'] = $pic;
            }
            $result = $this->_call('Regulators.update', $content);
            if($result
            && 200 == $result['status_code']
            && 0 == $result['content']['is_success'])
            {
                //$this->success('保存成功',C('Template_pre')."Regulators/get_list");
                $this->echo_message(0,'保存成功',C('Template_pre')."Regulators/get_list");
                exit();
            }
            else
            {
                $this->echo_message(-1,'保存失败',C('Template_pre')."Regulators/get_list");
                exit();
            }
        }
        
        $content = array(
            'id' => $id
        );
        $result = $this->_call("Regulators.get_info", $content);
        if($result
        && 200 == $result['status_code'])
        {
            $obj = $result['content'];
            $obj['content'] = base64_decode($obj['content']);
            $this->assign('obj', $obj);
        }
        $this->display();
    }
    
    public function delete()
    {
        $id = I('get.id');
        if(0< $id)
        {
            $content = array(
                'id'=>$id
            );
            $result = $this->_call('Regulators.delete', $content);
            if($result
            && 200 == $result['status_code']
            && 0 == $result['content']['is_success']
            )
            {
                //$this->success('删除成功', C('Template_pre')."Regulators/get_list");
                $this->echo_message(0,'删除成功', C('Template_pre')."Regulators/get_list");
                exit();
            }
            else
            {
                $this->echo_message(-1,'删除失败', C('Template_pre')."Regulators/get_list");
                exit();   
            }
        }
    }
}