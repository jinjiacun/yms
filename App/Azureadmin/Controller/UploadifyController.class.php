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
}