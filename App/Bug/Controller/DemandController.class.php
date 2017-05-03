<?php
namespace Home\Controller;
use Think\Controller;
header('Content-type: text/html; charset=utf-8');
include_once(dirname(__FILE__)."/BaseController.class.php");
class DemandController extends BaseController {
    public function _initialize(){
        parent::_initialize();
        if("" == session('user_id'))
        {
            exit('<script>top.location.href="../Login/index"</script>');
        }
    }
    //需求列表
    public function index(){
        //查询全部还是自己权限
        $dem_id = session('dem_id');
        $map_priority_list = $this->_map_priority_list(); //优先级
        $dem_list       = $this->_demand_mpa(); //完成进度
        
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
        if ($dem_id == 13) {
            $xq_id = $this->demand_mem_xq();
            if ($xq_id == "") {
                $content['where'] = array(
                    '_string' => '`create` = '.session("user_id")
                            .' or `mast_develop` = '.session("user_id")
                            .' or `mast_product` = '.session("user_id")
                            .' or `to_user_id` = '.session("user_id")
                );
            }else{
                $content['where'] = array(
                    '_string' => '`create` = '.session("user_id")
                		    .' or `mast_develop` = '.session("user_id")
                		    .' or `mast_product` = '.session("user_id")
                		    .' or `to_user_id` = '.session("user_id")
                		    .' or id in ('.$xq_id.')'
                );  
            }
            
        }
        
        //搜索
        if (I('get.sub')) {
            //关键字
            $name = I('get.keywords');
            if ("" != $name) {
                $this->assign('name', $name);
                $content['where']['description'] = array('like', '$'.urlencode($name).'$');
                $this->assign('name', $name);
            }
            //项目
            if (0 != I('get.project_id')) {
                $this->assign('proj', I('get.project_id'));
                $content['where']['project_id'] = I('get.project_id');
                $this->assign('proj', I('get.project_id'));
            }
        }
        $result = $this->_call('Demand.get_list',$content);
        if (200 == $result['status_code']) {
            $con = $result['content']['list']; 
            foreach ($con as $key => $rs) {
                $con[$key]['plan_online_ex'] = date('Y-m-d',$rs['plan_online']);
                $con[$key]['last_time'] = date('Y-m-d H:i:s',$rs['last_time']);
                $con[$key]['last_online_ex'] = date('Y-m-d H:i:s',$rs['last_online']);
                $con[$key]['level'] = $map_priority_list[$rs['level']];
                $con[$key]['status'] = $dem_list[$rs['status']];
                $con[$key]['status_ex']  = $rs['status'];
                $con[$key]['stage']  = $rs['stage'];
            } 
            $this->assign('con',$con);
            $record_count = $result['content']['record_count'];
            $this->assign('record_count', $record_count);
            $this->get_page($record_count, $page_size);
        }
        
        $this->_map_mybug();//分类映射
        $this->display();
    }
    //需求添加
    public function add(){
        //表单提交
    	if (I('post.submit')) {
            $this->_login();  //判断登录是否过期
            $number      = I('post.number');
            $description = I('post.description');
            $description = $this->DeleteHtml($description);
            $create      = session('user_id');
            if ($status == 1) {
            	$plan_online = strtotime($plan_online);
            }else {
            	$plan_online = 1;
            }
            $content = array(
                'number'      => urlencode($number),
                'description' => urlencode($description),
                'create'      => $create,
                'status'      => 10,
                'last_person' => $create,
                'last_time'   => time()                      
                );
            $result = $this->_call('Demand.add', $content);
            if (200 == $result['status_code']
                && 0 == $result['content']['is_success']) {
                echo 0;
                exit();
            }else{
                echo -1;
                exit();
            }
        }
        //编号
        $mod = "Demand.get_list";
        $type = "XQ-";
        $this->_number($mod, $type);
        $this->_map_priority_list(); //优先级
    	$this->display();
    }
    //需求修改
    public function edit(){
    	$id = I('get.id');
    	$dem_list = $this->_demand_mpa(); //完成进度
        //修改信息查询
        $content['id'] = $id;
        $result = $this->_call('Demand.get_info',$content);
        if ($result && 200 == $result['status_code']) {
            $enit_list = $result['content'];
            $enit_list['add_time'] = date('Y-m-d H:i',$result['content']['add_time']);
            $enit_list['plan_online_ex'] = date('Y-m-d',$result['content']['plan_online']);
            $enit_list['last_online_ex'] = date('Y-m-d H:i:s',$result['content']['last_online']);
            $enit_list['status_ex']      = $dem_list[$result['content']['status']];
            //$enit_list['to_user_id']     = $result['content']['to_user_id']; 
            //$p_id = $result['content']['project_id'];
            $this->assign('edit_info',$enit_list);
        }
        //受理人查询
        $this->demand_mem($id);
        //项目成员查询
        //$this->project_mem($p_id);
        $this->_map_priority_list(); //优先级
    	$this->display();
    }
    
