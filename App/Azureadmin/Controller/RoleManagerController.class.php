<?php
namespace Azureadmin\Controller;
use Think\Controller;
include_once(dirname(__FILE__).'/BaseController.class.php');
class RoleManagerController extends BaseController {
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
    if(session('ComId') != 0)
    {
      $content['where']['ComId'] = session('ComId');
    }
           
    $result = $this->_call('ComRole.get_list', $content);

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
       功能：删除角色

       参数:
       @param $RoleId int 角色id
     */
    public function Delete(){
    	   $RoleId = I('post.RoleId');

	  //判定是否是系统角色，系统角色不可删除
	  //return Content("{\"res\":-5001}");
	  $content['RoleId'] = $RoleId;
	  $content['AdminId'] = 0;
	  $result = $this->_call('ComRole.is_exists', $content);
	  unset($content);
	  if($result){
		if($result['status_code'] == 200
		&& $result['content']['is_exists']){
		   $out = array('res'=>-5001);
		   echo json_encode($out);
		   exit();
		}	
	  }
	  unset($result);

	  //删除角色权限关联
	  //return Content("{\"res\":-5002}");
	  $content['RoleId'] = $RoleId;
	  $result = $this->_call('ComRoMo.delete', $content);
	  if($result){
		if($result['status_code'] == 200 
		&& $result['content']['is_success'] == 1){
		   $out = array('res'=>-5002);
		   echo json_encode($out);
		   exit();
		}
	  }
	  unset($result);

	  //删除角色
	  //return Content("{\"res\":-5003}");
	  $content['RoleId'] = $RoleId;
	  $result = $this->_call('ComRole.delete', $content);
	  unset($content);
	  if($result){
		if($result['status_code']
		&& $result['content']['is_success']){
		   $out = array('res'=>-5003);
		   echo json_encode($out);
		   exit();
		}
	  }
	  unset($result);

	  $out = array('res'=>1);
	  echo json_encode($out);
	  exit();
    }

    /**
       功能:新增
       
       参数:
       @@input
       @param $RoleName string 名称
       @param $ComId int       机构id
       @param $column string   角色权限（多个之间用','隔开）
     */
    public function Add(){
    	   //增加角色
	   //return Content("{\"res\":-5001}");
	   $content = array(
	   	    'AdminId'	=> session('AdminId'),
                    'ComId'   	=> intval(session('ComId')),
                    'RoleName' 	=> I('post.RoleName'),
                    'RoleState' => 1,
                    'Creatime' 	=> date('Y-m-d H:i:s'),
                    'UpTime' 	=> date('Y-m-d H:i:s')
	   );
	   $result = $this->_call('ComRole.add', $content);
	   unset($content);
	   $RoleId = 0;
	   if($result){
		if($result['status_code'] == 200
		&& 1 == $result['content']['is_success']){
		   $out = array('res'=>-5001);
		   echo json_encode($out);
		   exit();	   
		}
	   }
	   $RoleId = $result['content']['id'];
	   unset($result);

	   //增加角色权限
	   //return Content("{\"res\":-5002}");
	   $AMIdList = explode(',', $column);	   
	   foreach($AMIdList as $v){
	   	$content[] = array(
	   	'RoleId'   => $RoleId, 
		'AMId' 	   => intval($v), 
		'Creatime' => date('Y-m-d H:i:s')
	   	);		     		     
	   }
	   $result = $this->_call('ComRoMo.add_all', $content);
	   if($result){
		if($result['status_code'] == 200
		&& 1 == $result['content']['is_success']){
		   $out = array('res'=>-5002);
		   echo json_encode($out);
		   exit();
		}
	   }

	   $out = array('res'=>1);
	   echo json_encode($out);
	   exit();
    }
    
