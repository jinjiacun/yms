<?php
namespace Soadmin\Controller;
use Think\Controller;
include_once(dirname(__FILE__).'/BaseController.class.php');
/**
 *广告管理
*/
class AdController extends BaseController {
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
                'pic'            => $this->upload('pic','001011'),
                'title'          => urlencode(I('post.title')),
        		'url'           => I('post.url'),
        	);
            $result = $this->_call("Ad.add",
                                   $content);
            if($result
            && 200 == $result['status_code']
            && 0 == $result['content']['is_success'])
            {
                $this->echo_message(0,'成功添加',C('Template_pre')."Ad/get_list");    
                exit();
            }
            else{
                $this->echo_message(-2,'添加失败');    
                exit();
            }
        }
		$this->display();
	}
	
	public function edit()
	{
		$id = intval(I('get.id'));
        if(I('post.submit'))
        {
            $content = array(
                'where'=>array(
                    'id'=>I('post.id'),
                ),    
                'data' => array(                  
                    'title'          => I('post.title'),
                    'url'            => I('post.url'),
                )
            );
            if($pic = $this->upload('pic','001011'))
            {
                 $content['data']['pic']   =  $pic;
            }
            
            $result = $this->_call("Ad.update",
                                    $content);
            if($result
            &&  200 == $result['status_code']
            &&  0  == $result['content']['is_success']
            )
            {
                $this->echo_message(0,'成功保存', C('Template_pre')."Ad/get_list");
                exit();   
            }
			else
			{
				$this->echo_message(-1,'保存失败');
                exit();   
			}
        }
        
        $content = array(
            'id'=> $id,
        );
        $result = $this->_call('Ad.get_info',
                               $content);
        if($result
        && 200 == $result['status_code'])
        {
            $this->assign('obj', $result['content']);
        }
        
        $this->display();

	}
	
	public function get_list()
	{
	    $page_index = 1;
        $page_size  = 20;
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
        
		$content = array();     
        if(I('get.submit'))
        {   
        }
		$result = $this->_call("Ad.get_list", $content);
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
                    $this->get_page($record_count, $page_size);
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
            $this->echo_message(-100,"参数错误");
            exit();
        }   
          
        $result = $this->_call("Ad.delete",array('id'=>$id));    
        if($result
        && 200 == $result['status_code']
        && 0 == $result['content']['is_success']
        )
        {
            $this->echo_message(0,"成功操作", C('Template_pre')."Ad/get_list");
            exit();
         }
         else
         {
            $this->echo_message(-1,"删除失败");
            exit();
         }
	}
}
