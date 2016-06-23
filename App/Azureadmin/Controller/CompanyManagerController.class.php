<?php
namespace Azureadmin\Controller;
use Think\Controller;
include_once(dirname(__FILE__).'/BaseController.class.php');
class CompanyManagerController extends BaseController {
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
        $this->assign('menu_index', 1);

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
               
        $res = A('Callapi')->call_api('Comtable.get_list', 
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
                    $record_count = $result['content']['record_count'];
                    $this->assign('record_count', $record_count);
                    $this->get_page($record_count, $page_size);
                }
            }
        }
        
        
        $this->_map_trade_list();
        
		$this->display();
	}

    //查询一条机构信息
    /*
    ComId 机构id
    */
    public function GetDetail()
    {
        $ComId = intval(I('post.ComId'));
        if(0 == $ComId) 
        {            
            echo '{"res":-5001}';
            exit();
        }

        $content['ComId'] = $ComId;
        $res = A('Callapi')->call_api('Comtable.get_info', 
                                    $content,
                                    'text',
                                  null);
        $result = $this->deal_re_call_api($res);
        $info = array();
        if($result)
        {
            if(200 == $result['status_code'])
            {
                $info = array(
                    'res'=>1,
                    'data'=>$result['content']
                    );
                echo json_encode($info);
                exit();
            }
        }

        echo '{"res":-5000}';
        exit();
    }

    //修改机构信息
    public function UpdateInfo()
    {

    }

    //延长期限
    public function ExtendTime()
    {

    }

    //重置密码
    public function ResetPwd()
    {

    }

    //设置机构状态
    public function SetState()
    {

    }

    //审核通过
    public function Pass()
    {

    }

    public function quit()
    {
        session('AdminName',null);
        $this->redirect("Index/index");
        exit();
    }
}