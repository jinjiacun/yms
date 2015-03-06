<?php
namespace Soadmin\Controller;
use Think\Controller;
include_once(dirname(__FILE__).'/BaseController.class.php');
/**
 *企业管理
*/
class CompanyController extends BaseController {
     public function _initialize()
    {
	parent::_initialize();
	if(null == session('admin_name')
	|| ''   == session('admin_name'))
	{
	    $this->redirect('/Soadmin/Login/index');
	}
    }
    public function add()
    {
        if(I('post.submit'))
        {
            //check name 
            $content = array(
                'company_name' => urlencode(I('post.company_name'))
            );
            $result = $this->_call('Company.exists_name', $content);
            if($result
            && 200 == $result['status_code']
            && 0 == $result['content']['is_exists']
            )
            {
                $this->error("企业名称已存在");
                exit();
            }

            $content = array(
                        'logo'            => $this->upload('logo','001008'),
                        'nature'          => I('post.nature'),
        		'trade'           => I('post.trade'),
        		'company_name'    => urlencode(I('post.company_name')),
        		'auth_level'      => I('post.auth_level'),
        		'reg_address'     => urlencode(I('post.reg_address')),
        		'busin_license'   => $this->upload('busin_license','001003'),
                        'control_busin_license' => ''==I('post.control_busin_license')?0:1,
        		'code_certificate'=> $this->upload('code_certificate','001004'),
                        'control_code_certificate' => ''==I('post.control_code_certificate')?0:1,
        		'telephone'       => I('post.telephone'),
        		'website'         => I('post.website'),
        		'record'          => urlencode(I('post.record')),
                        'regulators_id'   => I('post.regulators_id'),
        		'find_website'    => I('post.find_website'),
                        'agent_platform'  => I('post.agent_platform'),
                        'mem_sn'          => urlencode(I('post.mem_sn')),
                        'certificate'     => $this->upload('certificate','001005'),
                        'control_certificate'=>'' == I('post.control_certificate')?0:1,
            );
            $result = $this->_call("Company.add",
                                   $content);
            if($result
            && 200 == $result['status_code']
            && 0 == $result['content']['is_success'])
            {
                $company_id = $result['content']['id'];
                //添加别名
                if('' !=  trim(I('post.company_alias')))
                {
                    $company_alias_list = array();
                    $company_alias = trim(I('post.company_alias'));
                    $company_alias = str_replace('，',',', $company_alias);
                    $company_alias_list = explode(',', $company_alias);
                    if($company_alias_list
                    && 0<count($company_alias_list))
                    {
                        foreach($company_alias_list as $v)
                        {
                            if(isset($content)) unset($content);
                            $content = array(
                                'name'       =>urlencode($v),
                                'company_id' => $company_id
                            );
                            $s_result = $this->_call("Companyalias.add", $content);
                            if($s_result
                            && 200 == $s_result['status_code']
                            && -1 == $s_result['content']['is_success'])
                            {
                                //$this->success("别名:($v)添加错误");
                                $this->echo_message(-1,"别名:($v)添加错误");
                                exit();
                            }
                        }
                    }
                }                
                //$this->success('成功添加',C('Template_pre')."Company/get_list", 3);
                $this->echo_message(0,'成功添加',C('Template_pre')."Company/get_list");    
                exit();
            }
            else{
                $this->echo_message(-2,'添加失败');    
                exit();
            }
        }
         
        //平台
        $this->assign('agent_flatform_list', $this->_map_company(2));
        $this->assign('regulators_list', $this->_map_regulators());
        $this->_map_trade_list();
        $this->display();   
    }
    
    public function add_ex()
    {
        $company_id = I('get.id');
        $this->assign('company_id', $company_id);
        if(I('post.submit'))
        {
             //check name 
            $content = array(
                'name' => urlencode(I('post.name'))
            );
            $result = $this->_call('Companyalias.exists_name', $content);
            if($result
            && 200 == $result['status_code']
            && 0 == $result['content']['is_exists']
            )
            {
                $this->error("企业别名已存在");
            }
            
        	$company_id = I('post.company_id');
            $content = array(
                'company_id' =>I('post.company_id'),
                'name'=>urlencode(I('post.name')),
            );
            
            $result = $this->_call("Companyalias.add",
                                   $content);
            if($result
            && 200 == $result['status_code']
            && 0 == $result['content']['is_success'])
            {
                $this->success(‘添加成功’, C('Template_pre')."Company/get_list_ex/id/".$company_id);
                exit();
            }
        }
        
        $company_list = $this->_map_company();
        $this->assign('company_list', $company_list);
        $this->display();
    }
    
