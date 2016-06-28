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

    $this->assign('menu_index', 3);
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
           
    $res = A('Callapi')->call_api('Comrole.get_list', 
                                $content,
                                'text',
                              null);
    $result = $this->deal_re_call_api($res);

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
                $this->assign('page', $this->get_page_by_custom(C('controller').'/RoleManager/GetTable', 1, $record_count, $page_size));
            }
        }
    }  

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
    public function GetAllColumn(){

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