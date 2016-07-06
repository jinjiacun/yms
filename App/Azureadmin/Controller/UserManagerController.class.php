<?php
namespace Azureadmin\Controller;
use Azureadmin\Controller;
include_once(dirname(__FILE__).'/BaseController.class.php');

class UserManagerController extends BaseController{

	public function index()
	{
	  $this->assign('menu_index', 12);

	  $page_index = 1;
          $page_size  = 20;
          $content    = array();
          if(I('get.page'))
          {
            $page_index = I('get.page');
            $content['page_size'] = $page_size;
            $content['page_index'] = $page_index;
          }
          else
          {
            $content['page_size'] = $page_size;
            $content['page_index'] = $page_index;
          }
	  
	  if(session('ComId') >0){
	    $content['where']['ComId'] = session('ComId');
	  }
               
          $content['order']['User_Id'] = 'desc';
          $result = $this->_call('ComUser.get_list', $content);
	  unset($content);	  

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
                    $this->assign('page', $this->get_page_by_custom(C('controller').'/UserManager/Index', $page_index, $record_count, $page_size));
                }
            }
          }
	  unset($result);

	  $vip_list = array();//以VipLevel作为键值
	  //获取当前机构的vip等级
	  $content['where']['ComId'] = session('ComId');
	  $content['page_size'] = 20;
	  $result = $this->_call('ComVip.get_list', $content);
	  unset($content);
	  if($result){
	    if($result['status_code'] == 200){
	         if(count($result['content']['list']) > 0){
		   foreach($result['content']['list'] as $v){
		   	$vip_list[intval($v['VipLevel'])] = $v;
		   }
		   unset($v);
		   $this->assign('vip_list', $vip_list);
		 }
	    }
	  }
	  unset($result);

	  //是否允许查看
	  $content['ComAdmin'] = session('AdminId');
	  $result = $this->_call('ComInit.is_exists', $content);
	  unset($content);
	  if($result){
	     if($result['status_code'] == 200
	     && $result['content']['is_exits'] == 0){
	     	$this->assign('is_allow', 1);
	     }
	  }
	  unset($result);

	   $user_ids = '';
	  //获取用户详细信息(真实姓名)
          if(count($list) > 0){
	    $user_id_list = array();	   
	    $tmp_list = array();
	    foreach($list as $v){
	      $user_id_list[] = intval($v['User_Id']);
	      $tmp_list[intval($v['User_Id'])] = $v;
	    }
	    unset($v);
	    $list = $tmp_list;
	    unset($tmp_list);
	    if(count($user_id_list) >0){
	       $user_ids = implode(',', $user_id_list);
	       $content['where']['User_Id'] = array('in', $user_ids);
	       $content['page_size'] = 20;
	       $result = $this->_call('CGUser.get_list', $content);
	       unset($content);
	       if($result){
	         if($result['status_code'] == 200){
                   foreach($result['content']['list'] as $v){
		      $list[intval($v['User_Id'])] = array_merge($list[intval($v['User_Id'])], $v);
		   }
		   $this->assign('list', $list);
		 }
	       }
	       
	     }
	  }
	  unset($result);
	  
	  //获取用户名|手机号码|邮箱
	  if(count($list) > 0){
	    if(count($user_id_list) >0){
	       $user_ids = implode(',', $user_id_list);
	       $content['where']['User_Id'] = array('in', $user_ids);
	       $content['page_size'] = 20;
	       $result = $this->_call('UserLogin.get_list', $content);
	       unset($content);
	       if($result){
	         if($result['status_code'] == 200){
                   foreach($result['content']['list'] as $v){
		      $list[intval($v['User_Id'])] = array_merge($list[intval($v['User_Id'])], $v);
		   }
		   $this->assign('list', $list);
		 }
	       }
	       
	     }
	  }

	  $this->display();
	}

	/**
	功能：更新用户状态

	参数：
	@@input
	@param $ComUserId int 机构用户Id 
	@param $UCState int 状态
	*/
	public function EditUCState(){
	  $content = array(
	      'where' => array('ComUserId'=>I('post.ComUserId')),
	      'data' => array(
	        'UCState' => I('post.UCState')
	      ),
	  );
	  $result = $this->_call('', $content);
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

	/**
	功能：获取用户信息

	参数：
	@@input
	@param $ComUserId 机构用户id
	*/
	public function Bind_Edit_ComUser(){
	   $content['ComUserId'] = I('post.ComUserId');

	   $result = $this->_call('ComUser.get_info_by_key', $content);
	   unset($content);
	   $html = "<div class=\"widget-box\" id=\"div_edit\">
	    	      <div class=\"widget-title\">
            	              <span class=\"icon\">
			         <i class=\"icon-align-justify\"></i>
                              </span>
			       <h5>编辑</h5>
	              </div>
                      <div class=\"widget-content nopadding\">
                      <form id=\"form_edit\" action=\"/UserManage/SaveComUser/\" method=\"post\"
                        class=\"form-horizontal\">
                        <div class=\"control-group\">
                           <label class=\"control-label\">VIP等级</label>
                           <div class=\"controls\">
                               <select id=\"VipLevel\" name=\"VipLevel\" class=\"s-auto\">{0}</select>
                            </div>
                        </div>
                        <div class=\"control-group\">
                            <label class=\"control-label\">状态</label>
                            <div class=\"controls\">
                                <select id=\"UCState\" name=\"UCState\" class=\"s-auto\">{1}</select>
                            </div>
                        </div>
                        <div class=\"form-actions\">
                            <button type=\"button\" onclick=\"SaveComUser('{2}');\" class=\"btn btn-primary\">保存</button>
                        </div>
                    </form>
                </div>
            </div>";	   

	   $com_user_info = array();
	   if($result){
	     if($result['status_code'] == 200){
	       $com_user_info = $result['content'];

	       $html = str_replace('{0}', $com_user_info['VipLevel'], $html);//VipLevel
	       $html = str_replace('{1}', $com_user_info['UCState'], $html);//UCState
	       $html = str_replace('{2}', I('post.ComUserId'), $html);//ComUserId
	       echo $html;
	       exit();
	     }
	   }
	}

	/**
	功能：获取详情

	参数：
	@@input
	@param $ComUserId int 机构用户id
	*/
	public function GetDetails(){
	  $com_user_info = array();
	  $content['ComUserId'] = I('post.ComUserId');
	  $result = $this->_call('ComUser.get_info_by_key', $content);
	  unset($content);
	  if($result){
 	    if($result['status_code'] == 200){
	      $com_user_info = $result['content'];
	    }
	  }
	  unset($result);

	  if(count($com_user_info) > 0){
	    
	  }

	}
	
}