    public function edit()
    {
        $id = intval(I('get.id'));
        if(I('post.submit'))
        {
        	#检查企业名称是否存在
        	//check name
        	$content = array(
        			'id'=>I('post.id'),
        			'company_name' => urlencode(I('post.company_name'))
        	);
        	$result = $this->_call('Company.exists_name_ex', $content);
        	if($result
        			&& 200 == $result['status_code']
        			&& 0 == $result['content']['is_exists']
        	)
        	{
        		//$this->error("企业名称已存在");
                        $this->echo_message(-100,"企业名称已存在");
                        exit();
        	}
        	 
        	
            $content = array(
                'where'=>array(
                    'id'=>I('post.id'),
                ),    
                'data' => array(                  
                    'nature'          => I('post.nature'),
                    'trade'           => I('post.trade'),
                    'company_name'    => urlencode(I('post.company_name')),
                    'auth_level'      => I('post.auth_level'),
                    'reg_address'     => urlencode(I('post.reg_address')),
                    'control_busin_license' => '' == I('post.control_busin_license')?0:1,
                    'control_code_certificate' => '' == I('post.control_code_certificate')?0:1,
                    'telephone'       => I('post.telephone'),
                    'website'         => urlencode(I('post.website')),
                    'record'          => urlencode(I('post.record')),
                    'regulators_id'   => I('post.regulators_id'),
                    'find_website'    => I('post.find_website'),
                    'agent_platform'  => I('post.agent_platform'),
                    'mem_sn'          => urlencode(I('post.mem_sn')),
                    'control_certificate'=> '' == I('post.certificate')?0:1,
                )
            );
            if($logo = $this->upload('logo','001008'))
            {
                 $content['data']['logo']   =  $logo;
            }
            if($busin_license = $this->upload('busin_license','001003'))
            {
                $content['data']['busin_license'] = $busin_license;
            }
            if($code_certificate = $this->upload('code_certificate','001004'))
            {
                $content['data']['code_certificate'] = $code_certificate;
            }
            if($certificate = $this->upload('certificate','001005'))
            {
                $content['data']['certificate'] = $certificate;
            }
            
            $result = $this->_call("Company.update",
                                    $content);
            if($result
            &&  200 == $result['status_code']
            &&  0  == $result['content']['is_success']
            )
            {
                 //修改别名
                if('' !=  trim(I('post.company_alias')))
                {
                    $company_id = I('post.id');
                    $this->_call('Companyalias.delete',array('company_id'=>$company_id));
                    //删除别名
                    
                    $company_alias_list = array();
                    $company_alias = trim(I('post.company_alias'));
                    $company_alias = str_replace('，',',', $company_alias);
                    $company_alias_list = explode(',', $company_alias);
                    if($company_alias_list
                    && 0<count($company_alias_list))
                    {
                        foreach($company_alias_list as $v)
                        {
                            if(isset($content)) unset($content);
                            $content = array(
                                'name'       =>urlencode($v),
                                'company_id' => $company_id
                            );
                            $s_result = $this->_call("Companyalias.add", $content);
                            if($s_result
                            && 200 == $s_result['status_code']
                            && -1 == $s_result['content']['is_success'])
                            {
                                //$this->error("别名:($v)添加错误");
                                $this->echo_message(-1, "别名:($v)添加错误");
                                exit();
                            }
                        }
                    }
                }
               
                $this->echo_message(0,'成功保存', C('Template_pre')."Company/get_list");
                exit();   
            }
        }
        
        $content = array(
            'id'=> $id,
        );
        $result = $this->_call('Company.get_info',
                               $content);
        if($result
        && 200 == $result['status_code'])
        {
            $this->assign('obj', $result['content']);
        }
        
        $this->_map_trade_list();
        $this->assign('agent_platform_list', $this->_map_company(2));
        $this->assign('regulators_list', $this->_map_regulators());
        //查询企业别名
        $result = $this->_call('Companyalias.get_list',array('where'=>array('company_id'=>$id)));
        if($result
        && 200 == $result['status_code'])
        {
            $tmp_list = array();
            $tmp = $result['content']['list'];
            if($tmp
            && 0<count($tmp))
            {
                foreach($tmp as $v)
                {
                    $tmp_list[] = $v['name'];
                }
                unset($tmp, $v);
            }
            $this->assign('company_alias', trim(implode(',', $tmp_list)));
        }
        
        $this->_map_trade_list();
        $this->display();
    }
    
