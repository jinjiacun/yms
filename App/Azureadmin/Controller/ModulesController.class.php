<?php
namespace Azureadmin\Controller;
use Think\Controller;
include_once(dirname(__FILE__).'/BaseController.class.php');
/**
	前台模块管理
*/
class ModulesController extends BaseController {
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
	  $this->assign('menu_index', 6);
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
               
          $content['where']['MoPid'] = 0;
          $content['order']['MoId'] = 'asc';
        
          $result = $this->_call('ComModule.get_list', $content);

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

          //èŽ·å–æ¬¡çº§æ¨¡å—
          unset($result);
         if($list
         && 0<count($list))
         {
            $id_list = array();
            $ids = '';
            foreach($list as $v)
            {
                $id_list[] = $v['MoId'];
            }
            if(0<count($id_list))
                $ids = implode(',', $id_list);

            $content['where']['MoPid'] = array('in', $ids);
            $result = $this->_call('ComModule.get_list', $content);
            if($result)
            {
                if(200 == $result['status_code'])
                {
                    if(isset($result['content']['list'])
                    && isset($result['content']['record_count']))
                    {
                        $tmp_list = $result['content']['list'];
                        foreach($list as $k=>$v)
                        {
                            foreach($tmp_list as $_k=>$_v)
                            {
                                if($v['MoId'] == $_v['MoPid'])
                                {
                                    $list[$k]['_ex'][] = $_v;
                                    unset($tmp_list[$_k]);    
                                }
                            }
                        }
                        $this->assign('list', $list);
                    }
                }
            }
         }

