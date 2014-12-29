<?php
namespace Admin\Controller;
use Think\Controller;
include_once(dirname(__FILE__).'/BaseController.class.php');
class MediaController extends BaseController {

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

		$this->display();
	}
}