<?php
namespace User\Controller;
use Think\Controller;
class BaseController extends Controller
{
	public function _initialize()
	{
		$this->assign('call_url', C('call_url'));
	}

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

	#调用分类键值对
	public function _map_category()
	{
		$list = array();
		$result = $this->_call('Category.get_category_name_map');
		if($result
		&& 200 == $result['status_code']
		&& 0 <count($result['content']))
		{
			$list = $result['content'];
		}

		return $list;
	}	

	#计量单位映射
	public function _map_unit()
	{
		$list = array();
		$content = array(
			'cat_id'=> 10,	       
		); 
		$result = $this->_call('Dict.get_name_map',
				       $content);
		if($result
		&& 200 == $result['status_code']
		&& 0 <count($result['content'])
		)
		{
			return $result['content'];
		}
		
		return array();
	}
	
	#交易类型映射
	public function _map_transaction_type()
	{
		$list = array();
		$content = array(
			'cat_id' => 13,
				 );
		$result = $this->_call('Dict.get_name_map',
				       $content);
		if($result
		&& 200 == $result['status_code']
		&& 0 <count($result['content'])
		)
		{
			return $result['content'];
		}
		
		return array();
	}
	
	#性别映射
	public function _map_sex()
	{
		$list = array();
		$content = array(
			'cat_id' => 9,
				 );
		$result = $this->_call('Dict.get_name_map',
				       $content);
		if($result
		&& 200 == $result['status_code']
		&& 0 <count($result['content'])
		)
		{
			return $result['content'];
		}
		
		return array();
	}
	
	#交易状态映射
	public function _map_transaction_status()
	{
		$list = array();
		$content = array(
			'cat_id' => 14,
				 );
		$result = $this->_call('Dict.get_name_map',
				       $content);
		if($result
		&& 200 == $result['status_code']
		&& 0 <count($result['content'])
		)
		{
			return $result['content'];
		}
		
		return array();
	}
}
