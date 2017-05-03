<?php
namespace Home\Controller;
use Think\Controller;
header('Content-type: text/html; charset=utf-8');
include_once(dirname(__FILE__)."/BaseController.class.php");
class ResumeController extends BaseController {
    public function _initialize(){
        parent::_initialize();
        if("" == session('user_id'))
        {
            exit('<script>top.location.href="../Login/index"</script>');
        }
    }
	//简历列表查询
    public function index(){
        //查询全部还是自己权限
        $res_id = session('res_id');
        //简历进度map
        $jl_schedule = $this->_schedule_map();
	    $page_index = 1;
        $page_size  = 20;
        $content = array();
        if(I('get.p'))
        {
            $page_index = I('get.p');
            $content['page_size']  = $page_size;
            $content['page_index'] = $page_index;
        }else{
            $content['page_size']  = $page_size;
            $content['page_index'] = $page_index;
        }
        if ($res_id == 10) {
            $content['where'] = array('part_id'=>session('part_id'));
        }
        //搜索
        if (I('get.sub')) {
            $name = I('get.keywords');
            if ("" != $name) {
                $this->assign('name', $name);
                $content['where']['candidates'] = array('like', '$'.urlencode($name).'$');
                $this->assign('name', $name);
            }
            if (0 != I('get.stage')) {
                $this->assign('stage', I('get.stage'));
                if(I('get.stage') == 6){
                    $dq_time = time();
                    $content['where'] = array(
                        'stage'  => I('get.stage'), 
                        '_logic' => 'or',
                        '_complex' => array(
                            'stage' => 5,
                            'stage_time' => array('ELT',$dq_time)
                            )
                        );
                }else{
                    $content['where']['stage'] = I('get.stage');
                }
                $this->assign('stage', I('get.stage'));
            }
            if (0 != I('get.part_id')) {
                $this->assign('part', I('get.part_id'));
                $content['where']['part_id'] = I('get.part_id');
                $this->assign('part', I('get.part_id'));
            }
            if (0 != I('get.position_id')) {
                $this->assign('position_id', I('get.position_id'));
                $content['where']['position_id'] = I('get.position_id');
                $this->assign('position_id', I('get.position_id'));
            }
        }
    	$result = $this->_call('Resume.get_list',$content);
    	if (200 == $result['status_code']) {
    		$con = $result['content']['list'];
            foreach ($con as $key => $rs) {
                $con[$key]['accessories'] = $this->url_xz($rs['accessories']);
                $con[$key]['accessoriess'] = $this->_resume_map($rs['accessories']);                
                $con[$key]['last_time'] = date('Y-m-d H:i:s',$rs['last_time']);
                $con[$key]['last_time_ex'] = date('Y-m-d',$rs['last_time']);
                $con[$key]['stage_time_ex'] = date('Y-m-d H:i:s',$rs['stage_time']);
                $con[$key]['stage']     = $jl_schedule[$rs['stage']];
            }  
            $this->assign('list',$con);
            $record_count = $result['content']['record_count'];
            $this->assign('record_count', $record_count);
            $this->get_page($record_count, $page_size);
    	}
        $this->source_map();//简历来源
	    $this->display();
    }
    public function url_xz($id){
        $content = array('doc_id'=>$id);
        $result = $this->_call('Media.get_swf_by_doc',$content);
        if (200 == $result['status_code'] && 0 == $result['content']['is_success']) {
            $url = $result['content']['url'];
            return $url;
        }
    }
    /*
    *简历添加
    */
    // public function add(){
    //     if (I('post.submit')) {
    //         $number      = I('post.number');
    //         $candidates  = I('post.candidates');
    //         $telephone   = I('post.telephone');
    //         $position_id = I('post.position_id');
    //         $part_id     = I('post.part_id');
    //         $accessories = $_FILES['accessories']['tmp_name'];
    //         $remartk     = I('post.remartk');
    //         $remartk     = $this->DeleteHtml($remartk);
    //         $create      = session('user_id');

