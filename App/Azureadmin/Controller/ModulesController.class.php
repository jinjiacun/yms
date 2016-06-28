<?php
namespace Azureadmin\Controller;
use Think\Controller;
include_once(dirname(__FILE__).'/BaseController.class.php');
class ModulesController extends BaseController {
    public function _initialize()
    {
        parent::_initialize();
        if(null == session('AdminName')
        || ''   == session('AdminName'))
        {
            $this->redirect('/Azureadmin/Login/index');
        }
    }

	public function index()
	{
        $this->assign('menu_index', 6);
        $page_index = 1;
        $page_size  = 20;
        $content    = array();
        if(I('get.p'))
        {
            $page_index = I('get.p');
            $content['page_size'] = $page_size;
            $content['page_index'] = $page_index;
        }
        else
        {
            $content['page_size'] = $page_size;
            $content['page_index'] = $page_index;
        }
               
        $content['where']['MoPid'] = 0;
        $content['order']['MoId'] = 'asc';
        $res = A('Callapi')->call_api('Commodule.get_list', 
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
                    $this->assign('list', $list); 
                }
            }
        }

        //获取次级模块
        unset($result);
        if($list
        && 0<count($list))
        {
            $id_list = array();
            $ids = '';
            foreach($list as $v)
            {
                $id_list[] = $v['MoId'];
            }
            if(0<count($id_list))
                $ids = implode(',', $id_list);

            $content['where']['MoPid'] = array('in', $ids);
            $res = A('Callapi')->call_api('Commodule.get_list', $content, 'text', null);
            $result = $this->deal_re_call_api($res);
            if($result)
            {
                if(200 == $result['status_code'])
                {
                    if(isset($result['content']['list'])
                    && isset($result['content']['record_count']))
                    {
                        $tmp_list = $result['content']['list'];
                        foreach($list as $k=>$v)
                        {
                            foreach($tmp_list as $_k=>$_v)
                            {
                                if($v['MoId'] == $_v['MoPid'])
                                {
                                    $list[$k]['_ex'][] = $_v;
                                    unset($tmp_list[$_k]);    
                                }
                            }
                        }
                        $this->assign('list', $list);
                    }
                }
            }
        }

		$this->display();
	}

    public function quit()
    {
        session('AdminName',null);
        $this->redirect("Index/index");
        exit();
    }
}