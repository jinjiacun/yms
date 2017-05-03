<?php
namespace Home\Controller;
use Think\Controller;
include_once(dirname(__FILE__)."/BaseController.class.php");
class PublicController extends BaseController {
    public function _initialize(){
        parent::_initialize();
        if("" == session('user_id'))
        {
            exit('<script>top.location.href="../Login/index"</script>');
        }
    }
    public function left(){
        //根据角色查询菜单
        $role_id = session('role_id');
        $content['id'] = $role_id;
        $result = $this->_call('Role.get_info',$content);
        if ($result && 200 == $result['status_code']) {
            $resource = $result['content']['resource'];
            $arr_a = explode(',', $resource);
            if(in_array("1", $arr_a)){
                $_SESSION['pro_id']  = '1';
            } 
            if(in_array("2", $arr_a)){
                $_SESSION['pro_id']  = '2';
            }
            if(in_array("3", $arr_a)){
                $_SESSION['bug_id']  = '3';
            }
            if(in_array("4", $arr_a)){
                $_SESSION['bug_id']  = '4';
            }
            if(in_array("9", $arr_a)){
                $_SESSION['res_id']  = '9';
            }
            if(in_array("10", $arr_a)){
                $_SESSION['res_id']  = '10';
            }
            if(in_array("12", $arr_a)){
                $_SESSION['dem_id']  = '12';
            }
            if(in_array("13", $arr_a)){
                $_SESSION['dem_id']  = '13';
            }
            $cont['where']['id'] = array('in', $resource);
            $cont['order'] = array('id'=>'asc');
            $res = $this->_call('Resource.get_list',$cont);
            if (200 == $res['status_code']) {
                $res_list = $res['content']['list']; 
                foreach ($res_list as $key => $value) {
                    $re_list[$value['team_name']][] = array($value['name'],$value['url'],$value['description']);
                }
                $this->assign('re_list',$re_list);
            }
        }
        $this->display();
    }
    public function main(){
        //查询全部还是自己权限
        $bug_id = session('bug_id');
        $map_priority_list = $this->_map_priority_list(); //优先级
        $map_state_list = $this->_map_state_list();  //状态
        $this->_map_mybug(); //分类
        
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
        $content['where'] =array(
            'status'  => 1,
            '_string' => 'get_member = '.session('user_id').' or put_member = '.session('user_id')
        );
        $result = $this->_call('Bug.get_list',$content);
        if (200 == $result['status_code']) {
            $con = $result['content']['list']; 
            foreach ($con as $key => $rs) {
                //$con[$key]['get_member_ex'] = $this->project_mem_ex($rs['project_id'], $rs['get_member']);
                $con[$key]['number'] = 'WT-'.sprintf("%06d", $rs['id']);
                $con[$key]['add_time'] = date('Y-m-d H:i',$rs['add_time']);
                $con[$key]['last_update_time'] = date('Y-m-d H:i',$rs['last_update_time']);
                $con[$key]['level'] = $map_priority_list[$rs['level']];
                $con[$key]['status'] = $map_state_list[$rs['status']];
            } 
            $this->assign('con',$con);
            $record_count = $result['content']['record_count'];
            $this->assign('record_count', $record_count);
            $this->get_page($record_count, $page_size);
        }
        $this->display();
    }
    public function top(){
        $date      = date("Y年m月d日",time());//时间
        $weekarray = array("日","一","二","三","四","五","六");
        $xq        = date("w");//星期
        $user_id = session('user_id');//用户id
        $shijian = $date." 星期".$weekarray[$xq];
    	$this->assign('sj',$shijian);
    	$this->assign('user_id',$user_id);
        $this->display();
    }
    //与自己相关的问题
}