    //产品主管确认
    public function edit_product()
    {
    	#检查当前用户是否是产品主管
    	
    	$id = I('get.id');
    	$dem_list = $this->_demand_mpa(); //完成进度
    	//修改信息查询
    	$content['id'] = $id;
    	$result = $this->_call('Demand.get_info',$content);
    	if ($result && 200 == $result['status_code']) {
    		$enit_list = $result['content'];
    		$enit_list['add_time'] = date('Y-m-d H:i',$result['content']['add_time']);
    		$enit_list['plan_online_ex'] = date('Y-m-d',$result['content']['plan_online']);
    		$enit_list['last_online_ex'] = date('Y-m-d H:i:s',$result['content']['last_online']);
    		$enit_list['status_ex'] = $dem_list[$result['content']['status']];
    		//$p_id = $result['content']['project_id'];
    		$this->assign('edit_info',$enit_list);
    	}
    	
    	//查询最后一条确认信息
    	unset($content);
    	$content['order'] = array('id'=>'desc');
    	$content['where'] = array(
    		'demand_id'=>$id
    	);
    	$content['page_size'] = 1;
    	$result = $this->_call('Demandproductlog.get_list', $content);
    	$log = array(
    		'result'=>'',
    		'content'=>'',
    		'to_user_id'=>0,
    	);
    	if($result && 200 == $result['status_code'])
    	{
    		if(0< $result['content']['record_count'])
    		{
    			$info = $result['content']['list'][0];
    		    $log['result']     = $info['result']; 
    			$log['content']    = $info['content'];
    			$log['to_user_id'] = $info['to_user_id'];
    		}	
    	}
    	$this->assign('log',$log);
    	#进行操作，并且改变当前阶段
    	
    	#保存历史记录

    	$this->display();
    }
    
    //开发主管确认
    public function edit_develop()
    {
    	#检查当前用户是否是产品主管
    	 
    	#进行操作，并且改变当前阶段
    	$id = I('get.id');
    	$dem_list = $this->_demand_mpa(); //完成进度
    	//修改信息查询
    	$content['id'] = $id;
    	$result = $this->_call('Demand.get_info',$content);
    	if ($result && 200 == $result['status_code']) {
    		$enit_list = $result['content'];
    		$enit_list['add_time'] = date('Y-m-d H:i',$result['content']['add_time']);
    		$enit_list['plan_online_ex'] = date('Y-m-d',$result['content']['plan_online']);
    		$enit_list['last_online_ex'] = date('Y-m-d H:i:s',$result['content']['last_online']);
    		$enit_list['status_ex'] = $dem_list[$result['content']['status']];
    		$this->assign('edit_info',$enit_list);
    	}
    	 
    	//查询最后一条确认信息
    	unset($content);
    	$content['order'] = array('id'=>'desc');
    	$content['where'] = array(
    			'demand_id'=>$id
    	);
    	$content['page_size'] = 1;
    	$result = $this->_call('Demanddeveloplog.get_list', $content);
    	$log = array(
    			'result'=>'',
    			'content'=>'',
    			'to_user_id'=>0,
    	);
    	if($result && 200 == $result['status_code'])
    	{
    		if(0< $result['content']['record_count'])
    		{
    			$info = $result['content']['list'][0];
    			$log['result']     = $info['result'];
    			$log['content']    = $info['content'];
    			$log['to_user_id'] = $info['to_user_id'];
    		}
    	}
    	$this->assign('log',$log);
    	#保存历史记录
    	
    	$this->display();
    }
    
