<?php
namespace Home\Controller;
use Think\Controller;
header('Content-type: text/html; charset=utf-8');
include_once(dirname(__FILE__)."/BaseController.class.php");
class PostsController extends BaseController {
	/*
	*评论主贴
	*/
    public function posts_pl(){
       
        $this->_login();
        //企业和评论id
        $userid     = session('user_id');
        $company_id = I('get.qy');
        $qy_id      = I('get.pl');
        
        //信息查询方法名
        $method_list = array(
            'Company.get_info',        //企业信息查询
            'Comment.get_info',        //查询楼主的主贴评论 
            'Sharecount.get_info'      //查询分享次数
        ); 
        //查询条件
        $comment_list = array(
            //企业信息查询
            array('id' => $company_id),
            //查询楼主的主贴评论
            array('id' => $qy_id,
                  'is_delete' => 0 ),
            //查询分享次数
            array(
                'type'     => '007002',
                'value_id' => $qy_id
            )
        );
        //传入方法名和查询条件
        $result = $this->_mul_call($method_list, $comment_list);
        if ($result) {
            //企业信息查询
            if (200 == $result['status_code'][0]) {
                $list = $result['content'][0];
                //黑平台信息输出
                $this->assign('qy_list', $list);
            }
            //查询楼主的主贴评论
            if (200 == $result['status_code'][1]) {
                $list_lz = $result['content'][1];
                $add_time = date('Y-m-d H:i:s',$result['content'][1]['add_time']);
                $add_time_ex = date('Y-m-d',$result['content'][1]['add_time']);
                $content  =$this->cont($result['content'][1]['content']);
                $user_photo  = $this->photo($result['content'][1]['user_id']);
                $this->assign('add_time',$add_time);
                $this->assign('add_time_ex',$add_time_ex);
                $this->assign('content',$content);
                $this->assign('user_photo',$user_photo);
                $this->assign('lz',$list_lz);
            }
            //查询分享次数
            if (200 == $result['status_code'][2]) {
                $fx_times = $result['content'][2]['times'];
                $this->assign('fx_times',$fx_times);
            }
        }
        //评论列表
        $page_index_p = 1;
        $page_size_p  = 20;
        $p_content = array();
        if(I('get.p'))
        {
            $page_index_p = I('get.p');
            $p_content['page_size']  = $page_size_p;
            $p_content['page_index'] = $page_index_p;
        }else{
            $p_content['page_size']  = $page_size_p;
            $p_content['page_index'] = $page_index_p;
        }
        $p_content['order'] = array(
                'add_time'=>'asc'
                );
        if ($userid > 0) {
            $p_content['where'] = array(
                '_string'    => 'user_id = '.$userid.' or is_validate = 1',
                'company_id' => $company_id,
                'parent_id'  => $qy_id,
                'is_delete'  => 0);
        }else{
            $p_content['where'] = array(
                'is_validate'=> 1,
                'company_id' => $company_id,
                'parent_id'  => $qy_id,
                'is_delete'  => 0
                //'type'       => '005003'
                );
        }
        $p_result = $this->_call('Comment.get_list_ex',
                                    $p_content);
        if (200 == $p_result['status_code']) {
            $con_p = $p_result['content']['list'];
            foreach ($con_p as $key => $rs) {
                $con_p[$key]['add_time'] = date('Y-m-d H:i:s',$rs['add_time']);
                $con_p[$key]['add_time_ex'] = date('Y-m-d',$rs['add_time']);
                $con_p[$key]['content']  = $this->cont($rs['content']);
                $con_p[$key]['user_photo']  = $this->photo($rs['user_id']);
                $con_p[$key]['re_sub_ex'] = $rs['re_sub']['list'];
                $con_p[$key]['re_sub_count'] = $rs['re_sub']['record_count']-2;
            } 
            $this->_news(); 
            $this->assign('con_p',$con_p);
            $record_count_p = $p_result['content']['record_count'];
            $this->assign('record_count_p', $record_count_p);
            $this->get_page($record_count_p, $page_size_p);
        }
        if ($list) {
            if ($list_lz) {
                if($this->is_mobile()){ 
                  $this->display('wap_posts_pl');
                }else{
                    $this->display(); 
                }
            }else{
                $auth_level = $list['auth_level'];
                $id = $list['id'];
                if ("006001" == $auth_level) {
                    header("Location:".C('tz_url')."hpt?resid=".$id);
                    exit;
                }
                elseif ("006002" == $auth_level) {
                    header("Location:".C('tz_url')."wrz?resid=".$id);
                    exit;
                }
                elseif ("006003" == $auth_level) {
                    header("Location:".C('tz_url')."yrz?resid=".$id);
                    exit;
                }
            }
        }else{
            $this->redirect("/Index");
        }
        
    }
    /*
    *评论回复信息查询
    */
    public function query_yrz_hf($parent_id,$uId){
    	$userid = session('user_id');
        $page_size = 10;
        $page_index = 1;
        if(I('get.p'))
        {
            $page_index = I('get.p');
            $content['page_size']  = $page_size;
            $content['page_index'] = $page_index;
        }
        $content['page_size'] = $page_size;
        $content['order'] = array(
                'add_time'=>'asc'
                );
        if ($userid > 0) {
            $content['where']="(user_id = $userid or is_validate = 1) and company_id = $uId and parent_id = $parent_id and is_delete = 0";
        }else{
            $content['where']="is_validate = 1 and company_id = $uId and parent_id = $parent_id and is_delete = 0";
        }
        $result = $this->_call('Comment.get_list',
                               $content);
        if (200 == $result['status_code']) {
            $record_count = $result['content']['record_count'];
            $Page = new \Think\Page($record_count, $page_size);
            $pageShow = $Page->show();
            $hf_result = $result['content']['list'];
            foreach ($hf_result as $key => $rs) {
                $hf_result[$key]['add_time'] = date('Y-m-d H:i:s',$rs['add_time']);
                $hf_result[$key]['content']  = $this->cont($rs['content']);
                $hf_result[$key]['user_photo']  = $this->photo($rs['user_id']);
                $hf_result[$key]['suiji']    = $this->sudtext($rs['nickname']);
            }
            echo json_encode(array('list'=>$hf_result,'pages'=>$pageShow));
            exit();
        }
    }
     /*
    *用户评论添加
    */
    public function comment_add(){
    	$userid       = session('user_id');
    	$company_id   = I('post.company_id');
        $type         = I('post.wypl');
        $content_n    = $_POST['saytext'];
        $content_n    = $this->preg_rep($content_n);
        $content_n    = str_replace(PHP_EOL, '', $content_n);
        $is_anonymous = I('post.is_anonymous');
        $parent_id    = I('post.parent_id');
        //$verify       = I('param.verify','');  
        $arr          = I('post.pic');  
        $pic_1        = $arr[0];
        $pic_2        = $arr[1];
        $pic_3        = $arr[2];
        $pic_4        = $arr[3];
        $pic_5        = $arr[4];
        //图片1上传
        if ($content_n == "") {
        	echo 6;
            exit();
        }
        if ($pic_1 == "") {
            $pic_1 = 0;
        }
        if ($pic_2 == "") {
            $pic_2 = 0;
        }
        if ($pic_3 == "") {
            $pic_3 = 0;
        }
        if ($pic_4 == "") {
            $pic_4 = 0;
        }
        if ($pic_5 == "") {
            $pic_5 = 0;
        }
        $content = array(
        	'user_id'=>$userid,
        	'company_id'=>$company_id,
        	'type'=>$type,
        	'content'=>urlencode($content_n),
            'is_anonymous'=>$is_anonymous,
            'parent_id'=>$parent_id,
            'pic_1'=>$pic_1,
            'pic_2'=>$pic_2,
            'pic_3'=>$pic_3,
            'pic_4'=>$pic_4,
            'pic_5'=>$pic_5
        	);    
        $result = $this->_call('Comment.add',$content);
        if (200 == $result['status_code']){
            if(0 == $result['content']['is_success']) {
                echo 0;
                exit();
            }else if (-1 == $result['content']['is_success']) {
                echo -1;
                exit();
            }else if (-2 == $result['content']['is_success']) {
                echo -2;
                exit();
            }else if (-6 == $result['content']['is_success']){
                echo -6;
                exit();
            }else{
                echo -3;
                exit();
            }
        }else{
            echo -1;
            exit();
        }

    }



