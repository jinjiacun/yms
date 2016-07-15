<?php
namespace Azureadmin\Controller;
use Azureadmin\Controller;
include_once(dirname(__FILE__).'/BaseController.class.php');

class NewsManagerController extends BaseController{
        public function _initialize()
	{
	   parent::_initialize();
	   parent::get_dictionary();
	   if(null == session('AdminName')
	   || ''   == session('AdminName')){
	      $this->redirect('/Azureadmin/Login/index');
	   }
	}

	public function index()
	{
		$this->assign('menu_index', 11);

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
        
        if(session('ComId') > 0)
        {
        	$content['where']['ComId'] = session('ComId');
        }       

        $content['where']['NewsState'] = 1;
        $content['where']['ColumnId'] = 222;
        
        $result = $this->_call('ComNews.get_list', $content);

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
                    //$this->get_page($record_count, $page_size);
                    $this->assign('page', $this->get_page_by_custom(C('controller').'/CompanyManager/GetTable', 1, $record_count, $page_size));
                }
            }
        }
        unset($result);

		$this->display();
	}

	public function showone(){
	       $NewId = '';
	       if(I('get.id')){
	         $NewId = I('get.id');
		 $content['NewId'] = $NewId;
		 $result = $this->_call('ComNews.get_info_by_key', $content);
		 unset($content);
		 if($result){
		   if($result['status_code'] == 200
		   && count($result['content']) >0){
		    $this->assign('info', $result['content']);
		   }
		 }
	       }
	       else{
	         $NewId = '00000000-0000-0000-0000-000000000000';
	       }
	       $this->assign('NewId', $NewId);
	       
	       $this->display();
	}

	public function Save(){
	       $id = '';
	       //判定新增还是修改
	       if(I('post.id')){
		$id = I('post.id');
		if($id == '00000000-0000-0000-0000-000000000000'){
		       //新增
		       $content = array(
		          'NewId'         => create_guid(),
			  'AdminId'       => session('AdminId'),
			  'AdminName'     => $this->dictionary['admin'][session('AdminId')],
		       	  'NewsTitle'     => urlencode(I('post.NewsTitle')),
			  'NewsCon'       => urlencode(I('post.NewsCon')),
			  'NewsDocReader' => urlencode(base64_encode(I('post.NewsDocReader'))),
			  'ColumnId'      => 222,
			  'NewsUrl' 	  => "",
			  'NewsImg' 	  => '',
			  'ComId' 	  => session('ComId'),
			  'NewsState' 	  => 1,
			  'NewsFlag' 	  => 1,
			  'NewShowTime'   => I('post.NewShowTime'),		   	  
		       );
		       $result = $this->_call('ComNews.add', $content);
		       unset($content);
		       if($result){
			  if($result['status_code'] == 200
			  && $result['content']['is_success'] == 0){		
			     header('Content-type:text/json');
			     $out = array('res'=>1);
			     echo json_encode($out);
			     exit();
			  }
		       }
		       unset($result);            
		}
		else{
		       //修改
		       $content = array(
		       	  'where'=>array('NewId'=>$id),
			  'data'=>array(
			      'NewsTitle'     => urlencode(I('post.NewsTitle')),
			      'NewsCon'       => urlencode(I('post.NewsCon')),
			      'NewsDocReader' => urlencode(base64_encode(I('post.NewsDocReader'))),
			      'ColumnId'      => 222,
			      'NewsUrl' 	  => "",
			      'NewsImg' 	  => '',
			      'ComId' 	  => session('ComId'),
			      'NewsState' 	  => 1,
			      'NewsFlag' 	  => 1,
			      'NewShowTime'   => I('post.NewShowTime'),
			  )
		       );
		       $result = $this->_call('ComNews.update', $content);
		       unset($content);
		       if($result){
			  if($result['status_code'] == 200
			  && $result['content']['is_success'] == 0){		
			     header('Content-type:text/json');
			     $out = array('res'=>1);
			     echo json_encode($out);
			     exit();
			  }
		       }
		       unset($result);		       
		}	
		header('Content-type:text/json');
		$out = array('res'=>-5001);
		echo json_encode($out);		
		exit();	
	       }
	}

	/**
	功能：删除
	
	参数：
	@@input
	@param $NewId int 新闻id
	*/
	public function Delete(){
	   $content = array('NewId'=>I('post.NewId'));
	   $result = $this->_call('ComNews.delete', $content);
	   unset($content);
	   if($result){
	     if($result['status_code'] == 200
	     && $result['content']['is_success'] == 0){
	       header('Content-type:text/json');
	       $out = array('res'=>1);
	       echo json_encode($out);
	       exit();
	     }
	   }

	   header('Content-type:text/json');
	   $out = array('res'=>-5001);
	   echo json_encode($out);
	   exit();
	}
}