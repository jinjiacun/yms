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

	/**
	功能：重置用户密码

	参数:
	@@input
	@param $uid int 用户id
	@param $pwd string 密码
	@param $repwd string 确认密码
	*/
	public function ResetUserPwd(){
	       if(I('post.pwd') <> I('post.repwd')){
	          header('Content-type:text/json');
		  $out = array('res'=>502);
	          echo json_encode($out);
	          exit();
	       }

	       $content = array(
	          'where' => array(),
		  'data'  => array(),
	       );
	       //???
	}
	
	/**
	功能：修改密码

	参数：
	@@input
	@param $OldPassword 旧密码
	@param $NewPassword 新密码
	*/	
	public function SavePassword(){
	 $com_admin_info = array();
	 $content['AdminId'] = session('AdminId');
	 $result = $this->_call('ComAdmin.get_info_by_key', $content);
	 unset($content);

	 if($result){
	   if($result['status_code'] == 200){
	     $com_admin_info = $result['content'];	 
	   }
	 }
	 unset($result);

	 if($com_admin_info['Password'] <> md5(I('post.OldPassword'))){
	   header('Content-type:text/json');
	   $out = array('msg'=>'原登陆密码错误.');
	   echo json_encode($out);
	   exit();
	 }

	 $content['data']['Password'] = I('post.NewPassword');
	 $content['where']['AdminId'] = session('AdminId');
	 $result = $this->_call('ComAdmin.update', $content);
	 unset($content);
	 if($result){
	   if($result['status_code'] == 200
	   && $result['content']['is_success'] == 0){
	      header('Content-type:text/json');
	      $out = array('msg'=>'修改成功.');
	      echo json_encode($out);
	      exit();
	   }
	 }
	 
	 header('Content-type:text/json');
	 $out = array('msg'=>'修改失败.');
	 echo json_encode($out);
	 exit();
	}

	/*-----------------------分析师个人信息管理-----------------------------------------*/
	
	public function Bind_ComAdminLTE(){
	   //获取分析师账号信息
	   $com_admin_info = array();
	   $content['AdminId'] = session('AdminId');
	   $result = $this->_call('ComAdmin.get_info_by_key', $content);
	   unset($content);
	   if($result){
	     if($resul['status_code'] == 200){
	       $com_admin_info = $resul['content'];
	     }
	   }
	   unset($result);

	   //获取角色
	   $com_role_info = array();
	   $role_name = '';
	   $content['RoleId'] = session('RoleId');
	   $result = $this->_call('ComRole.get_info_by_key', $content);
	   unset($content);
	   if($result){
	     if($result['status_code'] == 200){
	       $com_role_info = $result['content'];
	       $role_name = $com_role_info['RoleName'];
	     }
	   }
	   unset($result);
	   
	   //所属直播室
	   $com_room_list = array();
	   $room_name_list = array();
	   $room_names = '';
	   $content['where']['RoomTeacher'] = array('like', '$'.session('AdminId').'$');
	   $result = $this->_call('ComRoom.get_list', $content);
	   unset($content);
	   if($result){
	     if($result['status_code']){	     
	       $com_room_list = $result['content']['list'];	       
	     }
	   }
	   unset($result);

	   if(count($com_room_list) > 0){
	    foreach($com_room_list as $v){
	      $com_name_list = $v['RoomName'];
	    }   
	    unset($v);
	    $room_names = implode(',', $com_name_list);
	    unset($com_name_list);
	    $room_names .= ',';
	   }

	   //分析师个人信息
	   $com_admin_lte_info = array();
	   $content['AdminId'] = session('AdminId');
	   $result = $this->_call('ComAdminLTE.get_info', $content);
	   unset($content);
	   if($result){
	     if($result['status_code'] == 200){
	       $com_admin_lte_info = $result['content'];
	     }
	   }

	   header('Content-type:text/json');
	   $out = array(
	   	'Adavatar'=>$com_admin['Adavatar'],
		'ComAdminLTE' => array(
		   lblAdminId = comAdmin.AdminId.ToString(),
                        'lblAdminUserName' => $com_admin_info['AdminUserName'],
                        'lblRoleName'      => $com_role_info['RoleName'],
                        'lblRoomName'      => $com_room_info['RoomName'],
                        //lblPower'        => lblPower,
                        'lblAdminName'     => $com_admin_info['AdminName'],
                        'lblComTLevel'     => $com_admin_lte_info['ComTLevel'],
                        'lblComTStyle'     => $com_admin_lte['ComTStyle'] == '' ? "" : $com_admin_lte_info['ComTStyle'],
                        'lblComTIntro'     => $com_admin_lte['ComTIntro'] == '' ? "" : $com_admin_lte_info['ComTIntro']
		)
	   );
	   echo json_encode($out);
	   exit();
	}
	

	public function Bind_Edit_ComAdminLTE(){
	  $id = I('post.id');
	  //获取账号信息
	  $com_admin_info = array();
	  $content['AdminId'] = $id;
	  $result = $this->_call('ComAdmin.get_info_by_key', $content);
	  unset($content);
	  if($result){
	    if($result['status_code'] == 200){
	       $com_admin_info = $result['content'];
	    }
	  }
	  unset($result);

	  //获取分析师个人信息
	  $com_admin_lte_info = array();
	  $content['ComAdminId'] = session('AdminId');
	  $result = $this->_call('ComAdminLTE.get_info', $content);
	  unset($content);
	  if($result){
	    if($result['status_code'] == 200){
	      $com_admin_lte_info = $result['content'];
	    }
	  }
	  unset($result);

	  $html = "<div id=\"div_edit\" class=\"widget-box\">
                <div class=\"widget-title\">
                    <span class=\"icon\">
                        <i class=\"icon-align-justify\"></i>
                    </span>
                    <h5>编辑</h5>
                </div>
                <div class=\"widget-content nopadding\">
                    <form id=\"form_edit\" action=\"\" method=\"post\"
                        class=\"form-horizontal\">
                        <div class=\"control-group class1\">
                            <img id=\"Adavatar\" src=\"{0}\" /><br/><br/>
                                              <span class=\"uploadtips\">* 图片的尺寸必须是 136px * 136px</span>
                            <div class=\"div-file\">
                               <input type=\"file\" id=\"imgfile\" />
                            </div>
                        </div>
                        <div class=\"control-group\">
                            <label class=\"control-label\">分析师姓名</label>
                            <div class=\"controls\">
                                <input id=\"AdminName\" name=\"AdminName\" type=\"text\" value=\"{1}\" >
                            </div>
                        </div>
                        <div class=\"control-group\">
                            <label class=\"control-label\">分析师等级</label>
                            <div class=\"controls\">
                                <select id=\"ComTLevel\" name=\"ComTLevel\" class=\"s-auto\">
                 {2}
                                </select>
            
                            </div>
                        </div>
                        <div class=\"control-group\">
                            <label class=\"control-label\">分析师风格</label>
                            <div class=\"controls\">
                                <input id=\"ComTStyle\" name=\"ComTStyle\" type=\"text\" value=\"{3}\" >
                            </div>
                        </div>
                        <div class=\"control-group\">
                            <label class=\"control-label\">分析师格言</label>
                            <div class=\"controls\">
                                <input id=\"ComTIntro\" name=\"ComTIntro\" type=\"text\" value=\"{4}\" >
                            </div>
                        </div>
                        <div class=\"form-actions\">
                            <button type=\"button\" onclick=\"SaveComAdminLTE('{5}');\" class=\"btn btn-primary\">保存</button>
                        </div>
                    </form>
                </div>
                        </div>";

	    //替换
	    $html = str_replace('{0}', $com_admin_info['Adavatar'], $html);//comAdmin.Adavatar
	    $html = str_replace('{1}', $com_admin_info['AdminName'], $html);//comAdmin.AdminName
	    $html = str_replace('{2}', '', $html);//GetStateOptions<EnumAnalystRank>(comAdminLTE.ComTLevel == null ? EnumAnalystRank.初级分析师.ToString("D") : comAdminLTE.ComTLevel),
	    $html = str_replace('{3}', $com_admin_lte_info['ComTStyle'], $html);//comAdminLTE.ComTStyle == null ? "" : comAdminLTE.ComTStyle	   
	    $html = str_replace('{4}', '', $html);//comAdminLTE.ComTIntro == null ? "" : comAdminLTE.ComTIntro,	    
	    $html = str_replace('{5}', $id, $html);//id

	    header('Content-type:text/json');
	    $out = array(
	      'html'=> $html
	    );
	    echo json_encode($out);
	    exit();
	}

	public function SaveComAdminLTE(){
	    //更新账号信息
	    $com_admin_info = array();
	    $content['where']['AdminId'] = I('post.AdminId');
	    $content['data']['AdminName'] = I('post.AdminName');
	    $content['data']['Adavatar'] = I('post.Adavatar');
	    $result = $this->_call('ComAdmin.update', $content);
	    unset($content);
	    if($result){
	      if($result['status_code'] == 200
	      && $result['content']['is_success'] == 1){
	        header('Content-type:text/json');
		$out = array('res'=>-5001);
		echo json_encode($out);
	        exit();
	      }
	   }
	   unset($result);
	    
	   //更新分析师信息
	   //判定是否存在此账号的分析师
	   $is_exists = False;
	   $content['ComAdminId'] = I('post.AdminId');
	   $result = $this->_call('ComAdminLTE.is_exist', $content);
	   unset($content);
	   if($result){
	     if($result['status_code'] == 200
	     && $result['content']['is_exists'] == 0){
	       $is_exists = True;
	     }
	   }
	   unset($result);

	   if($is_exists){
	      //更新
	      $content = array(
	         'where' => array('ComAdminId'=>I('post.AdminId')),
		 'data'  => array(
		   'ComTLevel' => urlencode(I("post.ComTLevel"));
                   'ComTStyle' => urlencode(I("post.ComTStyle"));
                   'ComTIntr'  => urlencode(I("post.ComTIntro"));
		 )
	      ); 
	      $result = $this->_call('ComAdminLTE.update', $content);
	      unset($content);
	      if($result){
	       if($result['status_code'] == 200
	       && $result['content']['is_success'] == 1){
	          header('Content-type:text/json');
		  $out = array('res'=>-5001);
	          echo json_encode($out);
	       	  exit();
	       }
	     }
	   }	
	   else{
	     //新增
	     $content = array(

	     );	      
	     $result = $this->_call('ComAdminLTE.add', $content);
	     unset($content);
	     if($result){
	       if($result['status_code'] == 200
	       && $result['content']['is_success'] == 1){
	          header('Content-type:text/json');
		  $out = array('res'=>-5002);
	          echo json_encode($out);
	       	  exit();
	       }
	     }
	   }

	   header('Content-type:text/json');
	   $out = array('res'=>1);
	   echo json_encode($out);
	   exit();
	}
	
	/*-----------------------分析师个人信息管理-----------------------------------------*/
}