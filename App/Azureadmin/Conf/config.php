<?php
return array(
	//'配置项'=>'配置值'
	#'url_api' => 'http://220.248.57.238:7788',
	'url_api' => 'http://192.168.1.131',
	'call_url'=> 'http://192.168.1.131/yms/admin.php/Soadmin/Callapi/ajax_call_api',
	'Template_pre' => 'http://192.168.1.131/yms/azureadmin.php/'.'Azureadmin/',
	'admin_url'    => 'http://192.168.1.131/yms/azureadmin.php',
	'TMPL_ACTION_SUCCESS'=>'Public:dispatch_jump',
    //'TMPL_ACTION_ERROR'=>'Public:dispatch_jump',
	'bq_url' => "/yms/Public/Home/arclist",
	'domain'=>'http://localhost/yms/',
	'controller'=>'http://localhost/yms/azureadmin.php/Azureadmin',
	'resource'=>'http://localhost/yms/Public/Azureadmin',

	//分析师权限
	'TeacherInitCol' => "355,377,381,378,385",
	'PlatFormName' => '平台',
	
	'DefaultPassword' => md5('123456'),
	'Dictionary' => array(
	   //登陆类型
	   'EnumLoginType' => array(
	     '手机号' => 1,
	     '邮箱'   => 5,
	     '用户名' => 6
	   ),
	   //用户状态
	   'EnumUserState' => array(
	     '禁用' => 0,
	     '启用' => 1,
	   ),
	   //分析师等级
	   'EnumAnalystRank' => array(
	     '初级分析师' => 0,
	     '中级分析师' => 1,
	     '高级分析师' => 2
	   ),
	   //消息阅读状态
	   'EnumComMessageRead' => array(
	     '未读' => 0,
             '已读' => 1,
	   ),
	   //消息状态
	   'EnumComMessageState' => array(
	     '未删' => 1,
             '已删' => 0,
	   ),
	),
);