		$this->display();
	}

	
	public function GetTable(){
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
               
          $content['where']['MoPid'] = 0;
          $content['order']['MoId'] = 'asc';
        
          $result = $this->_call('ComModule.get_list', $content);

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

          //èŽ·å–æ¬¡çº§æ¨¡å—
          unset($result);
         if($list
         && 0<count($list))
         {
            $id_list = array();
            $ids = '';
            foreach($list as $v)
            {
                $id_list[] = $v['MoId'];
            }
            if(0<count($id_list))
                $ids = implode(',', $id_list);

            $content['where']['MoPid'] = array('in', $ids);
            $result = $this->_call('ComModule.get_list', $content);
            if($result)
            {
                if(200 == $result['status_code'])
                {
                    if(isset($result['content']['list'])
                    && isset($result['content']['record_count']))
                    {
                        $tmp_list = $result['content']['list'];
                        foreach($list as $k=>$v)
                        {
                            foreach($tmp_list as $_k=>$_v)
                            {
                                if($v['MoId'] == $_v['MoPid'])
                                {
                                    $list[$k]['_ex'][] = $_v;
                                    unset($tmp_list[$_k]);    
                                }
                            }
                        }
                        $this->assign('list', $list);
                    }
                }
            }
         }

	       $html = '';
	       foreach($list as $item){
	        $version = '';
		if($item['MoType'] == 1){
		  $version = '白金版，钻石版，尊享版';
		}
		else if($item['MoType'] == 2){
		  $version = '钻石版，尊享版';
		}
		else{
		  $version = '尊享版';
		}
		$isNeed = '';
		if($item['MoNeed'] == 1){
		  $isNeed = '是';
		}
		else{
		  $isNeed = '否';
		}
	        $html .= "
                <tr data-tt-parent-id='0' data-tt-id='$item[MoId]'>
                    <td><span class='column' title='$item[MoName]'>$item[MoName]</span></td>
                    <td>$item[MoUrl]</td>
                    <td title=''>$item[MoIntro]</td>
                    <td>$version</td>
                    <td style='text-align: center;'>$isNeed</td>
                    <td><button onclick='op.x(0,$item[MoId],this)' data-isneed='1' class='btn btn-mini'>增加子模块</button>&nbsp;<button onclick='op.x(0,null,this)' class='btn btn-primary btn-mini'>增加同级模块</button>&nbsp;<button onclick='op.y(this,$item[MoId])' class='btn btn-danger btn-mini'>删除模块</button>&nbsp;<button onclick='op.z(this,$item[MoId])' class='btn btn-mini'>修改模块</button></td>
                </tr>";
		foreach($item['_ex'] as $s_item){
		    $s_version = '';
		    if($s_item['MoType'] == 1){
		      $s_version = '白金版，钻石版，尊享版';  
		    }
		    else if($s_item['MoType'] == 2){
		      $s_version = '钻石版，尊享版';
		    }
		    else{
		      $s_version = '尊享版';
		    }
		    $s_isNeed = '';
		    if($s_item['MoNeed'] == 1){
		      $s_isNeed = '是';
		    }
		    else{
		      $s_isNeed = '否';
		    }
		    $html .= "
                    <tr data-tt-parent-id='$s_item[MoPid]' data-tt-id='$s_item[MoId]'>
                        <td><span class='column' title='$s_item[MoName]'>$s_item[MoName]</span></td>
                        <td>$s_item[MoUrl]</td>
                        <td title=''>$s_item[MoIntro]</td>
                        <td>$s_version</td>
                        <td style='text-align: center;'>$s_isNeed</td>
                        <td><button onclick='op.x(0,null,this)' class='btn btn-primary btn-mini'>增加同级模块</button>&nbsp;<button onclick='op.y(this,$s_item[MoId])' class='btn btn-danger btn-mini'>删除模块</button>&nbsp;<button onclick='op.z(this,$s_item[MoId])' class='btn btn-mini'>修改模块</button></td>
                    </tr>";
                }
	     }

	     echo $html;
	     exit();
	}

	/**
	功能：添加模块
	
        参数：
	@@input
	@param $AdminId int 创建者id
	@param $MoState int 状态
	@param $MoUrl string url
	@param $MoIntro string 介绍
	@param $Mopid int 父节点id
	@param $MoType int 类型
	@param $MoNeed int 是否必要
	*/
	public function AddModel(){
	       $content = array(
	       		'MoName'  => urlencode(I('post.MoName')),
	       		'AdminId' => session('AdminId'),
			'MoState' => 1,
			'MoUrl'   => I('post.MoUrl'),
			'MoIntro' => urlencode(I('post.MoIntro')),
			'MoPid'   => I('post.MoPid'),
			'MoType'  => I('post.MoType'),
			'MoNeed'  => i('post.MoNeed')
	       );
	       $result = $this->_call('ComModule.add', $content);
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
	功能：获取模块

	参数：
	@@input
	@param $MoId int 模块id
	*/
	public function GetModel(){
	       $content['MoId'] = I('get.MoId');
	       $result = $this->_call('ComModule.get_info_by_key', $content);
	       unset($content);
	       if($result){
		if($result['status_code'] == 200){
		  header('Content-type:text/json');
		  $out = $result['content'];
		  echo json_encode($out);		  
		  exit();
	       }
	     } 
	}

	/**
	功能：更新

	参数：
	@@input
	@param $MoId int
	@param $MoNeed 
	@param $MoType
	@param $MoIntro
	@param $MoName
	@param $MoUrl	
	*/
	public function UpdateModel(){
	       $model = array(
	       	      'MoId'	=> I('post.MoId'),
		      'MoNeed' 	=> I('post.MoNeed'),
		      'MoType'	=> I('post.MoType'),
		      'MoName'  => urlencode(I('post.MoName'))
	       );
	       $content['MoId'] = I('post.MoId');
	       $ComModuleInfo = array();
	       $result = $this->_call('ComModule.get_info_by_key', $content);
	       unset($content);
	       if($result){
		if($result['status_code'] == 200){
		   $ComModuleInfo = $result['content'];
		}
	       }
	       unset($result);
	       
	       $_list = array();
	       if($ComModuleInfo){
	        if($ComModuleInfo['MoPid'] == 0
		&& (($ComModuleInfo['MoNeed'] != $model['MoNeed']
		    && $model['MoNeed'] == 0)
		   || $ComModuleInfo['MoType'] < $model['MoType'])){
		      $content['where'] = array(
		      	'_string' => "MoPid = $ComModuleInfo[MoId] and (MoNeed <> $model[Noeed] or MoType < $model[MoType])",
		      ); 
		      $result = $this->_call('ComModule.get_list', $content);
		      unset($content);
		      if($result){
			if($result['status_code'] == 200){
				$_list = $result['content']['list'];
			}
		      }
		      unset($result);
		   }
	       }
	       
	       if(count($_list) > 0){
	       	  foreach($_list as $v){
		    $item = $v;
		    unset($item['MoId']);
		    $content = array(
		    	     'where' => array('MoId' => $model['MoId']),
		    	     'data' => $item
		    );
		    $content['data']['MoNeed'] = $model['MoNeed'];     
                    if($v['MoType'] < $model['MoType']){
                            $content['data']['MoType'] = $model['MoType'];
		    }
		    $result = $this->_call('ComModule.update', $content);
		    unset($content);
		    if($result){
			if($result['status_code'] == 200
			&& $result['content']['is_success'] == 1){
			   $out = array('res'=>-5002);
			   echo json_encode($out);
			   exit();
			}
		    }	
		  }		 
	       }

	       $content = array(
	       		'where' => array('MoId'=>$model['MoId']),
	       		'data'=>array(
	       		'MoUpTime' => date('Y-m-d H:i:s'),
			'MoType'   => $model['MoType'],
			'MoIntro'  => '', 
			'MoName'   => $model['MoName'],
			'MoNeed'   => $model['MoNeed'],
			'MoUrl'    => '',
			'AdminId'  => session('AdminId'),
			)
	       	);
		$result = $this->_call('ComModule.update', $content);
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
	功能：删除

	参数：
	@@input
	@param $MoId int
	*/
	public function DeleteModel(){
	       $MoId = I('post.MoId');
	       //查询父节点及其子节点
	       $content['where']['MoId'] = $MoId;
	       $content['where']['MoPid'] = $MoId;
	       $content['where']['_logic'] = 'OR';
	       $result = $this->_call('ComModule.get_list', $content);
	       unset($content);
	       $_list = array();
	       $MoIdStr = '';
	       if($result){
		if($result['status_code'] == 200){
		  if(count($result['content']['list']) > 0){
		     foreach($result['content']['list'] as $v){
		         $_list[] = intval($v['MoId']);
		     }
		  }
		}
	       }
	       unset($result);
	       
	       if(count($_list) > 0){
	       	   $MoIdStr = implode(',', $_list);
		   $content['MoId'] = array('in', $MoIdStr);
		   $result = $this->_call('ComModule.delete', $content);
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
	       }

	       header('Content-type:text/json');
	       $out = array('res'=>-5001);
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