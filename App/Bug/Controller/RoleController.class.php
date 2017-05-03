<?php
namespace Home\Controller;
use Think\Controller;
header('Content-type: text/html; charset=utf-8');
include_once(dirname(__FILE__)."/BaseController.class.php");
class RoleController extends BaseController {
    public function _initialize(){
        parent::_initialize();
        if("" == session('user_id'))
        {
            exit('<script>top.location.href="../Login/index"</script>');
        }
    }
    /*
    *角色列表
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
        $result = $this->_call('Role.get_list',$content);
        if (200 == $result['status_code']) {
            $con = $result['content']['list']; 
            foreach ($con as $key => $rs) {
                $con[$key]['resource'] = explode(',', $rs['resource']);
            } 
            $this->assign('con',$con);
            $record_count = $result['content']['record_count'];
            $this->assign('record_count', $record_count);
            $this->get_page($record_count, $page_size);
        }
        $this->_map_resource();  //权限map
        $this->display();
    }
    /*
    *角色添加
    */
    public function add(){
        if (I('post.submit')) {
            $name = I('post.jsname');
            $resource = I('post.resource');
            $number = I('post.number');
            $str = implode(',',$resource);
            if ($name == "") {
                echo 1;
                exit();
            }
            if ($resource == "") {
                echo 2;
                exit();
            }
            $content = array(
                'name' => urlencode($name),
                'resource' => urlencode($str),
                'number' => urlencode($number)
                );
            $result = $this->_call('Role.add',$content);
            if (200 == $result['status_code']
                && 0 == $result['content']['is_success']) {
                echo 0;
                S('get_map',null);
                exit();
            }else{
                echo -1;
                exit();
            }
        }
        //编号
        $mod = "Role.get_list";
        $type = "JS-";
        $this->_number($mod, $type);
        $this->_map_resource();  //权限map
    	$this->display();
    }
    /*
    *角色修改
    */
    public function edit(){
        $id = I('get.id');
        //修改提交
        if (I('post.submit')) {
            $id = I('post.id');
            $name = I('post.jsname');
            $resource = I('post.resource');
            $number = I('post.number');
            $str = implode(',',$resource);
            if ($name == "") {
                echo 1;
                exit();
            }
            if ($resource == "") {
                echo 2;
                exit();
            }
            $content['data'] = array(
                'name' => urlencode($name),
                'resource' => urlencode($str),
                'number' => urlencode($number)
                ); 
            $content['where'] = array(
                    'id'=>$id
            ); 
            $result = $this->_call('Role.update',$content);
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
        $result = $this->_call('Role.get_info',$content);
        if ($result && 200 == $result['status_code']) {
            $enit_list = $result['content'];
            $enit_list['resource'] = explode(',', $result['content']['resource']);
            $this->assign('enit_list',$enit_list);
        }
        $this->_map_resource();
        $this->display();
    }
    //权限map
    public function _map_resource(){
        $content['page_size']  = 20;
        $content['order'] = array('id'=>'asc');
        $result = $this->_call('Resource.get_list',$content);
        if (200 == $result['status_code']) {
            $con = $result['content']['list']; 
            foreach($con as $value){
                $res_list[$value['id']] = $value['source_name'];
            }
            $this->assign('res_list',$res_list);
            return $res_list;
        }
    }
}
