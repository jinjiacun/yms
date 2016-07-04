<?php
namespace Azureadmin\Controller;
use Think\Controller;
include_once(dirname(__FILE__).'/BaseController.class.php');
/**
	¹«¸æ¹ÜÀí
*/
class NoticeManagerController extends BaseController {
    public function _initialize()
    {
        parent::_initialize();
        parent::get_dictionary();
        if(null == session('AdminName')
        || ''   == session('AdminName'))
        {
            $this->redirect('/Azureadmin/Login/index');
        }
    }

	public function index()
	{
        $this->assign('menu_index', 4);

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
        
        $result = $this->_call('AllMessage.get_list', $content);

        $list = array();
        if($result)
        {
            if(200 == $result['status_code'])
            {
                if(isset($result['content']['list'])
                && isset($result['content']['record_count']))
                {
                    $list   = $result['content']['list'];   
                    //解析多个机构
                    if(count($list)> 0)
                    {
                    	;
                    }
                    $this->assign('list', $list);     
                    $record_count = $result['content']['record_count'];
                    $this->assign('record_count', $record_count);
                    //$this->get_page($record_count, $page_size);
                    $this->assign('page', $this->get_page_by_custom(C('controller').'/NoticeManager/GetTable', 1, $record_count, $page_size));
                }
            }
        }

		$this->display();
	}

	/**
	功能:获取所有机构
	*/
	public function GetAllCompany(){
	       $content['ComState'] = array('neq', 0);
	       $result = $this->_call('ComTable.get_list', $content);
	       unset($content);
	       
	       $_list = array();
	       if($result){
			if($result['status_code'] == 200){
		  		if(count($result['content']['list']) > 0){
		     		foreach($result['content']['list'] as $v){
		       			$_list[] = array(
		             		'name' => $v['ComName'], 
			     			'id'   => intval($v['ComId']), 
					);
		     		}
		     		$out = array(
		     	  		'res'  => 1,
			  			'data' => $_list);
		     			echo json_encode($out);
		     			exit();
		  		}		  
			}
	       }
	}

	/**
	功能:增加公告
	
	参数:
	@@input
	@param $FMComId string 机构编号（逗号分隔）
	@param $FMCon string 内容
	@param $FMTitle string 标题
	*/
	public function AddNotice(){
	       $content = array(
	       	    'FMTitle' => urlencode(I('post.FMTitle')),
                'FMCon'   => urlencode(I('post.FMCon')),
                'FMComId' => I('post.FMComId'),
                'FMState' => 1,
                'FMFlag'  => 0
	       );
	       $result = $this->_call('AllMessage.add', $content);
	       unset($content);
	       if($result){
				if($result['status_code'] == 200
				&& $result['content']['is_success'] == 0){
				   $out = array('res'=>1);
				   echo json_encode($out);
				   exit();
				}
	       }

	       $out = array('res'=>-5001);
	       echo json_encode($out);
	       exit();
	}

	/**
	¹¦ÄÜ:ÐÞ¸Ä¹«¸æ

	²ÎÊý:
	@@input
	@param $FMComId string »ú¹¹±àºÅ£¨¶ººÅ·Ö¸ô£©
	@param $FMCon string ÄÚÈÝ
	@param $FMTitle string ÄÚÈÝ
	@param $FMId int ¹«¸æ±àºÅ
	*/
	public function UpdateNotice(){
	   $content = array(
	         'where' => array('FMId' => I('post.FMId')),
		 'data'  => array(
		 	 'FMTitle'  => I('post.FMTitle'),
                	 'FMCon'    => I('post.FMCon'),
                	 'FMComId'  => I('post.FMComId'),
                	 'FMUpTime' => date('Y-m-d H:i:s'),
                	 'FMFlag'   => 0
		 )
	   );
	   $result = $this->_call('AllMessage.update', $content);
	   unset($content);
	   if($result){
	     if($result['status_code'] == 200
	     && $result['content']['is_success'] == 0){
	        $out = array('res'=>1);
	        echo json_encode($out);
	     	exit();
	     }
	   }

	   $out = array('res'=>-5001);
	   echo json_encode($out);
	   exit();
	}

	/**
	¹¦ÄÜ£º É¾³ý¹«¸æ

	²ÎÊý£º
	@@input
	@param $FMId int ¹«¸æ±àºÅ
	*/	
	public function Delete(){
	   $content['FMId'] = I('post.FMId');   
	   $result = $this->_call('AllMessage.delete', $content);
	   unset($content);
	   if($result){
	     if($result['status_code'] == 200
	     && $result['content']['is_success'] == 0){
	        $out = array('res'=>1);
	        echo json_encode($out);
	     	exit();
	     }
	   }

	   $out = array('res'=>-5001);
	   echo json_encode($out);
	   exit();       
	}

	/**
	¹¦ÄÜ£º»ñÈ¡¹«¸æ
	
	²ÎÊý£º
	@@input
	@param $FMId int ¹«¸æ±àºÅ
	*/
	public function GetNotice(){
	   $content = array(
	   	    
	   );
	   $result = $this->_call('AllMessage.add', $content);
	   unset($content);
	   if($result){
	     if($result['status_code'] == 200){
	        $_list = array(
  		    'title'   => $result['content']['FMTitle'], 
	   	    'content' => $result['content']['FMCon'], 
		    'company' => $result['content']['FMComId']
		);
	        $out = array('res'=>1, 'data'=>$_list);
	        echo json_encode($out);
	     	exit();
	     }
	   }

	   $out = array('res'=>-5001);
	   echo json_encode($out);
	   exit();       
	}

    public function quit()
    {
        session('AdminName',null);
        $this->redirect("Index/index");
        exit();
    }
}