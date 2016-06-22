<?php
namespace Home\Controller;
use Think\Controller;
header('Content-type: text/html; charset=utf-8');
include_once(dirname(__FILE__)."/BaseController.class.php");
class RankingController extends BaseController {
	/*
	*曝光台
	*/
    public function machine(){
        //用户登录返回信息
        $log_result = $this->_call('User.get_login_info',
                                   $content);
        if(200 == $log_result['status_code'] &&
            0 == $log_result['content']['is_success'])
        {
            $userid = $log_result['content']['user_id'];
            $this->assign('login', $log_result['content']);
            $this->assign('userid',$userid);
        }
        //统计曝光人数
        $res = $this->_call('Inexposal.stat_user_amount',
                             $content);
        if (200 == $res['status_code']) {
            $this->assign('user_amout',$res['content']);
        }
        //曝光平台总数
        $result_num = $this->_call('Inexposal.dynamic',
                               $content);
        if (200 == $result_num['status_code']) {
            $record_count = $result_num['content']['record_count'];
            $this->assign('record_count',$record_count);
        }
        //曝光信息查询
    	$auth_level = "006001";
    	$content['where'] = array('auth_level'=>$auth_level);
    	$result = $this->_call('Company.black_sort',
                                  $content);
    	if (200 == $result['status_code']) {
            $get_list = $result['content']['list'];
            $record_count = $result['content']['record_count'];
    		$this->assign('get_list', $get_list);
            $this->assign('record_count',$record_count);
    	}
        //最新曝光
        $page_size = 7;
        $content_zx['where'] = array('company_id' => array('gt',0));
        $content_zx['page_size'] = $page_size;
        $res_zx = $this->_call('Inexposal.get_list',
                                $content_zx);
        if (200 == $res_zx['status_code']) {
            $list_zx = $res_zx['content']['list'];
            $this->assign('list_zx',$list_zx);
        }
        $this->display();
    }
}
