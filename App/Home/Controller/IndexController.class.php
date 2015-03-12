<?php
namespace Home\Controller;
use Think\Controller;
class IndexController extends Controller {
    public function index(){
        if(!in_array($_SERVER['HTTP_HOST'], array('www.souhei.com.cn','souhei.com.cn')))
        {
           exit('no authorization'); 
        }
        $this->display();
    }
}