<?php
namespace Home\Controller;
use Think\Controller;
use com;
use ZipArchive;
class BaseController extends Controller
{
	public function _initialize()
	{
		$this->assign('call_url',C('call_url'));
		$this->assign('user_id', session('user_id')); //用户id
		$this->assign('role_id', session('role_id')); //角色id
		$this->assign('part_id', session('part_id')); //部门id
		//快捷映射管理
        if(S("get_map")){
            $result = S("get_map");            
        }else{
            $result = $this->_call('Map.get_map',$content);
            S("get_map",$result);
        } 
        if (200 == $result['status_code']) {
        	$u_map = $result['content'];
            $admin_name = $result['content']['admin'];
            natcasesort($admin_name);
            $project_name = $result['content']['project'];
            $this->utf8_array_asort($project_name);
            $u_map['admin'] = $admin_name;
            $u_map['project'] = $project_name;
            $this->assign('u_map',$u_map);
            $this->assign('u_map_json',json_encode($u_map));
        }
	}
    //中文排序
    function utf8_array_asort(&$array) {
        if(!isset($array) || !is_array($array)) {
          return false;
        }
        foreach($array as $k=>$v) {
          $array[$k] = iconv('UTF-8', 'GB2312',$v);
        }
        asort($array);
        foreach($array as $k=>$v) {
          $array[$k] = iconv('GB2312', 'UTF-8', $v);
        }
        return true;
    }
	//解析接口调用返回处理
	protected function deal_re_call_api($res)
	{
		try
		{
			$result_array = json_decode(trim($res,chr(239).chr(187).chr(191)), true);
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
	public function ajax_page($record_count, $page_size)
	{
		#页数
        $this->assign('page_count', $page_count);
        $Page = new \Think\PageAjax($record_count, $page_size);// 实例化分页类 传入总记录数和每页显示的记录数(25)
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
	//快捷映射管理
	public function grtmap(){
		$result = $this->_call('Map.get_map',$content);
        if (200 == $result['status_code']) {
        	$u_map = $result['content'];
        	return $u_map;
        }
	}
	//编号	
	public function _number($mod, $type){
		//编号
        $content['page_size']  = 1;
        $result = $this->_call($mod,$content);
        if (200 == $result['status_code']) {
            $con = $result['content']['list'][0]['id']+1; 
            $number = $type.sprintf("%06d", $con);
            $this->assign('number',$number);
            return $number;
        }
	}
	/*
    *项目名称查询
    */
    // public function project_map(){
    //     $content['page_size']  = 20;
    //     $result = $this->_call('Project.get_list',$content);
    //     if (200 == $result['status_code']) {
    //         $con = $result['content']['list']; 
    //         foreach($con as $value){
    //             $xm_list[$value['id']] = $value['name'];
    //         }
    //         $this->assign('xm_list',$xm_list);
    //         return $xm_list;
    //     }
    // }
    //查询自己对应的需求
    public function demand_mem_xq(){
    	$page_index = 1;
        $page_size_fc  = 20;
        $content = array();
        $content['page_index'] = $page_index;
        $content['page_size']  = $page_index;
        $r_count = $this->demand_xq($content);
        $r_count = $r_count[1];
        $tu_count = ceil($r_count/$page_size_fc);
        if ($tu_count >= 1) {
            $content['page_index'] = 1;
            $content['page_size']  = $page_size_fc;
            $count1 = $this->demand_xq($content);
            $count1 = $count1[0];
        }
        if ($tu_count >= 2) {
            $content['page_index'] = 2;
            $content['page_size']  = $page_size_fc;
            $count2 = $this->demand_xq($content);
            $count2 = $count2[0];
        }
        if ($tu_count >= 3) {
            $content['page_index'] = 3;
            $content['page_size']  = $page_size_fc;
            $count3 = $this->demand_xq($content);
            $count3 = $count3[0];
        }
        if (!empty($count1) && !empty($count2) && !empty($count3)) {
            $con = array_merge($count1, $count2, $count3);
        }elseif (!empty($count1) && !empty($count2)) {
            $con = array_merge($count1, $count2);
        }elseif (!empty($count1)) {
            $con = $count1;
        }
        return implode(',', $con);
    }
    //需求查询
    public function demand_xq(){
    	$user_id = session('user_id');
        $content['where'] = array('user_id' => $user_id);
        $result = $this->_call('Demandmem.get_list',$content);
        if ($result && 200 == $result['status_code']) {
            $res = $result['content']['list'];
            foreach($res as $value)
            {
                $xm_list[] = $value['demand_id']; 
            }
            $record_count = $result['content']['record_count'];
            return array($xm_list,$record_count);
        }
    }
    //查询自己对应的项目
    public function project_mem_xm()
    {
    	$page_index = 1;
        $page_size_fc  = 20;
        $content = array();
        $content['page_index'] = $page_index;
        $content['page_size']  = $page_index;
        $r_count = $this->project_xm($content);
        $r_count = $r_count[1];
        $tu_count = ceil($r_count/$page_size_fc);
        if ($tu_count >= 1) {
            $content['page_index'] = 1;
            $content['page_size']  = $page_size_fc;
            $count1 = $this->project_xm($content);
            $count1 = $count1[0];
        }
        if ($tu_count >= 2) {
            $content['page_index'] = 2;
            $content['page_size']  = $page_size_fc;
            $count2 = $this->project_xm($content);
            $count2 = $count2[0];
        }
        if ($tu_count >= 3) {
            $content['page_index'] = 3;
            $content['page_size']  = $page_size_fc;
            $count3 = $this->project_xm($content);
            $count3 = $count3[0];
        }
        if (!empty($count1) && !empty($count2) && !empty($count3)) {
            $con = array_merge($count1, $count2, $count3);
        }elseif (!empty($count1) && !empty($count2)) {
            $con = array_merge($count1, $count2);
        }elseif (!empty($count1)) {
            $con = $count1;
        }
        return implode(',', $con);

        // $admin_id = session('user_id');
        // $content['page_size'] = 20;
        // $content['where'] = array('admin_id' => $admin_id);
        // $result = $this->_call('Projectmem.get_list',$content);
        // if ($result && 200 == $result['status_code']) {
        //     $result = $result['content']['list'];
        //     foreach($result as $value)
        //     {
        //         $xm_list[] = $value['project_id']; 
        //     }
        //     print_r($xm_list);
        //     return implode(',', $xm_list);
        // }
        //成员
    }
    //项目查询
    public function project_xm($content){
    	$admin_id = session('user_id');
        $content['where'] = array('admin_id' => $admin_id);
        $result = $this->_call('Projectmem.get_list',$content);
        if ($result && 200 == $result['status_code']) {
            $res = $result['content']['list'];
            foreach($res as $value)
            {
                $xm_list[] = $value['project_id']; 
            }
            $record_count = $result['content']['record_count'];
            return array($xm_list,$record_count);
        }
    }
    //查询单个员工信息
    public function ugetinfo($id){
    	$content['id'] = $id;
        $result = $this->_call('Admin.get_info',$content);
        if ($result && 200 == $result['status_code']) {
            $edit_list = $result['content'];
            $upart = $result['content']['part'];
            $this->assign('edit_list',$edit_list);
            return $upart;
        }
    }
	//用户信息查询
    public function user_wap(){
        $content['page_size']  = 20;
        $result = $this->_call('Admin.get_list',$content);
        if (200 == $result['status_code']) {
            $con = $result['content']['list'];
            foreach($con as $value)
            {
              $u_list[$value['position']][$value['id']] = $value['admin_name'];
              $uu_list[$value['id']] = $value['admin_name'];
            }
            $this->assign('u_list',$u_list);
            return $uu_list;
        } 
    }
	//问题优先级
	public function _map_priority_list()
	{
		$_map =  array(
			'1'=>'超高',
			'2'=>'高',
			'3'=>'一般',
		);
		$this->assign('priority_list', $_map);
		return $_map;
	}
	
	//问题状态
	public function _map_state_list()
	{
		$_map =  array(
            '-1'=>'待观察',
			'1'=>'待解决',
			'2'=>'已解决',
			'3'=>'已关闭',
            '4'=>'不修改',
            '5'=>'暂缓',

		);
		$this->assign('state_list', $_map);
		return $_map;
	}
	//与我相关的问题
	public function _map_mybug(){
		$_map = array(
			'1'=>'指派给我的',
			'2'=>'我提交的',
			'3'=>'我相关的',
		);
	        if($_SESSION['user_id'] == 1){
			$_map['4'] = '提交人';
                }
		$this->assign('mybug', $_map);
	}
	//简历进度
	public function _schedule_map(){
		$_map = array(
			'1'=>'未筛选',
            '2'=>'待预约',
			'3'=>'打不通',
			'4'=>'无意向',
			'5'=>'预约成功',
			'6'=>'未到面',
			'7'=>'已到面',
            '8'=>'已删除',
		);
		$this->assign('jl_list', $_map);
		return $_map;
	}
	//需求完成进度
	public function _demand_mpa(){
		$_map = array(
			'1'=>'新需求确认',
			'2'=>'UI设计',
			'3'=>'HTML处理',
			'4'=>'新需求开发',
			'5'=>'功能测试',
			'6'=>'上线确认',
			'7'=>'已上线',
				
			'10'=>'新需求提交',
            '11'=>'产品部暂缓',
			'12'=>'产品部通过',
            '13'=>'开发部暂缓',
			'14'=>'开发部通过',
			'15'=>'任务派发',
		);
		return $_map;
	}
	//登录用户信息保存
	public function _login()
	{   
		$user_id = session('user_id');
        if("" == $user_id){
            echo 100;
            exit();
        }
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
	 //添加评论时英文标点和特殊字符的过滤
    public function preg_rep($text){
    	$regex = "/\/|\~|\!|\@|\#|\\$|\%|\^|\&|\*|\(|\)|\+|\{|\}|\:|\<|\>|\?|\,|\.|\/|\;|\'|\`|\-|\=|\"|\\\|\|/"; 
        return preg_replace($regex, '', $text);    //英文符号过滤  
        return $text;

    }
    public function DeleteHtml($str){ 
		$str = trim($str); //清除字符串两边的空格
		$str = preg_replace("/\t/","",$str); //使用<a href="/list-10/" target="_blank">正则表达式</a>替换内容，如：空格，换行，并将替换为空。
		$str = preg_replace("/\r\n/","",$str); 
		$str = preg_replace("/\r/","",$str); 
		$str = preg_replace("/\n/","",$str); 
		$str = preg_replace("/ /","",$str);
		$str = preg_replace("/  /","",$str);  //匹配html中的空格
		return trim($str); //返回字符串
	}
    /**
    * 解压zip文件
    */
    public function unzip_file($file, $dir){ 
        // 实例化对象 
        $zip = new ZipArchive() ; 
        //打开zip文档，如果打开失败返回提示信息 
        if ($zip->open($file) !== TRUE) { 
          die ("Could not open archive"); 
        } 
        //将压缩文件解压到指定的目录下 
        $zip->extractTo($dir); 
        //关闭zip文档 
        $zip->close();  
    } 
    /**
    *解压rar文件
    **/ 
    public function unrar($file,$dir){
        $obj = new com("wscript.shell");
        if($obj){
            $obj->run('winrar x '.$file.' '.$dir, 0, true);
            return true;
        }else{
            return false;
        }
        $obj->Quit(); 
        $obj->Release(); 
        $obj = null; 
    }
    //获取解压文件
    public function loopFun($dir)  
    {  
        $handle = opendir($dir.".");
        //定义用于存储文件名的数组
        $array_file = array();
        while (false !== ($file = readdir($handle)))
        {
            if ($file != "." && $file != "..") {
                $array_file[] = $dir.'/'.$file; //输出文件名
            }
        }
        closedir($handle);
        return $array_file;
    }
    //清除解压文件
    // function deldir($dir) {
    //     //先删除目录下的文件：
    //     $dh = opendir($dir);
    //     while ($file=readdir($dh)) {
    //         if($file!="." && $file!="..") {
    //             $fullpath = $dir."/".$file;
    //             if(!is_dir($fullpath)) {
    //                 //unlink($fullpath);
    //                 var_dump(1);
    //                 @unlink(iconv("UTF-8","gbk",$fullpath));
    //             }else{
    //                 deldir($fullpath);
    //             }
    //         }
    //     }
    //     closedir($dh);
    //     //删除当前文件夹：
    //     if(rmdir($dir)) {
    //         return true;
    //     } else {
    //         return false;
    //     }
    // }
    function deldir($dir){
        exec('rd /s /q '.$dir);
    }
}
