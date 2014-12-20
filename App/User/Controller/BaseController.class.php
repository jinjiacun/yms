<?php
namespace User\Controller;
use Think\Controller;
class BaseController extends Controller
{

	//解析接口调用返回处理
	protected function deal_re_call_api($res)
	{
		try
		{
			$result_array = json_decode($res, true);
		}
		catch(Exception $ex)
		{
			echo "系统返回异常";
			exit();
		}
		return $result_array;
	}

	#获取商品规格
	public function get_goods_spec()
	{
		
	}
}