    /**
       功能:修改

       参数:
       @param $RoleId int 角色id
       @param $RoleName string 角色名称
       @param $column string 角色权限（多个之间用','隔开）
     */
    public function Update(){
    	   $RoleId = I('post.RoleId');
	   $RoleName = I('post.RoleName');
	   $column = I('post.column');
	   //当前权限列表
	   $CurrentRightList = explode(',', $column);

    	   //更新角色表
	   //return Content("{\"res\":-5001}");
	   $content = array(
	   	    'where'=>array('RoleId'=>$RoleId),
	   	    'data'=>array(
		    	   	'RoleName' => $RoleName,
				'UpTime'   => date('Y-m-d H:i:s')
				)
	   );
	   $result = $this->_call('ComRole.update', $content);
	   unset($content);
	   if($result){
		if($result['status_code'] == 200
		&& $result['content']['is_success'] == 1){
		   $out = array('res'=>-5001);
		   echo json_encode($out);
		   exit();
		}
	   }
	   unset($result);

	   //--更新角色权限
	   if(count($CurrentRightList)>0){
		     //删除去掉的权限
		     //return Content("{\"res\":-5002}");
		     $AmIdList = array();
		     $content = array(#查询当前权限
			      'where'=>array(
				  'RoleId'=>$RoleId
			      ),
		     );
		     $result = $this->_call("ComRole.get_list", $content);
		     unset($content);
		     if($result){
			  if($result['status_code'] == 200
			  && $result['content']['list']
			  && count($result['content']['list'])>0){
			     foreach($result['content']['list'] as $v){
			     $AMIdList[] = intval($v['AMId']);		   
			     }
			  }
		     }
		     unset($result);
		     
		     $_diff = array_diff($AMIdList, $CurrentRightList);
		     if(count($_diff) >0){
		          $AMIdStr = implode(',', $_diff);
			  $content['AMId'] = array('in', $AMIdStr);
			  unset($AMIdStr);
			  $result = $this->_call('ComRoMo.delete', $content);
			  unset($content);
			  if($result){
				if($result['status_code'] == 200
				&& $result['contnt']['is_success'] == 1){
				   $out = array('res'=>-5002);
				   echo json_encode($out);
				   exit();
				}
			  }
			  unset($result);
		     }
		     unset($_diff);		     
		     
		     //增加新增的权限
		     //return Content("{\"res\":-5003}");
		     $_diff = array_diff($CurrentRightList, $AMIdList);
		     if(count($_diff)>0){
			foreach($_diff as $v){
			  $content[] = array(
			      'RoleId'	  => $RoleId, 
			      'AMId'   	  => intval($v), 
			      'Creatime'  => date('Y-m-d H:i:s')
			  );
			}
			unset($v);

			$result = $this->_call('ComRoMo.add_all', $content);
			unset($content);
			if($result){
			  if($result['status_code'] == 200
			  && 1 == $result['content']['is_success']){
			    $out = array('res'=>-5003);
			    echo json_encode($out);
			    exit();
			  }
			}
			unset($resul);
		     }
		     unset($_diff);
	   }
	   
	   $out = array('res'=>1);
	   echo json_encode($out);
	   exit();
    }

    /**
       功能:获取所有机构和栏目
     */
    public function GetAllColumn(){
    	   //机构
	   if(session('ComId') > 0){
	       $ComTableInfo = array();
	       $AModuleList = array();
	       $content['ComId'] = session('ComId');
	       $result = $this->_call('ComTable.get_info_by_key', $content);
	       unset($content);
	       if($result){
		if($result['status_code'] == 200
		&& count($result['content']) > 0){
		   $ComTableInfo = $result['content'];
		}
	       }
	       unset($result);
	       
	       //屏蔽分析师栏目，且为父栏目同时存在有权限的子栏目(待定???)
	       $TeacherInitColList = explode(',', C('TeacherInitCol'));
	       $content = array(
	       		'where' => array(
				'AMoType' => 2,
			)
	       );
	       $result = $this->_call('AModule.get_list', $content);
	       unset($content);
	       if($result){
		if($result['status_code'] == 200){
		$AModuleList = $result['content']['list'];
		$_list = array();
		if($AModuleList
		&& count($AModuleList)>0){
		   
		   foreach($AModuleList as $v){
		      $_list[] = array(
		      	      'id' => intval($v['AMoId']),
			      'pId' => intval($v['AMoPId']),
			      'name' => $v['AMoName'],
		      );
		      $out = array(
		      	   'res'=>1,
			   'type'=>2,
			   'data'=>array(
			     'column' => $_list,
			     'company' => $ComTableInfo['ComAllName']
			   )
		      );
		      echo json_encode($out);
		      exit();
		   }
		}
		}
	       }
	   }
	   else{//平台
		$content['where']['AMoType'] = 1;
	   	$result = $this->_call('AModule.get_list', $content);
	   	unset($contnt);
		$_list = array();
	   	if($result){
			if($result['status_code'] == 200){
			    if(isset($result['content']['list'])
			    && count($result['content']['list']) >0 ){
			       foreach($result['content']['list'] as $v){
			       	  $_list[] = array(
				  	   'id' => intval($v['AMoId']),
					   'pId' => intval($v['AMoPId']),
					   'name' => $v['AMoName']);
			       }
			       $out = array('res'  =>1,
				            'type' =>1,
					    'data' =>array(
					    	   'column'=>$_list,
						   'company'=>C('PlatForm'),
						)
					    );
			       echo json_encode($out);
			       exit();
			    }
	   		}
	   	}
	   }
	   
	   $out = array('res'=>-5000);
	   echo json_encode($out);
	   exit();
    }

