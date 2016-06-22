<?php
namespace Home\Controller;
use Think\Controller;
class CallapiController extends Controller {
	#api接口回调统一函数
	/**
	*@@input
	*@param $method  方法名
	*@param $content 内容
	*@param $type    数据传输类型(text-文本数据,resource-资源文件)
	*@param $handler 资源处理句柄
	*/
	public function call_api($method, $content, $type='text', $handler=null, $is_get=false)
	{
		
        $url_post = C('url_api');
        $url_post .= '/'.'yms_api'.'/'.'index.php/Soapi';

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
				if(is_array($method))
				{
					$data_arr = array(
				            'type'   => $type,
							'method' => json_encode($method),
							'content'=> urldecode(json_encode($content)),
							'handler'=> null,
							'is_mul'=>true,
				    );
				}
				else
				{
					$data_arr = array(
				            'type'   => $type,
							'method' => $method,
							'content'=> urldecode(json_encode($content)),
							'handler'=> null,
				    );
				}
			}
        	break;
        }
		$data = $data_arr;	
		$obj =  new \Org\Util\DES();
		$data['token'] = $obj->encrypt($data['method'].date('Y-m-d')); 
		//print_r($data['method']);
		//print_r($data['token']);
		if($is_get)
		{
			$res  = $this->get($url_post, $data);	
		}
		else
		{
			$res  = $this->post($url_post, $data, $header);		
			//$this->mul_post($url_post, $data);
		}
		return $res;
		//echo $res;
	}
    public function ajax_call_api()
	{	
		$method = I('post.method');
		if(I('get.method'))$method = I('get.method');
		$content = I('post.content');
		if(I('get.content'))$content = I('get.content');
		//$content = json_decode($content, true);
		$type    = I('post.type');
		if(I('get.type')) $type = I('get.type');
		
		$header = array(
				    'Connection: Keep-Alive',
				    'Keep-Alive: 300'
				);
		
		if(I('get.method'))
		{
			echo $this->call_api($method, $content, $type, $handler, true);
			exit();
		}
		else			
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
		curl_setopt($ch, CURLOPT_TIMEOUT, 1); 
		curl_setopt($ch, CURLOPT_TIMEOUT, 3600); 
		if($params !== false){
		 	curl_setopt($ch, CURLOPT_POSTFIELDS , $params);    
		} 
		curl_setopt($ch, CURLOPT_USERAGENT,'Mozilla/5.0 (Windows NT 5.1; rv:21.0) Gecko/20100101 Firefox/21.0'); 
		curl_setopt($ch, CURLOPT_URL,$url); 
		curl_setopt($ch, CURLOPT_HTTPHEADER, $header); 
		$result = curl_exec($ch); 
		file_put_contents("./txt.txt", $result);
		curl_close($ch); 
		 
		return $result; 
	}  

	function mul_post($url, $params)
	{
		//require("class/RollingCurl.php");
		/*
	   function callback($response, $info, $request) {
	      print_r($response);
	      print_r($info);
	      print_r($request);
	   }
	   */
	   $rc = new \Org\Util\RollingCurl();
	   $rc->window_size = 2;
	   for ($i = 1; $i < 2; $i++) {
	      //$url = "http://www.baidu.com/";
	      $request = new \Org\Util\RollingCurlRequest($url);
	      $request->options = array(CURLOPT_POSTFIELDS=>$params);
	      //array(CURLOPT_COOKIEJAR => '/tmp/ck.cookie', CURLOPT_COOKIEFILE => '/tmp/ck.cookie');
	      //$request->headers = array('Referer: http://www.haiyun.me');
	      $request->callback = 'callback';
	      $rc->add($request);
	   }
	   $res = $rc->execute();
	}

	function get($url, $params= false)
	{
		//初始化
		$ch = curl_init();
		if($params)
		{
			$str_list = array();
			foreach($params as $k=>$v)
			{
				$str_list[] = $k.'='.$v;
			}
			unset($params, $k, $v);
			$url .= '?'.implode('&',$str_list);
		}
		curl_setopt($ch, CURLOPT_URL,$url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	    curl_setopt($ch, CURLOPT_HEADER, 0);

		$result = curl_exec($ch);
		curl_close($ch); 

		return $result;
	}
}