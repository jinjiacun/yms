<?php
namespace Home\Controller;
use Think\Controller;
class BaseController extends Controller
{
	public function _initialize()
	{
		$this->assign('call_url',C('call_url'));
		//var_dump($_SERVER['HTTP_HOST']);
		if(!in_array($_SERVER['HTTP_HOST'], array('www.souhei.com.cn','souhei.com.cn','192.168.1.131')))
        {
            header('HTTP/1.1 401 Unauthorized');
	    		  exit();
           exit('no authorization'); 
        }
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

	//分页
	public function get_page($record_count, $page_size)
	{
		#页数
        $this->assign('page_count', $page_count);
        $Page = new \Think\Page($record_count, $page_size);// 实例化分页类 传入总记录数和每页显示的记录数(25)
		$show = $Page->show();// 分页显示输出
		$this->assign('page',$show);// 赋值分页输出
	}
	//分页
	public function get_pages($record_count, $page_size)
	{
		#页数
        $this->assign('page_count', $page_count);
        $Page = new \Think\nPage($record_count, $page_size);// 实例化分页类 传入总记录数和每页显示的记录数(25)
		$show = $Page->show();// 分页显示输出
		$this->assign('pages',$show);// 赋值分页输出
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

	public function _mul_call($method_list=array(), $content_list = array(), $type='text', $handler = null)
	{
			$res = A('Callapi')->call_api($method_list, 
                                      $content_list,
                                      $type,
                                      $handler);
		#var_dump($res);
        $result = $this->deal_re_call_api($res);
        return $result;
	}
    //1-过滤合规企业,2-平台
	public function _map_company($type,$zhi)
	{
		$list = array();
		if(1 == $type)
		{
			$content['where']['auth_level'] = array('eq', $zhi);
		}
		elseif(2 == $type)
		{
			$content['where']['nature'] = array('eq', $zhi);
		}
		//查询企业
		$result = $this->_call("Company.get_id_name_map", $content);
		if($result
		&& 200 == $result['status_code'])
		{
		    $list = $result['content'];
		    natcasesort($list);
		}
		return $list;
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
		
	//企业性质
	public function _map_nature_list()
	{
		$_map =  array(
			'003001'=>'公司',
			'003002'=>'平台',
		);
		$this->assign('nature_list', $_map);
		return $_map;
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
	//登录用户信息保存
	public function _login()
	{
		$userid    = session('user_id');
        $nickname  = session('nickname');
        $a         = '/\s+/';
        $avatar    = 'avatar.jpg';
        $photo_url = C('user_photo_url').preg_replace($a,'/',chunk_split($userid,2)).$avatar;
        $this->assign('photo_url',$photo_url);
        $this->assign('nickname',$nickname);
        $this->assign('userid',$userid);
	}
	//字符截断
    public function cutstr($string, $length) {
        preg_match_all("/[\x01-\x7f]|[\xc2-\xdf][\x80-\xbf]|\xe0[\xa0-\xbf][\x80-\xbf]|[\xe1-\xef][\x80-\xbf][\x80-\xbf]|\xf0[\x90-\xbf][\x80-\xbf][\x80-\xbf]|[\xf1-\xf7][\x80-\xbf][\x80-\xbf][\x80-\xbf]/", $string, $info);
        for($i=0; $i<count($info[0]); $i++) {
            $wordscut .= $info[0][$i];
            $j = ord($info[0][$i]) > 127 ? $j + 2 : $j + 1;
            if ($j > $length - 3) {
                return $wordscut." ...";
            }
        }
        return join('', $info[0]);
    }
    //获取当前时间戳
    public function _news(){
    	$time=date("Y-m-d 00:00:00");
        $news=strtotime($time);
        $this->assign('news',$news);
    }
    //获取当前时间戳
    public function news(){
    	$time=date("Y-m-d 00:00:00");
        $news=strtotime($time);
        return $news;
    }
    //内容格式化
    public function cont($text)
	{  
	 	$pat     = '#\[em_([0-9]+)\]#';
	 	$bq      = C('bq_url');
        $replace = "<img src='$bq/$1.gif' />";
        
        return preg_replace($pat,$replace,$text);
	    return $text;
	}
	//头像
	public function photo($text){
		$jk      = C('user_photo_url');
		$a       = '/\s+/';
		$avatar  = 'avatar.jpg';
		return $jk.preg_replace($a,'/',chunk_split($text,2)).$avatar;
		return $text;

	}
	//昵称格式化取字符串最后一位
	public function sudtext($text)
	 {
	    return '****'.mb_substr($text, mb_substr($text)-1,1,'utf-8');
	    //return mb_substr($text, 0, $length, 'utf8').'...';
	    return $text;
	 }
	 //添加评论时英文标点和特殊字符的过滤
    public function preg_rep($text){
    	$regex     = "/\/|\~|\!|\@|\#|\\$|\%|\^|\&|\*|\(|\)|\+|\{|\}|\:|\<|\>|\?|\,|\.|\/|\;|\'|\`|\-|\=|\"|\\\|\|/"; 
        return preg_replace($regex, '', $text);    //英文符号过滤  
        return $text;

    }
    //判断访问是pc端还是手机端
    public function is_mobile(){ 
        $user_agent = $_SERVER['HTTP_USER_AGENT']; 
        $mobile_agents = Array("240x320","acer","acoon","acs-","abacho","ahong","airness","alcatel","amoi","android","anywhereyougo.com","applewebkit/525","applewebkit/532","asus","audio","au-mic","avantogo","becker","benq","bilbo","bird","blackberry","blazer","bleu","cdm-","compal","coolpad","danger","dbtel","dopod","elaine","eric","etouch","fly ","fly_","fly-","go.web","goodaccess","gradiente","grundig","haier","hedy","hitachi","htc","huawei","hutchison","inno","ipad","ipaq","ipod","jbrowser","kddi","kgt","kwc","lenovo","lg ","lg2","lg3","lg4","lg5","lg7","lg8","lg9","lg-","lge-","lge9","longcos","maemo","mercator","meridian","micromax","midp","mini","mitsu","mmm","mmp","mobi","mot-","moto","nec-","netfront","newgen","nexian","nf-browser","nintendo","nitro","nokia","nook","novarra","obigo","palm","panasonic","pantech","philips","phone","pg-","playstation","pocket","pt-","qc-","qtek","rover","sagem","sama","samu","sanyo","samsung","sch-","scooter","sec-","sendo","sgh-","sharp","siemens","sie-","softbank","sony","spice","sprint","spv","symbian","tablet","talkabout","tcl-","teleca","telit","tianyu","tim-","toshiba","tsm","up.browser","utec","utstar","verykool","virgin","vk-","voda","voxtel","vx","wap","wellco","wig browser","wii","windows ce","wireless","xda","xde","zte"); 
        $is_mobile = false; 
        foreach ($mobile_agents as $device) { 
            if (stristr($user_agent, $device)) { 
                $is_mobile = true; 
                break; 
            } 
        } 
        return $is_mobile; 
    } 
}