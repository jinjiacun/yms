<?php
namespace user\Controller;
use Think\Controller;
class UserController extends Controller {

	public function register()
	{
		if($_POST['submit'])
		{
			$user_name = I('post.user_name');
			$content = array(
                      'user_name'=>urlencode($user_name),
            );
            $res = A('Callapi')->call_api('User.add', 
                               $content,
                              'text',
                              $handler);
            var_dump($res);
            $callback_info = json_decode($res);
            var_dump($callback_info);
            if(200 == $callback_info['status_code']
            &&	0  == $callback_info['content']['is_success']
            	)
            {
            	echo '成功注册';
            }
            else
            {
            	echo '注册失败';
            }
		}
		$this->display();
	}	

	public function get_list()
	{
		$data = A('Callapi')->call_api('User.add', 
                		               $content,
                        		      'text',
                              		   $handler);
		var_dump($data);
	}

  public function login()
  {
    if($_POST['submit'])
    {
      $user_name = I('post.user_name');
      $password  = I('post.password');

      $content = array(
          'user_name' => $user_name,
          'password'  => $password,
      );

      $res = A('Callapi')->call_api('User.login',
                                    $content,
                                    'text',
                                    $handler
            );
      var_dump($res);
      $callback_info = json_decode($res, true);
      if(200 == $callback_info['status_code']
      && 0   == $callback_info['content']['is_success'])
      {
        //session('user_name', $user_name);
        echo '登录成功';
      }
      else
      {
        echo '登录失败'; 
      }
    }
    $this->display();
  }

  public function getinfo()
  {
    $res = A('Callapi')->call_api('User.get_session',
                                  $content,
                                  'text',
                                  $handler
          );
    var_dump($res);
    //var_dump(session('user_name'));
    $callback_info = json_decode($res, true);
    if(200 == $callback_info['status_code'])
    {
      if($callback_info['content'])
      {
        print_r($callback_info['content']);
      }
    }
  }
}