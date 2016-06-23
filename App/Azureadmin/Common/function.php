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