<?php
return array(
	//'配置项'=>'配置值'
	'url_api' => 'http://192.168.1.233',
	'call_url'=> 'http://192.168.1.73/bug/Callapi/ajax_call_api',
	'SESSION_AUTO_START' =>true,
    'ERROR_PAGE' =>'/Public/error.html',
    //'SESSION_OPTIONS' =>  array('name'=>'session_id','expire'=>432000),  
    'SESSION_OPTIONS'         =>  array(
        'name'                =>  'session_id',                    //设置session名
        'expire'              =>  24*3600*15,                      //SESSION保存15天
        'use_trans_sid'       =>  1,                               //跨页传递
        'use_only_cookies'    =>  0,                               //是否只开启基于cookies的session的会话方式
    ),
    'URL_MODEL'=> 2,
    'URL_HTML_SUFFIX' =>'.html',
    'URL_ROUTER_ON'   => true
);