    /*
    *曝光评论主贴
    */
    public function posts_bg(){
    	//用户登录返回信息
    	$this->_login();
    	//企业和评论id
        $userid     = session('user_id');
        $company_id = I('get.qy');
        $qy_id      = I('get.pl');
        $this->assign('exposal_id',$qy_id);

        //信息查询方法名
        $method_list = array(
            'Company.get_info',        //企业信息查询
            'Inexposal.get_info',      //查询楼主的主贴评论 
            'Sharecount.get_info'      //查询分享次数
        ); 
        //查询条件
        $comment_list = array(
            //企业信息查询
            array('id' => $company_id),
            //查询楼主的主贴评论
            array('id' => $qy_id,
                  'is_delete' => 0),
            //查询分享次数
            array(
                'type'     => '007002',
                'value_id' => $qy_id
            )
        );
        //传入方法名和查询条件
        $result = $this->_mul_call($method_list, $comment_list);
        if ($result) {
            //企业信息查询
            if (200 == $result['status_code'][0]) {
                $list = $result['content'][0];
                //黑平台信息输出
                $this->assign('qy_list', $list);
            }
            //查询楼主的主贴评论
            if (200 == $result['status_code'][1]) {
                $list_lz = $result['content'][1];
                $add_time = date('Y-m-d H:i:s',$result['content'][1]['add_time']);
                $add_time_ex = date('Y-m-d',$result['content'][1]['add_time']);
                $content  =$this->cont($result['content'][1]['content']);
                $user_photo  = $this->photo($result['content'][1]['user_id']);
                $this->assign('add_time_ex',$add_time_ex);
                $this->assign('content',$content);
                $this->assign('user_photo',$user_photo);
                $this->assign('lz',$list_lz);
            }
            //查询分享次数
            if (200 == $result['status_code'][2]) {
                $fx_times = $result['content'][2]['times'];
                $this->assign('fx_times',$fx_times);
            }
        }
        //评论列表
        $page_index_p = 1;
        $page_size_p  = 20;
        $p_content = array();
        if(I('get.p'))
        {
            $page_index_p = I('get.p');
            $p_content['page_size']  = $page_size_p;
            $p_content['page_index'] = $page_index_p;
        }else{
            $p_content['page_size']  = $page_size_p;
            $p_content['page_index'] = $page_index_p;
        }
        $p_content['order'] = array(
                'add_time'=>'asc'
                );
        if ($userid > 0) {
        	$p_content['user_id'] = $userid;
            $p_content['where'] = array(
                '_string'    => 'user_id = '.$userid.' or is_validate = 1',
                'exposal_id' => $qy_id,
                'parent_id' => 0,
                'is_delete'  => 0
                );
        }else{
        	$p_content['user_id'] = 0;
            $p_content['where'] = array(
                'is_validate'=> 1,
                'exposal_id' => $qy_id,
                'parent_id' => 0,
                'is_delete'  => 0
                );
        }
        $p_result = $this->_call('Comexposal.get_list_com_ex',
                                    $p_content);
        
        if (200 == $p_result['status_code']) {
            $con_p = $p_result['content']['list'];
            foreach ($con_p as $key => $rs) {
                $con_p[$key]['add_time'] = date('Y-m-d H:i:s',$rs['add_time']);
                $con_p[$key]['add_time_ex'] = date('Y-m-d',$rs['add_time']);
                $con_p[$key]['content']  = $this->cont($rs['content']);
                $con_p[$key]['user_photo']  = $this->photo($rs['user_id']);
                $con_p[$key]['re_sub_ex'] = $rs['sub']['list'];
                $con_p[$key]['re_sub_count'] = $rs['sub']['record_count']-2;
            } 
            $this->_news(); 
            $this->assign('con_p',$con_p);
            $record_count_p = $p_result['content']['record_count'];
            $this->assign('record_count_p', $record_count_p);
            $this->get_page($record_count_p, $page_size_p);
        }
        if ($list) {
            if ($list_lz) {
                if($this->is_mobile()){ 
                   $this->display('wap_posts_bg');
                }else{
                    $this->display(); 
                }
            }else{
                $auth_level = $list['auth_level'];
                $id = $list['id'];
                if ("006001" == $auth_level) {
                    header("Location:".C('tz_url')."hpt?resid=".$id);
                    exit;
                }
                elseif ("006002" == $auth_level) {
                    header("Location:".C('tz_url')."wrz?resid=".$id);
                    exit;
                }
                elseif ("006003" == $auth_level) {
                    header("Location:".C('tz_url')."yrz?resid=".$id);
                    exit;
                }
            }
        }else{
            $this->redirect("/Index");
        }
    }
    /*
    *网友曝光评论列表
    */
    public function query_wybg_hf($exposal_id,$uId){
    	$userid = session('user_id');
        $page_size = 10;
        $page_index = 1;
        if(I('get.p'))
        {
            $page_index = I('get.p');
            $content['page_size']  = $page_size;
            $content['page_index'] = $page_index;
        }
        $content['page_size'] = $page_size;
        $content['order'] = array(
                'add_time'=>'asc'
                );
        if ($userid > 0) {
            $content['where']="(user_id = $userid or is_validate = 1) and exposal_id = $exposal_id and parent_id = $uId";
        }else{
            $content['where']="is_validate = 1 and exposal_id = $exposal_id and parent_id = $uId";
        }
        
        $result = $this->_call('Comexposal.get_list',
                               $content);
        if (200 == $result['status_code']) {
            $record_count = $result['content']['record_count'];
            $Page = new \Think\Page($record_count, $page_size);
            $pageShow = $Page->show();
            $hf_result = $result['content']['list'];
            foreach ($hf_result as $key => $rs) {
                $hf_result[$key]['add_time'] = date('Y-m-d H:i:s',$rs['add_time']);
                $hf_result[$key]['content']  = $this->cont($rs['content']);
                $hf_result[$key]['user_photo']  = $this->photo($rs['user_id']);
            }
            echo json_encode(array('list'=>$hf_result,'pages'=>$pageShow));
            exit();
        }
    }
    /*
    *用户曝光评论
    */
    public function comexposal_add(){
    	$userid       = session('user_id');
    	$exposal_id   = I('post.exposal_id');
        $type         = I('post.wypl');
        $content_n    = $_POST['saytext'];
        $content_n    = $this->preg_rep($content_n);
        $content_n    = str_replace(PHP_EOL, '', $content_n);
        $is_anonymous = I('post.is_anonymous');  
        $arr          = I('post.pic');  
        $pic_1        = $arr[0];
        $pic_2        = $arr[1];
        $pic_3        = $arr[2];
        $pic_4        = $arr[3];
        $pic_5        = $arr[4];
        //图片1上传
        if ($content_n == "") {
        	echo 6;
            exit();
        }
        if ($pic_1 == "") {
            $pic_1 = 0;
        }
        if ($pic_2 == "") {
            $pic_2 = 0;
        }
        if ($pic_3 == "") {
            $pic_3 = 0;
        }
        if ($pic_4 == "") {
            $pic_4 = 0;
        }
        if ($pic_5 == "") {
            $pic_5 = 0;
        } 
        $content = array(
        	'user_id'=>$userid,
        	'exposal_id'=>$exposal_id,
        	'type'=>$type,
        	'content'=>urlencode($content_n),
            'is_anonymous'=>$is_anonymous,
            'parent_id' => 0,
            'pic_1'=>$pic_1,
            'pic_2'=>$pic_2,
            'pic_3'=>$pic_3,
            'pic_4'=>$pic_4,
            'pic_5'=>$pic_5
        	);
        $result = $this->_call('Comexposal.add',$content);
        if (200 == $result['status_code']) {
            if(0 == $result['content']['is_success']) {
                echo 0;
                exit();
            }else if (-1 == $result['content']['is_success']) {
                echo -1;
                exit();
            }else if (-2 == $result['content']['is_success'] || -3 == $result['content']['is_success']) {
                echo -2;
                exit();
            }else if (-4 == $result['content']['is_success']){
                echo -4;
                exit();
            }else{
                echo -3;
                exit();
            }
        }else{
            echo -1;
            exit();
        }

    }
    /*
    *评论筛选列表
    */
    public function comment_list(){
        $is_id      = I('post.id');
        $company_id = I('post.qy');
        $pl_id      = I('post.pl');
        $userid     = session('user_id');
        $page_size  = 20;
        $p_content  = array();
        $p_content['page_size'] = $page_size;
        $p_content['order'] = array(
                'add_time'=>'asc'
                );
        if ($is_id == "qb") { //查询全部
            if ($userid > 0) {
                $p_content['where'] = array(
                    '_string'    => 'user_id = '.$userid.' or is_validate = 1',
                    'company_id' => $company_id,
                    'parent_id'  => $pl_id,
                    'is_delete'  => 0);
            }else{
                $p_content['where'] = array(
                    'is_validate'=> 1,
                    'company_id' => $company_id,
                    'parent_id'  => $pl_id,
                    'is_delete'  => 0
                    //'type'       => '005003'
                    );
            }
        }elseif ($is_id == "pic_1") { //有图有真相
            $p_content['where'] = array(
                'is_validate'=> 1,
                'pic_1'   => array('neq',0),
                'company_id' => $company_id,
                'parent_id'  => $pl_id,
                'is_delete'  => 0
                );  
        }elseif ($is_id == "has_child") { //精彩评论
            $p_content['where'] = array(
                'is_validate'=> 1,
                'has_child'  => array('neq',0),
                'company_id' => $company_id,
                'parent_id'  => $pl_id,
                'is_delete'  => 0
                );
        }else{ //楼主出品
            $p_content['where'] = array(
                'is_validate'=> 1,
                'is_anonymous' => 0,
                'user_id'    => $is_id,
                'company_id' => $company_id,
                'parent_id'  => $pl_id,
                'is_delete'  => 0
                );
            $p_content['where_ex'] = array(
                'company_id' => $company_id,
                'is_validate'=> 1,
                'is_delete'  => 0
                );
        }
        $p_result = $this->_call('Comment.get_list_ex',
                                    $p_content);
        if (200 == $p_result['status_code']) {
            $con_p = $p_result['content']['list'];
            $pl_count = $p_result['content']['record_count'];
            foreach ($con_p as $key => $rs) {
                $con_p[$key]['nickname_ex']  = $this->sudtext($rs['nickname']);
                $con_p[$key]['add_time'] = date('Y-m-d H:i:s',$rs['add_time']);
                $con_p[$key]['add_time_ex'] = date('Y-m-d',$rs['add_time']);
                $con_p[$key]['content']  = $this->cont($rs['content']);
                $con_p[$key]['user_photo']  = $this->photo($rs['user_id']);
                $con_p[$key]['re_sub_ex'] = $rs['re_sub']['list'];
                $con_p[$key]['re_sub_count'] = $rs['re_sub']['record_count']-2;
                $con_p[$key]['re_record_count'] = $rs['re_sub']['record_count'];
                foreach ($con_p[$key]['re_sub_ex'] as $kk => $value) {
                    $con_p[$key]['re_sub_ex'][$kk]['nickname_ex']  = $this->sudtext($value['nickname']);
                    $con_p[$key]['re_sub_ex'][$kk]['add_time'] = date('Y-m-d H:i',$value['add_time']);
                    $con_p[$key]['re_sub_ex'][$kk]['content']  = $this->cont($value['content']);
                    $con_p[$key]['re_sub_ex'][$kk]['user_photo']  = $this->photo($value['user_id']);
                }
            } 
            echo json_encode(array('list'=>$con_p,'pl_count'=>$pl_count));
            exit();
        }
    }
    /*
    *曝光筛选列表
    */
    public function comexposal_list(){
        //评论列表
        $is_id     = I('post.id');
        $pl_id     = I('post.pl');
        $userid    = session('user_id');
        $page_size = 20;
        $p_content = array();
        $p_content['page_size'] = $page_size;
        $p_content['order'] = array(
                'add_time'=>'asc'
                );
        if ($is_id == "qb") {
            if ($userid > 0) {
                $p_content['user_id'] = $userid;
                $p_content['where'] = array(
                    '_string'    => 'user_id = '.$userid.' or is_validate = 1',
                    'exposal_id' => $pl_id,
                    'parent_id' => 0,
                    'is_delete'  => 0
                    );
            }else{
                $p_content['user_id'] = 0;
                $p_content['where'] = array(
                    'is_validate'=> 1,
                    'exposal_id' => $pl_id,
                    'parent_id' => 0,
                    'is_delete'  => 0
                    );
            }
        }elseif ($is_id == "pic_1") {
                //$p_content['user_id'] = $userid;
                $p_content['where'] = array(
                    'is_validate' => 1,
                    'pic_1'   => array('gt',0),
                    'exposal_id' => $pl_id,
                    'parent_id' => 0,
                    'is_delete'  => 0
                    );
        }elseif ($is_id == "has_child") {
                //$p_content['user_id'] = $userid;
                $p_content['where'] = array(
                    'is_validate' => 1,
                    'has_child'   => array('gt',0),
                    'exposal_id' => $pl_id,
                    'parent_id' => 0,
                    'is_delete'  => 0
                    );
        }else{
                //$p_content['user_id'] = $is_id;
                $p_content['where'] = array(
                    'is_validate' => 1,
                    'user_id'     => $is_id,
                    'exposal_id' => $pl_id,
                    'is_anonymous' => 0,
                    'parent_id' => 0,
                    'is_delete'  => 0
                    );
                $p_content['where_ex'] = array(
                    'exposal_id' => $pl_id,
                    'is_validate'=> 1,
                    'is_delete'  => 0
                );
        }
        $p_result = $this->_call('Comexposal.get_list_com_ex',
                                    $p_content);
        if (200 == $p_result['status_code']) {
            $con_p = $p_result['content']['list'];
            $pl_count = $p_result['content']['record_count'];
            foreach ($con_p as $key => $rs) {
                $con_p[$key]['nickname_ex']  = $this->sudtext($rs['nickname']);
                $con_p[$key]['add_time'] = date('Y-m-d H:i:s',$rs['add_time']);
                $con_p[$key]['add_time_ex'] = date('Y-m-d',$rs['add_time']);
                $con_p[$key]['content']  = $this->cont($rs['content']);
                $con_p[$key]['user_photo']  = $this->photo($rs['user_id']);
                $con_p[$key]['re_sub_ex'] = $rs['sub']['list'];
                $con_p[$key]['re_sub_count'] = $rs['sub']['record_count']-2;
                $con_p[$key]['re_record_count'] = $rs['sub']['record_count'];
                foreach ($con_p[$key]['re_sub_ex'] as $kk => $value) {
                    $con_p[$key]['re_sub_ex'][$kk]['nickname_ex']  = $this->sudtext($value['nickname']);
                    $con_p[$key]['re_sub_ex'][$kk]['add_time'] = date('Y-m-d H:i',$value['add_time']);
                    $con_p[$key]['re_sub_ex'][$kk]['content']  = $this->cont($value['content']);
                    $con_p[$key]['re_sub_ex'][$kk]['user_photo']  = $this->photo($value['user_id']);
                }
            }
            echo json_encode(array('list'=>$con_p,'pl_count'=>$pl_count));
            exit();
        }  
    }
    //评论查看更多
    public function pl_pl(){
        $userid    = session('user_id');
        //评论列表
        $qy_id      = I('post.id');
        $company_id = I('post.company_id');
        $p          = isset($_POST['k'])?intval(trim($_POST['k'])):0;
        $page_index_p = 1;
        $page_size_p  = 20;
        $p_content = array();
        if($p)
        {
            $page_index_p = $p;
            $p_content['page_size']  = $page_size_p;
            $p_content['page_index'] = $page_index_p;
        }
        $p_content['order'] = array(
                'add_time'=>'asc'
                );
        if ($userid > 0) {
            $p_content['where'] = array(
                '_string'    => 'user_id = '.$userid.' or is_validate = 1',
                'company_id' => $company_id,
                'parent_id'  => $qy_id,
                'is_delete'  => 0);
        }else{
            $p_content['where'] = array(
                'is_validate'=> 1,
                'company_id' => $company_id,
                'parent_id'  => $qy_id,
                'is_delete'  => 0
                );
        }

        $p_result = $this->_call('Comment.get_list_ex',
                                    $p_content);
        if (200 == $p_result['status_code']) {
            $con_p = $p_result['content']['list'];
            foreach ($con_p as $key => $rs) {
                $con_p[$key]['add_time'] = date('Y-m-d H:i:s',$rs['add_time']);
                $con_p[$key]['add_time_ex'] = date('Y-m-d',$rs['add_time']);
                $con_p[$key]['content']  = $this->cont($rs['content']);
                $con_p[$key]['user_photo']  = $this->photo($rs['user_id']);
                $con_p[$key]['re_sub_ex'] = $rs['re_sub']['list'];
                $con_p[$key]['re_sub_count'] = $rs['re_sub']['record_count']-2;
                $con_p[$key]['nickname_ex'] = $this->sudtext($rs['nickname']);
                foreach ($con_p[$key]['re_sub_ex'] as $kk => $value) {
                    $con_p[$key]['re_sub_ex'][$kk]['add_time'] = date('Y-m-d H:i',$value['add_time']);
                    $con_p[$key]['re_sub_ex'][$kk]['content']  = $this->cont($value['content']);
                    $con_p[$key]['re_sub_ex'][$kk]['user_photo']  = $this->photo($value['user_id']);
                }
            } 
            echo json_encode($con_p);
            exit();
        }
    }
    //曝光查看更多
    public function bg_pl(){
        $userid    = session('user_id');
        //评论列表
        $qy_id      = I('post.id');
        $p          = isset($_POST['k'])?intval(trim($_POST['k'])):0;
        $page_index_p = 1;
        $page_size_p  = 20;
        $p_content = array();
        if($p)
        {
            $page_index_p = $p;
            $p_content['page_size']  = $page_size_p;
            $p_content['page_index'] = $page_index_p;
        }
        $p_content['order'] = array(
                'add_time'=>'asc'
                );
        if ($userid > 0) {
            $p_content['user_id'] = $userid;
            $p_content['where'] = array(
                '_string'    => 'user_id = '.$userid.' or is_validate = 1',
                'exposal_id' => $qy_id,
                'parent_id' => 0,
                'is_delete'  => 0
                );
        }else{
            $p_content['user_id'] = 0;
            $p_content['where'] = array(
                'is_validate'=> 1,
                'exposal_id' => $qy_id,
                'parent_id' => 0,
                'is_delete'  => 0
                );
        }
        $p_result = $this->_call('Comexposal.get_list_com_ex',
                                    $p_content);
        
        if (200 == $p_result['status_code']) {
            $con_p = $p_result['content']['list'];
            foreach ($con_p as $key => $rs) {
                $con_p[$key]['add_time'] = date('Y-m-d H:i:s',$rs['add_time']);
                $con_p[$key]['add_time_ex'] = date('Y-m-d',$rs['add_time']);
                $con_p[$key]['content']  = $this->cont($rs['content']);
                $con_p[$key]['user_photo']  = $this->photo($rs['user_id']);
                $con_p[$key]['re_sub_ex'] = $rs['sub']['list'];
                $con_p[$key]['re_sub_count'] = $rs['sub']['record_count']-2;
                foreach ($con_p[$key]['re_sub_ex'] as $kk => $value) {
                    $con_p[$key]['re_sub_ex'][$kk]['add_time'] = date('Y-m-d H:i',$value['add_time']);
                    $con_p[$key]['re_sub_ex'][$kk]['content']  = $this->cont($value['content']);
                    $con_p[$key]['re_sub_ex'][$kk]['user_photo']  = $this->photo($value['user_id']);
                }
            } 
            echo json_encode($con_p);
            exit();
        }
    }
    //评论添加页面
    public function pl_wap(){
        $this->_login();
        $company_id = I("get.qy");
        $parent_id = I("get.lz");
        $content['id'] = $company_id;
        $result = $this->_call('Company.get_info',$content);
        if (200 == $result['status_code']) {
            $list = $result['content'];
            $this->assign('list',$list);
            
        }
        $this->assign('parent_id',$parent_id);
        $this->display();
    }
    //曝光评论添加页面
    public function bg_wap(){
        $this->_login();
        $company_id = I("get.qy");
        $exposal_id = I("get.lz");
        $content['id'] = $company_id;
        $result = $this->_call('Company.get_info',$content);
        if (200 == $result['status_code']) {
            $list = $result['content'];
            $this->assign('list',$list);  
        }
        $this->assign('exposal_id',$exposal_id);
        $this->display();
    }
    //评论回复
    public function plhf_wap(){
        $this->_login();
        $company_id = I("get.cm");
        $id         = I("get.cn");
        $lz         = I("get.lz");
        $content['id'] = $company_id;
        $result = $this->_call('Company.get_info',$content);
        if (200 == $result['status_code']) {
            $list = $result['content'];
            $this->assign('list',$list);   
        }
        $this->assign('id',$id);
        $this->display();
    }
    //曝光回复
    public function bghf_wap(){
        $this->_login();
        $exposal_id = I("get.cm");
        $id         = I("get.cn");
        $qy         = I("get.qy");
        $content['id'] = $qy;
        $result = $this->_call('Company.get_info',$content);
        if (200 == $result['status_code']) {
            $list = $result['content'];
            $this->assign('list',$list);   
        }
        $this->assign('id',$id);
        $this->assign('exposal_id',$exposal_id);
        $this->display();
    }
    //第三层跟帖
    public function plgt_wap(){
        $this->_login();
        $company_id = I("get.cm");
        $id         = I("get.cn");
        $lz         = I("get.lz");
        //查询企业
        $content['id'] = $company_id;
        $result = $this->_call('Company.get_info',$content);
        if (200 == $result['status_code']) {
            $list = $result['content'];
            $this->assign('qy_list',$list);   
        }
        //查询二次主贴评论
        $con['id'] = $id;
        $result = $this->_call('Comment.get_info',$con);
        if (200 == $result['status_code']) {
            $list_lz = $result['content'];
            $add_time = date('Y-m-d H:i:s',$result['content']['add_time']);
            $add_time_ex = date('Y-m-d',$result['content']['add_time']);
            $content  =$this->cont($result['content']['content']);
            $user_photo  = $this->photo($result['content']['user_id']);
            $this->assign('add_time',$add_time);
            $this->assign('add_time_ex',$add_time_ex);
            $this->assign('content',$content);
            $this->assign('user_photo',$user_photo);
            $this->assign('lz',$list_lz);
        }
        //查询第三层评论
        $userid = session('user_id');
        $page_size = 10;
        $page_index = 1;
        $content_n = array();
        $content_n['page_index'] = $page_index;
        $content_n['page_size'] = $page_size;
        $content_n['order'] = array(
                'add_time'=>'asc'
                );
        if ($userid > 0) {
            $content_n['where']="(user_id = $userid or is_validate = 1) and company_id = $company_id and parent_id = $id and is_delete = 0";
        }else{
            $content_n['where']="is_validate = 1 and company_id = $company_id and parent_id = $id and is_delete = 0";
        }
        $result = $this->_call('Comment.get_list',
                               $content_n);
        if (200 == $result['status_code']) {
            $record_count = $result['content']['record_count'];
            $hf_result = $result['content']['list'];
            foreach ($hf_result as $key => $rs) {
                $hf_result[$key]['add_time'] = date('Y-m-d H:i:s',$rs['add_time']);
                $hf_result[$key]['content']  = $this->cont($rs['content']);
                $hf_result[$key]['user_photo']  = $this->photo($rs['user_id']);
                $hf_result[$key]['suiji']    = $this->sudtext($rs['nickname']);
            }
            $this->assign('record_count',$record_count);
            $this->assign('hf',$hf_result);
        }
        $this->display();
    }
    //第三层跟帖查看更多
    public function plgt_wap_ex(){
        $userid     = session('user_id');
        $uId        = I('post.uId');
        $parent_id  = I('post.parent_id');
        $p          = isset($_POST['k'])?intval(trim($_POST['k'])):0;
        $page_size  = 10;
        $page_index = 1;
        $content    = array();
        if($p)
        {
            $page_index = $p;
            $content['page_size']  = $page_size;
            $content['page_index'] = $page_index;
        }
        $content['order'] = array(
                'add_time'=>'asc'
                );
        if ($userid > 0) {
            $content['where']="(user_id = $userid or is_validate = 1) and company_id = $uId and parent_id = $parent_id and is_delete = 0";
        }else{
            $content['where']="is_validate = 1 and company_id = $uId and parent_id = $parent_id and is_delete = 0";
        }
        $result = $this->_call('Comment.get_list',
                               $content);
        if (200 == $result['status_code']) {
            $hf_result = $result['content']['list'];
            foreach ($hf_result as $key => $rs) {
                $hf_result[$key]['add_time'] = date('Y-m-d H:i:s',$rs['add_time']);
                $hf_result[$key]['content']  = $this->cont($rs['content']);
                $hf_result[$key]['user_photo']  = $this->photo($rs['user_id']);
            }
            echo json_encode($hf_result);
            exit();
        }
    }
    //第三层跟帖
    public function bggt_wap(){
        $this->_login();
        $company_id = I("get.qy"); //企业
        $id         = I("get.cn"); //本体
        $lz         = I("get.cm"); //楼主
        //查询企业
        $content['id'] = $company_id;
        $result = $this->_call('Company.get_info',$content);
        if (200 == $result['status_code']) {
            $list = $result['content'];
            $this->assign('qy_list',$list);   
        }
        //查询二次主贴评论
        $con['id'] = $id;
        $result = $this->_call('Comexposal.get_info',$con);
        if (200 == $result['status_code']) {
            $list_lz = $result['content'];
            $add_time = date('Y-m-d H:i:s',$result['content']['add_time']);
            $add_time_ex = date('Y-m-d',$result['content']['add_time']);
            $content  =$this->cont($result['content']['content']);
            $user_photo  = $this->photo($result['content']['user_id']);
            $this->assign('add_time',$add_time);
            $this->assign('add_time_ex',$add_time_ex);
            $this->assign('content',$content);
            $this->assign('user_photo',$user_photo);
            $this->assign('lz',$list_lz);
        }
        //查询第三层评论
        $userid = session('user_id');
        $page_size = 10;
        $page_index = 1;
        $content_n = array();
        $content_n['page_size']  = $page_size;
        $content_n['page_index'] = $page_index;
        $content_n['order'] = array(
                'add_time'=>'asc'
                );
        if ($userid > 0) {
            $content_n['where']="(user_id = $userid or is_validate = 1) and exposal_id = $lz and parent_id = $id";
        }else{
            $content_n['where']="is_validate = 1 and exposal_id = $lz and parent_id = $id and is_delete = 0";
        }
        $result = $this->_call('Comexposal.get_list',
                               $content_n);

        if (200 == $result['status_code']) {
            $record_count = $result['content']['record_count'];
            $hf_result = $result['content']['list'];
            foreach ($hf_result as $key => $rs) {
                $hf_result[$key]['add_time'] = date('Y-m-d H:i:s',$rs['add_time']);
                $hf_result[$key]['content']  = $this->cont($rs['content']);
                $hf_result[$key]['user_photo']  = $this->photo($rs['user_id']);
            }
            $this->assign('hf',$hf_result);
            $this->assign('record_count',$record_count);
        }
        $this->display();
    }
    //第三层跟帖查看更多
    public function bggt_wap_ex(){
        $userid     = session('user_id');
        $uId        = I('post.uId');
        $parent_id  = I('post.parent_id');
        $p          = isset($_POST['k'])?intval(trim($_POST['k'])):0;
        $page_size  = 10;
        $page_index = 1;
        $content    = array();
        if($p)
        {
            $page_index = $p;
            $content['page_size']  = $page_size;
            $content['page_index'] = $page_index;
        }
        $content['order'] = array(
                'add_time'=>'asc'
                );
        if ($userid > 0) {
            $content['where']="(user_id = $userid or is_validate = 1) and exposal_id = $parent_id and parent_id = $uId and is_delete = 0";
        }else{
            $content['where']="is_validate = 1 and exposal_id = $parent_id and parent_id = $uId and is_delete = 0";
        }
        $result = $this->_call('Comexposal.get_list',
                               $content);
        if (200 == $result['status_code']) {
            $hf_result = $result['content']['list'];
            foreach ($hf_result as $key => $rs) {
                $hf_result[$key]['add_time'] = date('Y-m-d H:i:s',$rs['add_time']);
                $hf_result[$key]['content']  = $this->cont($rs['content']);
                $hf_result[$key]['user_photo']  = $this->photo($rs['user_id']);
            }
            echo json_encode($hf_result);
            exit();
        }
    }
}