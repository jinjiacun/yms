<?php
namespace Home\Controller;
use Think\Controller;
header('Content-type: text/html; charset=utf-8');
include_once(dirname(__FILE__)."/BaseController.class.php");
class UsercenterController extends BaseController {
	public function index(){
        $this->_login();
		//获取用户id
		$userid = I('get.id');
        $content_us = array(
            'uid' => $userid
            );
        $result_us = $this->_call('User.get_info',
                                   $content_us);
        if(200 == $result_us['status_code'])
        {
            $us_list = $result_us['content'][0][UI_NickName];
            $this->assign('us_nickname',$us_list);
        }
        $this->assign('usid', $userid);
        if ($this->is_mobile()) {
            $this->display('index_wap');
        }else{
            $this->display();
        }
        
	}
    //查询会员信息
    public function user_info(){
        $userid = I('get.id');
        //用户信息查询
        $content_us = array(
            'uid' => $userid
            );
        $result_us = $this->_call('User.get_info',
                                   $content_us);
        if(200 == $result_us['status_code'])
        {
            $us_list = $result_us['content'][0];
            echo json_encode($us_list);
            exit();
        }
    }
    //ta的评论
    public function user_pl(){
        //获取用户id
        $uid = session('user_id');
        $userid = I('get.id');

        $page_size  = 20;
        //我的评论
        $a1 = '006001';
        $a2 = '006002';
        $a3 = '006003';
        $t1 = '005001';
        $t2 = '005003';
        $content_pl = array();
        $content_pl['page_size']  = $page_size;
        if ($userid == $uid) {
            $content_pl['where'] = array(
                'user_id'   => $userid,
                'is_delete' => 0
                );
        }else{
            $content_pl['_tag'] = 1; 
            $content_pl['where'] = array(
                'user_id' => $userid,
                'is_validate' => 1,
                'is_delete' => 0,
                '_string'   => '(auth_level = '.$a1.' and type = '.$t2.') or (auth_level = '.$a3.' and type ='.$t1.') or auth_level = '.$a2
                );
        }
        $result_pl = $this->_call('Comment.get_list',$content_pl);
        if (200 == $result_pl['status_code']) {
            $pl_list = $result_pl['content']['list'];
            $pl_count = $result_pl['content']['record_count'];
            foreach ($pl_list as $key => $rs) {
                $pl_list[$key]['add_time'] = date('Y-m-d',$rs['add_time']);
                $pl_list[$key]['content'] = $this->cont($rs['content']); 
            }
            echo json_encode(array('list'=>$pl_list,'pl_count'=>$pl_count));
            exit();
        }
    }
    //ta的曝光
    public function user_bg(){
        //获取用户id
        $uid    = session('user_id');
        $userid = I('get.id');

        $auth_level  = '006001';
        $auth_level2 = '006002';
        $content_bg['page_size'] = 20;
        if ($userid == $uid) {
            $content_bg['where'] = array(
            'user_id' => $userid
            );
            $content_bg['where_ex'] = array(
                '_string' => 'user_id ='.$userid.' or is_validate = 1'
                );
        }else{
            $content_bg['where'] = array(
            'user_id' => $userid,
            'auth_level'=>array('in',$auth_level.','.$auth_level2)
            );
        }
        $result_bg = $this->_call('Inexposal.get_list_com',$content_bg);
        if (200 == $result_bg['status_code']) {
            $bg_list = $result_bg['content']['list'];
            $bg_count = $result_bg['content']['record_count'];
            foreach ($bg_list as $key => $vl) {
                $bg_list[$key]['add_time'] = date('Y-m-d H:i:s',$vl['add_time']);
                $bg_list[$key]['sub_count'] = $vl['sub']['record_count'];
            }
            echo json_encode(array('list'=>$bg_list,'bg_count'=>$bg_count));
            exit();
        }
    }
    //ta的关注
    public function user_gz(){
        $userid = I('get.id');
        $content_gz['page_size'] = 20;
        $content_gz['where'] = array(
            'user_id' => $userid
            );
        $result_gz = $this->_call('Attention.get_list',$content_gz);
        if (200 == $result_gz['status_code']) {
            $gz_list = $result_gz['content']['list'];
            $gz_count = $result_gz['content']['record_count'];
            foreach ($gz_list as $key => $vl) {
                $gz_list[$key]['add_time'] = date('Y-m-d',$vl['add_time']);
            }
            echo json_encode(array('list'=>$gz_list,'gz_count'=>$gz_count));
            exit();

        }
    }
	//企业跳转
	public function tiao(){
		$id = I('get.id');
		$content['id'] = $id;
        $result = $this->_call('Company.get_info',
                                    $content);
        if (200 == $result['status_code']) {
            $list = $result['content'];
            if ("006001" == $list['auth_level']) {
                header("Location: ../hpt?resid=$id");
                exit;
            }
            elseif ("006002" == $list['auth_level']) {
                header("Location: ../wrz?resid=$id");
                exit;
            }
            elseif ("006003" == $list['auth_level']) {
                header("Location: ../yrz?resid=$id");
                exit;
            }
        }
	}
	/*
    *我的评论加载更多
    */
    public function pl(){
        //曝光动态
        $a1 = '006001';
        $a2 = '006002';
        $a3 = '006003';
        $t1 = '005001';
        $t2 = '005003';
        $uid = session('user_id');
        $p=isset($_POST['k'])?intval(trim($_POST['k'])):0;
        $userid = I('post.user_id');
        $page_size = 20;
        $page_index = 1;
        if($p <= 10)
        {
            $page_index = $p;
            $content['page_size']  = $page_size;
            $content['page_index'] = $page_index;
        }else{
            exit();
        }
        $content['page_size'] = $page_size;
        if ($userid == $uid) {
            $content['where'] = array(
                'user_id' => $userid,
                'is_delete' => 0
                );
        }else{
            $content['where'] = array(
                'user_id' => $userid,
                'is_validate' => 1,
                'is_delete' => 0,
                '_string'   => '(auth_level = '.$a1.' and type = '.$t2.') or (auth_level = '.$a3.' and type ='.$t1.') or auth_level = '.$a2
                );
        }
        $result = $this->_call('Comment.get_list',
                               $content);
        if (200 == $result['status_code']) {
            $pl_list = $result['content']['list'];
            foreach ($pl_list as $key => $rs) {
                $pl_list[$key]['add_time'] = date('Y-m-d',$rs['add_time']);
                $pl_list[$key]['content'] = $this->cont($rs['content']);
                $pl_list[$key]['re_sub_ex'] = $rs['re_sub']['list'];
            }
            if(count($pl_list)>0){
                echo json_encode($pl_list);
                exit();
            }else{
                exit();
            }
        } 
    }
}