    //需求修改
    public function edit_demand()
    {
    	#检查用户
    	
    	$id = I('get.id');
    	$dem_list = $this->_demand_mpa(); //完成进度
    	//修改信息查询
    	$content['id'] = $id;
    	$result = $this->_call('Demand.get_info',$content);
    	if ($result && 200 == $result['status_code']) {
    		$enit_list = $result['content'];
    		$enit_list['add_time'] = date('Y-m-d H:i',$result['content']['add_time']);
    		$enit_list['plan_online_ex'] = date('Y-m-d',$result['content']['plan_online']);
    		$enit_list['last_online_ex'] = date('Y-m-d H:i:s',$result['content']['last_online']);
    		$enit_list['status_ex'] = $dem_list[$result['content']['status']];
    		//$p_id = $result['content']['project_id'];
    		$this->assign('edit_info',$enit_list);
    	}
    	
    	$this->display();
    }
    
    //反馈信息ajax分页
    public function feedback_ajax(){
    	$id = I('get.id');
    	$content_fk = array();
        $page_index = 1;
        $page_size = 10;
        if(I('get.p'))
        {
            $page_index = I('get.p');
            $content_fk['page_size']  = $page_size;
            $content_fk['page_index'] = $page_index;
        }else{
            $content_fk['page_size']  = $page_size;
            $content_fk['page_index'] = $page_index;
        }
        $content_fk['where'] = array('demand_id' => $id);
        $result_fk = $this->_call('Demandfeedback.get_list', $content_fk);
        if (200 == $result_fk['status_code']) {
            $fk_list = $result_fk['content']['list'];
            foreach ($fk_list as $key => $v) {
                $fk_list[$key]['add_time'] = date('Y-m-d H:i:s',$v['add_time']);
            }
            $this->assign('fk_list',$fk_list);
            $record_count = $result_fk['content']['record_count'];
            $this->assign('record_count', $record_count);
            $this->ajax_page($record_count, $page_size);
        }
    	$this->display();
    }
    //数据打印
    public function export(){
    	$id = I('get.id');
    	$dem_list = $this->_demand_mpa(); //完成进度
        //修改信息查询
        $content['id'] = $id;
        $result = $this->_call('Demand.get_info',$content);
        if ($result && 200 == $result['status_code']) {
            $enit_list = $result['content'];
            $enit_list['add_time'] = date('Y-m-d',$result['content']['add_time']);
            $enit_list['plan_online_ex'] = date('Y-m-d',$result['content']['plan_online']);
            $enit_list['last_online_ex'] = date('Y-m-d H:i:s',$result['content']['last_online']);
            $p_id = $result['content']['project_id'];
            $this->assign('edit_info',$enit_list);
        }
        //受理人查询
        $u_id= $this->demand_mem($id);
        //产品经理
        $u_cpid = implode(',', $u_id[1]);
        $list1 = $this->feedback_ex($id,1,$u_cpid);
        $c_jf = current($list1); //初版交付时间
        $z_jf = end($list1);  //终板交付时间
        $this->assign('c_jf',$c_jf);
        $this->assign('z_jf',$z_jf);
        //ui设计
        $u_uiid = implode(',', $u_id[2]);
        $list2 = $this->feedback_ex($id,2,$u_uiid);
        $uic_jf = current($list2); //初版交付时间
        $uiz_jf = end($list2);  //终板交付时间
        $this->assign('uic_jf',$uic_jf);
        $this->assign('uiz_jf',$uiz_jf);
        //前端
        $u_qdid = implode(',', $u_id[3]);
        $list3 = $this->feedback_ex($id,3,$u_qdid);
        $qdz_jf = end($list3);  //终板交付时间
        $this->assign('qdz_jf',$qdz_jf);
        //开发
        $u_kfid = implode(',', $u_id[4]);
        $list4 = $this->feedback_ex($id,4,$u_kfid);
        $kfz_jf = end($list4);  //终板交付时间
        $this->assign('kfz_jf',$kfz_jf);
        //测试
        $u_csid = implode(',', $u_id[5]);
        $list5 = $this->feedback_ex($id,5,$u_csid);
        $csz_jf = end($list5);  //终板交付时间
        $this->assign('csz_jf',$csz_jf);

    	$this->display();
    }
    //根据需求和用户查询反馈
    public function feedback_ex($id,$position_id,$uu_id){
        $content = array();
        $content['page_size'] = 20;
        $content['where'] = array(
        	'demand_id' => $id,
            'position_id' => $position_id,
        	'user_id'   => array('in', $uu_id)
        );
        $content['order'] = array('id'=>'asc');
        $result = $this->_call('Demandfeedback.get_list', $content);
        if (200 == $result['status_code']) {
            $fk_list = $result['content']['list'];
            foreach ($fk_list as $key => $v) {
                $fk_list[$key]['add_time'] = date('Y-m-d H:i:s',$v['add_time']);
            }
            return $fk_list;
        }
    }
    /*
    *基本详情修改
    */
    public function update_jb(){
    	if (I('post.submit')) {
            $this->_login();  //判断登录是否过期
            $id          = I('post.id');
            $description = I('post.description');
            $description = $this->DeleteHtml($description);
            $level       = I('post.level');
            $project_id  = I('post.project_id');
            $status      = I('post.status');
		    $plan_online = I('post.stage_time');
		    $ytime       = I('post.ytime');
		    $mast_develop= I('post.mast_develop');
		    $mast_product= I('post.mast_product');
		    $slr         = I('post.slr');
            $content['data'] = array(
                'description' => urlencode($description),
                'level'       => $level,
                'project_id'  => $project_id,
                'mast_develop'=> $mast_develop,
                'mast_product'=> $mast_product,
                'status'      => $status,
                'last_person' => session('user_id'),
                'last_time'   => time(),     
                );
            $content['where'] = array('id'=>$id);
            $result = $this->_call('Demand.update', $content);
            if (200 == $result['status_code']
                && 0 == $result['content']['is_success']) {
                $mem_count = $this->demand_mem($id);
                if($mem_count == 0){
                    //项目成员添加
                    foreach ($slr as $k => $v) {
                        foreach ($v as $key => $vl) {
                            $content_mem = array(
                                'demand_id'  => $id,
                                'position_id'=> $k,
                                'user_id'    => $vl
                            );
                            $res_mem = $this->_call('Demandmem.add', $content_mem);
                            if (200 == $res_mem['status_code']
                                && -1 == $res_mem['content']['is_success']) {
                                echo -1;
                                exit();
                            }
                        }
                    }
                    echo 0;
                    exit();
                }else{
                    $res_mdl = $this->_call("Demandmem.delete",array('demand_id'=>$id));
                    if(200 == $res_mdl['status_code']
                    && 0 == $res_mdl['content']['is_success']){
                    	//项目成员添加
    	                foreach ($slr as $k => $v) {
    	                	foreach ($v as $key => $vl) {
    	                		$content_mem = array(
    				    			'demand_id'  => $id,
    				    			'position_id'=> $k,
    				    			'user_id'    => $vl
    			    			);
    				    		$res_mem = $this->_call('Demandmem.add', $content_mem);
    				    		if (200 == $res_mem['status_code']
    		            			&& -1 == $res_mem['content']['is_success']) {
    				    			echo -1;
    				    		    exit();
    				    		}
    	                	}
    				    }
    	                echo 0;
    	                exit();
                    }
                }
            }else{
                echo -1;
                exit();
            }
        }
    }
    //反馈添加
    public function feedback(){ 
    	if (I('post.submit')) {
    		$dem_list = $this->_demand_mpa(); //完成进度

    		$demand_id   = I('post.demand_id');
    		$position_id = I('post.position_id');
    		$user_id     = session('user_id');
    		$delay       = I('post.delay');
    		$ycyy        = I('post.ycyy');
    		$cont = $dem_list[$position_id]."：新版交付时间：";
    		//判断功能测试
    		if ($position_id == 5) {
    			if ($delay == 1) {
	    			$cont = $dem_list[$position_id]."，是否延迟：否，新版交付时间：";
	    		}else{
	    			$cont = $dem_list[$position_id]."，是否延迟：是，延迟原因：".$ycyy."，新版交付时间：";
	    		}
    		}
    		//获取当前用户是否是受理人
    		$count = $this->demand_mem_ex($demand_id,$position_id);
            //判断受理人权限
    		if ($count == 0) {
    			echo -5;
    			exit();
    		}
    		//反馈添加
    		$content = array(
    			'demand_id' => $demand_id,
                'position_id' => $position_id,
    			'user_id'   => $user_id,
    			'content'   => urlencode($cont)
    			);
    		$result = $this->_call('Demandfeedback.add', $content);
    		//修改需求进度
    		$con = array();
    		$con['data'] = array(
    			'status'      => $position_id,
    			'last_person' => $user_id,
    			'last_time'   => time() 
    			);
    		$con['where']['id'] = $demand_id;
    		$res = $this->_call('Demand.update',$con);
    		if (200 == $result['status_code'] && 0 == $result['content']['is_success'] 
            && 200 == $res['status_code'] && 0 == $res['content']['is_success']) {
	            echo 0;
	            exit();
	        }else{
	            echo -1;
	            exit();
	        }
    	}
    }
    //上线确认
    public function feedback_qr(){
		$dem_list = $this->_demand_mpa(); //完成进度

		$demand_id   = I('post.demand_id');
		$position_id = I('post.position_id');
		$zg_name     = I('post.zg_name');
		$mast_develop= I('post.mast_develop'); //开发主管
		$mast_product= I('post.mast_product'); //产品主管
		$user_id     = session('user_id');
		$cont = $dem_list[$position_id]."：".$zg_name."同意上线，时间：";
        //判断产品主管和开发主管是否都存在
        if($mast_develop != 0 && $mast_product != 0){
    		if ($zg_name == "开发主管") {
    			//查询产品主管确认是否确认
    			$mast_zg_qr = $this->director_qr($demand_id,$mast_product);
    		}
    		if ($zg_name == "产品主管") {
    			//查询产品主管确认是否确认
    			$mast_zg_qr = $this->director_qr($demand_id,$mast_develop);
    		}
    		if ($mast_zg_qr > 0) {
    			//修改需求进度
        		$con = array();
        		$con['data'] = array(
        			'status'      => 7,
        			'last_person' => $user_id,
        			'last_time'   => time(),
        			'last_online' => time()
        			);
        		$con['where']['id'] = $demand_id;
        		$res = $this->_call('Demand.update',$con);
    		}else{
    			//修改需求进度
        		$con = array();
        		$con['data'] = array(
        			'status'      => $position_id,
        			'last_person' => $user_id,
        			'last_time'   => time()
        			);
        		$con['where']['id'] = $demand_id;
        		$res = $this->_call('Demand.update',$con);
    		}
	    }else{
            //修改需求进度
            $con = array();
            $con['data'] = array(
                'status'      => 7,
                'last_person' => $user_id,
                'last_time'   => time(),
                'last_online' => time()
                );
            $con['where']['id'] = $demand_id;
            $res = $this->_call('Demand.update',$con);
        }
		//反馈添加
		$content = array(
			'demand_id' => $demand_id,
            'position_id' => $position_id,
			'user_id'   => $user_id,
			'content'   => urlencode($cont)
			);
		$result = $this->_call('Demandfeedback.add', $content);
		if (200 == $result['status_code'] && 0 == $result['content']['is_success'] 
        && 200 == $res['status_code'] && 0 == $res['content']['is_success']) {
            echo 0;
            exit();
        }else{
            echo -1;
            exit();
        }
    }
    public function director_qr($demand_id,$user_id){
    	//成员
        $content = array();
        $content['page_size']  = 20;
        $content['where'] = array(
        	'demand_id' => $demand_id,
        	'user_id'     => $user_id
        	);
        //成员
        $result_mem = $this->_call('Demandfeedback.get_list',$content);
        if ($result_mem && 200 == $result_mem['status_code']) {
            $count = $result_mem['content']['record_count'];
            return $count;
        }
    }
    //查询成员是否存在
    public function demand_mem_ex($demand_id,$position_id){
        //成员
        $cont = array();
        $cont['page_size']  = 20;
        $cont['where'] = array(
        	'demand_id' => $demand_id,
        	'position_id' => $position_id,
        	'user_id'     => session('user_id')
        	);
        //成员
        $result_mem = $this->_call('Demandmem.get_list',$cont);
        if ($result_mem && 200 == $result_mem['status_code']) {
            $count = $result_mem['content']['record_count'];
            return $count;
        }
    } 
    //项目成员查询
    // public function project_mem($id){
    //     //用户名称
    //     $u_name = $this->grtmap();
    //     $u_name = $u_name['admin'];
    //     //成员和模块信息
    //     $cont = array();
    //     $cont['page_size']  = 20;
    //     $cont['where'] = array('project_id' => $id);
    //     //成员
    //     $result_mem = $this->_call('Projectmem.get_list',$cont);
    //     if ($result_mem && 200 == $result_mem['status_code']) {
    //         $mem_list = $result_mem['content']['list'];
    //         foreach($mem_list as $value)
    //         {
    //             $m_list[$value['admin_id']] = $u_name[$value['admin_id']]; 
    //         }
    //         $this->assign('m_list',$m_list);
    //     }
    // }
    //受理人成员查询
    public function demand_mem($id){
        //用户名称
        $u_name = $this->grtmap();
        $u_name = $u_name['admin'];
        //成员和模块信息
        $cont = array();
        $cont['page_size']  = 20;
        $cont['where'] = array('demand_id' => $id);
        //成员
        $result_mem = $this->_call('Demandmem.get_list',$cont);
        if ($result_mem && 200 == $result_mem['status_code']) {
            $mem_list = $result_mem['content']['list'];
            foreach($mem_list as $value)
            {
                $d_list[$value['position_id']][$value['user_id']] = $u_name[$value['user_id']];
                $dd_list[$value['position_id']][$value['user_id']] = $value['user_id'];
            }
            $this->assign('d_list',$d_list);
            return $dd_list;
        }
    } 
    
