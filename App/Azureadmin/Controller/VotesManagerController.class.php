<?php
namespace Azureadmin\Controller;
use Think\Controller;
include_once(dirname(__FILE__).'/ComBaseController.class.php');
class VotesManagerController extends ComBaseController {
    public function _initialize()
    {
        parent::_initialize();
    }

    public function index(){
        $this->assign('menu_p_index', 425);
        $this->assign('menu_index', 426);
        $this->display();
    }

}