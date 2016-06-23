<?php
namespace Admin\Controller;
use Think\Controller;
header('Content-type: text/html; charset=utf-8');
include_once(dirname(__FILE__)."/BaseController.class.php");
class AskController extends BaseController {
    public function _initialize(){
        parent::_initialize();
        if("" == session('user_id'))
        {
            exit('<script>top.location.href="/wenda/admin.php/Login/index"</script>');
        }
    }
	/*
	*问题列表
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
            //关键字
            $name = I('get.keywords');
            if ("" != $name) {
                $this->assign('name', $name);
                $content['where']['title'] = array('like', '$'.urlencode($name).'$');
                $this->assign('name', $name);
            }
            //项目
            if (0 != I('get.project_id')) {
                $this->assign('prmod', I('get.project_id'));
                $content['where']['project_id'] = I('get.project_id');
                $this->assign('prmod', I('get.project_id'));
            }
            //状态
            $status = I('get.status');
            if (0 != $status) {
                $this->assign('sta', $status);
                if (1 == $status) {
                    $content['where']['status'] = 0;
                }else{
                    $content['where']['status'] = 1;
                }
                $this->assign('sta', $status);
            }
        }
        $result = $this->_call('Ask.get_list',$content);
        if (200 == $result['status_code']) {
            $con = $result['content']['list']; 
            foreach ($con as $key => $rs) {
                $con[$key]['ask'] = base64_decode(str_replace(' ', '+', $rs['ask']));
                $con[$key]['answer'] = base64_decode(str_replace(' ', '+', $rs['answer']));
                $con[$key]['ask_time'] = date('Y-m-d H:i:s',$rs['ask_time']);
            } 
            $this->assign('con',$con);
            $record_count = $result['content']['record_count'];
            $this->assign('record_count', $record_count);
            $this->get_page($record_count, $page_size);
        }
        $this->display();
    }
    /*
    *问题添加
    */
    public function add(){
    	if (I('post.submit')) {
            $project_id   = I('post.project_id');
            $title        = I('post.title');
            $title        = $this->DeleteHtml($title);
            $ask          = I('post.ask');
            $asker        = session('user_id');
            $status       = I('post.status');
            $answer       = I('post.answer');
            $answerer     = session('user_id');
            $content = array(
                'project_id' => $project_id,
                'title' => urlencode($title),
                'ask' => urlencode(base64_encode($ask)),
                'asker' => $asker,
                'status' => $status,
                'answer' => urlencode(base64_encode($answer)),
                'answerer' => $answerer,
                'ask_time' => time(),
                'answer_time' => time()
                );
            $result = $this->_call('Ask.add',$content);
            if (200 == $result['status_code']
                && 0 == $result['content']['is_success']) {
                echo 0;
                exit();
            }else{
                echo -1;
                exit();
            }
        }
        $this->assign('user_id',session('user_id'));
    	$this->display();
    }
    /*
    *问题修改
    */
    public function edit(){
        $id = I('get.id');
        //修改信息查询
        $content['id'] = $id;
        $result = $this->_call('Ask.get_info',$content);
        if ($result && 200 == $result['status_code']) {
            $edit_info = $result['content'];
            $edit_info['ask'] = base64_decode(str_replace(' ', '+', $edit_info['ask']));
            $edit_info['answer'] = base64_decode(str_replace(' ', '+', $edit_info['answer']));
            $edit_info['ask_time'] = date('Y-m-d H:i:s',$result['content']['ask_time']);
            $edit_info['answer_time'] = date('Y-m-d H:i:s',$result['content']['answer_time']);
            $this->assign('edit_info',$edit_info);
        }
        //修改信息提交
        if (I('post.submit')) {
            $id           = I('post.id');
            $project_id   = I('post.project_id');
            $title        = I('post.title');
            $title        = $this->DeleteHtml($title);
            $ask          = I('post.ask');
            $status       = I('post.status');
            $answer       = I('post.answer');
            $answerer     = session('user_id');
            $content['data'] = array(
                'project_id' => $project_id,
                'title' => urlencode($title),
                'ask' => urlencode(base64_encode($ask)),
                'status' => $status,
                'answer' => urlencode(base64_encode($answer)),
                'answerer' => $answerer,
                'answer_time' => time()
                );
            $content['where'] = array('id' => $id);
            $result = $this->_call('Ask.update',$content);
            if (200 == $result['status_code']
                && 0 == $result['content']['is_success']) {
                echo 0;
                exit();
            }else{
                echo -1;
                exit();
            }
        }
        $this->display();
    }
    //批量删除问题
    public function batch_delete(){
        $id_list = I('post.id');
        $item = explode(',', $id_list);
        if(0<count($item))
        {
            foreach($item as $id)
            {
                $result = $this->_call("Ask.delete",array('id'=>$id));
                if($result && 200 == $result['status_code']
                && 0 == $result['content']['is_success']
                ){
                }else
                {
                    echo -1;
                    exit();
                }
            }
            
        }
    }
}