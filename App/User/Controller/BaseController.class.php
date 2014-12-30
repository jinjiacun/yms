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

	#获取计量单位
	public function get_unit()
	{
		$where = array(
            	'page_size'=>12,
            	'where' =>array(
            		'cat_id'=>10,
            	),
            );
        return $this->get_dict($where);	
	}

	#获取交易类型
	public function get_trade_type()
	{
		$where = array(
			'page_size' =>100,
			'where' =>array(
				'cat_id' => 13,
			),
		);

		return $this->get_dict($where);
	}

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
            if($result['content']['list']
            && 0 < count($result['content']['list']))
            {
               return $result['content']['list'];
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

	//分页
	public function get_page($record_count, $page_size)
	{
		#页数
        $this->assign('page_count', $page_count);
        $Page = new \Think\Page($record_count, $page_size);// 实例化分页类 传入总记录数和每页显示的记录数(25)
		$show = $Page->show();// 分页显示输出
		$this->assign('page',$show);// 赋值分页输出
	}

	#调用接口
	/**
	*
	*/
	public function _call($method='', $content = array(), $type='text', $handler = null)
	{
		$res = A('Callapi')->call_api($method, 
                                      $content,
                                      $type,
                                      $handler);
        $result = $this->deal_re_call_api($res);
        return $result;
	}
}