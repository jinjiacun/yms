<?php
namespace Azureadmin\Controller;
use Think\Controller;
include_once(dirname(__FILE__).'/BaseController.class.php');
class RoleManagerController extends BaseController {
    public function _initialize()
    {
        parent::_initialize();
        if(null == session('AdminName')
        || ''   == session('AdminName'))
        {
            $this->redirect('/Azureadmin/Login/index');
        }
    }

    /**
       功能:入口函数
     */
	public function Index()
	{   
		$this->display();
	}

    /**
       功能:查询表格
     */
    public function GetTable(){

    }

    /**
       功能:删除

       参数:
       @param $RoleId int 角色id
     */
    public function Delete(){

    }

    /**
       功能:新增
       
       参数:
       @param $RoleName string 角色名称
       @param $ComId int 所属机构id
       @param $column string 权限(多个权限之间用','隔开)
     */
    public function Add(){

    }
    
    /**
       功能:更新

       参数:
       @param $RoleId int 角色id
       @param $RoleName string 角色名称
       @param $column string 角色权限(之间用','隔开)
     */
    public function Update(){
    }

    /**
       功能:获取所有机构和权限       
     */
    public funtion GetAllColumn(){

    }

    /**
       功能:获取角色信息

       参数:
       @param $RoleId int 角色id
     */
    public function GetRole(){

    }
    
    
    public function quit()
    {
        session('AdminName',null);
        $this->redirect("Index/index");
        exit();
    }
}