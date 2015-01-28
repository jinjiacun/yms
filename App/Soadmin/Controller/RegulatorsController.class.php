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
                'content' => urlencode(I('post.content')),
            );
            $result = $this->_call("Regulators.add", $content);
            if($result
            && 200 == $result['status_code']
            && 0   == $result['content']['is_success']
            )
            {
                $this->success("添加成功", C('Template_pre')."Regulators/get_list");
            }
        }
        
        $this->display();
    }
    
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
        $res = A('Callapi')->call_api('Regulators.get_list', 
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
                'content' =>urlencode(I('content')),
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
                $this->success('保存成功',C('Template_pre')."Regulators/get_list");
            }
        }
        
        $content = array(
            'id' => $id
        );
        $result = $this->_call("Regulators.get_info", $content);
        if($result
        && 200 == $result['status_code'])
        {
            $this->assign('obj', $result['content']);
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
                $this->success('删除成功', C('Template_pre')."Regulators/get_list");
            }
        }
    }
}