    #需求修改历史记录
    public function demand_log_ajax()
    {
    	$demand_id = I('get.demand_id');
    	$content_fk = array();
        $page_index = 1;
        $page_size = 10;
        if(I('get.p'))
        {
            $page_index = I('get.p');
            $content_fk['page_size']  = $page_size;
            $content_fk['page_index'] = $page_index;
        }else{
            $content_fk['page_size']  = $page_size;
            $content_fk['page_index'] = $page_index;
        }
        $content_fk['where'] = array('demand_id' => $demand_id);
        $result_fk = $this->_call('Demandlog.get_list', $content_fk);
        if (200 == $result_fk['status_code']) {
            $fk_list = $result_fk['content']['list'];
            foreach ($fk_list as $key => $v) {
                $fk_list[$key]['add_time'] = date('Y-m-d H:i:s',$v['add_time']);
            }
            $this->assign('fk_list',$fk_list);
            $record_count = $result_fk['content']['record_count'];
            $this->assign('record_count', $record_count);
            $this->ajax_page($record_count, $page_size);
        }
    	$this->display();
    }
    
    #产品主管确认记录
    public function product_log_ajax()
    {
    	$demand_id = I('get.demand_id');
    	$content_fk = array();
    	$page_index = 1;
    	$page_size = 10;
    	if(I('get.p'))
    	{
    		$page_index = I('get.p');
    		$content_fk['page_size']  = $page_size;
    		$content_fk['page_index'] = $page_index;
    	}else{
    		$content_fk['page_size']  = $page_size;
    		$content_fk['page_index'] = $page_index;
    	}
    	$content_fk['where'] = array('demand_id' => $demand_id);
    	$result_fk = $this->_call('Demandproductlog.get_list', $content_fk);
    	if (200 == $result_fk['status_code']) {
    		$fk_list = $result_fk['content']['list'];
    		foreach ($fk_list as $key => $v) {
    			$fk_list[$key]['add_time'] = date('Y-m-d H:i:s',$v['add_time']);
    		}
    		$this->assign('fk_list',$fk_list);
    		$record_count = $result_fk['content']['record_count'];
    		$this->assign('record_count', $record_count);
    		$this->ajax_page($record_count, $page_size);
    	}
    	$this->display();
    }
    
