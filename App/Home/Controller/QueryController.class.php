<?php
namespace Home\Controller;
use Think\Controller;
header('Content-type: text/html; charset=utf-8');
include_once(dirname(__FILE__)."/BaseController.class.php");
class QueryController extends BaseController {
	/*
	*黑平台
	*/
    public function query_hpt(){
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
        //企业id
        $id = I('get.id');
        //黑平台信息查询
        $content_hpt['where'] = array('id'=>$id);
        $result_hpt = $this->_call('Company.get_list',
                                    $content_hpt);
        if (200 == $result_hpt['status_code']) {
            $hpt_list = $result_hpt['content']['list'];
            //黑平台信息输出
            $this->assign('hpt_list', $hpt_list);
            //企业别名
            $content_bm['where'] = array('company_id'=>$id);
            $res_bm = $this->_call('Companyalias.get_list',
                                    $content_bm);
            if (200 == $res_bm['status_code']) {
                $bm_list = $res_bm['content']['list'];
                $this->assign('bm_list',$bm_list);
            }
            //用户已加黑总数
            $content_j = array('company_id'=>$id);
            $res_j = $this->_call('Addblack.stat_user_all_amount',
                                   $content_j);
            if (200 == $res_j['status_code']) {
                $this->assign('count_j',$res_j['content']);
            }
            //曝光总数
            $res_b = $this->_call('Inexposal.stat_user_amount',
                                   $content_j);
            if (200 == $res_b['status_code']) {
                $this->assign('count_b',$res_b['content']);
            }
            //查询新闻
            $page_size  = 5;
            $content['where'] = array(
                'company_id'=>$id,
                );
            $content['page_size'] = $page_size;
            $result = $this->_call('News.get_list',
                                    $content);
            if (200 == $result['status_code']) {
                //相应条件下数据总条数
                $record_count = $result['content']['record_count'];
                //输出新闻列表
                $new_list = $result['content']['list'];
                //解码base64_decode
                foreach ($new_list as $key => $rs) {
                    $new_list[$key]['content'] = base64_decode($rs['content']);  
                }
                $this->assign('record_count', $record_count);
                $this->assign('new_list', $new_list);
            }
        }
        $this->display();
    }
    /*
	*未认证
	*/
    public function query_wrz(){
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


        $id = I('get.id');
        //未认证信息的查询
        $content_wrz['where'] = array('id'=>$id);
        $result_wrz = $this->_call('Company.get_list',
                                   $content_wrz);
        if (200 == $result_wrz['status_code']) {
            $wrz_list = $result_wrz['content']['list'];
            //未认证信息输出
            $this->assign('wrz_list', $wrz_list);

            //查询新闻
            $page_size  =5;
            $content['where'] = array(
                'company_id'=>$id
                );
            $content['page_size'] = $page_size;
            $result = $this->_call('News.get_list',
                                    $content);
            if (200 == $result['status_code']) {
                //相应条件下数据总条数
                $record_count = $result['content']['record_count'];
                //输出新闻列表
                $new_list = $result['content']['list'];
                //解码base64_decode
                foreach ($new_list as $key => $rs) {
                    $new_list[$key]['content'] = base64_decode($rs['content']);  
                }
                $this->assign('record_count', $record_count);
                $this->assign('new_list', $new_list);
            }
        }
        $this->display();
    }
    /*
    *已认证
    */
    public function query_yrz(){
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

        $id = I('get.id');
        //已认证信息的查询
        $content_yrz['where'] = array('id'=>$id);
        $result_yrz = $this->_call('Company.get_list',
                                   $content_yrz);
        if (200 == $result_yrz['status_code']) {
            $yrz_list = $result_yrz['content']['list'];
            //已认证信息输出
            $this->assign('yrz_list', $yrz_list);
            //企业别名
            $content_bm['where'] = array('company_id'=>$id);
            $res_bm = $this->_call('Companyalias.get_list',
                                    $content_bm);
            if (200 == $res_bm['status_code']) {
                $bm_list = $res_bm['content']['list'];
                $this->assign('bm_list',$bm_list);
            }
            //评论列表
            $page_index = 1;
            $page_size  = 2;
            if(I('get.p'))
            {
                $page_index = I('get.p');
                $yrz_content['page_size']  = $page_size;
                $yrz_content['page_index'] = $page_index;
            }
            $yrz_content['where'] = array(
                'company_id' => $id,
                'parent_id'=> 0
                );
            $yrz_result = $this->_call('Comment.get_list',
                                        $yrz_content);
            if (200 == $yrz_result['status_code']) {
                $con_yrz = $yrz_result['content']['list'];
                $pat = '#\[em_([0-9]+)\]#';
                $bq  = C('bq_url');
                $replace = "<img src='$bq/$1.gif' />";
                $a = '/\s+/';
                $avatar = 'avatar.jpg';
                foreach ($con_yrz as $key => $rs) {
                    $con_yrz[$key]['add_time'] = date('Y-m-d H:i:s',$rs['add_time']);
                    $con_yrz[$key]['content']  = preg_replace($pat,$replace,$rs['content']);
                    $con_yrz[$key]['user_id']  = C('user_photo_url').preg_replace($a,'/',chunk_split($rs['user_id'],2)).$avatar;
                    $con_yrz[$key]['id']       = $rs['id'];
                }
                //查询评论的回复列表
                $page_size_pid = 100;
                $arrContent=array(); 
                $parent_id['where']=array(
                        'company_id' => $id,
                        'parent_id'=> array('gt',0),
                        );
                $parent_id['page_size'] = $page_size_pid;
                //$content['page_index'] = $page_index;
                $arrContent=$this->_call('Comment.get_list',
                                         $parent_id);
                if (200 == $yrz_result['status_code']){
                    $arrContentSon1= $arrContent['content']['list'];
                    $arrContentSon2=array();
                    foreach ($arrContentSon1 as $k => $v) {
                        $arrContentSon2[$k]['add_time']  = date('Y-m-d H:i:s',$v['add_time']);
                        $arrContentSon2[$k]['content']   = preg_replace($pat,$replace,$v['content']);
                        $arrContentSon2[$k]['user_id']   = C('user_photo_url').preg_replace($a,'/',chunk_split($v['user_id'],2)).$avatar;
                        $arrContentSon2[$v['parent_id']][] = $v;
                    }
                }
                //print_r($arrContentSon2);
                //exit();
                $this->assign('con_yrz',$con_yrz);
                $record_count = $yrz_result['content']['record_count'];
                $this->assign('record_count', $record_count);
                $this->assign('sonList', $arrContentSon2);
                $this->get_page($record_count, 3);
            }       
        }
        $this->display();
    }
    /*
    *未收录
    */
    public function query_wsl(){
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
        $this->display();
    }
}