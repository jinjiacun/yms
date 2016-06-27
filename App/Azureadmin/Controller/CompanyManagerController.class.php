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
                    //$this->get_page($record_count, $page_size);
                    $this->assign('page', $this->get_page_by_custom(C('controller').'/CompanyManager/GetTable', 1, $record_count, $page_size));
                }
            }
        }
        
		$this->display();
	}

    /**
        功能：查询表格
    */
    public function GetTable()
    {
        $page_index = 1;
        $page_size  = 20;
        $content    = array();
        if(I('get.page'))
        {
            $page_index = I('get.page');
            $content['page_size'] = $page_size;
            $content['page_index'] = $page_index;
        }
        else
        {
            $content['page_size'] = $page_size;
            $content['page_index'] = $page_index;
        }
            
        //机构名称模糊查询   
        if(I('get.company'))
        {
            $content['where']['ComAllName'] = array('like', '$'.urlencode(I('get.company')).'$');
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
                    
                    //输出html
                    $html_begin = <<<EOF
                    <div class="search">
                        <div>机构全称(模糊)：</div>
                        <div><input id="txtSearchCompany" type="text" /></div>
                        <div><button class="btn btn-primary" onclick="e()">查询</button></div>
                        <div style="clear: left; float: none;"></div>
                        </div>
                        <div id="grid">
                            <table class="table table-bordered data-table dataTable">
                                <thead>
                                    <th class="ui-state-default width1">编号</th>
                                    <th class="ui-state-default width5">公司全称</th>
                                    <th class="ui-state-default width1">购买产品</th>
                                    <th class="ui-state-default">产品地址</th>
                                    <th class="ui-state-default width2">申请时间</th>
                                    <th class="ui-state-default width2">过期时间</th>
                                    <th class="ui-state-default width3">状态</th>
                                    <th class="ui-state-default width4">操作</th>
                                </thead>
                                <tbody>
EOF;
$html_end = <<<EOF
                            </tbody>
                            </table>
EOF;
                          /*  <div class="dataTables_wrapper">
                                <div class="fg-toolbar ui-toolbar ui-widget-header ui-corner-bl ui-corner-br ui-helper-clearfix">
                                    <div class="dataTables_paginate fg-buttonset ui-buttonset fg-buttonset-multi ui-buttonset-multi paging_full_numbers">
                                        <a href="javascript:;" class="first ui-corner-tl ui-corner-bl fg-button ui-button ui-state-default ui-state-disabled" title="首页">首页</a>
                                        <span>
                                            <a currpage="1" class="fg-button ui-button ui-state-default ui-state-disabled" href="javascript:;" title="第1页">1</a>
                                            <a href="javascript:;" onclick="$('#grid').load('/CompanyManager/GetTable?page=2&company= #grid');"  class="fg-button ui-button ui-state-default">2</a></span><a href="javascript:;" onclick="$('#grid').load('/CompanyManager/GetTable?page=2&company= #grid');" class="last ui-corner-tr ui-corner-br fg-button ui-button ui-state-default"  title="末页">末页</a>
                                    </div>
                                </div>
                            </div>
*/  
                    $record_count = $result['content']['record_count'];
                    $page_size = 20;                    
                    $my_page = $this->get_page_by_custom(C('controller').'/CompanyManager/GetTable', $page_index, $record_count, $page_size);
                    $tr_str = '';
                    $_map_vip = array(
                        1=>'白金版',
                        2=>'钻石版',
                        3=>'尊享版',
                    );
                    foreach($list as $v)
                    {
                        $url = '';
                        if($v['ComState'] <> 0)
                        {
                            $url = ' <a target="_black" href="'.C('domain').$v['ComTag'].'">'.C('domain').$v['ComTag'].'</a>';
                        }
                        $vip = $_map_vip[$v['ComFlag']];
                        $CreateTime = date('Y-m-d',strtotime($v['CreateTime']));
                        $ExpTime = '';
                        if($v['ComState'] <> 0)
                        {
                            $ExpTime = date('Y-m-d', strtotime($v['ExpTime']));
                        }
                        $ComState = '';
                        if($v['ComState'] == -1)
                        {
                            $ComState = '<span style="color:red">已禁用</span>';
                        }
                        elseif($v['ComState'] == 0)
                        {
                            $ComState = '<span style="color:orange">等待审核</span>';
                        }
                        elseif($v['ComState'] == 1)
                        {
                            $ComState = diffDate($v['ExpTime']);
                        }
                        $tr_str .= "
                                 <tr>
                                        <td>$v[ComId]</td>
                                        <td><a target=\"_blank\" href=\"$v[ComUrl]\">$v[ComAllName]</a></td>
                                        <td>$vip</td>
                                        <td>$url</td>
                                        <td>$CreateTime</td>
                                        <td>$ExpTime</td>
                                        <td>$ComState</td>
                                        <td><button onclick=\"b($v[ComId])\" class=\"btn btn-primary btn-mini\">修改</button>&nbsp;<button onclick=\"c($v[ComId])\" class=\"btn btn-success btn-mini\">通过</button>&nbsp;</td>
                                    </tr>
                        ";
                    }
                    echo $html_begin.$tr_str.$html_end.$my_page."</div>";
                    exit();
                }
            }
        }

    }

    /**
        功能：查询一条机构信息

        参数：
            @param $ComId int 机构编号
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
        $res = A('Callapi')->call_api('Comtable.get_info_by_key', 
                                    $content,
                                    'text',
                                  null);
        $result = $this->deal_re_call_api($res);
        
        $data = array();
        $info = array();
        
        if($result)
        {
            if(200 == $result['status_code'])
            {
            	$data =  $result['content'];
            }
        }


        if(0 != $data['ComState'])
        {
             unset($content);
            $content['ComId'] = $ComId;
            //查询管理员id
            $res = A('Callapi')->call_api("Cominit.get_info",
                                            $content,
                                            'text',
                                            null);
            $result = $this->deal_re_call_api($res);
            $ComAdmin = 0;
            if($result)
            {
                if(200 == $result['status_code'])
                {
                    $ComAdmin = $result['content']['ComAdmin'];
                }
            }
            unset($content);
            //查询管理员用户名及其id
            $content['AdminId'] = $ComAdmin;
            $res = A('Callapi')->call_api("ComAdmin.get_info_by_key",
                                           $content,
                                          'text',
                                           null);
            $result = $this->deal_re_call_api($res);
            if($result)
            {
                if(200 == $result['status_code'])
                {
                    $data['AdminId'] = $result['content']['AdminId'];
                    $data['AdminName'] = $result['content']['AdminName'];
                }
            }
        }
       

        $info = array(
            'res'=>1,
            'data'=>$data
            );
        echo json_encode($info);
        exit();
       
    }

    /**
        功能:修改机构信息

        入口参数:
            @param ComId int 机构编号
            @param ComAddress string 联系地址
            @param ComLine string 联系人
            @param ComEmail string 企业邮箱
            @param ComMob string 联系电话
            @param ComPhone string 热线电话
            @param ComMail string 联系邮箱
    */
    /***/
    public function UpdateInfo()
    {
        $content = array(
                'where'=>array('ComId' => intval(I('post.ComId'))),
                'data'=>array(
                    'ComAddress' => urlencode(I('post.ComAddress')), 
                    'ComLine' => urlencode(I('post.ComLine')), 
                    'ComEmail' => I('post.ComEmail'),
                    'ComMob' => I('post.ComMob'),
                    'ComPhone' => I('post.ComPhone'),
                    'ComMail' => I('post.ComMail')
                    ),
            );
	$res = A('Callapi')->call_api(
		'Comtable.update',
		$content,
		'text',null);
	$result = $this->deal_re_call_api($res);
	if($result)
	{
		if(0 == $result['is_success'])
		{
			echo json_encode(array('res'=>1));		
			exit();
		}
	}

	echo json_encode(array('res'=>-5001));
	exit();
    }

    	/*
	    功能:延长期限

	    参数:
	    	@param ComId int 机构编号
		@param ExpTime timestamp 延长日期
	*/
    public function ExtendTime()
    {
	    $content = array(
		    'where' => array('ComId' => I('post.ComId')),
		    'data' => array(
			    'ExpTime' => I('post.ExpTime'),
			    'UpTime' => date('Y-m-d H:i:s'),
		    ),
	    );

	$res = A('Callapi')->call_api('Comtalbe.update', $content, 'text', null);
	$result = $this->deal_re_call_api($res);
	if($result)
	{
		if(0 == $result['is_success'])
		{
			echo json_encode(array("res"=>1));
			exit();
		}
	}

	echo json_encode(array('res'=>-5001));
	exit();
    }

    /*
	    功能：重置密码

	    参数：
	    @param ComId int 机构编号
	    @param AdminId int 管理员编号
     */
    public function ResetPwd()
    {
	$content = array(
		'where' => array('ComId' => I('post.ComId'),
				 'AdminId' => I('post.AdminId')),
		'data' => array('Password' => md5('123456'),
				'UpTime' => date('Y-m-d H:i:s'))
			);
	$res = A('Callapi')->call_api('ComAdmin.update', $content, 'text', null);
		$result = $this->deal_re_call_api($res);
	if($result)
	{
		if(0 == $result['is_success'])
		{
			echo json_encode(array("res" => 1));
			exit();
		}
	}

	echo json_encode(array("res" => -5001));
	exit();
		
    }

    /*
     * 功能：设置机构状态
     *
     * 参数：
     * 	@param ComId int 机构编号
     * 	@param ComState int 状态
     */
    public function SetState()
    {
	$content = array(
		'where' => array('ComId' => I('post.ComId')),
		'data' => array('ComState' => I('post.ComState'))
	);

	$res = A("Callapi")->call_api("Comtable.update", $content, 'text', null);
	$result = $this->deal_re_call_api($res);
	if($result)
	{
		if(0 == $result['is_success'])
		{
			echo json_encode(array('res' => 1));
			exit();
		}
	}

	echo json_encode(array('res' => -5001));
	exit();
    }

    /**
     * 功能：审核通过
     *
     * 参数：
     * 	@param ComId int 机构id
     * 	@param ComTag string 机构标识
     *
     */
    public function Pass()
    {
	//检查机构tag
	$content = array("ComTag" => I("ComTag"));
	$res = A("Callapi")->call_api("Comtable.check", $content, 'text', null);
	$result = $this->deal_re_call_api($res);
	if($result)
	{
		if(0 == $result['is_success'])
		{
			echo json_encode(array('res' => 1));
			exit();
		}
	}

	echo json_encode(array("res"=> -5001));
	exit();
    }
	
    /*
    public function quit()
    {
        session('AdminName',null);
        $this->redirect("Index/index");
        exit();
    }
     */
}