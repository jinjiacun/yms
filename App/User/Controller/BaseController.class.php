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

	#获取邮票品相
	public function get_post_condition()
	{
		$where = array(
            'cat_id'=>2,
            );
        return $this->get_dict($where);
	}

	#获取邮票规格
	public function get_post_spec()
	{
		$where = array(
            'cat_id'=>1,
            );
        return $this->get_dict($where);
	}

	#获取计量单位
	public function get_unit()
	{
		$where = array(
            'cat_id'=>10,
            );
        return $this->get_dict($where);	
	}

	#获取交易类型
	//public function get_

	#获取字典信息
	private function get_dict($where)
	{
		$res = A('Callapi')->call_api('Dict.get_list',
                            $where,
                            'text',
                            $handler
        );
        $result = $this->deal_re_call_api($res);
        if(200 == $result['status_code'])
        {
            if($result['content']
            && 0 < count($result['content']))
            {
               return $result['content'];
            }
        }

        return array();
	}

	#获取邮票有效期年
	public function get_years()
	{
		return array(
			2014, 2015, 2016, 2017, 2018, 2019, 2020
			);
	}

	#获取邮票有效期月
	public function get_months()
	{
		return array(
			1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12
			);
	}

	#获取邮票有效期日
	public function get_days($year, $month)
	{
		switch($month)
		{
			case 1:
			case 3:
			case 5:
			case 7:
			case 8:
			case 10:
			case 12:
				return array(1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20,
					         21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31);
			case 4:
			case 6:
			case 9:
			case 11:
				return array(1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20,
					         21, 22, 23, 24, 25, 26, 27, 28, 29, 30);
			case 2:
			{
				#闰年
				if(0 == $year%4
				|| 0 == $year%100
				|| 0 == $year%400)
				{
					return array(1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20,
					         21, 22, 23, 24, 25, 26, 27, 28, 29);
				}
				else
				{
					return array(1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20,
					         21, 22, 23, 24, 25, 26, 27, 28);
				}
			}

		}
	}

	#获取邮票有效期时	
	public function get_hour()
	{
		return array(
			0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23
			);
	}
}