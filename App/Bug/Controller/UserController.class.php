<?php
namespace Home\Controller;
use Think\Controller;
header('Content-type: text/html; charset=utf-8');
include_once(dirname(__FILE__)."/BaseController.class.php");
class UserController extends BaseController {
    public function _initialize(){
        parent::_initialize();
        if("" == session('user_id'))
        {
            exit('<script>top.location.href="../Login/index"</script>');
        }
    }
    /**
    *用户列表
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
                $content['where']['admin_name'] = array('like', '$'.urlencode($name).'$');
                $this->assign('name', $name);
            }
        }
        $content['order']['admin_name'] = 'ASC';
        $result = $this->_call('Admin.get_list',$content);
        if (200 == $result['status_code']) {
            $con = $result['content']['list'];
            foreach ($con as $key => $rs) {
                $con[$key]['add_time'] = date('Y-m-d H:i:s',$rs['add_time']);
            }  
            $this->assign('u_con',$con);
            $record_count = $result['content']['record_count'];
            $this->assign('record_count', $record_count);
            $this->get_page($record_count, $page_size);
        }
        $this->display();
    }
    /*
    *用户添加
    */
    public function add(){
        if (I('post.submit')) {
            $number     = I('post.number');
            $admin_name = I('post.admin_name');
            $passwd     = I('post.passwd');
            $name       = I('post.xname');
            $status     = I('post.status');
            $part       = I('post.part');
            $role       = I('post.role');
            //$position   = I('post.position');

            $content = array(
                'number' => urlencode($number),
                'admin_name' => urlencode($admin_name),
                'passwd' => urlencode($passwd),
                'name' => urlencode($name),
                'status' => $status,
                'part' => $part,
                'role' => $role,
                //'position' => $position
                );  
            $result = $this->_call('Admin.add',$content);
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
        //编号
        $mod = "Admin.get_list";
        $type = "YH-";
        $this->_number($mod, $type);

        $this->display();
    }
    /*
    *用户修改
    */
    public function edit(){
        $id = I('get.id');
        //修改提交
        if (I('post.submit')) {
            $id         = I('post.id');
            $admin_name = I('post.admin_name');
            $passwd     = I('post.passwd');
            $name       = I('post.xname');
            $status     = I('post.status');
            $part       = I('post.part');
            $role       = I('post.role');
            //$position   = I('post.position');
            if ($passwd == "") {
                $content['data'] = array(
                    'admin_name' => urlencode($admin_name),
                    'name' => urlencode($name),
                    'status' => $status,
                    'part' => $part,
                    'role' => $role,
                    'position' => $position
                );
            }else{
                $content['data'] = array(
                    'admin_name' => urlencode($admin_name),
                    'passwd' => urlencode($passwd),
                    'name' => urlencode($name),
                    'status' => $status,
                    'part' => $part,
                    'role' => $role,
                    //'position' => $position
                ); 
            }
            $content['where'] = array('id' => $id); 
            $result = $this->_call('Admin.update',$content);
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
        $this->ugetinfo($id);
        // $content['id'] = $id;
        // $result = $this->_call('Admin.get_info',$content);
        // if ($result && 200 == $result['status_code']) {
        //     $edit_list = $result['content'];
        //     $this->assign('edit_list',$edit_list);
        // }
        $this->display();
    }
    //用户密码修改
    public function pwdup(){
        $user_id = session('user_id');
        if (I('post.submit')) {
            $admin_name = I('post.admin_name');
            $passwd     = I('post.passwd');
            $content = array(
                'admin_name' => urlencode($admin_name),
                'passwd'     => urlencode($passwd)
            ); 
            $result = $this->_call('Admin.update_passwd', $content);
            if (200 == $result['status_code'] && 0 == $result['content']['is_success']) {
                $_SESSION = array(); //清除SESSION值.
                if(isset($_COOKIE[session_name()])){ 
                    setcookie(session_name(),'',time()-1,'/');
                }
                session_destroy();
                echo 0;
                exit();
            }else{
                echo -1;
                exit();
            }
        }
        $this->assign('user_id', $user_id);
        $this->display();
    }
    //管理员修改密码
    public function user_up(){
        $user_id = I('get.id');
        if (I('post.submit')) {
            $admin_name = I('post.admin_name');
            $passwd     = I('post.passwd');
            $content = array(
                'admin_name' => urlencode($admin_name),
                'passwd'     => urlencode($passwd)
            ); 
            $result = $this->_call('Admin.update_passwd', $content);
            if (200 == $result['status_code'] && 0 == $result['content']['is_success']) {
                echo 0;
                exit();
            }else{
                echo -1;
                exit();
            }
        }
        $this->assign('user_id', $user_id);
        $this->display();
    }
    //用户名称验证
    public function ex_name(){
        $admin_name = I('post.param');
        $content = array('admin_name' => urlencode($admin_name));
        $result = $this->_call('Admin.exists_name', $content);
        if (200 == $result['status_code'])
        {
           if (0 == $result['content']['is_exists']) {
              echo '{
                      "info":"用户帐号已存在！",
                      "status":"n"
                    }';
              exit();
           }else{
              echo '{
                      "info":"可以注册！",
                      "status":"y"
                    }';
              exit();
           }
        }
    }
}