<?php
namespace Azureadmin\Controller;
use Think\Controller;
include_once(dirname(__FILE__).'/ComBaseController.class.php');
class TeacherRoomController extends ComBaseController {
    public function _initialize()
    {
        parent::_initialize();
    }

    public function LiveRoom(){
        $this->assign('menu_p_index', 422);
        $this->assign('menu_index', 424);
        $this->display();
    }

}