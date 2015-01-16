<?php
namespace Soadmin\Controller;
use Think\Controller;
class BaseController extends Controller {
	public function _initialize()
	{
		/*if(session('admin_name'))
		{
			//$this->display('Index:index');
		}
		else
		{
			$this->display('Login:index');
			exit();
		}*/
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
	
	//上传图片
	protected function upload($field , $sn)
	{
	    if(I('post.submit'))
	    {
		if($_FILES[$field])
		{
		    $fp  = fopen($_FILES[$field]['tmp_name'], "rb");
		    $buf = fread($fp, $_FILES[$field]['size']);
		    fclose($fp);
		    $content = array(
			'file_name' => '123.jpg',
			'buf'       => $buf,
			'file_ext'  => 'jpg',
			'module_sn' => $sn,
		    ); 
		    
		    $result = $this->_call(
				  'Media.upload',
				  $content,
				  'resource'  
			    );
		    if($result
		    && 200 == $result['status_code']
		    && 0   == $result['content']['is_success']
		    )
		    {
		       return intval($result['content']['id']);
		    }
		}
	    }
	    
	    return 0;
	}
	
	public function _map_company()
	{
		$list = array();
		//查询企业
		$result = $this->_call("Company.get_id_name_map");
		if($result
		&& 200 == $result['status_code'])
		{
		    $list = $result['content'];
		}
		
		return $list;
	}
}