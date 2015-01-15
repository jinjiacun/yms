<?php
namespace Soadmin\Controller;
use Think\Controller;
include_once(dirname(__FILE__).'/BaseController.class.php');
/**
 *企业管理
*/
class CompanyController extends BaseController {
    public function add()
    {
        if(I('post.submit'))
        {
            $content = array(
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
                'agent_platform'  => I('post.agent_platform'),
                'mem_sn'          => I('post.mem_sn'),
                'certificate'     => $this->upload('certificate','001008'),
            );
            $result = $this->_call("Company.add",
                                   $content);
            if($result
            && 200 == $result['status_code']
            && 0 == $result['is_success'])
            {
                $this->success('成功添加');
            }
        }
            
        $this->display();   
    }
    
    public function edit()
    {
        $id = intval(I('post.id'));
        if(I('post.submit'))
        {
            
        }
        
        $content = array(
            'id'=> $id,
        );
        $result = $this->_call('Company.get_info',
                               $content);
        if($result
        && 200 == $result['status_code'])
        {
            $this->assign('company', $result['content']);
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
    
    public function delete()
    {
        $this->display();
    }
}