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
	
	'DefaultPassword' => md5('123456')
);
