<?php
namespace Soadmin\Controller;
use Soadmin\Controller;
include_once(dirname(__FILE__).'/BaseController.class.php');
class NewsController extends BaseController {
    
    public function add()
    {
        if(I('post.submit'))
        {
            //上传图片
            $pic     = $this->upload('pic');
            $pic_app = $this->upload('pic_app');
            $content = array(
                'title'   => urlencode(I('post.title')),
                'source'  => urlencode(I('post.source')),
                'author'  => urlencode(I('author')),
                'content' => urlencode(base64_encode(I('post.content'))),
                'pic'     => $pic,
                'pic_app' => $pic_app,
            );
             $result = $this->_call('News.add', $content);
             if($result
             && 0 == $result['status_code'])
             {
                $this->success("成功添加");
             }
        }
        $this->display();
    }
    
    public function get_list()
    {
        $page_index = 1;
        $page_size  = 10;
        $content    = array();
        if(I('get.p'))
        {
            $page_index = I('get.p');
            $content['page_size'] = $page_size;
            $content['page_index'] = $page_index;
        }
        $res = A('Callapi')->call_api('News.get_list', 
                                    $content,
                                    'text',
                                  null);
        $result = $this->deal_re_call_api($res);

        $list = array();
        if($result)
        {
            if(200 == $result['status_code'])
            {
                if(isset($result['content']['list'])
                && isset($result['content']['record_count']))
                {
                    $list   = $result['content']['list'];   
                    $this->assign('news_list', $list);     
                    $record_count = $result['content']['record_count'];
                    $this->assign('record_count', $record_count);
                    $this->get_page($record_count, 10);
                }
            }
        }

        $this->display();
    }
    
    public function edit()
    {
        $id = I('get.id');
        if(0>= $id)
        {
            $this->error('参数错误');
        }
        
        
        $content['id'] = $id;
        $result = $this->_call("News.get_info", $content);
        if($result
        && 200 == $result['status_code'])
        {
            $news_info = $result['content'];
            $news_info['content'] = base64_decode($news_info['content']);
            $this->assign('news', $news_info);
        }
        $this->display();
    }
    
    public function delete()
    {
        $this->display();
    }
    
    //上传图片
    private function upload($field ='pic')
    {
        if(I('post.submit'))
        {
            if($_FILES[$field])
            {
                $fp  = fopen($_FILES[$field]['tmp_name'], "rb");
                $buf = fread($fp, $_FILES[$field]['size']);
                fclose($fp);
                $content = array(
                    'file_name' => '123.jpg',
                    'buf'       => $buf,
                    'file_ext'  => 'jpg',
                    'module_sn' => '001006',
                ); 
                
                $result = $this->_call(
                              'Media.upload',
                              $content,
                              'resource'  
                        );
                if($result
                && 200 == $result['status_code']
                && 0   == $result['content']['is_success']
                )
                {
                   return intval($result['content']['id']);
                }
            }
        }
        
        return 0;
    }
}