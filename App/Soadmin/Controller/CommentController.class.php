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
        else
        {
            $content['page_size'] = $page_size;
            $content['page_index'] = $page_index;
        }
        if(I('get.submit'))
        {
            $status = I('get.status');
            switch($status)
            {
                case 0:{
                       // $content['where']['is_validate'] = 0;
                        $where['is_validate'] = 0;
                        $where['childs']  = array('gt', 0);
                        $where['pparent_id'] = array('gt', 0);
                        $where['_logic'] = 'or';
                        $content['where']['_complex'] = $where;
                        $content['where']['is_delete'] = 0;
                        $this->assign('status', 0);
                        //调用统计
                        $this->_call("Comment.stat_re_comment");
                    }
                    break;
                case 1:{
                        $where['is_validate'] = 1;
                        $where['is_delete'] = 0;
                        $where['_logic'] = 'and';
                        $content['where']['_complex'] = $where;
                        $this->assign('status', 1);
                    }
                    break;
                case 2:{
                        $content['where']['_string'] = "is_delete=1 or id in(select distinct(parent_id) from so_comment where is_delete=1 and pparent_id=0) or id in(select distinct(pparent_id) from so_comment where is_delete=1)";
						$content['where_ex']['_string'] = "is_delete=1 or id in(select distinct(parent_id) from so_comment where is_delete=1 and pparent_id not in(0))";
                        $this->assign('status', 2);
                    }
                    break;
            }
            if('' != I('get.user_id'))
            {
                $content['where']['user_id']= htmlspecialchars(I('get.user_id'));
                $this->assign('user_id', I('get.user_id'));
            }
            if(0 != I('get.type'))
            {
                $content['where']['type']= htmlspecialchars(I('get.type'));
                $this->assign('type', I('get.type'));
            }
            if(0 != I('get.company_id'))
            {
                $content['where']['company_id']= I('get.company_id');
                $this->assign('company_id', I('get.company_id'));
                $this->assign('company_name', I('get.company_name'));
            }
        }
        else
        {
            //$content['where']['is_validate'] = 0;
            $where['is_validate'] = 0;
            $where['childs']  = array('gt', 0);
            $where['pparent_id'] = array('gt', 0);
            $where['_logic'] = 'or';
            $content['where']['_complex'] = $where;
            $content['where']['is_delete'] = 0;
            $this->assign('status', 0);
            //调用统计
            $this->_call("Comment.stat_re_comment");
        }
         if(I('get.s_p'))
        {
        		if(isset($content)) unset($content);
            //回复查询
            $content['page_index'] = I('get.s_p');
            $content['where']['parent_id'] = I('get.parent_id');
            if(0 == I('get.status'))
            {
				$where['is_validate'] =0;
				$where['childs'] = array('gt', 0);
				$content['where']['_complex'] = $where;
                $content['where']['is_delete'] = 0;
            }
            elseif(1 == I('get.status'))
            {
                $content['where']['is_validate'] = 1;
                $content['where']['is_delete'] = 0;
            }
            else
            {
                $content['where']['is_delete'] = 1;
            }
            $result = $this->_call("Comment.get_list", $content);
            if($result
            && 200 == $result['status_code']
            )
            {
                echo json_encode($result['content']);
            }
            exit();
        }
        //批量审核
        if(I('get.check_mul'))
        {                
            $tmp_list = I('get.id');
            if(!is_array($tmp_list))
            {
                //$this->error('参数错误');
                $this->echo_message(-100,'参数错误');
                exit();
            }

            $id_list = $company_id_list = array();
            foreach($tmp_list as $v)
            {
                $tmp = explode('|', $v);
                $id_list[] = $tmp[0];
                $company_id_list[] = $tmp[1];
                $content = array(
                    'id'         => $tmp[0],
                    'company_id' => $tmp[1],
                );
                $result = $this->_call('Comment.validate', $content);
                if($result
                && 200 == $result['status_code']
                && 0 == $result['content']['is_success']
                )
                {
                }
                else
                {
                    $this->echo_message(-1,"操作失败");
                    exit();
                }
            }

            /*
            $result = $this->_call('Comment.validate_mul', 
                                   array('id'=>$id_list,
                                         'company_id'=>$company_id_list));
            if($result
            && 200 == $result['status_code']
            && 0 == $result['content']['is_success'])
            {
                //$this->success('成功操作', C('Template_pre').'Comment/get_list');
                $this->echo_message(0,'成功操作', '');
                exit();
            }
            else{
                //$this->error('操作失败');
                $this->echo_message(-1,'操作失败');
                exit();
            }
            */
            $this->echo_message(0,'成功操作', '');
            exit();
        }
        
         if(I('get.search'))
        {
            $kword = I('post.search-text');
            $content = array();
            if('' != htmlspecialchars(trim($kword)))
            {
                $content['where']['company_name'] = array("like", "$".urlencode($kword)."$");
            }
            $arr = array();
            //select name of company
            $result = $this->_call("Company.get_id_name_map", $content);
            if($result
            && 200 == $result['status_code'])
            {
                
               foreach($result['content'] as $k=>$v)
               {
                $arr[] = $k.','.$v;
               }
               unset($k, $v);
               //$arr = $result['content'];
            }
            $response = $arr;
            echo json_encode($response);
            exit();
        }
        
        //批量删除
         if(I('get.delete_mul'))
        {                
            $tmp_list = I('get.id');
            if(!is_array($tmp_list))
            {
                //$this->error('参数错误');
                $this->echo_message(-100,'参数错误');
                exit();
            }

            $id_list = $company_id_list = array();
            foreach($tmp_list as $v)
            {
                $tmp = explode('|', $v);
                $id_list[] = $tmp[0];
                $company_id_list[] = $tmp[1];
            }

            $result = $this->_call('Comment.delete_mul', 
                                   array('id'=>$id_list));
            if($result
            && 200 == $result['status_code']
            && 0 == $result['content']['is_success'])
            {
                //$this->success('成功操作', C('Template_pre').'Comment/get_list');
                $this->echo_message(0,'成功操作', '');
                exit();
            }
            else{
                //$this->error('操作失败');
                $this->echo_message(-1,'操作失败');
                exit();
            }
        }
        $content['order'] = array(
					'last_time'=>'desc',
					'last_cchild_time'=>'desc',
           		    'last_child_time'=>'desc',
	                'add_time'=>'desc',
		);
        $content['where']['parent_id'] = array('eq',0);
        $res = A('Callapi')->call_api('Comment.get_list_ex', 
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
                    if($list
                    && 0<count($list))
                    {
                        foreach($list as $k=>$v)
                        {
                            $list[$k]['content'] = $this->_format_face($v['content']);
                            $list[$k]['parent_content'] = $this->_format_face($v['parent_content']);
                        }
                    }
                    $this->assign('list', $list);     
                    $record_count = $result['content']['record_count'];
                    $this->assign('record_count', $record_count);
                    $this->get_page($record_count, 10);
                }
            }
        }
        
        $this->assign('company_list', $this->_map_company());
        $_auth_level_company = $this->_map_auth_level_company();
        $this->assign('auth_level_company', $_auth_level_company);
        $this->display();
    }
    
    public function validate()
    {
        $id = I('get.id');
        $parent_id = I('get.parent_id');
        $company_id = I('get.company_id');
        if(0< $id)
        {
            //检查主体是否审核
            $result = $this->_call('Comment.get_info', array('id'=>$parent_id));
            if($result
            && 200 == $result['status_code'])
            {
                if(0 == $result['content']['is_validate'])
                {
                    $this->echo_message(-100,"相应的主体未审核");
                    exit();
                    //$this->error("相应的主体未审核");
                }
            }
            
            $content = array(
                'id'=>$id,
                'company_id'=>$company_id
            );
            $result = $this->_call('Comment.validate',$content);
            if($result
            && 200 == $result['status_code']
            && 0 == $result['content']['is_success'])
            {
                //$this->success('成功操作',C('Template_pre').'Comment/get_list');
                $this->echo_message(0,'成功操作',C('Template_pre').'Comment/get_list');
                exit();
            }
        }
    }
    
    public function delete()
    {
        $id = I('get.id');
        $company_id = I('get.company_id');
        $is_validate = I('get.is_validate');
        $parent_id = I('get.parent_id');
        if(0>= $id)
        {
            //$this->error('参数错误');
            $this->echo_message(-100, '参数错误');
            exit();
        }
        $content = array(
            'id'=> $id,
            'company_id'=>$company_id,
            'is_validate'=>$is_validate,
            'parent_id' =>$parent_id,
        );
        $result = $this->_call("Comment.delete", $content);
        if($result
        && 200 == $result['status_code']
        && 0 == $result['content']['is_success'])
        {
            //$this->success('成功删除', C('Template_pre').'Comment/get_list');
            $this->echo_message(0, '成功删除', '');
            exit();
        }
        else
        {
            $this->echo_message(-1, '成功失败');
            exit();
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
        if(I('get.submit'))
        {
            $status = I('get.status');
            switch($status)
            {
                case 0:{
                        $content['where']['is_validate'] = 0;
                        $content['where']['is_delete'] = 0;
                        $this->assign('status', 0);
                    }
                    break;
                case 1:{
                        $content['where']['is_validate'] = 1;
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
            $content['where']['is_validate'] = 0;
            $content['where']['is_delete'] = 0;
            $this->assign('status', 0);
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
                     if($list
                    && 0<count($list))
                    {
                        foreach($list as $k=>$v)
                        {
                            $list[$k]['content'] = $this->_format_face($v['content']);
                            $list[$k]['parent_content'] = $this->_format_face($v['parent_content']);
                        }
                    }
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
        $parent_id = I('get.parent_id');
        if(0< $id)
        {
             //检查主体是否审核
            $result = $this->_call('Comnews.get_info', array('id'=>$parent_id));
            if($result
            && 200 == $result['status_code'])
            {
                if(0 == $result['content']['is_validate'])
                {
                    //$this->error("相应的主体未审核");
                    $this->echo_message(-100,"相应的主体未审核");
                    exit();
                }
            }
            
            $content = array(
                'id'=>$id
            );
            $result = $this->_call('Comnews.validate',$content);
            if($result
            && 200 == $result['status_code']
            && 0 == $result['content']['is_success'])
            {
                //$this->success('成功操作',C('Template_pre').'Comment/get_news_list');
                $this->echo_message(0,'成功操作',C('Template_pre').'Comment/get_news_list');
                exit();
            }
            else{
                $this->echo_message(-1,'操作失败');
                exit();
            }
        }
    }
    
    public function delete_news()
    {
        $id = I('get.id');
        if(0>= $id)
        {
            //$this->error('参数错误');
            $this->echo_message(-100,'参数错误');
            exit();
        }
        $content['id'] = $id;
        $result = $this->_call("Commentnews.delete", $content);
        if($result
        && 200 == $result['status_code']
        && 0 == $result['content']['is_success'])
        {
            //$this->success('成功删除', C('Template_pre').'Comment/get_news_list');
            $this->echo_message(0, '成功删除', C('Template_pre').'Comment/get_news_list');
            exit();
        }
        else
        {
            $this->echo_message(-1, '删除失败');
            exit();
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
        else
        {
            $content['page_size'] = $page_size;
            $content['page_index'] = $page_index;
        }
        
         if(I('get.submit'))
        {
            $status = I('get.status');
            switch($status)
            {
                case 0:{
                       // $content['where']['is_validate'] = 0;
                        $where['is_validate'] = 0;
                        $where['childs']  = array('gt', 0);
                        $where['_logic'] = 'or';
                        $content['where']['_complex'] = $where;
                        $content['where']['is_delete'] = 0;
                        $content['where']['parent_id'] = 0;
                        $content['user_id'] = -10000;
                        $this->assign('status', 0);
                        //调用统计
                        $this->_call("Comexposal.stat_re_comment");
                    }
                    break;
                case 1:{
                        $where['is_validate'] = 1;
                        $where['is_delete'] = 0;
                        $where['_logic'] = 'and';
                        $content['where']['_complex'] = $where;
                        $content['where']['parent_id'] = 0;
                        $content['user_id'] = -10000;
                        $this->assign('status', 1);
                    }
                    break;
                case 2:{
                        $content['where']['is_delete'] = 1;
                        $content['where']['parent_id'] = 0;
                        $this->assign('status', 2);
                    }
                    break;
            }
            if('' != I('get.user_id'))
            {
                $content['where']['user_id']= htmlspecialchars(I('get.user_id'));
                $this->assign('user_id', I('get.user_id'));
            }
            if(0 != I('get.type'))
            {
                $content['where']['type']= htmlspecialchars(I('get.type'));
                $this->assign('type', I('get.type'));
            }
        }
        else
        {
            //$content['where']['is_validate'] = 0;
            $where['is_validate'] = 0;
            $where['childs']  = array('gt', 0);
            $where['_logic'] = 'or';
            $content['where']['_complex'] = $where;
            $content['where']['is_delete'] = 0;
            $content['where']['parent_id'] = 0;
            $content['user_id'] = -10000;
            $this->assign('status', 0);
             //调用统计
            $this->_call("Comexposal.stat_re_comment");
        }
        
         if(I('get.s_p'))
        {
            //回复查询
            $content['page_index'] = I('get.s_p');
            $content['where']['parent_id'] = I('get.parent_id');
            $result = $this->_call("Comexposal.get_list", $content);
            if($result
            && 200 == $result['status_code']
            )
            {
                echo json_encode($result['content']);
            }
            exit();
        }
        //批量审核
        if(I('get.check_mul'))
        {                
            $tmp_list = I('get.id');
            if(!is_array($tmp_list))
            {
                //$this->error('参数错误');
                $this->echo_message(-100,'参数错误');
                exit();
            }

            foreach($tmp_list as $v)
            {
                $content = array(
                    'id'         => $v,
                );
                $result = $this->_call('Comexposal.validate', $content);
                if($result
                && 200 == $result['status_code']
                && 0 == $result['content']['is_success']
                )
                {
                }
                else
                {
                    $this->echo_message(-1,"操作失败");
                    exit();
                }
            }
            $this->echo_message(0,'成功操作', C('Template_pre').'Comment/get_exposal_list');
            exit();
        }
	    $content['order'] = array(
			'last_time'=>'desc',
			'last_child_time'=>'desc',
			'add_time'=>'desc',
		);
        
        $res = A('Callapi')->call_api('Comexposal.get_list_com_ex', 
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
                    if($list
                    && 0<count($list))
                    {
                        foreach($list as $k=>$v)
                        {
                            $list[$k]['content'] = $this->_format_face($v['content']);
                        }
                    }
                    $this->assign('list', $list);     
                    $record_count = $result['content']['record_count'];
                    $this->assign('record_count', $record_count);
                    $this->get_page($record_count, $page_size);
                }
            }
        }
    
        $this->assign('exposal_list', $this->_map_exposal());
        $this->display();
    }
    
     public function validate_exposal()
    {
        $id = I('get.id');
        $parent_id = I('get.parent_id');
        if(0< $id)
        {
            //检查主体是否审核
            $result = $this->_call('Comnews.get_info', array('id'=>$parent_id));
            if($result
            && 200 == $result['status_code'])
            {
                if(0 == $result['content']['is_validate'])
                {
                    //$this->error("相应的主体未审核");
                    $this->echo_message(-100,"相应的主体未审核");
                    exit();
                }
            }
            $content = array(
                'id'=>$id
            );
            $result = $this->_call('Comexposal.validate',$content);
            if($result
            && 200 == $result['status_code']
            && 0 == $result['content']['is_success'])
            {
                //$this->success('成功操作',C('Template_pre').'Comment/get_exposal_list');
                $this->echo_message(0,'成功操作',C('Template_pre').'Comment/get_exposal_list');
                exit();
            }
            else
            {
                $this->echo_message(-1,'操作失败');
                exit();
            }
        }
    }
    
    public function test1()
    {
        $this->display();
    }

    public function test2()
    {
        $this->display();
    }
    
    //恢复
    public function recover()
    {
        $id = I('get.id');
        $company_id = I('get.company_id');
        $is_validate = I('get.is_validate');
        $parent_id = I('get.parent_id');
        if(0>= $id)
        {
            //$this->error('参数错误');
            $this->echo_message(-100, '参数错误');
            exit();
        }
        $content = array(
            'id'=> $id,
            'company_id'=>$company_id,
            'is_validate'=>$is_validate,
            'parent_id' =>$parent_id,
        );
        $result = $this->_call("Comment.recover", $content);
        if($result
        && 200 == $result['status_code']
        && 0 == $result['content']['is_success'])
        {
            //$this->success('成功删除', C('Template_pre').'Comment/get_list');
            $this->echo_message(0, '成功恢复', C('Template_pre').'Comment/get_list');
            exit();
        }
    }
}
