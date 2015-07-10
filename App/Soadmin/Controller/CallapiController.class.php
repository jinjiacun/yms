<?php
namespace Soadmin\Controller;
use Soadmin\Controller;
include_once(dirname(__FILE__).'/BaseController.class.php');
class CallapiController extends BaseController {
	#api接口回调统一函数
	/**
	*@@input
	*@param $method  方法名
	*@param $content 内容
	*@param $type    数据传输类型(text-文本数据,resource-资源文件)
	*@param $handler 资源处理句柄
	*/
	public function call_api($method='', $content=array(), $type='text', $handler=null)
	{
		
        $url_post = C('url_api');
        $url_post .= '/'.'yms_api'.'/'.'index.php?m=Soapi';

        $buff = null;
        switch($type)
        {
        	case 'resource':
        	{
	        	$buf      = $content['buf'];
	        	$filename = $content['file_name'];
	        	$varname  = "my";
	       		$key      = "$varname\";filename=\"$filename\r\nContent-Type:$type\r\n";
	       		$handler  = $key;
	       		$data_arr[$key]         = $buf;
	       		
	       		$data_arr['content'] = json_encode(array('field_name'  => $varname,               #上传字段名称
	       												 'file_name'   => $filename,              #文件名称
	       												  'file_ext'   => $content['file_ext'],   #文件后缀名称
	       												  'module_sn'  => $content['module_sn'],  #目标模块编号
	       								));
	       		$data_arr['method']     = $method;
	       		$data_arr['type']       = $type;
        	}
        	break;
        	case 'text':#普通文本json传输
			{
				$data_arr = array(
				            'type'   => $type,
							'method' => $method,
							'content'=> urldecode(json_encode($content)),
							'handler'=> null,
				        );
			}
        	break;
        }
		$data = $data_arr;
		$obj =  new \Org\Util\DES();
		$data['token'] = $obj->encrypt($data['method'].date('Y-m-d')); 
		$res  = $this->post($url_post, $data, $header);
		return $res;
		//echo $res;
	}

	public function ajax_call_api()
	{
		$method = I('post.method');
		$content = I('post.content');
		//$content = json_decode($content, true);
		$type    = I('post.type');
		echo $this->call_api($method, $content, $type, $handler);
	}

	function post($url, $params = false, $header = array()){
		//$cookie_file = tempnam(dirname(__FILE__),'cookie');
		$cookie_file = __PUBLIC__.'cookies.tmp';
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_POST, 1); 
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 60); 
		//curl_setopt($ch, CURLOPT_COOKIEJAR, $cookieFile);
		curl_setopt($ch, CURLOPT_COOKIEJAR, $cookie_file); 
		//curl_setopt($ch, CURLOPT_COOKIEFILE,$cookieFile); 
		curl_setopt($ch, CURLOPT_COOKIEFILE,$cookie_file); 
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1); 
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER,FALSE); 
		curl_setopt($ch, CURLOPT_HTTPGET, true); 
		curl_setopt($ch, CURLOPT_TIMEOUT, 30); 
		if($params !== false){
		 	curl_setopt($ch, CURLOPT_POSTFIELDS , $params);
		} 
		curl_setopt($ch, CURLOPT_USERAGENT,'Mozilla/5.0 (Windows NT 5.1; rv:21.0) Gecko/20100101 Firefox/21.0'); 
		curl_setopt($ch, CURLOPT_URL,$url); 
		curl_setopt($ch, CURLOPT_HTTPHEADER, $header); 
		$result = curl_exec($ch); 
		curl_close($ch); 
		 
		return $result; 
	}  
}