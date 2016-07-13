<?php
namespace Azureadmin\Controller;
use Think\Controller;
include_once(dirname(__FILE__).'/BaseController.class.php');
//文件上传
class UploadifyController extends BaseController {
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

    public function UpLoadImage(){
          $_POST['submit'] = 1;
    	  $pic = $this->upload('Filedata','003001');
	  //查询图片
	  $content['media_id'] = $pic;
	  $result = $this->_call('Media.get_by_id', $content);
	  unset($content);
	  if($result){
	    if($result['status_code'] == 200){
	        header("Content-type:text/json");
		echo $result['content']['http_url'];
	    	exit();
	    }
	  }
    }

    public function UpLoadImage_Login(){
      	  $_POST['submit'] = 1;
    	  $pic = $this->upload('Filedata','003002');
	  //查询图片
	  $content['media_id'] = $pic;
	  $result = $this->_call('Media.get_by_id', $content);
	  unset($content);
	  if($result){
	    if($result['status_code'] == 200){
	        header("Content-type:text/json");
		echo $result['content']['http_url'];
	    	exit();
	    }
	  } 
    }

    public function UpLoadImage_Focus(){
          $comMin = I('post.comMin');
          $_POST['submit'] = 1;
    	  $pic = $this->upload('Filedata','003003');
	  
	  $pic_url = '';
	  //查询图片
	  $content['media_id'] = $pic;
	  $result = $this->_call('Media.get_by_id', $content);
	  unset($content);
	  if($result){
	    if($result['status_code'] == 200){
	       $pic_url = $result['content']['http_url'];
	    }
	  }
	  unset($result);

	  //更新机构banner图片
	  $ComBanner = '';
	  $ComBanLink = '';
	  $ComMin = 0;
	  $ComLogin = 0;
	  $content['ComId'] = session('ComId');
	  $result = $this->_call('ComTable.get_info_by_key', $content);
	  unset($content);
	  if($result){
	    if($result['status_code'] == 200){
	       $ComBanner = $result['content']['ComBanner'];
	       $ComBanLink = $result['content']['ComBanLink'];
	       $ComMin = $result['content']['ComMin'];
	       $ComLogin = $result['content']['ComLogin'];
	    }
	  }
	  unset($result);	  
	  
          $ComBanner  .= "|".$pic_url;
          $ComBanLink .= "|"." ";
	  $ComBanner = trim($ComBanner, "|");
	  $ComBanLink = trim($ComBanLink, "|");
	  $ComMin = $comMin == 1?1:0;
	  $ComLogin = $comMin == 2?1:0;
	  $content = array(
	      'where'=>array('ComId'=>session('ComId')),
	      'data'=>array(
	          'ComBanner'  => $ComBanner, 
		  'ComBanLink' => $ComBanLink,
		  'ComMin'     => $ComMin,
		  'ComLogin'   => $ComLogin
	      ),
	  );
          $result = $this->_call('ComTable.update', $content);
	  unset($content);
	  if($result){
	    if($result['status_code'] == 200
	    && $result['content']['is_success'] == 0){
	       echo $pic_url;
	       exit();
	    }
	  }
	  
	  echo $pic_url;
	  exit();
    }
}