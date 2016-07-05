<?php

#字符串日期格式格式化成年月日
function toDate($time, $format='Y-m-d H:i:s')
{
	return date('Y-m-d', strtotime($time));
}

#比较当前日期和过期日期，小于为已审核，否则为已过期
function diffDate($exp_time)
{
	$now = date('Y-m-d H:i:s');
	if(strtotime($now) > strtotime($exp_time))
	{
		return '<span style="color:red">已过期</span>';
	}

	return "<span style=\"color:green\">已审核</span>";
}

#生成uuid
function create_guid($namespace = '') {    
    static $guid = '';
    $uid = uniqid("", true);
    $data = $namespace;
    $data .= $_SERVER['REQUEST_TIME'];
    $data .= $_SERVER['HTTP_USER_AGENT'];
    $data .= $_SERVER['LOCAL_ADDR'];
    $data .= $_SERVER['LOCAL_PORT'];
    $data .= $_SERVER['REMOTE_ADDR'];
    $data .= $_SERVER['REMOTE_PORT'];
    $hash = strtoupper(hash('ripemd128', $uid . $guid . md5($data)));
    $guid = substr($hash,  0,  8) .
            '-' .
            substr($hash,  8,  4) .
            '-' .
            substr($hash, 12,  4) .
            '-' .
            substr($hash, 16,  4) .
            '-' .
            substr($hash, 20, 12);
    return $guid;
  }