    #开发主管确认记录
    public function develop_log_ajax()
    {
    	$demand_id = I('get.demand_id');
    	$content_fk = array();
    	$page_index = 1;
    	$page_size = 10;
    	if(I('get.p'))
    	{
    		$page_index = I('get.p');
    		$content_fk['page_size']  = $page_size;
    		$content_fk['page_index'] = $page_index;
    	}else{
    		$content_fk['page_size']  = $page_size;
    		$content_fk['page_index'] = $page_index;
    	}
    	$content_fk['where'] = array('demand_id' => $demand_id);
    	$result_fk = $this->_call('Demanddeveloplog.get_list', $content_fk);
    	if (200 == $result_fk['status_code']) {
    		$fk_list = $result_fk['content']['list'];
    		foreach ($fk_list as $key => $v) {
    			$fk_list[$key]['add_time'] = date('Y-m-d H:i:s',$v['add_time']);    
    			if(1< $v['plan_online_time'])
    			{
    				$fk_list[$key]['plan_online_time'] = date('Y-m-d',$v['plan_online_time']);
    			}			
    		}
    		$this->assign('fk_list',$fk_list);
    		$record_count = $result_fk['content']['record_count'];
    		$this->assign('record_count', $record_count);
    		$this->ajax_page($record_count, $page_size);
    	}
    	$this->display();
    }
    