    /**
       功能:获取角色及其权限

       参数:
       @param $RoleId int 角色id
     */
    public function GetRole(){
    	   $RoleId = intval(I('post.RoleId'));    	   

	   
    	   //获取角色信息
	   $RoleName = '';
	   $content = array(
	   	    'RoleId'=>$RoleId
	   );
	   $result = $this->_call('ComRole.get_info_by_key', $content);
	   unset($content);
	   if($result){
		if($result['status_code'] == 200){
			$RoleName = $result['content']['RoleName'];		  
		}
	   }
	   unset($result);

	   //获取机构信息
	   $company = C('PlatForm');
	   if(session('ComId') > 0){
	      $content['ComId'] = session('ComId');
	      $result = $this->_call('ComTable.get_info_by_key', $content);
	      unset($content);
	      if($result){
		if($result['status_code'] == 200){
		   $company = $result['content']['ComAllName'];
		}
	      }
	      unset($result);
	   }
	   

	   //获取角色权限
	   $ComRoMoList = array();
	   $content['where']['RoleId'] = $RoleId;
	   $result = $this->_call('ComRoMo.get_list', $content);
	   unset($content);
	   if($result){
		if($result['status_code'] == 200){
		   $_tmp_list = $result['content']['list'];
		   if(count($_tmp_list)){
			foreach($_tmp_list as $v){
			   $ComRoMoList[] = intval($v['AMId']);
			}
			unset($tmp_list, $v);
		   }
		}
	   }
	   unset($result);

	   //获取所有栏目
	   $ColumnList = array();
	   $content['where']['AMoType'] = session('ComId')>0?2:1;
	   $result = $this->_call('AModule.get_list', $content);
	   unset($content);
	   if($result){
		if($result['status_code'] == 200){
		   $ColumnList = $result['content']['list'];
		}
	   }
	   unset($result);

	   

	   if(session('ComId') >0){
	       /*
	       需要屏蔽的内容：
	       a.属于分析师的子栏目(如果当前栏目没有跟栏目，本身也理解成子栏目)       
	       */
	       //todo:??
	       
	   }

	   $_list = array();
	   if(count($ColumnList) > 0){
	   	foreach($ColumnList as $v){
		      $_list = array(
		      	     'id'      => $v['AMoId'],
			     'pId'     => $v['AMoPId'],
			     'name'    => $v['AMoName'],
			     'checked' => in_array($v['AMoId'], $ComRoMo)?true:false
		      );
		}
		
		$out = array(
		     'res'  => 1,
		     'data' => array(
		     	    'role'    => $RoleName,
			    'company' => $company,
			    'column'  => $_list
		     )
		);
		echo json_encode($out);
		exit();
	   }

	   
    }
    
    
    public function quit()
    {
        session('AdminName',null);
        $this->redirect("Index/index");
        exit();
    }
}