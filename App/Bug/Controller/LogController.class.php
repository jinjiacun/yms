<?php
namespace Home\Controller;
use Think\Controller;
header('Content-type: text/html; charset=utf-8');
include_once(dirname(__FILE__)."/BaseController.class.php");
class LogController extends BaseController {
    public function _initialize(){
        parent::_initialize();
        if("" == session('user_id'))
        {
            exit('<script>top.location.href="../Login/index"</script>');
        }
    }
    public function index(){
    	$page_index = 1;
    	$page_size  = 20;
    	if (I('get.p')) {
    		$page_index = I('get.p');
    		$content['page_size']  = $page_size;
    		$content['page_index'] = $page_index;
    	}else{
    		$content['page_size']  = $page_size;
    		$content['page_index'] = $page_index;
    	}
    	//搜索
        if (I('get.sub')) {
        	//app名称
        	$name = I('get.keywords');
        	if ("" != $name) {
                $this->assign('name', $name);
                $content['where']['app_name'] = array('like', '$'.urlencode($name).'$');
                $this->assign('name', $name);
            }
        	//系统
            if ("" != I('get.system')) {
                $this->assign('ver', I('get.system'));
                $content['where']['system'] = array('like', '$'.urlencode(I('get.system')).'$');;
                $this->assign('ver', I('get.system'));
            }
        }
    	$result = $this->_call('Buglog.get_list',$content);
    	if(200 == $result['status_code']){
    		$con = $result['content']['list'];
    		foreach ($con as $key => $v) {
    			$con[$key]['add_time'] = date('Y-m-d H:i:s',$v['add_time']);
    		}
    		$this->assign('list',$con);
            $record_count = $result['content']['record_count'];
            $this->assign('record_count', $record_count);
            $this->get_page($record_count, $page_size);
    	}
    	$this->display();
    }
    //详情
    public function edit(){
    	$id = I('get.id');
    	$content['id'] = $id;
    	$result = $this->_call('Buglog.get_info', $content);
    	if (200 == $result['status_code']) {
    		$list = $result['content'];
    		$list['add_time'] = date('Y-m-d H:i:s',$result['content']['add_time']);
    		$this->assign('list',$list);
    	}
    	$this->display();
    }
}