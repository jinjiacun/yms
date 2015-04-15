<?php
namespace Home\Controller;
use Think\Controller;
header('Content-type: text/html; charset=utf-8');
include_once(dirname(__FILE__)."/BaseController.class.php");
class InexposureController extends BaseController{
	/*
	*申请搜黑可信企业认证数据添加
	*/
    public function authentication(){
        //用户登录返回信息
        $log_result = $this->_call('User.get_login_info',
                                   $content);
        if(200 == $log_result['status_code'] &&
            0 == $log_result['content']['is_success'])
        {
            $userid = $log_result['content']['user_id'];
            $this->assign('login', $log_result['content']);
            $this->assign('userid',$userid);
        }

        //申请搜黑可信企业认证数据添加
        if ($_POST['submit']) {
            $user_id  = $userid;
            $nature              = I('post.nature');
            $trade               = I('post.trade');
            $company_name        = I('post.company_name');
            $corporation         = I('post.corporation');
            $reg_address         = I('post.reg_address');
            $company_type        = I('post.company_type');
            $busin_license_ex    = $_FILES['busin_license']['tmp_name'];
            $code_certificate_ex = $_FILES['code_certificate']['tmp_name'];
            $telephone           = I('post.telephone');
            $website             = I('post.website');
            $record              = I('post.record');
            $agent_platform      = I('post.agent_platform');
            $mem_sn              = I('post.mem_sn');
            $certificate_ex      = $_FILES['certificate']['tmp_name'];
            $find_website        = I('post.find_website');
            if ($user_id == "") {
                 $this->error("您还没有登录，请登录后操作");
            }
            if($company_name == ""){
                $this->error("公司全称不能为空");
            }
            if($corporation == ""){
                $this->error("公司简称不能为空");
            }
            if($reg_address == ""){
                $this->error("注册地址不能为空");
            }
            if($company_type == ""){
                $this->error("企业类型不能为空");
            }
            if($telephone == ""){
                $this->error("联系电话不能为空");
            }
            if($website == ""){
                $this->error("官方网站不能为空");
            }
            if($record == ""){
                $this->error("官网备案不能为空");
            }
            //判断营业执照是否上传
            if (!empty($busin_license_ex)) {
                $fp  = fopen($busin_license_ex, "rb");
                $buf = fread($fp, $_FILES['busin_license']['size']);
                fclose($fp);
                $filename = $busin_license_ex;
                $result = $this->_call('Media.upload', 
                                             array(
                                              'file_name'=>$filename,  #文件名称
                                              'buf'      =>$buf,       #要上传的二进制数据
                                              'file_ext' =>'jpg',      #图片后缀
                                              'module_sn'=>'001003',   #营业执照
                                              ),
                                            'resource',
                                            $fp);
                if($result)
                {
                    if(200 == $result['status_code']
                    && 0   == $result['content']['is_success'])
                    {
                        $busin_license = $result['content']['id'];
                    }else{
                        $this->error("营业执照上传失败","exposure",3);
                        exit();
                    }
                }
            }else{
                $this->error("请上传营业执照");
            }
            //判断机构代码证是否上传
            if (!empty($code_certificate_ex)) {
                $fp  = fopen($code_certificate_ex, "rb");
                $buf = fread($fp, $_FILES['code_certificate']['size']);
                fclose($fp);
                $filename = $code_certificate_ex;
                $result = $this->_call('Media.upload', 
                                             array(
                                              'file_name'=>$filename,  #文件名称
                                              'buf'      =>$buf,       #要上传的二进制数据
                                              'file_ext' =>'jpg',      #图片后缀
                                              'module_sn'=>'001004',   #机构代码证
                                              ),
                                            'resource',
                                            $fp);
                if($result)
                {
                    if(200 == $result['status_code']
                    && 0   == $result['content']['is_success'])
                    {
                        $code_certificate = $result['content']['id'];
                    }else{
                        $this->error("机构代码证上传失败","exposure",3);
                        exit();
                    }
                }
            }else{
                $this->error("请上传机构代码证");
            }
            //资质证明图片上传
            if(!empty($code_certificate_ex)){
                $fp  = fopen($certificate_ex, "rb");
                $buf = fread($fp, $_FILES['certificate']['size']);
                fclose($fp);
                $filename = $certificate_ex;
                $result = $this->_call('Media.upload', 
                                             array(
                                              'file_name'=>$filename,  #文件名称
                                              'buf'      =>$buf,       #要上传的二进制数据
                                              'file_ext' =>'jpg',      #图片后缀
                                              'module_sn'=>'001005',   #资质证明
                                              ),
                                            'resource',
                                            $fp);
                if($result)
                {
                    if(200 == $result['status_code']
                    && 0   == $result['content']['is_success'])
                    {
                        $certificate = $result['content']['id'];
                    }else{
                        $this->error("机构代码证上传失败","exposure",3);
                        exit();
                    }
                }
            }else{
                $certificate = "";
            }
            $content = array(
                'user_id'          => $user_id,
                'nature'           => $nature,
                'trade'            => $trade,
                'company_name'     => urlencode($company_name),
                'corporation'      => urlencode($corporation),
                'reg_address'      => urlencode($reg_address),
                'company_type'     => urlencode($company_type),
                'busin_license'    => $busin_license,
                'code_certificate' => $code_certificate,
                'telephone'        => urlencode($telephone),
                'website'          => urlencode($website),
                'record'           => urlencode($record),
                'agent_platform'   => urlencode($agent_platform),
                'mem_sn'           => urlencode($mem_sn),
                'certificate'      => $certificate,
                'find_website'     => urlencode($find_website),
                );
            print_r($content);
            //exit();
            $result = $this->_call('Inexposal.add_ex',
                                   $content);
            if(200 == $result['status_code']
            &&  0  == $result['content']['is_success'])
            {
                //$this->success("添加成功","../Inexposure/authentication",3);
                echo "<script>alert('添加成功');location.href='../Home/index'</script>"; 
                exit(); 
            }
            else
            {
                //$this->error("添加失败");
                echo "<script>alert('添加失败');location.href='../Inexposure/authentication'</script>"; 
                exit(); 
            }
        }
        $this->display();
    }
    /*
	*我要曝光数据添加
	*/
    public function exposure(){
        //用户登录返回信息
        $log_result = $this->_call('User.get_login_info',
                                   $content);
        if(200 == $log_result['status_code'] &&
            0 == $log_result['content']['is_success'])
        {
            $userid = $log_result['content']['user_id'];
            $this->assign('login', $log_result['content']);
            $this->assign('userid',$userid);
        }
        
        //我要曝光数据添加
        if ($_POST['submit']) {
            
            $user_id      = $userid;
            $nature       = I('post.nature');
            $trade        = I('post.trade');
            $company_name = I('post.company_name');
            $amount       = I('post.amount');
            $website      = I('post.website');
            $content      = I('post.content');
            if ($user_id == "") {
                $this->error("您还没有登录，请登录后操作");
            }
            if ($company_name =="") {
                $this->error("公司名称不能为空");
            }
            if ($amount =="") {
                $this->error("涉及金额不能为空");
            }
            if ($content =="") {
                $this->error("曝光内容不能为空");
            }
            //用户照片的上传
            $fp  = fopen($_FILES['pic_1']["tmp_name"], "rb");
            $buf = fread($fp, $_FILES['pic_1']['size']);
            fclose($fp);
            $filename = $_FILES['pic_1']["tmp_name"];
            $result = $this->_call('Media.upload', 
                                   array(
                                      'file_name'=>$filename,  #文件名称
                                      'buf'      =>$buf,       #要上传的二进制数据
                                      'file_ext' =>'jpg',      #图片后缀
                                      'module_sn'=>'001001',   #曝光图片
                                      ),
                                   'resource',
                                   $fp);
            if($result)
            {
                if(200 == $result['status_code']
                && 0   == $result['content']['is_success'])
                {
                    $pic_1 = $result['content']['id'];
                }else{
                    $this->error("图片上传失败","exposure",3);
                    exit();
                }
            }
            $content = array(
                'user_id'      =>$user_id,
                'nature'       =>$nature,
                'trade'        =>$trade,
                'company_name' =>urlencode($company_name),
                'amount'       =>$amount,
                'website'      =>$website,
                'content'      =>urlencode($content),
                'pic_1'        =>$pic_1, 
                );
            $result = $this->_call('Inexposal.add',
                                   $content);
            if(200 == $result['status_code']
            &&  0  == $result['content']['is_success'])
            {
                //$this->success("添加成功","../Inexposure/authentication",3);
                echo "<script>alert('添加成功');location.href='../Ranking/machine'</script>"; 
                exit(); 

            }
            else
            {
                //$this->error("添加失败");
                echo "<script>alert('添加失败');location.href='../Inexposure/exposure'</script>"; 
                exit();
            }
        }
        $this->display();
    }
}