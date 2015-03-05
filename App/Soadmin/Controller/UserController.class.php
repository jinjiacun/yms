<?php
namespace Soadmin\Controller;
use Soadmin\Controller;
include_once(dirname(__FILE__).'/BaseController.class.php');
class UserController extends BaseController {

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
            $user_id = I('get.user_id');
            if('' != $user_id
            && 0 < $user_id)
            {
                $this->assign('user_id', $user_id);
                $content['where']['user_id'] = $user_id;
            }
            if('' != I('get.nickname'))
            {
                $nickname = I('get.nickname');
                $this->assign('nickname', $nickname);
                $content['where']['nickname'] = array('like', '%'.urlencode($nickname).'%');
            }
        }
        $result = $this->_call('Member.get_list',$content);
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

    public function info()
    {
        if(I('post.submit'))//封号
        {
            if('' == I('post.user_id')
            || 0>= intval(I('post.user_id'))
            )
            {
                $this->echo_message(-100,'参数错误');
                exit();
            }
            $content = array(
                'uid'=>I('post.user_id'),
                'state'  =>I('post.status')
            );
            $result = $this->_call('User.update_status', $content);
            if($result
            && 200 == $result['status_code']
            && 0 == $result['content']['is_success'])
            {
                $this->echo_message();
                exit();
            }
            elseif(-1 == $result['content']['is_success'])
            {
                $this->echo_message(-1, '操作失败');
                exit();  
            }
            elseif(-2 == $result['content']['is_success'])
            {
                $this->echo_message(-2, '用户不存在');
                exit();
            }
        }
        elseif(I('post.submit1'))//封号ip
        {
            $content = array(
                'uid'=>I('post.user_id'),
                'blackip'=>I('post.ip'),
            );
            $result = $this->_call('User.update_ip', $content);
            if($result
            && 200 == $result['status_code']
            && 0 == $result['content']['is_success']
            )
            {
                $this->echo_message();
                exit();
            }
            elseif(-1 == $result['content']['is_success'])
            {
                $this->echo_message(-1, '操作失败');
                exit();
            }
            elseif(-2 == $result['content']['is_success'])
            {
                $this->echo_message(-2, '用户不存在');
                exit();
            }
        }
        $this->display();
    }
    
    public function edit()
    {
        $user_id = I('get.user_id');
        $state = I('get.state');
        if(0>= $user_id)
        {
            $this->error("参数错误");
            exit();
        }
        
        $content = array(
            'uid'=>$user_id,
            'state'=>$state
        );
        
        $result = $this->_call('User.update_status', $content);
        if($result
        && 200 == $result['status_code']
        && 0 == $result['content']['is_success'])
        {
            $this->success('保存成功', C('Template_pre')."User/get_list", 3);
            exit();
        }
        else
        {
            $this->error('保存失败');
            exit();
        }
    }
}
?>