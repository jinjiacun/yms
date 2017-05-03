<?php
namespace Home\Controller;
use Think\Controller;
header('Content-type: text/html; charset=utf-8');
include_once(dirname(__FILE__)."/BaseController.class.php");
class RecruitController extends BaseController {
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
    	$result = $this->_call('Positionhr.get_list',$content);
    	if (200 == $result['status_code']) {
    		$con = $result['content']['list'];
            foreach ($con as $key => $rs) {
                $con[$key]['start_time'] = date('Y-m-d H:i:s',$rs['start_time']);
            }  
            $this->assign('list',$con);
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
            $part_id = I('post.part_id');
            $name = I('post.gw_name');
            $description = I('post.description');
            $description = $this->DeleteHtml($description);
            $create = session('user_id');
            $content = array(
                'name' => urlencode($name),
                'part_id' => $part_id,
                'description' => urlencode($description),
                'create' => $create
                );
            $result = $this->_call('Positionhr.add',$content);
            if(200 == $result['status_code'] 
                && 0 == $result['content']['is_success']){
                echo 0;
                S('get_map',null);
                exit();
            }else{
                echo -1;
                exit();
            }
        }
        $this->display();
    }
    /*
    *岗位修改
    */
    public function edit(){
        $id = I('get.id');
        //修改提交
        if (I('post.submit')) {
            $id          = I('post.id');
            $part_id     = I('post.part_id');
            $name        = I('post.gw_name');
            $status      = I('post.status');
            $description = I('post.description');
            $description = $this->DeleteHtml($description);
            $create = session('user_id');
            $content['data'] = array(
                'name' => urlencode($name),
                'part_id' => $part_id,
                'status'  => $status,
                'description' => urlencode($description),
                'create' => $create
                );
            $content['where'] = array('id'=>$id);
            $result = $this->_call('Positionhr.update',$content);
            if(200 == $result['status_code'] 
                && 0 == $result['content']['is_success']){
                echo 0;
                S('get_map',null);
                exit();
            }else{
                echo -1;
                exit();
            }
        }
        //修改信息查询
    	$content['id'] = $id;
        $result = $this->_call('Positionhr.get_info',$content);
        if ($result && 200 == $result['status_code']) {
            $edit_list = $result['content'];
            $this->assign('edit_list',$edit_list);
        }
        $this->display();
    }
    //修改状态
    public function status_up(){
        $id     = I('post.id');
        $status = I('post.status'); 
        $content['data'] = array('status'=>$status);
        $content['where'] = array('id'=>$id);
        $result = $this->_call('Positionhr.update',$content);
        if(200 == $result['status_code'] 
            && 0 == $result['content']['is_success']){
            echo 0;
            exit();
        }else{
            echo -1;
            exit();
        }
    }

}