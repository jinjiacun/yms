<?php
namespace Soadmin\Controller;
use Think\Controller;
include_once(dirname(__FILE__).'/BaseController.class.php');
/**
 *意见反馈管理
*/
class IdeabackController extends BaseController {
     public function _initialize()
    {
	parent::_initialize();
	if(null == session('admin_name')
	|| ''   == session('admin_name'))
	{
	    $this->redirect('/Soadmin/Login/index');
	}
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
        if(I('get.submit'))
        {
            
        }
        
        $result = $this->_call('Ideaback.get_list', $content);
        
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
    
    public function delete()
    {
        $id = I('get.id');
        if(0>= $id)
        {
            echo $this->echo_message(-100, "参数不正确");
            //$this->error("参数不正确");
            exit();
        }
        
        $result = $this->_call("Ideaback.delete", array('id'=>$id));
        if($result
        && 200 == $result['status_code']
        && 0 == $result['content']['is_success']
        )
        {
            $this->echo_message(0, "操作成功", '');
            //$this->success("操作成功", C('Template_pre')."Admin/get_list");
            exit();
        }
        else{
            $this->echo_message(-1, "删除失败");
            //$this->error("删除失败");
            exit();
        }
    }
}