<?php

namespace Home\Controller;

use Think\Controller;
use Org\ThinkSDK\ThinkOauth;

/**
 * 测试例程
 */
class CController extends Controller {

    // 定义公共方法，作用为访问Ta进入三方登录页面
    public function index($type = null) {
        empty($type) && $this->error('参数错误');

        //加载ThinkOauth类并实例化一个对象
        //import("ThinkOauth");
        $sns  = ThinkOauth::getInstance($type);
        //跳转到授权页面
        redirect($sns->getRequestCodeURL());
    }

    /**
     * QQ登录的回调页面。此处举例时使用的是QQ登录
     */
    public function qc() {
        // 获取GET传入的code值
        $code = $this->get('code');
        print_r($code);
        //exit();
        // 设置类型为QQ
        $type = 'QQ';
        // 获取QQ的实例化对象
        $sns = ThinkOauth::getInstance($type);
        // 给extend赋值初始null
        $extend = null;
        // 如果是腾讯微博的客户，此处给extend重新赋值
        if ($type == 'tencent') {
            $extend = array('openid' => $this->_get('openid'), 'openkey' => $this->_get('openkey'));
        }
        // 获取token值。
        $token = $sns->getAccessToken($code, $extend);
        $openid = $token['openid'];
        // 判断token是否是数组
        if (is_array($token)) {
            // 获取用户的详细信息
            $data = $sns->call('user/get_user_info');
            // 将获取到的信息进行整理
            if ($data['ret'] == 0) {
                $userInfo['type'] = 'QQ';
                $userInfo['name'] = $data['nickname'];
                $userInfo['nick'] = $data['nickname'];
                $userInfo['head'] = $data['figureurl_2'];
                // 此处的$userInfo就是需要的用户信息
            } else {
                E('获取腾讯QQ用户信息失败 : ' . $data['msg']);
            }
        } else {
            E('获取腾讯QQ用户信息失败  ');
        }
        // 其中，$userInfo就是需要的值
    }

}

