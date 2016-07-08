<?php
namespace Azureadmin\Controller;
use Azureadmin\Controller;
include_once(dirname(__FILE__).'/BaseController.class.php');

class ComManagerController extends BaseController{

	public function index()
	{
		
	}

	/**
	功能：获取机构基本信息	
	*/
	public function ComTable()
	{
		$this->assign('menu_index', 13);
		
		$content['ComId'] = session('ComId');
		$result = $this->_call('ComTable.get_info_by_key', $content);
		unset($content);
		if($result){
		  if($result['status_code'] == 200){
		    $this->assign('info', $result['content']);
		  }
		}
		
		$this->display();
	}

	public function SaveComTable(){
	  
	}

	public function ComInit()
	{
		$this->assign('menu_index', 14);
		
		$content['ComId'] = session('ComId');
		$result = $this->_call('ComInit.get_info', $content);
		unset($content);
		if($result){
		  if($result['status_code'] == 200){
		    $this->assign('info', $result['content']);
		  }
		}
		
		$this->display();	
	}

	public function ComInit_Oper()
	{
		$this->assign('menu_index', 15);
		$this->display();	
	}	

	public function FriendlyLink()
	{
		$this->assign('menu_index', 16);
		
		$content['where']['ComId'] = session('ComId');
		$content['where']['LinkState'] = 1;
		//查询友情链接
		$content['where']['LinkType'] = 0;
		$result = $this->_call('ComLink.get_list', $content);
		if($result){
		  if($result['status_code'] == 200
		  && count($result['content']['list']) > 0){
		     $this->assign('list', $result['content']['list']);
		  }
		}		
		unset($result);

	        //查询合作链接
		$content['where']['LinkType'] = 1;
		$result = $this->_call('ComLink.get_list', $content);
		if($result){
		  if($result['status_code'] == 200
		  && count($result['content']['list']) > 0){
		     $this->assign('list_ex', $result['content']['list']);
		  }
		}		
		unset($result);
		unset($content);


		//友情链接展开方式
		$com_link_type = 0;
		$content['ComId'] = session('ComId');
		$result = $this->_call('ComInit.get_info', $content);
		unset($conten);
		if($result){
		  if($result['status_code'] == 200){
		    if(isset($result['content']['ComLinkType'])){
		     $com_link_type = $result['content']['ComLinkType'];
		    }
		  }
		}
		$this->assign('com_link_type', $com_link_type);
		
		$this->display();	
	}	

	public function ComTable_Img()
	{
		$this->assign('menu_index', 17);
		$this->display();	
	}	
}