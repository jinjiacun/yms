<?php
namespace Azureadmin\Controller;
use Think\Controller;
include_once(dirname(__FILE__).'/BaseController.class.php');
class ColumnManagerController extends BaseController {
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
        $this->assign('title', '栏目管理');
        $this->assign('menu_index', 2);
        
		$this->display();
	}

    /**
       功能:获取列表
     */
    public function GetTable(){
        
    }

    /**
       功能:获取一条信息
       
       参数:
       @param $AMoId int 栏目id
     */
    public function Get(){

    }

    /**
       功能:更新
       
       参数:
       @param $AMoId int 栏目编号
       @param $AMoName string 栏目名称
       @param $AMoUrl string 栏目url地址
     */
    public function Update(){

    }

    /**
       功能:新增

       参数:
       @param $AMoPId int 父栏目编号
       @param $AMoName string 栏目名称
       @param $AMoUrl string 栏目url地址
       @param $AMoType int 栏目类型
     */
    public function Add(){

    }
    
    /**
       功能:删除

       参数:
       @param $AMoId int 栏目id
     */
    public function Delete(){

    }

    public function quit()
    {
        session('AdminName',null);
        $this->redirect("Index/index");
        exit();
    }
}