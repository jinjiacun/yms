<?php
namespace Azureadmin\Controller;
use Azureadmin\Controller;
include_once(dirname(__FILE__).'/ComBaseController.class.php');
class CureManagerController extends ComBaseController {
    public function _initialize(){
        parent::_initialize();
    }

    public function Index(){
        $this->display();
    }
}