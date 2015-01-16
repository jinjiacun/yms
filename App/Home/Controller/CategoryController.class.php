<?php
namespace Home\Controller;
use Think\Controller;
class CategoryController extends Controller {
    public function index(){
    	$this->assign('cat_id', 1);
    	$this->assign('call_url', C('call_url'));
        $this->display();
    }
}