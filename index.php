<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2014 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用入口文件

// 检测PHP环境
if(version_compare(PHP_VERSION,'5.3.0','<'))  die('require PHP > 5.3.0 !');
header("Cache-Control:max-age=3600");
header('Expires:'.date('D, d M Y H:i:s \G\M\T', time()+60));
header("Last-Modified:". date('r', time()));
header('Etag:'.date("Y-m-d H:i", time()));
header("Access-Control-Allow-Origin:*");
ob_start('ob_gzhandler');//gzip
// 开启调试模式 建议开发阶段开启 部署阶段注释或者设为false
define('APP_DEBUG',True);
//$_GET['m'] = 'Home'; 
define('BIND_MODULE','Home');
// 定义应用目录
//define('APP_NAME', 'App');
//define('APP_PATH', __FILE__);
#复制代码复制代码
define('APP_PATH','./App/');
define('__PUBLIC__', dirname(__FILE__).'/Public/');
// 引入ThinkPHP入口文件
require './ThinkPHP/ThinkPHP.php';

// 亲^_^ 后面不需要任何代码了 就是如此简单