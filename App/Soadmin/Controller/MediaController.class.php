<?php
namespace Soadmin\Controller;
use Think\Controller;
include_once(dirname(__FILE__).'/BaseController.class.php');
class MediaController extends BaseController {
         public function _initialize()
    {
	parent::_initialize();
	if(null == session('admin_name')
	|| ''   == session('admin_name'))
	{
	    $this->redirect('/Soadmin/Login/index');
	}
    }

	function get_list()
	{
            $content = array();
            $page_index = 1;
            $page_size  = 10;
            if(I('post.Submit'))
            {
                    if(I('post.dict_sn'))
                    {
                            $content['where'] = array(
                                    'dict_sn'=>urlencode(I('post.dict_sn')),
                            );
                            $this->assign('dict_sn', I('post.dict_sn'));
                    }
            }
            if(I('get.p'))
            {
                    $page_index = I('get.p');
                    $content['page_size'] = $page_size;
                    $content['page_index'] = $page_index;
            }

            $result = $this->_call('Media.get_list', $content);
            if($result)
            {
                if(200 == $result['status_code'])
                {
                    $this->assign('media_list', $result['content']['list']);
                    $record_count = $result['content']['record_count'];
                    $this->assign('record_count', $record_count);
                    $this->get_page($record_count, 10);
                }
            }
    
            $this->assign('sn_list', $this->_map_sn());
	    $this->display();
	}
        
        //图片编号映射名称
        private function _map_sn()
        {
            return array(
                '001001'=>'曝光图片',
                '001002'=>'监管机构',
                '001003'=>'营业执照',
                '001004'=>'机构代码证',
                '001005'=>'资质证明',
                '001006'=>'新闻图片(pc)',
                '001007'=>'新闻图片（app)',
                '001008'=>'企业logo',
                '001009'=>'评论图片',
            );
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
        }
}