    #保存需求修改
    public function update_demand()
    {
    	if (I('post.submit')) {
    		$this->_login();  //判断登录是否过期
    		$id          = I('post.id');
    		$description = I('post.description');
    		$description = $this->DeleteHtml($description);
    		$old_description = I('post.old_description');
    		$old_description =$this->DeleteHtml($old_description);
    		
    		if ($status == 1) {
    			if ($plan_online == "") {
    				$plan_online = strtotime($ytime);
    			}else {
    				$plan_online = strtotime($plan_online);
    			}
    		}else {
    			$plan_online = 1;
    		}
    		$content['data'] = array(
    				'description' => urlencode($description),
    				'status'=>10,
    				'last_person' => session('user_id'),
    				'last_time'   => time(),
    		);
    		$content['where'] = array('id'=>$id);
    		$result = $this->_call('Demand.update', $content);
    		if (200 == $result['status_code']
    		&& 0 == $result['content']['is_success']) {
    			#新增历史记录
    			unset($content);
    			$content = array(
    				'demand_id' => $id,
    				'user_id'   => session('user_id'),
    				'content'   => urlencode($old_description),
    			);
    			$res_mdl = $this->_call("Demandlog.add", $content);
    			if(200 == $res_mdl['status_code']
    			&& 0 == $res_mdl['content']['is_success']){
    				echo 0;
    				exit();
    			}
    		}else{
    			echo -1;
    			exit();
    		}
    	}
    }
    
