<?php
namespace Azureadmin\Controller;
use Think\Controller;
include_once(dirname(__FILE__).'/BaseController.class.php');
class LiveRoomStatisticsController extends BaseController{
    public function _initialize()
    {
        parent::_initialize();
        parent::get_dictionary();
        if(null == session('AdminName')
        || ''   == session('AdminName'))
        {
            $this->redirect('/Azureadmin/Login/index');
        }
    }

	public function index()
	{
		$this->assign('menu_index', 19);

        $ComId = session('ComId');
        //直播信息
        $content['ComId'] = $ComId;
        $content['template_name'] = 'STAT_LIVE_BROADCAST';
        $result = $this->_call('Help.stat_by_template', $content);
        if($result){
            if($result['status_code'] == 200){
                $this->assign('live_room_list', $result['content']);
            }
        }
        unset($result);

        //互动数量
        $content['template_name'] = 'STAT_LIVE_BROADCAST';
        $result = $this->_call('Help.stat_by_template', $content);
        if($result){
            if($result['status_code'] == 200){
                $this->assign('room_inter_list', $result['content']);
            }
        }
        unset($result);
        
        //操作建议
        $content['template_name'] = 'OPTION';
        $result = $this->_call('Help.stat_by_template', $content);
        if($result){
            if($result['status_code'] == 200){
                $this->assign('opetion_suggest_list', $result['content']);
            }
        }
        unset($result);

        //金评信息
        $content['template_name'] = 'GLOD_COMMENT';
        $result = $this->_call('Help.stat_by_template', $content);
        if($result){
            if($result['status_code'] == 200){
                $this->assign('comment_list', $result['content']);
            }
        }
        unset($result);

        //多空观点
        $content['template_name'] = 'LONG_SHORT_VIEW';
        $result = $this->_call('Help.stat_by_template', $content);
        if($result){
            if($result['status_code'] == 200){
                $this->assign('view_list', $result['content']);
            }
        }
        unset($result);

        //账户诊断
        $content['template_name'] = 'ACCOUNT_DIAGNOSIS';
        $result = $this->_call('Help.stat_by_template', $content);
        if($result){
            if($result['status_code'] == 200){
                $this->assign('account_list', $result['content']);
            }
        }
        unset($result);

        //公司新闻
        $content['template_name'] = 'NEWS';
        $result = $this->_call('Help.stat_by_template', $content);
        if($result){
            if($result['status_code'] == 200){
                $this->assign('news_list', $result['content']);
            }
        }
        unset($result);
	
		$this->display();
	}
}