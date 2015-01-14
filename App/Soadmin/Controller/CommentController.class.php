<?php
namespace Soadmin\Controller;
use Think\Controller;
include_once(dirname(__FILE__).'/BaseController.class.php');
/**
 *评论管理
*/
class CommentController extends BaseController {
    //查询
    public function get_list()
    {
        $this->display();
    }
    
    //审核
    public function check()
    {
        $this->display();
    }
    
    //删除
    public function delete()
    {
        $this->display();
    }
}