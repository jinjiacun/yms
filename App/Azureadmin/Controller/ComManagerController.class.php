<?php
namespace Azureadmin\Controller;
use Azureadmin\Controller;
include_once(dirname(__FILE__).'/BaseController.class.php');

class ComManagerController extends BaseController{
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
		    $this->assign('item', $result['content']);
		  }
		}
		
		$this->display();
	}
	
	public function ComTable_Oper(){
	       	$content['ComId'] = session('ComId');
		$result = $this->_call('ComTable.get_info_by_key', $content);
		unset($content);
		if($result){
		  if($result['status_code'] == 200){
		    $this->assign('item', $result['content']);
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
		    $this->assign('item', $result['content']);
		  }
		}
		
		$this->display();	
	}

	public function Edit_ComIntro(){
	  $content['ComId'] = session('ComId');
	  $result = $this->_call('ComInit.get_info', $content);
	  if($result){
	    if($result['status_code'] == 200){
	      $this->assign('item', $result['content']);
	    }
	  }
	  unset($result);
	
	  $this->display();
	}

	public function SaveComIntro(){
	       $content = array(
	           'where' => array('ComId'=>session('ComId')),
		   'data'  => array(
		           'ComIntro_Introduce' => urlencode(base64_encode(I('post.Introduce'))),
			   'ComIntro_Download'  => urlencode(base64_encode(I('post.Download'))), 
			   'ComIntro_Contact'   => urlencode(base64_encode(I('post.Contact'))),
		   ),
	       );
	       $result = $this->_call("ComInit.update", $content);
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
	       
	       header('Content-type:text/json');
	       $out = array('res'=>5000);
	       echo json_encode($out);
	       exit();
	}

	public function Edit_ComSafe(){
	  $content['ComId'] = session('ComId');
	  $result = $this->_call('ComInit.get_info', $content);
	  unset($content);
	  if($result){
	    if($result['status_code'] == 200){
	      $this->assign('item', $result['content']);
	    }
	  }
	  unset($result);

	  $this->display();
	}

	public function SaveComSafe(){
	   $content = array(
	           'where' => array('ComId'=>session('ComId')),
		   'data'  => array(
		           'ComSafe_Invest'    => urlencode(base64_encode(I('post.Invest'))),
			   'ComSafe_Guarantee' => urlencode(base64_encode(I('post.Guarantee'))), 
			   'ComSafe_Suggest'   => urlencode(base64_encode(I('post.Suggest'))),
		   ),
	       );
	   $result = $this->_call("ComInit.update", $content);
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
	
	   header('Content-type:text/json');
	   $out = array('res'=>5001);
	   echo json_encode($out);
	   exit();
	}

	public function ComInit_Oper()
	{
		$this->assign('menu_index', 15);
		
		$content['ComId'] = session('ComId');
	  	$result = $this->_call('ComInit.get_info', $content);
	 	if($result){
	    	  if($result['status_code'] == 200){
	      	    $this->assign('item', $result['content']);
	    	  }
	  	}
	  	unset($result);

		$this->assign('dictionary', C('Dictionary'));

		//获取themes
		$content['where']['ThemeState'] = 1;
		$result = $this->_call('Theme.get_list', $content);
	 	if($result){
	    	  if($result['status_code'] == 200){
	      	    $this->assign('theme_list', $result['content']['list']);
	    	  }
	  	}
	  	unset($result);
		
		
		$this->display();	
	}	

	public function SaveComInit(){
	      $restypes = I('post.restypes');
	      if(strpos($restypes)){
	        $restypes = '0'.$restypes;
	      }
	      $content = array(
	         'where'=>array('ComId'=>session('ComId')),
		 'data' =>array(
           	      'ResType'      => I('post.restypes'),
             	      'ThemeId'      => I('post.ThemeId'),
             	      'ComShowSpan'  => I('post.ComShowSpan'),
             	      'ComShowState' => I('post.ComShowState'),
             	      'ComShowAsc'   => I('post.ComShowAsc'),
             	      'CeUpTime'     => date('Y-m-d H:i:s'),
             	      'ShowType'     => I('post.ShowType')
		 )
	      );
	      $result = $this->_call('ComInit.update', $content);
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
	      $out = array('res'=>5001);
	      echo json_encode($out);
	      exit();
	}

	/**
	 功能：添加友情链接

	 参数：
	 @@input
	 @param $linkName string 友情链接链接名称
         @param $linkImg string 友情链接图片
         @param $linkUrl string 友情链接地址
         @param $comLinkType string  友情链接类型（0.文字，1.图片）
         @param $addType int 添加类型(0.友链，1.合作伙伴)
	*/
	public function AddFriendlyLink(){
	       $content = array(
	                'ComId'     => session('ComId'),
                        'LinkAdmin' => session('AdminId'),
                        'LinkAlt'   => I('post.linkName'),
                        'LinkImg'   => I('post.linkImg'),
                        'LinkName'  => I('post.linkName'),
                        'LinkState' => 1,
                        'LinkTime'  => date('Y-m-d H:i:s'),
                        'LinkType'  => I('post.addType'),
                        'LinkUrl'   => I('post.linkUrl')
	       );
	       $result = $this->_call('ComLink.add', $content);
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
	       $out = array('res'=>5001);
	       echo json_encode($out);
	       exit();
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
	
	/**
	功能：修改友情链接

	参数：
	@@input
	@param $linkId int 友情链接ID
        @param $linkName string 友情链接名称
        @param $linkImg string 友情链接图片
        @param $linkUrl string 友情链接地址
        @param $comLinkType int 友情链接类型（0.文字，1.图片）
        @param $updateType int 更新类型(0.友链，1.合作伙伴)
	*/
	public function UpdateFriendlyLink(){
	  $content = array(
	     'where'=>array('LinkId'=>I('post.LinkId')),
	     'data'=>array(
	          'LinkName' => I('post.LinkName'),
                  'LinkImg'  => I('post.LinkImg'),
                  'LinkUrl'  => I('post.LinkUrl'),
                  'LinkTime' => date('Y-m-d H:i:s'),
	     )
	  );
	  $result = $this->_call('ComLink.update', $content);
	  unset($content);
	  if($result){
	    if($result['status_code'] == 200
	    && $result['content']['is_success'] == 0){
              header("Content-type:text/json");
	      $out = array('res'=>1);
	      echo json_encode($out);
	      exit();
	    }
	  }

	  header("Content-type:text/json");
	  $out = array('res'=>5000);
	  echo json_encode($out);
	  exit();
	}

	/**
	 功能：删除友情链接

	 参数：
	 @@input
	 @param $LinkId int 友情链接ID
	*/
	public function DelFriendlyLink(){
	  $content['LinkId'] = I('post.LinkId');
	  $result = $this->_call('ComLink.delete', $content);
	  unset($content);
	  if($result){
	    if($result['status_code'] == 200
	    && $result['content']['is_success'] == 0){
              header("Content-type:text/json");
	      $out = array('res'=>1);
	      echo json_encode($out);
	      exit();
	    }
	  }

	  header("Content-type:text/json");
	  $out = array('res'=>5000);
	  echo json_encode($out);
	  exit();
	}

	public function ComTable_Img()
	{
		$this->assign('menu_index', 17);
		$this->display();	
	}	
}