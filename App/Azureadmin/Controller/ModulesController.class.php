<?php
namespace Azureadmin\Controller;
use Think\Controller;
include_once(dirname(__FILE__).'/BaseController.class.php');
/**
	Ç°Ì¨Ä£¿é¹ÜÀí
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

	/**
	¹¦ÄÜ£ºÌí¼ÓÄ£¿é
	
        ²ÎÊý£º
	@@input
	@param $AdminId int ´´½¨Õßid
	@param $MoState int ×´Ì¬
	@param $MoTime	string ´´½¨Ê±¼ä
	@param $MoUpTime string ¸üÐÂÊ±¼ä
	@param $MoUrl string url
	@param $MoIntro string ½éÉÜ
	*/
	public function AddModule(){
	       $content = array(
	       		'AdminId' => session('AdminId'),
			'MoState' => 1,
			'MoTime'  => date('Y-m-d H:i:s'),
			'MoUpTime'=> date('Y-m-d H:i:s'),
			'MoUrl'   => '',
			'MoIntro' => ''
	       );
	       $result = $this->_call('ComModule.add', $content);
	       unset($content);
	       if($result){
		if($result['status_code'] == 200){
		  $_list = array(
		      'title'   => $result['content']['FMTitle'], 
		      'content' => $result['content']['FMCon'], 
		      'company' => $result['content']['FMComId']
		  );
		  $out = array('res'=>1, 'data'=>$_list);
		  echo json_encode($out);
		  exit();
	       }
	     }

	     $out = array('res'=>-5001);
	     echo json_encode($out);
	     exit();
	}

	/**
	¹¦ÄÜ£º»ñÈ¡Ä£¿é

	²ÎÊý£º
	@@input
	@param $MoId int Ä£¿éid
	*/
	public function GetModel(){
	       $content['MoId'] = I('post.MoId');
	       $result = $this->_call('ComModule.get_info_by_key', $content);
	       unset($content);
	       if($result){
		if($result['status_code'] == 200){
		  $out = $result['content'];
		  echo json_encode($out);
		  exit();
	       }
	     } 
	}

	/**
	¹¦ÄÜ£º¸üÐÂ

	²ÎÊý£º
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
		      'MoType'	=> I('post.MoType')
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
		   && 0 == $result['content']['is_success']){
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
	¹¦ÄÜ£ºÉ¾³ý

	²ÎÊý£º
	@@input
	@param $MoId int
	*/
	public function DeleteModel(){
	       $MoId = I('post.MoId');
	       //²éÑ¯¸¸½Úµã¼°Æä×Ó½Úµã
	       $content['where']['MoId'] = $MoId;
	       $content['where']['MoPId'] = $MoId;
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
		   unset($result);
		   if($result){
			if($result['status_code'] == 200
			&& $result['content']['is_success'] == 0){
			   $out = array('res'=>1);
			   echo json_encode($out);
			   exit();
			}
		   }	  
	       }

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