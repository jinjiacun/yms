<?php
namespace Soadmin\Controller;
use Think\Controller;
include_once(dirname(__FILE__).'/BaseController.class.php');
/**
 *管理源帐号管理
*/
class AdminController extends BaseController {
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
            $admin_name = I('post.admin_name');
            $passwd     = I('post.passwd');
            $re_passwd  = I('post.re_passwd');
            if('' == $admin_name
            || '' == $passwd
            || '' == $re_passwd)
            {
                //$this->error('参数不合法');
                $this->echo_message(-100,'参数不合法');
                exit();
            }
            if($passwd != $re_passwd)
            {
                //$this->error('两次密码不一致');
                $this->echo_message(-101, '两次密码不一致');
                exit();
            }
            
            //检查用户名
            $result = $this->_call('Admin.exists_name',array('admin_name'=>$admin_name));
            if($result
            && 200 == $result['status_code']
            && 0 == $result['content']['is_exists']
            )
            {
                $this->echo_message(-102,'此用户名已存在');
                exit();
            }
            
            $content = array(
                'admin_name'=>urlencode($admin_name),
                'passwd'    =>urlencode($passwd),
            );
            $result = $this->_call("Admin.add", $content);
            if($result
            && 200 == $result['status_code']
            && 0 == $result['content']['is_success'])
            {
                //$this->success("保存成功", C('Template_pre')."Admin/get_list", 3);
                $this->echo_message(0, '保存成功', C('Template_pre')."Admin/get_list");
                exit();
            }
            else
            {
                //$this->error("保存失败");
                $this->echo_message(-1,"保存失败");
                exit();
            }
        }
        $this->display();
    }
    
    public function edit()
    {
        $admin_name = I('get.admin_name');
        if(I('post.submit'))
        {
            $admin_name = I('post.admin_name');
            $passwd     = I('post.passwd');
            $re_passwd  = I('post.re_passwd');
            if('' == $admin_name
            || '' == $passwd
            || '' == $re_passwd)
            {
                //$this->error('参数不合法');
                $this->echo_message(-100,'参数不合法');
                exit();
            }
            if($passwd != $re_passwd)
            {
                //$this->error('两次密码不一致');
                $this->echo_message(-101, '两次密码不一致');
                exit();
            }
            
            $content = array(
                'passwd'    =>urlencode($passwd),
                'admin_name'=>urlencode($admin_name),
            );
            $result = $this->_call("Admin.update_passwd", $content);
            if($result
            && 200 == $result['status_code']
            && 0 == $result['content']['is_success'])
            {
                //$this->success("保存成功", C('Template_pre')."Admin/get_list", 3);
                $this->echo_message(0, '保存成功', C('Template_pre')."Admin/get_list");
                exit();
            }
            else
            {
                //$this->error("保存失败");
                $this->echo_message(-1,"保存失败");
                exit();
            }
        }
        $this->assign('admin_name', $admin_name);
        $this->display();
    }
    
    public function edit_ex()
    {
        $admin_name = I('get.admin_name');
        if(I('post.submit'))
        {
            $admin_name = I('post.admin_name');
            $passwd     = I('post.passwd');
            $re_passwd  = I('post.re_passwd');
            if('' == $admin_name
            || '' == $passwd
            || '' == $re_passwd)
            {
                //$this->error('参数不合法');
                $this->echo_message(-100,'参数不合法');
                exit();
            }
            if($passwd != $re_passwd)
            {
                //$this->error('两次密码不一致');
                $this->echo_message(-101, '两次密码不一致');
                exit();
            }
            
            $content = array(
                'passwd'    =>urlencode($passwd),
                'admin_name'=>urlencode($admin_name),
            );
            $result = $this->_call("Admin.update_passwd", $content);
            if($result
            && 200 == $result['status_code']
            && 0 == $result['content']['is_success'])
            {
                //$this->success("保存成功", C('Template_pre')."Admin/get_list", 3);
                session('admin_name',null);
                $this->echo_message(0, '保存成功', C('Template_pre')."Login/index");
                exit();
            }
            else
            {
                //$this->error("保存失败");
                $this->echo_message(-1,"保存失败");
                exit();
            }
        }
        $this->assign('admin_name', $admin_name);
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
        if(I('get.submit'))
        {
            $company_name = I('get.company_name');
            if('' != $company_name)
            {
                $this->assign('company_name', $company_name);
                $content['where']['company_name'] = array('like', '%'.urlencode($company_name).'%');
                $this->assign('company_name', $company_name);
            }
        }
        
        $content['where']['role'] = 1;
        
        $result = $this->_call('Admin.get_list', $content);
        
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
            //echo $this->echo_message(-100, "参数不正确");
            $this->error("参数不正确");
            exit();
        }
        
        $result = $this->_call("Admin.delete", array('id'=>$id));
        if($result
        && 200 == $result['status_code']
        && 0 == $result['content']['is_success']
        )
        {
            //$this->echo_message(0, "操作成功", C('Template_pre')."Admin/get_list");
            $this->success("操作成功", C('Template_pre')."Admin/get_list");
            exit();
        }
        else{
            //$this->echo_message(-1, "删除失败");
            $this->error("删除失败");
            exit();
        }
        
    }
}
?>