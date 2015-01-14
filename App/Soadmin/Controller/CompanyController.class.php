<?php
namespace Soadmin\Controller;
use Think\Controller;
include_once(dirname(__FILE__).'/BaseController.class.php');
/**
 *企业管理
*/
class CompanyController extends BaseController {
    public function add()
    {
        $this->display();   
    }
    
    public function edit()
    {
        $this->display();
    }
    
    public function get_list()
    {
        $this->display();
    }
    
    public function delete()
    {
        $this->display();
    }
}