    #保存产品主管修改
    public function update_demand_product()
    {
    	if (I('post.submit')) {
    		$this->_login();  //判断登录是否过期
    		$id          = I('post.id');
    		$result      = I('post.result');
    		$content     = I('post.content');
    		$to_user_id  = I('post.to_user_id');
            $to_user_id  = intval($to_user_id);
    	
    		if ($status == 1) {
    			if ($plan_online == "") {
    				$plan_online = strtotime($ytime);
    			}else {
    				$plan_online = strtotime($plan_online);
    			}
    		}else {
    			$plan_online = 1;
    		}
    		$content = array(
    				'demand_id'    => $id,
    				'result'       => $result,
    				'content'       => urlencode($content),
    				'to_user_id'   => $to_user_id,
    				'user_id'      => session('user_id'),
    		);
    		$tmp_result = $result;
    		$result = $this->_call('Demandproductlog.add', $content);
    		if (200 == $result['status_code']
    		&& 0 == $result['content']['is_success']) {
    				if(2 == intval($tmp_result))
    				{
    					if(isset($content))unset($content);

    					$content = array(
    						'where'=>array('id'=>$id),
    						'data'=>array(
                                'stage'=>2,
                                'to_user_id'=>$to_user_id,
                                'last_person' => session('user_id'),
                                'last_time'   => time(),
                                'status'=>12
                                ),
    					);
    					$res = $this->_call('Demand.update', $content);
    					if(200 == $res['status_code']
    					&& 0 == $res['content']['is_success'])
    					{
    						echo 0;
    						exit();
    					}
    					else
    					{
    						echo -2;
    						exit();
    					}
    				}
    				else if(1 == intval($tmp_result)){
    					if(isset($content))unset($content);
    					
    					$content = array(
    							'where'=>array('id'=>$id),
    							'data'=>array(
                                    'stage'=>1,
                                    'to_user_id'=>$to_user_id,
                                    'last_person' => session('user_id'),
                                    'last_time'   => time(),
                                    'status'=>11
                                    ),
    					);
    					$res = $this->_call('Demand.update', $content);
    					if(200 == $res['status_code']
    					&& 0 == $res['content']['is_success'])
    					{
    						echo 0;
    						exit();
    					}
    					else
    					{
    						echo -3;
    						exit();
    					}
    				}
    		}else{
    			echo -1;
    			exit();
    		}
    	}
    }
    
