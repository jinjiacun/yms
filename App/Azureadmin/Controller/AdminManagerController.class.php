<?php
namespace Azureadmin\Controller;
use Think\Controller;
include_once(dirname(__FILE__).'/BaseController.class.php');
/*--管理员管理--*/
class AdminManagerController extends BaseController {
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
        $this->assign('menu_index', 7);

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
        
        if(session('ComId') != 0)
        {
            $content['where']['ComId'] = session('ComId');
        }

        $result = $this->_call('ComAdmin.get_list', $content);

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

		$this->display();
	}

	/**
	功能：设置管理员状态

	参数：
	@@input
	@param $AdminId int 编号
	@param $AdminState int 状态
	*/
	public function SetState(){
	       $content = array(
	       		'where' => array(
				'AdminId' => I('post.AdminId'),
			),
			'data' => array(
			       'AdminState' => I('post.AdminState'),
			       'UpTime' => date('Y-m-d H:i:s'),
			),
	       );
	       $result = $this->_call('ComAdmin.update', $content);
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
	功能：获取所有角色
	*/
	public function GetAllRole(){
	       //平台
	       if(session('ComId') == 0){
	           	$content['ComId'] = sesion('ComId');
	           	$result = $this->_call('ComAdmin.get_list', $content);
	           	unset($result);
	           	if($result)
	           	{
	           		
	           	}
	       }
	       else{//机构

	       }
	}

	/**
	功能：增加管理员

	参数：
	@@input
	@param $AdminName string 管理员姓名
	@param $Password string 登录密码
	@param $RoleId int 所属角色
	@param $ComId int 所属机构
	@param $AdminUserName string 登录账号
	*/
	public function Add(){
	       //检查用户名是否存在
	       ////帐号已存在
               //     return Content("{\"res\":-5002}");
	       $content['AdminUserName'] = I('post.AdminUserName');
	       $result = $this->_call('ComAdmin.is_exists', $content);
	       unset($content);
	       if($result){
		if($result['status_code'] == 200
		&& $result['content']['is_exists'] == 1){
		   $out = array('res'=>-5002);
		   echo json_encode($out);
		   exit();
		}
	       }
	       unset($result);

	       //新增
	       $content = array(
	       		'AdminName' => I('post.AdminName'),
                        'AdminUserName' => I('post.AdminUserName'),
                        'Password' => C('DefaultPassword'),
                        'ComId' => session('ComId') > 0 ? session('ComId') : 0,
                        'RoleId' => I('post.RoleId'),
                        'AuthNo' => "",
                        'Adavatar' => "",
                        'Creatime' => date('Y-m-d H:i:s') ,
                        'UpTime' => date('Y-m-d H:i:s'),
                        'AdminState' => 1,
                        'LoginIp' => "",
                        'LoginTime' => "1970-1-1 00:00:00",
                        'CreateAdminId' => session('AdminId')
	       );
	       $result = $this->_call('ComAdmin.add', $content);
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
	 功能：修改管理员

	参数：
	@@input
	@param $AdminId int 管理员编号
	@param $AdminName string 管理员姓名
	@param $Password string 登录密码
	@param $RoleId int 所属角色
	@param $ComId int 所属机构
	@param $AdminUserName string 登录账号
	*/
	public function Update(){
	       //检查用户名
	       //帐号已存在
               //     return Content("{\"res\":-5002}");
	       $content['AdminUserName'] = I('post.AdminUserName');
	       $result = $this->_call('ComAdmin.is_exists', $content);
	       unset($content);
	       if($result){
	         if($result['status_code'] == 200
		 && $result['content']['is_exists'] == 1){
		    $out = array('res'=>-5002);
		    echo json_encode($out);
		    exit();
		 }
	       }
	       unset($result);

	       $content = array(
	       		'where' => array(
				'AdminId'=>I('post.AdminId'),
			),
			'data' => array(
			       'AdminName' => I('post.AdminName'),
			       'AdminUserName' => I('post.AdminUserName'),
			       'UpTime' => date('Y-m-d H:i:s')		       
			),
	       );

	       if(I('post.Password') != ''){
	               $content['data']['Password'] = md5(I('post.Password'));
	       }
	       if(I('post.RoleId') > 0){
	               $content['data']['RoleId'] = intval(I('post.RoleId'));
	       }

	       $result = $this->_call('ComAdmin.update', $content);
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
	功能：修改密码

	参数：
	@@input
	@param $AdminId int 管理员编号
	@param $Password string 登录密码
	*/
	public function UpdatePwd(){
	       if(I('post.Password') == ''){
	       $out = array('res'=>-5001);
	       echo json_encode($out);
	       exit();
	       }

	       $content = array(
	       		'where'=>array(
				'AdminId'=>I('post.AdminId'),
			),
			'data'=>array(
				'Password'=>md5(I('post.Password')),
				'UpTime'=>date('Y-m-d H:i:s'),
			),
	       );
	       $result = $this->_call('ComAdmin.update', $content);
	       unset($content);
	       if($result){
	         if($result['status_code'] == 200
		 && $result['content']['is_success'] == 0){
		 $out = array('res'=>1);
		 echo  json_encode($out);
		 exit();
		 }
	       }
	       unset($result);

	       $out = array('res'=>-5002);
	       echo json_encode($out);
	       exit();
	}

	/**
	功能：获取管理员信息

	参数：
	@@input
	@param $AdminId int 管理员编号
	*/
	public function GetAdmin(){
	       $content = array(
	           'AdminId'=>I('post.AdminId')
		   );
	       $result = $this->_call('ComAdmin.get_info_by_key', $content);
	       unset($content);
	       $_info = array();
	       if($result){
                  if($result['staus_code'] == 200){
		  $_info = $result['content'];
		 }
	       }
	       unset($result);
	       
	       if(count($_info) >0){
	       	  $data = array(
		     'name' => $_info['AdminName'],
		     'uname' => $_info['AdminUserName'],
		     'RoleId' => $_info['RoleId'],
		     'company' => $_info['ComId']
		  );
		  $out = array('res'=>1, 'd'=>$data);
		  echo json_encode($out);
		  exit();
	       }
	       
	       $out = array('res'=>-5000);
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