    //         //判断简历是否上传
    //         if (!empty($accessories)) {
    //             $fp  = fopen($accessories, "rb");
    //             $fpp = $_FILES['accessories']['size'];
    //             $filename = $_FILES['accessories']['name'];
    //             $file_ext = pathinfo($filename, PATHINFO_EXTENSION);//获取后缀
    //             if ($fpp > 204800) {
    //                 echo 4;
    //                 exit();
    //             }
    //             $buf = fread($fp,$fpp);
    //             fclose($fp);
    //             $content = array(
    //                         'file_name'=>"jl",  #文件名称
    //                         'buf'      =>$buf,       #要上传的二进制数据
    //                         'file_ext' =>$file_ext,  #文件后缀
    //                         'module_sn'=>'011001',   #简历
    //                         );
    //             $result = $this->_call('Media.upload',$content,'resource',$fp);
    //             if($result)
    //             {
    //                 if(200 == $result['status_code'])
    //                 {
    //                     if(0 == $result['content']['is_success']){
    //                         $accessories_ex = $result['content']['id'];
    //                     }else if (-1 == $result['content']['is_success']) {
    //                         echo 1;
    //                         exit();
    //                     }else if (-2 == $result['content']['is_success']) {
    //                         echo 2;
    //                         exit();
    //                     }else if (-3 == $result['content']['is_success']) {
    //                         echo 3;
    //                         exit();
    //                     }else if (-4 == $result['content']['is_success']) {
    //                         echo 4;
    //                         exit();
    //                     }else if (-5 == $result['content']['is_success']) {
    //                         echo 5;
    //                         exit();
    //                     }
    //                 }else{
    //                     echo 2;
    //                     exit();
    //                 }
    //             }
    //         }else{
    //             echo 6;
    //             exit();
    //         }
    //         $content = array(
    //             'number'      => urlencode($number),
    //             'candidates'  => urlencode($candidates),
    //             'telephone'   => urlencode($telephone),
    //             'position_id' => $position_id,
    //             'part_id'     => $part_id,
    //             'accessories' => $accessories_ex,
    //             'remartk'     => urlencode($remartk),
    //             'create'      => $create
    //             );  
    //         $result = $this->_call('Resume.add',$content);
    //         if(200 == $result['status_code'] 
    //             && 0 == $result['content']['is_success']){
    //             echo 0;
    //             exit();
    //         }else{
    //             echo -1;
    //             exit();
    //         }
    //     }
    //     $this->position_map();  //岗位map
    //     //编号
    //     $mod = "Resume.get_list";
    //     $type = "JL-";
    //     $this->_number($mod, $type);

