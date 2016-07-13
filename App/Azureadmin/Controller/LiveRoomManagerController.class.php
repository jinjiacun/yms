<?php
namespace Azureadmin\Controller;
use Azureadmin\Controller;
include_once(dirname(__FILE__).'/BaseController.class.php');

class LiveRoomManagerController extends BaseController{
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
		$this->assign('menu_index', 18);

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
               
        if(session('ComId') > 0)
        {
        	$content['where']['ComId'] = session('ComId');
        }
        
        $result = $this->_call('ComRoom.get_list', $content);

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
	
	public function Edit(){
	    $RoomId = I('get.RoomId');
	    //查询直播室
	    $RoomTeacher = '';
        if($RoomId){
            $content['RoomId'] = $RoomId;
            $result = $this->_call('ComRoom.get_info_by_key', $content);
            unset($content);
            if($result){
                if($result['status_code'] == 200){
                    $RoomTeacher = $result['content']['RoomTeacher'];
                    $this->assign('room_info', $result['content']);
                }
            }
            unset($result);
        }

	    //查询此机构下不为当前直播室的分析师
	    $content['where']['ComId'] = session('ComId');
        if($RoomId){
            $content['where']['AdminId'] = array('not in', $RoomTeacher);
        }
	    $result = $this->_call("ComAdmin.get_list", $content);
	    unset($content);
	    if($result){
            if($result['status_code'] == 200){
                $_list = array();
                if(count($result['content']['list']) > 0){
                    foreach($result['content']['list'] as $v){
                        $_list[intval($v['AdminId'])] = $v['AdminName'];				      
                    }
                    unset($v);
                    $this->assign('other_admin_list', $_list);
                    unset($_list);
                }   
            }
	    } 
	    unset($result);

        if($RoomId){
            //此直播室的分析师
            $content['where']['ComId'] = session('ComId');
            $content['where']['AdminId'] = array('in', $RoomTeacher);
            $result = $this->_call("ComAdmin.get_list", $content);
            unset($content);
            if($result){
                if($result['status_code'] == 200){
                    $_list = array();
                    if(count($result['content']['list']) > 0){
                        foreach($result['content']['list'] as $v){
                            $_list[intval($v['AdminId'])] = $v['AdminName'];				      
                        }
                        unset($v);
                        $this->assign('admin_list', $_list);
                        unset($_list);
                    }   
                }
            } 
            unset($result);
        }

	    //查询vip等级
	    $content['where']['ComId'] = session('ComId');
	    $content['where']['VipLevel'] = array('gt', 0);
	    $result = $this->_call('ComVip.get_list', $content);
	    unset($content);
	    if($result){
            if($result['status_code'] == 200){
                $this->assign('vip_list', $result['content']['list']);
            }
	    }
	       
	    $this->display();
	}

	public function Save(){	    
	    
	    $data['RoomUpdateAdmin'] = session('AdminId');
        $data['ComId']           = session('ComId');
        $data['RoomEnable']      = 1;
        $data['RoomHisPop']      = I('post.RoomHisPop');
        $data['RoomInterLimit']  = I('post.RoomInterLimit');
        $data['RoomIntro']       = I('post.RoomIntro');
        $data['RoomTitle']       = I('post.RoomTitle'); 
        $data['RoomType']        = I('post.RoomType');
        $data['RoomLiveState']   = 0;
        $data['RoomTeacher']     = I('post.RoomTeacher');  
        $data['RoomMinimage']    = I('post.RoomMinimage');
        $data['RoomLivehisLimit']= I('post.RoomLivehisLimit');
        $data['RoomLivetime']    = I('post.RoomLivetime');
        $data['RoomMEtip']       = I('post.RoomMEtip'); 
        $data['RoomMaximage']    = I('post.RoomMinimage');
        $data['RoomName']        = I('post.RoomName');
        $data['RoomPopSet']      = I('post.RoomPopSet');

        if(I('post.RoomId') == 0){//新增
            $data['RoomAddAdmin'] = session('AdminId');
            $content = $data;
            $result = $this->_call('ComRoom.add', $content);
            unset($content);
            if($result){
                if($result['status_code'] == 200
                && $result['content']['is_success'] == 0){
                    header('Content-type:text/json');
                    $out = array('res'=>1);
                    echo json_encode($out);
                    exit();                }
            }
            unset($result);
	    }
	    else{
            $content['where']['RoomId'] = I('post.RoomId');
            $content['data'] = array(
                'RoomHisPop'       => I('post.RoomHisPop'),
                'RoomInterLimit'   => I('post.RoomInterLimit'),
                'RoomIntro'        => I('post.RoomIntro'),
                'RoomLivehisLimit' => I('post.RoomLivehisLimit'),
                'RoomVipType'      => I('post.RoomVipType'),
                'RoomLiveLimit'    => I('post.RoomLiveLimit'),
                'RoomLivetime'     => I('post.RoomLivetime'),
                'RoomMaximage'     => I('post.RoomMaximaeg'),
                'RoomMEtip'        => I('post.RoomMEtip'),
                'RoomMinimage'     => I('post.RoomMinimage'),
                'RoomName'         => I('post.RoomName'),
                'RoomPopSet'       => I('post.RoomPopSet'),
                'RoomTeacher'      => I('post.RoomTeacher'),
                'RoomTitle'        => I('post.RoomTitle'),
                'RoomType'         => I('post.RoomType'),
            );
            $result = $this->_call('ComRoom.update', $content);
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

	/**
	功能：开启直播室

	参数;
	@@inputx
	*/
	public function RoomEnableControll(){
	   //检查
	   if(I('post.id') <=0)
	   {
	     header('Content-type:text/json');
	     $out = array('res'=>-5001);
	     echo json_encode($out);
	     exit();
	   }

	   if(I('post.enable') == 1){
	     $content['data']['RoomEnable'] = 1;
	   }
	   else if(I('post.enable') == 0){
	     $content['data']['RoomEnable'] = 0;
	     $content['data']['RoomTeacher'] = "";
	   }
	   $content['where']['RoomId'] = I('post.id');
	   $result = $this->_call('ComRoom.update', $content);
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
	    $out = array('res'=>1);
	    echo json_encode($out);
	    exit();
	}

	/**
	功能：检测直播室名称是否唯一

	参数：
	@@input
	@param $RoomName string 直播室名称
	*/
	public function nameUniqe(){
	  $count = 0;
	  $content['ComId'] = session('ComId');
	  $content['RoomName'] = I('post.RoomName');
	  $result = $this->_call('ComRoot.get_count', $content);
	  unset($content);
	  if($result){
	    if($result['status_code'] == 200){
	      $count = $result['content'];
	    }
	  }
	  unset($result);
	  
	  if($count>0)
	  {
	    header('Content-type:text/json');
	    $out = array('res'=>1);
	    echo json_encode($out);
	    exit();
	  }

	  header('Content-type:text/json');
	  $out = array('res'=>5000);
	  echo json_encode($out);
	  exit();
	}
	
	/**
	 功能：上传图片
	*/
	public function UpLoadImage(){

	}
	
	

}