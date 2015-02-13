<?php
namespace Soadmin\Controller;
use Soadmin\Controller;
include_once(dirname(__FILE__).'/BaseController.class.php');
class NewsController extends BaseController {

    public function _initialize()
    {
	parent::_initialize();
	if(null == session('admin_name')
	|| ''   == session('admin_name'))
	{
	    $this->redirect('/Soadmin/Login/index');
	}
    }
    //添加企业新闻
    public function add()
    {
        if(I('post.submit'))
        {
            //上传图片
            $pic     = $this->upload('pic','001006');
            $pic_app = $this->upload('pic_app','001007');
            $content = array(
                'company_id'  => intval(I('post.company_id')),
                'sign'        => intval(I('post.sign')),
                'title'       => urlencode(I('post.title')),
                'source'      => urlencode(I('post.source')),
                'author'      => urlencode(I('author')),
                'content'     => urlencode(base64_encode(I('post.content'))),
                'pic'         => $pic,
            );
             $result = $this->_call('News.add', $content);
             if($result
             && 200 == $result['status_code']
             && 0 == $result['content']['is_success'])
             {
                //$this->success("成功添加", C('Template_pre')."News/get_list",3);
                $this->echo_message(0,"成功添加", C('Template_pre')."News/get_list");
                exit();
             }
             else
             {
                $this->echo_message(-1,"添加失败");
                exit();  
             }
        }
        
        $this->assign('company_list', $this->_map_company());
        
        $this->display();
    }
    
    //天际系统新闻
    public function add_ex()
    {
         if(I('post.submit'))
        {
            //上传图片
            $pic     = $this->upload('pic','001006');
            $pic_app = $this->upload('pic_app','001007');
            $content = array(
                'sign'    => intval(I('post.sign')),
                'title'   => urlencode(I('post.title')),
                'source'  => urlencode(I('post.source')),
                'author'  => urlencode(I('post.author')),
                'content' => urlencode(base64_encode(I('post.content'))),
                'pic'     => $pic,
            );
             $result = $this->_call('News.add', $content);
             if($result
             && 200 == $result['status_code']
             && 0 == $result['content']['is_success'])
             {
                //$this->success("成功添加", C('Template_pre')."News/get_list_ex",3);
                $this->echo_message("成功添加", C('Template_pre')."News/get_list_ex");
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
                $this->echo_message(0, "成功删除", C('Template_pre')."News/get_list");
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
        if(I('post.submit'))
        {
             if('' != I('post.title'))
                $content['where']['title'] = urlencode(I('post.title'));
        }        
        $content['where']['company_id'] = array("neq",0);
        $res = A('Callapi')->call_api('News.get_list', 
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
                    $this->assign('news_list', $list);     
                    $record_count = $result['content']['record_count'];
                    $this->assign('record_count', $record_count);
                    $this->get_page($record_count, 10);
                }
            }
        }
        
        $company_list = $this->_map_company();
        $this->assign('company_list', $company_list);
        $this->display();
    }
    
    public function get_list_ex()
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
                $this->echo_message(0, "成功删除", C('Template_pre')."News/get_list_ex");
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
        if(I('post.submit'))
        {
             if('' != I('post.title'))
                $content['where']['title'] = urlencode(I('post.title'));
        }        
        $content['where']['company_id'] = array("eq",0);
        $res = A('Callapi')->call_api('News.get_list', 
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
                    $this->assign('news_list', $list);     
                    $record_count = $result['content']['record_count'];
                    $this->assign('record_count', $record_count);
                    $this->get_page($record_count, 10);
                }
            }
        }
        $company_list = $this->_map_company();
        $this->assign('company_list', $company_list);
        $this->display();
    }
    
    public function edit()
    {
        $id = I('get.id');
        if(0>= $id)
        {
            //$this->error('参数错误');
        }
        
        if(I('post.submit'))
        {
        	$id = I('post.id');
        	$company_id = I('post.company_id');
        	$content['data'] = array(
        			'company_id'  => intval(I('post.company_id')),
                                'sign'        => intval(I('post.sign')),
		                'title'       => urlencode(I('post.title')),
		                'source'      => urlencode(I('post.source')),
		                'author'      => urlencode(I('post.author')),
		                'content'     => urlencode(base64_encode(I('post.content'))),
        	);	
        	if($pic = $this->upload('pic','001006'))
        	{
        		$content['data']['pic'] = $pic;
        	}
        	if($pic_app = $this->upload('pic_app','001007'))
        	{
        		$content['data']['pic_app'] = $pic_app;
        	}
        	$content['where'] = array(
        			'id'=>$id,
        	);
        	$result = $this->_call("News.update", $content);
        	if($result
        	&& 200 == $result['status_code']
        	&& 0 == $result['content']['is_success'])
        	{
        		//$this->success("成功修改",C('Template_pre')."News/get_list");
                $this->echo_message(0,"成功修改",C('Template_pre')."News/get_list");
                exit();
        	}
            else
            {
                $this->echo_message(-1,"修改失败");
                exit();   
            }
        }
        
        $content['id'] = $id;
        $result = $this->_call("News.get_info", $content);
        if($result
        && 200 == $result['status_code'])
        {
            $news_info = $result['content'];
            $news_info['content'] = base64_decode($news_info['content']);
            $this->assign('news', $news_info);
        }
        
        $company_list = $this->_map_company();
        $this->assign('company_list', $company_list);
        $this->display();
    }
    
    public function edit_ex()
    {
        $id = I('get.id');
        if(0>= $id)
        {
            //$this->error('参数错误');
        }
        if(I('post.submit'))
        {
        	$id = I('post.id');
        	$company_id = I('post.company_id');
        	$content['data'] = array(
                                'sign'        => I('post.sign'),
        			'title'       => urlencode(I('post.title')),
        			'source'      => urlencode(I('post.source')),
        			'author'      => urlencode(I('post.author')),
        			'content'     => urlencode(base64_encode(I('post.content'))),
        	);
        	if($pic = $this->upload('pic','001006'))
        	{
        		$content['data']['pic'] = $pic;
        	}
        	if($pic_app = $this->upload('pic_app','001007'))
        	{
        		$content['data']['pic_app'] = $pic_app;
        	}
        	$content['where'] = array(
        			'id'=>$id,
        	);
        	$result = $this->_call("News.update", $content);
        	if($result
        			&& 200 == $result['status_code']
        			&& 0 == $result['content']['is_success'])
        	{
        		//$this->success("成功修改",C('Template_pre')."News/get_list");
                $this->echo_message(0,"成功修改",C('Template_pre')."News/get_list");
                exit();
        	}
            else
            {
                $this->echo_message(-1,"修改失败");
                exit();   
            }
        }
        
        $content['id'] = $id;
        $result = $this->_call("News.get_info", $content);
        if($result
        && 200 == $result['status_code'])
        {
            $news_info = $result['content'];
            $news_info['content'] = base64_decode($news_info['content']);
            $this->assign('news', $news_info);
        }
        $this->display();
    }
    
    public function delete()
    {
       if(I('get.id'))
       {
       	 $content = array(
       	 		'id'=>I('get.id'),       	 		
       	 );
       	 
       	 $result = $this->_call("News.delete",$content);
       	 if($result
       	 && 200 == $result['status_code']
       	 && 0 == $result['content']['is_success'])
       	 {
       	 	//$this->success("成功删除", C('Template_pre')."News/get_list_ex", 3);
            $this->echo_message(0,"成功删除", C('Template_pre')."News/get_list");
            exit();
       	 }
         else
         {
            $this->echo_message(-1,"删除失败");
            exit();
         }
       }
    }
}