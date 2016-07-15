<?php
namespace Azureadmin\Controller;
use Think\Controller;
include_once(dirname(__FILE__).'/BaseController.class.php');
class LoginController extends BaseController {
	public function index()
	{
		if(I('post.submit'))
		{
                    $content = array(
                        'AdminUserName'=>I('post.AdminName'),
                        'Password'    =>I('post.Password'),
                    );
                    $result = $this->_call("ComAdmin.login",
                                           $content);
                    if($result
                    && 200 == $result['status_code']
                    && 0 == $result['content']['is_success'])
                    {
                        session('AdminName', I('post.AdminName'));
                        //用户id
                        session('AdminId', $result['content']['AdminId']);
                        //角色名称
                        session('RoleId', $result['content']['RoleId']);
                        //机构
                        session('ComId', $result['content']['ComId']);
                        //头像
                        session('Adavatar', $result['content']['Adavatar']);
                        //$this->echo_message(0,'成功登录', C('admin_url'));
                        if($result['content']['ComId'] == 0)
                        {
                            $this->redirect("Index/sys_index");    
                        }
                        else
                        {   
                            $this->redirect("Index/other_index");
                        }
                        exit();
                    }
                    else
                    {
                        $this->error("登录失败");
                        //$this->echo_message(-1,'登录失败');
                        //$this->redirect("Index/index");
                        exit();
                    }
		}
		$this->display();
	}

    public function Quit()
    {
        //session('AdminName',null);
        session(null);
        $this->redirect("Index/index");
        exit();
    }


}