    #保存开发主管修改
    public function update_demand_develop()
    {
    	if (I('post.submit')) {
    		$this->_login();  //判断登录是否过期
    		$id          	   = I('post.id');
    		$result      	   = I('post.result');
    		$content           = I('post.content');    		
    		$plan_online_time  = strtotime(I('post.plan_online'));
            if ($result == 2) {
                if('' == I('post.plan_online')){
                    $plan_online_time = 1;
                }
            }else{
                $plan_online_time = 0;
            }
    		$content = array(
    				'demand_id'          => $id,
    				'result'             => $result,
    				'content'            => urlencode($content),
    				'plan_online_time'   => $plan_online_time,
    				'user_id'            => session('user_id'),
    		);
    		$tmp_result = $result;
    		$result = $this->_call('Demanddeveloplog.add', $content);
    		if (200 == $result['status_code']
    		&& 0 == $result['content']['is_success']) {
    			if(1 == $tmp_result)
    			{
    					if(isset($content))unset($content);

    					$content = array(
    						'where'=>array('id'=>$id),
    						'data'=>array(
                                'stage'=>2,
                                'plan_online'=>$plan_online_time,
                                'last_person' => session('user_id'),
                                'last_time'   => time(),
                                'status'=>13),
    					);
    					$res = $this->_call('Demand.update', $content);
    					if(200 == $res['status_code']
    					&& 0 == $res['content']['is_success'])
    					{
    						echo 0;
    						exit();
    					}
    					else
    					{
    						echo -2;
    						exit();
    					}
    			}
    			else if(2 == $tmp_result)
    			{
    				if(isset($content))unset($content);
    				
    				$content = array(
    						'where'=>array('id'=>$id),
    						'data'=>array(
                                'stage'=>3,
                                'plan_online'=>$plan_online_time,
                                'last_person' => session('user_id'),
                                'last_time'   => time(),
                                'status'=>14),
    				);
    				$res = $this->_call('Demand.update', $content);
    				if(200 == $res['status_code']
    				&& 0 == $res['content']['is_success'])
    				{
    					echo 0;
    					exit();
    				}
    				else
    				{
    					echo -2;
    					exit();
    				}
    			}	
    				
    		}else{
    			echo -1;
    			exit();
    		}
    	}	
    }
    
}