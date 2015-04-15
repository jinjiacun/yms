<?php
namespace Home\Controller;
use Think\Controller;
header('Content-type: text/html; charset=utf-8');
include_once(dirname(__FILE__)."/BaseController.class.php");
class ArticleController extends BaseController {
	/*
	*文章显示
	*/
    public function article(){
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

    	$id = $_GET['id'];
    	$company_id = $_GET['company_id'];
        //新闻
    	$content = array(
    		'id'=>$id,
    		'company_id'=>$company_id
    		);
    	$result = $this->_call('News.get_info',
    		                    $content);
        if (200 == $result['status_code']) {
            $add_time=date('Y-m-d H:i:s',$result['content']['add_time']);
            $content =base64_decode($result['content']['content']);
            $this->assign('content',$content);
            $this->assign('add_time',$add_time);
            $this->assign('new_list', $result['content']);
        }
        //认证平台推荐
        $auth_level   = "006003";
        $page_size_tj = 3;
        $content_tj['page_size'] = $page_size_tj;
        $content_tj['where'] = array('auth_level'=>$auth_level);
        $res_tj = $this->_call('Company.get_list',
        	                    $content_tj);
        if (200 == $res_tj['status_code']) {
        	$list_tj = $res_tj['content']['list'];
        	$this->assign('list_tj',$list_tj);
        }
        //评论列表
        $news_content = array();
        $page_index = 1;
        $page_size  = 3;
        $news_content['where'] = array(
            'news_id'    => $id,
            'company_id' => $company_id,
            );
        if(I('get.p'))
        {
            $page_index = I('get.p');
            $news_content['page_size'] = $page_size;
            $news_content['page_index'] = $page_index;
        }
        $new_result = $this->_call('Comnews.get_list',
                                    $news_content);
        if (200 == $new_result['status_code']) {
            $comnews = $new_result['content']['list'];
            $pat = '#\[em_([0-9]+)\]#';
            $bq  = C('bq_url');
            $replace = "<img src='$bq/$1.gif' />";
            $a = '/\s+/';
            $avatar = 'avatar.jpg';
            foreach ($comnews as $key => $rs) {
                $comnews[$key]['add_time'] = date('Y-m-d H:i:s',$rs['add_time']);
                $comnews[$key]['content']  = preg_replace($pat,$replace,$rs['content']); 
                $comnews[$key]['user_id']  = C('user_photo_url').preg_replace($a,'/',chunk_split($rs['user_id'],2)).$avatar;
            }
            $this->assign('comnews',$comnews);
            $record_count = $new_result['content']['record_count'];
            $this->assign('record_count', $record_count);
            $this->get_page($record_count, 3);
        }

        $this->display();
    }
    /*
    *添加文章评论
    */
    // public function comment_add(){
    //     if ($_POST['submit']) {
    //     	$user_id      = 3;
    //     	$news_id      = I('post.news_id');
    //         $company_id   = I('post.company_id');
    //     	$content_news = I('post.saytext');
    //         if ($content_news == "" || $content_news =="在这里输入回复内容") {
    //             $this->error("请输入回复内容");
    //         }
    //     	$content = array(
    //             'user_id'    => $user_id,
    //     		'news_id'    => $news_id,
    //             'company_id' => $company_id,
    //     		'content'    => urlencode($content_news),
    //     		);
    //     	$result = $this->_call('Comnews.add',
    //     		                   $content);
    //         if (200 == $result['status_code']) {
    //             if (0 == $result['content']['is_success']) {
    //                 $this->success("评论成功！");
    //             }
    //             else{
    //                 $this->error("评论失败！");
    //             }
    //         }
    //     }
    // }
}