    public function get_list()
    {
         $page_index = 1;
        $page_size  = 10;
        $content    = array();
        if(I('get.p'))
        {
            $page_index = I('get.p');
            $content['page_size'] = $page_size;
            $content['page_index'] = $page_index;
        }
        
         //匹狼删除请求
        if(I('get.del_mul'))
        {
            $this->del_mul();
            exit();
        }
        
        if(I('get.submit'))
        {   
            $company_name = I('get.company_name');
            if('' != $company_name)
            {
                $this->assign('company_name', $company_name);
                $content['where']['company_name'] = array('like', '%'.urlencode($company_name).'%');
                $this->assign('company_name', $company_name);
            }
            if(0 != I('get.nature'))
            {
                $this->assign('nature', I('get.nature'));
                $content['where']['nature'] = I('get.nature');
                $this->assign('nature', I('get.nature'));
            }
            if(0 != I('get.trade'))
            {
                $this->assign('trade', I('get.trade'));
                $content['where']['trade'] = I('get.trade');
                $this->assign('trade', I('get.trade'));
            }
            if(0 != I('get.auth_level'))
            {
            	$this->assign('auth_level', I('get.auth_level'));
            	$content['where']['auth_level'] = I('get.auth_level');
            	$this->assign('auth_level', I('get.auth_level'));
            }
        }
        $res = A('Callapi')->call_api('Company.get_list', 
                                    $content,
                                    'text',
                                  null);
        $result = $this->deal_re_call_api($res);

        $list = array();
        if($result)
        {
            if(200 == $result['status_code'])
            {
                if(isset($result['content']['list'])
                && isset($result['content']['record_count']))
                {
                    $list   = $result['content']['list'];   
                    $this->assign('list', $list);     
                    $record_count = $result['content']['record_count'];
                    $this->assign('record_count', $record_count);
                    $this->get_page($record_count, 10);
                }
            }
        }
        
        
        $this->_map_trade_list();
        $this->display();
    }
    
    //批量删除企业
    private function del_mul()
    {
        $id_list = I('post.id');
        if(0<count($id_list))
        {
            foreach($id_list as $id)
            {
                $result = $this->_call("Company.delete",array('id'=>$id));
                if($result
                && 200 == $result['status_code']
                && 0 == $result['content']['is_success']
                )
                {}
                else
                {
                    $this->echo_message(-1,"删除失败");
                    exit();
                }
            }
        }
        $this->echo_message(0,"成功删除",C('Template_pre')."Company/get_list");
    }
    
    public function get_list_ex()
    {
        $company_id = I('get.id');
        $this->assign('company_id', $company_id);
        $page_index = 1;
        $page_size  = 10;
        $content    = array();
        if(I('get.p'))
        {
            $page_index = I('get.p');
            $content['page_size'] = $page_size;
            $content['page_index'] = $page_index;
        }
        $content['where']['company_id'] = $company_id;
        $res = A('Callapi')->call_api('Companyalias.get_list', 
                                    $content,
                                    'text',
                                  null);
        $result = $this->deal_re_call_api($res);

        $list = array();
        if($result)
        {
            if(200 == $result['status_code'])
            {
                if(isset($result['content']['list'])
                && isset($result['content']['record_count']))
                {
                    $list   = $result['content']['list'];   
                    $this->assign('list', $list);     
                    $record_count = $result['content']['record_count'];
                    $this->assign('record_count', $record_count);
                    $this->get_page($record_count, 10);
                }
            }
        }
        
        $this->display();
    }
    
    public function delete()
    {
        $id = I('get.id');
        if(0>= $id)
        {
            //$this->error("参数错误");
            $this->echo_message(-100,"参数错误");
            exit();
        }   
          
        $result = $this->_call("Company.delete",array('id'=>$id));    
       if($result
       && 200 == $result['status_code']
       && 0 == $result['content']['is_success']
       )
       {
            //$this->success("成功操作", C('Template_pre')."Company/get_list", 3);
            $this->echo_message(0,"成功操作", C('Template_pre')."Company/get_list");
            exit();
        }
        else
        {
            $this->echo_message(-1,"删除失败");
            exit();
        }
    }
    
    
    //删除企业别名
    public function delete_ex()
    {
        $id = I('get.id');
        if(0>= $id)
            $this->error("参数错误");
            
        $content = array(
            'id'=> $id
        );
        $result = $this->_call('Companyalias.delete',
                               $content);
        if($result
        && 200 == $result['status_code']
        && 0   == $result['content']['is_success'])
        {
            $this->success("成功操作", C('Template_pre')."Company/get_list_ex/id".$id, 3);
        }
    }
}  
