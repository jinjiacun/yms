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
            }

            $content = array(
                'logo'            => $this->upload('logo','001008'),
                'nature'          => I('post.nature'),
        		'trade'           => I('post.trade'),
        		'company_name'    => urlencode(I('post.company_name')),
        		'auth_level'      => I('post.auth_level'),
        		'company_type'    => urlencode(I('post.company_type')),
        		'reg_address'     => urlencode(I('post.reg_address')),
        		'busin_license'   => $this->upload('busin_license','001003'),
        		'code_certificate'=> $this->upload('code_certificate','001004'),
        		'telephone'       => I('post.telephone'),
        		'website'         => I('post.website'),
        		'record'          => I('post.record'),
        		'find_website'    => I('post.find_website'),
                'agent_platform'  => urlencode(I('post.agent_platform')),
                'mem_sn'          => urlencode(I('post.mem_sn')),
                'certificate'     => $this->upload('certificate','001008'),
            );
            $result = $this->_call("Company.add",
                                   $content);
            if($result
            && 200 == $result['status_code']
            && 0 == $result['is_success'])
            {
                $this->success('成功添加',C('Template_pre')."Company/get_list", 3);
            }
        }
            
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
        		$this->error("企业名称已存在");
        	}
        	 
        	
            $content = array(
                'where'=>array(
                    'id'=>I('post.id'),
                ),    
                'data' => array(
                    'logo'            => $this->upload('logo','001008'),
                    'nature'          => I('post.nature'),
                    'trade'           => I('post.trade'),
                    'company_name'    => urlencode(I('post.company_name')),
                    'auth_level'      => I('post.auth_level'),
                    'company_type'    => urlencode(I('post.company_type')),
                    'reg_address'     => urlencode(I('post.reg_address')),
                    'busin_license'   => $this->upload('busin_license','001003'),
                    'code_certificate'=> $this->upload('code_certificate','001004'),
                    'telephone'       => I('post.telephone'),
                    'website'         => I('post.website'),
                    'record'          => I('post.record'),
                    'find_website'    => I('post.find_website'),
                    'agent_platform'  => urlencode(I('post.agent_platform')),
                    'mem_sn'          => urlencode(I('post.mem_sn')),
                    'certificate'     => $this->upload('certificate','001008'),                
                )
            );
            $result = $this->_call("Company.update",
                                    $content);
            if($result
            &&  200 == $result['status_code']
            &&  0  == $result['content']['is_success']
            )
            {
                $this->success("成功保存",C('Template_pre')."Company/get_list", 3);
                
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
        if(I('post.submit'))
        {
            $company_name = I('post.company_name');
            if('' != $company_name)
            {
                $this->assign('company_name', $company_name);
                $content['where']['company_name'] = array('like', '%'.urlencode($company_name).'%');
                $this->assign('company_name', $company_name);
            }
            if(0 != I('post.nature'))
            {
                $this->assign('nature', I('post.nature'));
                $content['where']['nature'] = I('post.nature');
                $this->assign('nature', I('post.nature'));
            }
            if(0 != I('post.trade'))
            {
                $this->assign('trade', I('post.trade'));
                $content['where']['trade'] = I('post.trade');
                $this->assign('trade', I('post.trade'));
            }
            if(0 != I('post.auth_level'))
            {
            	$this->assign('auth_level', I('post.auth_level'));
            	$content['where']['auth_level'] = I('post.auth_level');
            	$this->assign('auth_level', I('post.auth_level'));
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
        
        $this->display();
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
            $this->error("参数错误");
            
        $content = array(
            'id'=> $id
        );
        $result = $this->_call('Company.delete',
                               $content);
        if($result
        && 200 == $result['status_code']
        && 0   == $result['content']['is_success'])
        {
            $this->success("成功操作", C('Template_pre')."Company/get_list", 3);
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