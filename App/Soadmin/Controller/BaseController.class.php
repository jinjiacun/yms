<?php
namespace Soadmin\Controller;
use Think\Controller;
class BaseController extends Controller {
	function   _empty(){
                    header("HTTP/1.0  404  Not Found");
                    $this->display('Public:err_404');
            }
	    
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
		if(!empty($_FILES[$field]['tmp_name']))
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
		    elseif(-4 == $result['content']['is_success'])
		    {
			//$this->error('文件超过最大范围');
		    $this->echo_message(-500,'文件超过最大范围');
		    exit();
			return 0;
		    }
		}
	    }
	    
	    return 0;
	}
	
	//0-全部，1-过滤合规企业,2-平台
	public function _map_company($type=0)
	{
		$list = array();
		if(1 == $type)
		{
			$content['where']['auth_level'] = array('neq', '006003');
		}
		elseif(2 == $type)
		{
			$content['where']['nature'] = array('eq', '003002');
		}
		//查询企业
		$result = $this->_call("Company.get_id_name_map", $content);
		if($result
		&& 200 == $result['status_code'])
		{
		    $list = $result['content'];
		}
		
		return $list;
	}
	
	//查询企业级别映射
	public function _map_auth_level_company()
	{
		$list = array();
		
		$result = $this->_call("Company.get_id_auth_level_map");
		if($result
		&& 200 == $result['status_code'])
		{
			$list = $result['content'];
		}
		return $list;
	}
	
	//监管机构映射
	public function _map_regulators()
	{
		$list = array();
		$result = $this->_call("Regulators.get_id_name_map", $content);
		if($result
		&& 200 == $result['status_code'])
		{
			$list = $result['content'];
		}
		return $list;
	}
	
	public function _map_dict()
	{
		return array(
			'001001'=>array(1,'图片','曝光图片'),
			'001002'=>array(1,'图片','监管机构'),
		);
	}
	
	public function _map_news()
	{
		$list = array();
		$result = $this->_call("News.get_id_name_map");
		if($result
		&& 200 == $result['status_code'])
		{
			$list = $result['content'];
		}
		
		return $list;
	}
	
	public function _map_exposal()
	{
		$list = array();
		$result = $this->_call("Inexposal.get_id_name_map");
		if($result
		&& 200 == $result['status_code'])
		{
			$list = $result['content'];
		}
		return $list;
	}
	
	public function _format_face($content)
	{
	
	//return $content;
	
		 $pat     = '#\[em_([0-9]+)\]#';
                 $bq      = C('bq_url');
                 //$replace = "<img src='$bq/$1.gif' />";
		 $replace = "";
		 $re_str  = preg_replace($pat,$replace,$content);
		 $re_str = mb_strcut($re_str,0,40, 'utf-8');
		 return $re_str;
	}
	
	//企业性质
	public function _map_nature_list()
	{
		$_map =  array(
			'003001'=>'公司',
			'003002'=>'平台',
		);
		$this->assign('nature_list', $_map);
	}
	
	//所属行业
	public function _map_trade_list()
	{
		$_map =  array(
			'004001'=>'贵金属',
			'004002'=>'外汇',
			'004003'=>'石油',
			'004004'=>'大宗商品',
			'004005'=>'其他',
		);
		$this->assign('trade_list', $_map);
		return $_map;
	}
	
	//返回状态
	public function echo_message($status=0, $message='操作成功', $jmp_url='')
	{
		echo json_encode(
		        array(
				'status'=>$status,
				'message'=>$message,
				'jmp_url'=>$jmp_url,
			)
		);
	}
	
	
	
	
	
	
	
	
	
	
	
	
}