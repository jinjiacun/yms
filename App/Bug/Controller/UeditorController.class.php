<?php
namespace Home\Controller;
use Think\Controller;
header('Content-type: text/html; charset=utf-8');
include_once(dirname(__FILE__)."/BaseController.class.php");
class UeditorController extends BaseController {
    public function _initialize(){
        parent::_initialize();
    }
}