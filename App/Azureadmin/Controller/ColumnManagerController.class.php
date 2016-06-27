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

    //查询平台
    $page_index = 1;
    $page_size  = 20;
    $content    = array();
    $content['page_size'] = $page_size;
    $content['page_index'] = $page_index;    
    $content['where']['AMoType'] = 1;
    $content['where']['AMoPId'] = 0;
    $res = A('Callapi')->call_api('Amodule.get_list', 
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
            }
        }
    }

    //查询机构
    $content['where']['AMoType'] = 2;
    $content['where']['AMoPId'] = 0;
    $res = A('Callapi')->call_api('Amodule.get_list', 
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
                $this->assign('list_ex', $list);
            }
        }
    }

    unset($result);
    $id_list = array();
    $ids = '';
    //查询三级关系
    if($list && 0<count($list))
    {
      foreach($list as $v)
      {
        $id_list[] = $v['AMoId'];
      }


      if(0< count($id_list))
      {
        $ids = implode($id_list, ',');
        $content['where']['AMoType'] = 2;
        $content['where']['AMoPId'] = array('in', $ids);
        $res = A('Callapi')->call_api('Amodule.get_list', $content, 'text', null);
        $result = $this->deal_re_call_api($res);
        if($result)
        {
          if(200 == $result['status_code']){
            if(isset($result['content']['list'])
            && isset($result['content']['record_count']))
            {
              $tmp_list = $result['content']['list'];
              foreach($list as $k=>$v)
              {
                foreach($tmp_list as $t_k=>$t_v)
                {
                    if($v['AMoId'] == $t_v['AMoPId'])
                    {
                      $list[$k]['_ex'][] = $t_v;
                    }
                }
              }
               $this->assign('list_ex', $list);
            }
          }
        }
      }
    }






        
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