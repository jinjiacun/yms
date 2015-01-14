<?php
namespace Soadmin\Controller;
use Think\Controller;
include_once(dirname(__FILE__).'/BaseController.class.php');
class IndexController extends BaseController {
    public function index(){
        $this->display();
    }

    public function login()
    {
    	$this->display();
    }
}