<?php
namespace Home\Controller;
use Think\Controller;
header('Content-type: text/html; charset=utf-8');
include_once(dirname(__FILE__)."/BaseController.class.php");
class PositionController extends BaseController {
    public function _initialize(){
        parent::_initialize();
        if("" == session('user_id'))
        {
            exit('<script>top.location.href="../Login/index"</script>');
        }
    }
	/*
	*岗位列表
	*/
    public function index(){
	    $page_index = 1;
        $page_size  = 20;
        $content = array();
        if(I('get.p'))
        {
            $page_index = I('get.p');
            $content['page_size']  = $page_size;
            $content['page_index'] = $page_index;
        }else{
            $content['page_size']  = $page_size;
            $content['page_index'] = $page_index;
        }
        //搜索
        if (I('get.sub')) {
            $name = I('get.keywords');
            if ("" != $name) {
                $this->assign('name', $name);
                $content['where']['name'] = array('like', '$'.urlencode($name).'$');
                $this->assign('name', $name);
            }
        }
    	$result = $this->_call('Position.get_list',$content);
    	if (200 == $result['status_code']) {
    		$con = $result['content']['list'];
            foreach ($con as $key => $rs) {
                $con[$key]['add_time'] = date('Y-m-d H:i:s',$rs['add_time']);
            }  
            $this->assign('con',$con);
            $record_count = $result['content']['record_count'];
            $this->assign('record_count', $record_count);
            $this->get_page($record_count, $page_size);
    	}
	    $this->display();
    }
    /*
    *岗位添加
    */
    public function add(){
        if (I('post.submit')) {
            $name = I('post.pname');
            $number = I('post.number');
            $create = session('user_id');
            if ($name == "") {
                echo 1;
                exit();
            }
            $content = array(
                'name' => urlencode($name),
                'number' => urlencode($number),
                'create' => $create
                );  
            $result = $this->_call('Position.add',$content);
            if(200 == $result['status_code'] 
                && 0 == $result['content']['is_success']){
                echo 0;
                exit();
            }else{
                echo -1;
                exit();
            }
        }
        //编号
        $mod = "Position.get_list";
        $type = "GW-";
        $this->_number($mod, $type);

        $this->display();
    }
    /*
    *部门修改
    */
    public function edit(){
        $id = I('get.id');
        //修改提交
        if (I('post.submit')) {
            $id = I('post.id');
            $name = I('post.pname');
            $number = I('post.number');
            $create = session('user_id');
            if ($name == "") {
                echo 1;
                exit();
            }
            $content['data'] = array(
                'name' => urlencode($name),
                'number' => urlencode($number),
                'create' => $create
                ); 
            $content['where'] = array('id' => $id); 
            $result = $this->_call('Position.update',$content);
            if(200 == $result['status_code'] 
                && 0 == $result['content']['is_success']){
                echo 0;
                exit();
            }else{
                echo -1;
                exit();
            }
        }
        //修改信息查询
    	$content['id'] = $id;
        $result = $this->_call('Position.get_info',$content);
        if ($result && 200 == $result['status_code']) {
            $enit_list = $result['content'];
            $this->assign('enit_list',$enit_list);
        }
        $this->display();
    }
}