    //     $this->display();
    // }
    //新增简历
    public function add_jl(){
        if (I('post.submit')) {
            //解压文件所保存的目录
            $dir = "D:\jl_zip";
            if (file_exists($dir) == true) {
                //清空解压文件
                $this->deldir($dir);
            }
            //创建解压目录
            mkdir($dir);            
            //编号参数
            $mod = "Resume.get_list";
            $type = "JL-";
            //接受表单值
            $number      = $this->_number($mod, $type);
            $part_id     = I('post.part_id');
            $accessories = $_FILES['accessories'];
            $remartk     = I('post.remartk');
            $remartk     = $this->DeleteHtml($remartk);
            $create      = session('user_id');
            $title       = $_FILES['accessories']['name'];
            if ($accessories['size'] > 20*1024*1024) {
                echo -2;
                exit();
            }
            $media_jl = array();
            //需要压缩的文件[夹]路径
            $file = $accessories['tmp_name'];
            //获取文件类型
            $type_wj = pathinfo($title, PATHINFO_EXTENSION);
            //判断文件类型
            if($type_wj == "zip" || $type_wj == "rar" || $type_wj == "ZIP" || $type_wj == "RAR"){
                if($type_wj == "zip" || $type_wj == "ZIP"){
                    //解压zip文件
                    $this->unzip_file($file,$dir); 
                }else{
                    //解压rar文件
                    $this->unrar($file,$dir);
                }
                //获取解压后的文件
                $array_file = $this->loopFun($dir);
                $wj_count = count($array_file);
                //判断上传文件个数，上传文件不能多于10个
                if ($wj_count > 10) {
                    //清空解压文件
                    $this->deldir($dir);
                    echo 8;
                    exit();
                }
                //文件上传提交
                if (!empty($array_file)) {
                    foreach ($array_file as $k => $v) {
                        $fp  = fopen($v, "rb");
                        $fpp = filesize($v);
                        $filename = basename($v);
                        $file_ext = pathinfo($filename, PATHINFO_EXTENSION);//获取后缀
                        if ($fpp > 2*1024*1024) {
                            echo 4;
                            exit();
                        }
                        $buf = fread($fp,$fpp);
                        fclose($fp);
                        $content = array(
                                    'file_name'=>"jl",  #文件名称
                                    'buf'      =>$buf,       #要上传的二进制数据
                                    'file_ext' =>$file_ext,  #文件后缀
                                    'module_sn'=>'011001',   #简历
                                    );
                        $result = $this->_call('Media.upload',$content,'resource',$fp);
                        if($result){
                            if(200 == $result['status_code'])
                            {
                                if(0 == $result['content']['is_success']){
                                    $accessories_ex[] = $result['content']['id'];
                                    $media_jl = array_merge($media_jl,$accessories_ex);
                                    unset($accessories_ex);
                                }else if (-1 == $result['content']['is_success']) {
                                    echo 1;
                                    exit();
                                }else if (-2 == $result['content']['is_success']) {
                                    echo 2;
                                    exit();
                                }else if (-3 == $result['content']['is_success']) {
                                    echo 3;
                                    exit();
                                }else if (-5 == $result['content']['is_success']) {
                                    echo 5;
                                    exit();
                                }
                            }else{
                                echo 2;
                                exit();
                            }
                        }
                    }
                }else{
                    echo 7;
                    exit();
                }
                //清空解压文件
                $this->deldir($dir);
                if (!empty($media_jl)) {
                    foreach ($media_jl as $key => $value) {
                        $content = array(
                            'number'      => urlencode($number),
                            'title'       => urlencode(substr($title,0,strrpos($title, '.'))),
                            'part_id'     => $part_id,
                            'accessories' => $value,
                            'remartk'     => urlencode($remartk),
                            'create'      => $create,
                            'last'        => $create,
                            'last_time'   => time()
                            );  
                        $result = $this->_call('Resume.add',$content);
                        if(200 == $result['status_code'] 
                            && -1 == $result['content']['is_success']){
                            echo -1;
                            exit();
                        }
                        $number = $this->_number($mod, $type);
                    }
                    echo 0;
                    exit();
                } 
            }else {
                //判断简历是否上传
                if (!empty($file)) {
                    $fp  = fopen($file, "rb");
                    $fpp = $_FILES['accessories']['size'];
                    $filename = $_FILES['accessories']['name'];
                    $file_ext = pathinfo($filename, PATHINFO_EXTENSION);//获取后缀
                    if ($fpp > 2*1024*1024) {
                        echo 4;
                        exit();
                    }
                    $buf = fread($fp,$fpp);
                    fclose($fp);
                    $content = array(
                                'file_name'=>"jl",  #文件名称
                                'buf'      =>$buf,       #要上传的二进制数据
                                'file_ext' =>$file_ext,  #文件后缀
                                'module_sn'=>'011001',   #简历
                                );
                    $result = $this->_call('Media.upload',$content,'resource',$fp);
                    if($result)
                    {
                        if(200 == $result['status_code'])
                        {
                            if(0 == $result['content']['is_success']){
                                $accessories_ex = $result['content']['id'];
                            }else if (-1 == $result['content']['is_success']) {
                                echo 1;
                                exit();
                            }else if (-2 == $result['content']['is_success']) {
                                echo 2;
                                exit();
                            }else if (-3 == $result['content']['is_success']) {
                                echo 3;
                                exit();
                            }else if (-5 == $result['content']['is_success']) {
                                echo 5;
                                exit();
                            }
                        }else{
                            echo 2;
                            exit();
                        }
                    }
                }else{
                    echo 6;
                    exit();
                }
                $content = array(
                    'number'      => urlencode($number),
                    'title'       => urlencode(substr($title,0,strrpos($title, '.'))),
                    'part_id'     => $part_id,
                    'accessories' => $accessories_ex,
                    'remartk'     => urlencode($remartk),
                    'create'      => $create,
                    'last'        => $create,
                    'last_time'   => time()
                    );  
                $result = $this->_call('Resume.add',$content);
                if(200 == $result['status_code'] 
                    && 0 == $result['content']['is_success']){
                    echo 0;
                    exit();
                }else{
                    echo -1;
                    exit();
                } 
            }           
        }
        $this->position_map();  //岗位map
        $this->display();
    }
    //简历来源添加
    public function source(){
        $id = I('get.id');
        //修改信息查询
        $content['id'] = $id;
        $result = $this->_call('Resume.get_info',$content);
        if ($result && 200 == $result['status_code']) {
            $edit_list = $result['content'];
            $this->assign('edit_list',$edit_list);
        }
        $this->source_map();//简历来源列表
        $this->display();
    }
    //修改简历来源
    public function so_updata(){
        if (I('post.submit')) {
            $id        = I('post.id');
            $source_id = I('post.source_id');
            $last      = session('user_id');
            $last_time = time();

            $content['data'] = array(
                'source_id' => $source_id,
                'last'      => $last,
                'last_time' => $last_time
            );
            $content['where']['id'] = $id;
            $result = $this->_call('Resume.update',$content);
            if(200 == $result['status_code'] 
                && 0 == $result['content']['is_success']){
                echo 0;
                exit();
            }else{
                echo -1;
                exit();
            }
        }
    }
    //简历来源添加
    public function so_add(){
        if (I('post.submit_ex')) {
            $so_list = $this->source_map();//简历来源列表
            $sourceid = I('post.sourceid');
            $sourceid_ex = I('post.sourceid_ex');          
            //已有模块的删除修改
            foreach ($so_list as $k => $v) {
                if (isset($sourceid[$k])) {
                    //存在的修改
                    $cont_mod['data']  = array('name' => urlencode($sourceid[$k]));
                    $cont_mod['where'] = array('id' => $k);
                    $result_mod = $this->_call('Resumesource.update',$cont_mod);
                    if(200 == $result_mod['status_code'] 
                        && -1 == $result_mod['content']['is_success']){
                        echo -1;
                        exit();
                    }
                }else{
                    //不存在的删除
                    $content_mod['id'] = $k;
                    $res_mod = $this->_call("Resumesource.delete", $content_mod);
                    if (200 == $res_mod['status_code']
                        && -1 == $res_mod['content']['is_success']) {
                        echo -1;
                        exit();
                    }
                }
            }        
            //添加新加模块
            if (!empty($sourceid_ex)) {
                foreach ($sourceid_ex as $v) {
                    $content_modd = array(
                        'name'       => urlencode($v)
                        );
                    $res_modd = $this->_call('Resumesource.add', $content_modd);
                    if (200 == $res_modd['status_code']
                        && -1 == $res_modd['content']['is_success']) {
                        echo -1;
                        exit();
                    }
                }
            }
            echo 0;
            exit();
        }
    }
    /*
    *简历修改
    */
    public function edit(){
        $id = I('get.id');
        //修改提交
        if (I('post.submit')) {
            $id = I('post.id');
            $title       = I('post.title');
            $candidates  = I('post.candidates');
            $telephone   = I('post.telephone');
            $position_id = I('post.position_id');
            $part_id     = I('post.part_id');
            $source_id   = I('post.source_id');
            $stage       = I('post.stage');
            $stage_time  = strtotime(I('post.stage_time'));
            $stage_times = I('post.stage_times');
            $accessories = $_FILES['accessories']['tmp_name'];
            $remartk     = I('post.remartk');
            $remartk     = $this->DeleteHtml($remartk);
            $create      = session('user_id');
            if ($stage_time == "") {
                $stage_time = $stage_times;
            }
            //判断简历是否上传
            if (!empty($accessories)) {
                $fp  = fopen($accessories, "rb");
                $fpp = $_FILES['accessories']['size'];
                $filename = $_FILES['accessories']['name'];
                $file_ext = pathinfo($filename, PATHINFO_EXTENSION);//获取后缀
                if ($fpp > 204800) {
                    echo 4;
                    exit();
                }
                $buf = fread($fp,$fpp);
                fclose($fp);
                $content = array(
                            'file_name'=>"jl",  #文件名称
                            'buf'      =>$buf,       #要上传的二进制数据
                            'file_ext' =>$file_ext,  #文件后缀
                            'module_sn'=>'011001',   #简历
                            );
                $result = $this->_call('Media.upload',$content,'resource',$fp);
                if($result)
                {
                    if(200 == $result['status_code'])
                    {
                        if(0 == $result['content']['is_success']){
                            $accessories_ex = $result['content']['id'];
                        }else if (-1 == $result['content']['is_success']) {
                            echo 1;
                            exit();
                        }else if (-2 == $result['content']['is_success']) {
                            echo 2;
                            exit();
                        }else if (-3 == $result['content']['is_success']) {
                            echo 3;
                            exit();
                        }else if (-4 == $result['content']['is_success']) {
                            echo 4;
                            exit();
                        }else if (-5 == $result['content']['is_success']) {
                            echo 5;
                            exit();
                        }
                    }else{
                        echo 2;
                        exit();
                    }
                }
            }
            if(!empty($accessories) && $stage == 5) {
                $content['data'] = array(
                    'title'       => urlencode($title),
                    'candidates'  => urlencode($candidates),
                    'telephone'   => urlencode($telephone),
                    'position_id' => $position_id,
                    'part_id'     => $part_id,
                    'source_id'   => $source_id,
                    'stage'       => $stage,
                    'last'        => $create,
                    'last_time'   => time(),                
                    'remartk'     => urlencode($remartk),
                    'create'      => $create,
                    'accessories' => $accessories_ex,
                    'stage_time'  => $stage_time
                );  
            }else if(!empty($accessories) && $stage != 5) {
                $content['data'] = array(
                    'title'       => urlencode($title),
                    'candidates'  => urlencode($candidates),
                    'telephone'   => urlencode($telephone),
                    'position_id' => $position_id,
                    'part_id'     => $part_id,
                    'source_id'   => $source_id,
                    'stage'       => $stage,
                    'last'        => $create,
                    'last_time'   => time(),                
                    'remartk'     => urlencode($remartk),
                    'create'      => $create,
                    'accessories' => $accessories_ex,
                );  
            }else if(empty($accessories) && $stage == 5) {
                $content['data'] = array(
                    'title'       => urlencode($title),
                    'candidates'  => urlencode($candidates),
                    'telephone'   => urlencode($telephone),
                    'position_id' => $position_id,
                    'part_id'     => $part_id,
                    'source_id'   => $source_id,
                    'stage'       => $stage,
                    'last'        => $create,
                    'last_time'   => time(),                
                    'remartk'     => urlencode($remartk),
                    'create'      => $create,
                    'stage_time'  => $stage_time
                );  
            }else {
                $content['data'] = array(
                    'title'       => urlencode($title),
                    'candidates'  => urlencode($candidates),
                    'telephone'   => urlencode($telephone),
                    'position_id' => $position_id,
                    'part_id'     => $part_id,
                    'source_id'   => $source_id,
                    'stage'       => $stage,
                    'last'        => $create,
                    'last_time'   => time(),                
                    'remartk'     => urlencode($remartk),
                    'create'      => $create,
                );  
            }     
            $content['where'] = array('id'=>$id);
            $result = $this->_call('Resume.update',$content);
            if(200 == $result['status_code'] 
                && 0 == $result['content']['is_success']){
                echo 0;
                exit();
            }else{
                echo -1;
                exit();
            }
        }
        //修改信息查询
        $content['id'] = $id;
        $result = $this->_call('Resume.get_info',$content);
        if ($result && 200 == $result['status_code']) {
            $edit_list = $result['content'];
            $edit_list['accessoriess']  = $this->_resume_map($result['content']['accessories']);
            $edit_list['accessories']   = $this->url_xz($result['content']['accessories']);
            $edit_list['stage_time_ex'] = date('Y-m-d H:i:s',$result['content']['stage_time']);
            $this->assign('edit_list',$edit_list);
        }
        $this->_schedule_map();  //简历进度
        $this->source_map();//简历来源列表
        $this->position_map();  //岗位map
        $this->display();
    }
    //批量删除简历
    public function batch_delete(){
        $id_list = I('post.id');
        $item = explode(',', $id_list);
        if(0<count($item))
        {
            foreach($item as $id)
            {
                $result = $this->_call("Resume.delete",array('id'=>$id));
                if($result && 200 == $result['status_code']
                && 0 == $result['content']['is_success']
                ){
                }else
                {
                    echo -1;
                    exit();
                }
            }
            
        }
    }
    //进度修改
    public function schedule(){
        $id = I('get.id');
        //修改提交
        if (I('post.submit')) {
            $id = I('post.id');
            //$status      = I('post.status');
            $stage       = I('post.stage');
            $stage_time  = strtotime(I('post.stage_time'));
            $last        = session('user_id');
            $last_time   = time();
            
            if ($stage == 5) {
                $content['data'] = array(
                    'stage'     => $stage,
                    'stage_time'=> $stage_time,
                    'last'      => $last,
                    'last_time' => $last_time
                ); 
            }else{
                $content['data'] = array(
                    'stage'     => $stage,
                    'last'      => $last,
                    'last_time' => $last_time
                );
            }            
            $content['where'] = array('id'=>$id);
            $result = $this->_call('Resume.update',$content);
            if(200 == $result['status_code'] 
                && 0 == $result['content']['is_success']){
                echo 0;
                exit();
            }else{
                echo -1;
                exit();
            }
        }
        //修改信息查询
        $content['id'] = $id;
        $result = $this->_call('Resume.get_info',$content);
        if ($result && 200 == $result['status_code']) {
            $edit_list = $result['content'];
            $edit_list['stage_time_ex'] = date('Y-m-d H:i:s',$result['content']['stage_time']);
            $this->assign('edit_list',$edit_list);
        }
        $this->_schedule_map();  //简历进度
        $this->display();
    }
    //岗位map
    public function position_map(){
        $content['page_size'] = 20;
        $content['where']['status'] = 0;
        $result = $this->_call('Positionhr.get_list',$content);
        if (200 == $result['status_code']) {
            $con = $result['content']['list']; 
            foreach($con as $value){
                $xm_list[$value['id']] = $value['name'];
            }
            $this->assign('pos_list',$xm_list);
        }
    }
    //简历下载url查询
    public function _resume_map($id){
        $content['media_id'] = $id;
        $result = $this->_call('Media.get_by_id', $content);
        if (200 == $result['status_code']) {
            $list['http_url'] = $result['content']['http_url'];
        }
        return $list;
    }
    //简历来源map
    public function source_map(){
        $content['page_size'] = 20;
        $result = $this->_call('Resumesource.get_list',$content);
        if (200 == $result['status_code']) {
            $con = $result['content']['list']; 
            foreach($con as $value){
                $so_list[$value['id']] = $value['name'];
            }
            $this->assign('so_list',$so_list);
            return $so_list;
        }
    }
    /*********************************简历统计****************************************/
    public function statistics(){
        if (I('post.subb')) {
            $this->assign('q_time', $q_time);
            $q_time = I('post.q_time');
            $this->assign('q_time', $q_time);
            $q_times = strtotime($q_time.' 01:00:00');
            $this->assign('t_time', $t_time);
            $t_time = I('post.t_time');
            $this->assign('t_time', $t_time);
            $t_times = strtotime($t_time.' 23:00:00');
        } 
        //按状态统计
        $ztt_count = array();
        $zbb_count = array();
        $stage = 'stage';
        $jl_list = $this->_schedule_map();
        //按部门统计
        $bmsh_count = array();
        $bmzb_count = array();
        $part_id = 'part_id';
        //部门列表查询
        $part_list = $this->grtmap();
        $part_list = $part_list['part'];
        //按来源统计
        $lysh_count = array();
        $lyzb_count = array();
        $source_id = 'source_id';
        //部门列表查询
        $sourece_list = $this->source_map();//简历来源map
        //判断是否按时间搜索
        if ($q_time != "" || $t_time != "") {          
            
            //按状态统计遍历
            foreach ($jl_list as $k => $v) {
                $zt_count = $this->resume_count_time($k,$stage,$q_times,$t_times);
                $ztt_count = array_merge($ztt_count,$zt_count[0]);
                $zbb_count = array_merge($zbb_count,$zt_count[1]);
            }           
            //按部门统计遍历
            foreach ($part_list as $k => $v) {
                $bm_count = $this->resume_count_time($k,$part_id,$q_times,$t_times);
                $bmsh_count = array_merge($bmsh_count,$bm_count[0]);
                $bmzb_count = array_merge($bmzb_count,$bm_count[1]);
            }            
            //按来源统计遍历
            foreach ($sourece_list as $k => $v) {
                $ly_count = $this->resume_count_time($k,$source_id,$q_times,$t_times);
                $lysh_count = array_merge($lysh_count,$ly_count[0]);
                $lyzb_count = array_merge($lyzb_count,$ly_count[1]);
            }
        }else {
            //按状态统计遍历
            foreach ($jl_list as $k => $v) {
                $zt_count = $this->resume_count_ex($k,$stage);
                $ztt_count = array_merge($ztt_count,$zt_count[0]);
                $zbb_count = array_merge($zbb_count,$zt_count[1]);
            }           
            //按部门统计遍历
            foreach ($part_list as $k => $v) {
                $bm_count = $this->resume_count_ex($k,$part_id);
                $bmsh_count = array_merge($bmsh_count,$bm_count[0]);
                $bmzb_count = array_merge($bmzb_count,$bm_count[1]);
            }            
            //按来源统计遍历
            foreach ($sourece_list as $k => $v) {
                $ly_count = $this->resume_count_ex($k,$source_id);
                $lysh_count = array_merge($lysh_count,$ly_count[0]);
                $lyzb_count = array_merge($lyzb_count,$ly_count[1]);
            }
        }
        //按状态统计输出模板
        // if($d = (100 - array_sum($zbb_count))) 
        //     $zbb_count[rand(0, count($zbb_count)-1)] += $d;
        $this->assign('ztt_count',$ztt_count);
        $this->assign('zbb_count',$zbb_count);
        //按部门统计输出模板
        $this->assign('bmsh_count',$bmsh_count);
        $this->assign('bmzb_count',$bmzb_count);
        //按来源统计输出模板
        $this->assign('lysh_count',$lysh_count);
        $this->assign('lyzb_count',$lyzb_count);

        $this->display();
    }
    //根据不同的条件查询不同的简历数
    public function resume_count_ex($id,$term){
        $record_count = $this->resume_count();
        $content['where'][$term] = $id;      
        $result = $this->_call('Resume.get_list',$content);
        if (200 == $result['status_code']) {
            $re_countt  = $result['content']['record_count'];
            $re_count[] = $re_countt;
            $zb_connt[] = round(($re_countt/$record_count)*100,2).'%';  
        }
        return array($re_count,$zb_connt);
    }
    //根据不同的条件查询不同的简历数---时间筛选
    public function resume_count_time($id,$term,$q_times,$t_times){
        $record_count = $this->resume_count_time_ex($q_times,$t_times);
        $content['where'] = array(
                'add_time' => array(array('EGT',$q_times),array('ELT',$t_times))
            );
        $content['where'][$term] = $id;       
        $result = $this->_call('Resume.get_list',$content);
        if (200 == $result['status_code']) {
            $re_countt  = $result['content']['record_count'];
            $re_count[] = $re_countt;
            $zb_connt[] = round(($re_countt/$record_count)*100,2).'%'; 
        }
        return array($re_count,$zb_connt);
    }
    //简历总数
    public function resume_count(){
        $result = $this->_call('Resume.get_list',$content);
        if (200 == $result['status_code']) {
            $record_count = $result['content']['record_count'];
            $this->assign('jl_count',$record_count);
            return $record_count;
        }
    }
    //简历总数---时间筛选
    public function resume_count_time_ex($q_times,$t_times){
        $content['where'] = array(
                'add_time' => array(array('EGT',$q_times),array('ELT',$t_times))
            );
        $result = $this->_call('Resume.get_list',$content);
        if (200 == $result['status_code']) {
            $record_count = $result['content']['record_count'];
            $this->assign('jl_count',$record_count);
            return $record_count;
        }
    }
    //简历预览
    public function false(){
        $url = I('get.url');
        $this->assign('url',$url);
        $this->display();
    }
}