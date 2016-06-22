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
        $this->_login();

        $userid     = session('user_id');
    	$id         = $_GET['id'];
    	$company_id = $_GET['company_id'];
        $method_list = array(
            'News.get_info',      #新闻查询
            'Company.get_list',   #认证平台推荐
        );
        $content_list = array(
            //新闻查询
            array(
                'id'         => $id,
                'company_id' => $company_id
            ),
            //认证平台推荐
            array(
                'page_size'=>3,
                'where'=>array(
                    'auth_level'=>'006003',
                    'nature'    =>'003001'
                )
            )
        );
        $res = $this->_mul_call($method_list, $content_list);
        if($res)
        {
            //新闻查询
            if (200 == $res['status_code'][0]) {
                $add_time=date('Y-m-d H:i:s',$res['content'][0]['show_time']);
                $content =base64_decode($res['content'][0]['content']);
                $this->assign('content',$content);
                $this->assign('add_time',$add_time);
                $this->assign('new_list', $res['content'][0]);
            }
            //认证平台推荐
            if (200 == $res['status_code'][1]) {
                $list_tj = $res['content'][1]['list'];
                foreach ($list_tj as $key => $value) {
                    $list_tj[$key]['gszz'] = $value['agent_platform_n'].'-'.$value['mem_sn'].'号会员';
                }
                $this->assign('list_tj',$list_tj);
            }
        }
        if($this->is_mobile()){ 
            $this->display('article_wap');
        }else{ 
            $this->display();
        }
        //评论列表
        // $news_content = array();
        // $page_index = 1;
        // $page_size  = 3;
        // $news_content['where'] = "(user_id = $userid or is_validate = 1) and news_id = $id and company_id = $company_id";
        // if(I('get.p'))
        // {
        //     $page_index = I('get.p');
        //     $news_content['page_size'] = $page_size;
        //     $news_content['page_index'] = $page_index;
        // }
        // $new_result = $this->_call('Comnews.get_list',
        //                             $news_content);
        // if (200 == $new_result['status_code']) {
        //     $comnews = $new_result['content']['list'];
        //     $pat = '#\[em_([0-9]+)\]#';
        //     $bq  = C('bq_url');
        //     $replace = "<img src='$bq/$1.gif' />";
        //     $a = '/\s+/';
        //     $avatar = 'avatar.jpg';
        //     foreach ($comnews as $key => $rs) {
        //         $comnews[$key]['add_time'] = date('Y-m-d H:i:s',$rs['add_time']);
        //         $comnews[$key]['content']  = preg_replace($pat,$replace,$rs['content']); 
        //         $comnews[$key]['user_id']  = C('user_photo_url').preg_replace($a,'/',chunk_split($rs['user_id'],2)).$avatar;
        //     }
        //     $this->assign('comnews',$comnews);
        //     $record_count = $new_result['content']['record_count'];
        //     $this->assign('record_count', $record_count);
        //     $this->get_page($record_count, 3);
        // }
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
