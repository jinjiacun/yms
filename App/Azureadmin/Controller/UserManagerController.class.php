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
	  $user_id = 0;
	  $content['ComUserId'] = I('post.ComUserId');
	  $result = $this->_call('ComUser.get_info_by_key', $content);
	  unset($content);
	  if($result){
 	    if($result['status_code'] == 200){
	      $com_user_info = $result['content'];
	      $user_id = $result['content']['User_Id'];
	    }
	  }
	  unset($result);

	  $user_login_info = array();
	  //获取用户名|手机号|邮箱
	  $content['User_Id'] = $user_id;
	  $result = $this->_call('UserLogin.get_info', $content);
	  unset($content);
	  if($result){
	    if($result['status_code'] == 200){
    	      $user_login_info = $result['content'];
	    }
	  }
	  unset($result);

	  $cg_user_info = array();
	  //获取用户详细信息(昵称，地址等）
	  $content['User_Id'] = $user_id;
	  $result = $this->_call('CGUser.get_info_by_key', $content);
	  unset($content);
	  if($result){
	    if($result['status_code'] == 200){
	      $cg_user_info = $result['content'];
	    }
	  }
	  unset($result);
	  
	  $Dictionary = C('Dictionary');
	  $html = '';
	  if(count($com_user_info) > 0){
	     $html .= "<div class=\"widget-box\" id=\"div_edit\">
                       <div class=\"widget-title\">
                       <span class=\"icon\">
                       <i class=\"icon-align-justify\"></i></span><h5>详情</h5></div>
                       <div class=\"widget-content nopadding\">
                       <form id=\"form_edit\" action=\"/UserManage/SaveComUser/\" method=\"post\"
                       class=\"form-horizontal\">
                       <div class=\"control-group\">
                       <label class=\"control-label\">用户头像</label>
                       <div class=\"controls\">
                       <img src='" + user.UserAvatar + "' />
                       </div></div>";
             //用户名
	     if($user_login_info['LoginType'] == $Dictionary['EnumLoginType']['用户名']){
	     $html .= "<div class=\"control-group\">;
                       <label class=\"control-label\">用户名</label>
                        <div class=\"controls\">".$user_login_info['LTExtend']."
                        </div></div>";
	    }
	    $html ."<div class=\"control-group\">
                    <label class=\"control-label\">昵称</label>
                    <div class=\"controls\">".
                    $cg_user_info['UserNickName'].
                   " </div></div>
                    <div class=\"control-group\">
                    <label class=\"control-label\">真实姓名</label>
                    <div class=\"controls\">".
                    $cg_user_info['UserName'].
                   " </div></div>";
             //手机号
	     if($user_login_info['LoginType'] == $Dictionary['EnumLoginType']['手机号']){
	        $html .= "<div class=\"control-group\">
                          <label class=\"control-label\">手机号</label>
                          <div class=\"controls\">".
                          CACommon.ClassCommon.DecryptMobile(ul.LoginId).
                          "</div></div>";
	     }
	     //邮箱
	     if($user_login_info['LoginType'] == $Dictionary['EnumLoginType']['邮箱']){	     
	        $html .= "<div class=\"control-group\">
                          <label class=\"control-label\">邮箱</label>
                          <div class=\"controls\">".
                          $user_login_info['LTExtend']
                          ."</div></div>";
	     }
	      $html .= "<div class=\"control-group\">
                    <label class=\"control-label\">地址</label>
                    <div class=\"controls\">".
                    $cg_user_info['Address']
                    ."</div></div>
                    </form>
                    </div></div>";	     
	  }

	  header('Content-type:text/json');
	  $out = array('html'=>$html);
	  echo json_encode($out);
	  exit();
	}

	/**
	功能:获取vip操作

	参数:
	@@input
	@param $selValue string 
	@param $isAddFirst bool 
	*/
	public function GetVipOptions(){
	  $listComVip = array();
	  $maxVip = 0;
	  $html = '';
	  
	  $content['where']['ComId'] = session('ComId');
	  $content['where']['VipState'] = 1;
	  $result = $this->_call('ComVip', $content);
	  unset($content);
	  if($result){
	    if($result['status_code'] == 200){
	      $listComVip = $result['content'];
	    }
	  }
	  unset($result);

	  if($isAddFirst){
	     $html .= "<option value=\"\" ".( selValue == ''?"selected" : ""). " >VIP等级</option>";
	  }
	  
	  /*var userVip = listComVip.Find(q => q.VipLevel.ToString(CultureInfo.InvariantCulture) == selValue);*/
	  foreach ($listComVip as $item)
          {
	      /*
                var select = (userVip == null && item.VipLevel == maxVip) ? "selected" : item.VipLevel.ToString(CultureInfo.InvariantCulture) == selValue ? "selected" : "";
		*/
                $html .= "<option value=\"".$item['VipLevel']."\" " + select + " >".$item['VipName']."</option>";
          }
	  
	  return $html;
	}

	/**
	功能:保存

	参数:
	@@input
	@param $ComUserId
	@param $VipLevel
	@param $UCState
	*/
	public function SaveComUser(){
	       $content = array(
	            'where' => array('ComUserId'=>I('post.ComUserId')),
		    'data' => array(
		    	   'VipLevel' => I('post.VipLevel'),
			   'UCState'  => I('post.UCState')
		    ),
	       );
	       $result = $this->_call('ComUser.update', $content);
	       unset($content);
	       if($result){
	         if($result['status_code'] == 200
		 && $result['content']['is_success'] == 1){
		    $out = array('msg'=>'更新失败', 'VipName'=>'');
		    echo json_encode($out);
		    exit();
		 }
	       }
	       unset($result);

	       $ComVipInfo = array();
	       $content['ComId'] = session('ComId');
	       $content['VipLevel'] = I('post.VipLevel');
	       $result = $this-_call('ComVip.get_info', $content);
	       unset($content);
	       if($result){
	          if($result['status_code'] == 200){
		      $ComVipInfo = $result['content'];	     
		      header('Content-type:text/json');
		      $out = array('msg'=>'', 'VipName'=>$ComVipInfo['VipName']);
		      echo json_encode($out);
		      exit();
		  }
	       }
	       unset($result);
	       
	       header('Content-type:text/json');
	       $out = array('msg'=>'操作失败', 'VipName'=>'');
	       echo json_encode($out);
	       exit();
	}

	/**
	功能:设置vip等级
	*/
	public function SetVipLevel(){
	   $vip_grade_map = array();
	   $user_id_list = array();
	   $user_ids = '';
	   $listComUser = array();
	   $content['where'] = array(
	     'ComId' => session('ComId'),
	     'VipLevel' => 0
	   );
	   $content['page_size'] = 20;
	   $result = $this->_call('ComUser.get_list', $content);
	   unset($content);
	   if($result){
	     if($result['status_code'] == 200){
	       $listComUser = $result['content']['list'];
	     }
	   }	   	   
	   unset($result);

	   if(count($listComUser) > 0){
	     foreach($listComUser as $v){
	       $user_id_list[] = intval($v['User_Id']);
	     }
	     unset($v, $listComUser);
	     
	     $user_ids = implode(',', $user_id_list);
	     $content['where']['User_Id'] = array('in', $user_ids);
	     $content['page_size'] = 20;
	     $result = $this->_call('CGUser.get_list', $content);
	     unset($content);
	     if($result){
	       if($result['status_code'] == 200){
	         if(count($result['content']['list'])>0){
		   foreach($result['content']['list'] as $v){
		     $vip_grade_map[intval($v['User_Id'])] = intval($v['VipGrade']);
		   }
		   unset($v);
		 }
	       }
	     }
	     unset($result);

	     if(count($vip_grade_map) >0){
	       foreach($vip_grade_map $User_Id=>$VipGrade){
	          $content = array(
		      'where'=>array('User_Id'=>$User_Id),
		      'data'=>array('VipLevel'=>$VipGrade),
		  );
		  $result = $this->_call('ComUser.update', $content);
		  unset($content);
		  if($result){
		    if($result['status_code'] == 200
		    && $result['content']['is_success'] == 1){
		       header('Content-type:text/json');
		       $out = array('res'=>-5000);
		       echo json_encode($out);
		       exit();
		    }
		  }
		  unset($result);
	       }
	     }
	     
	   }
		   
	   header('Content-type:text/json');
           $out = array('res'=>1);
	   echo json_encode($out);
	   exit();
	}
	
}