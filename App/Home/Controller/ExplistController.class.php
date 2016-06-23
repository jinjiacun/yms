<?php
namespace Home\Controller;
use Think\Controller;
header('Content-type: text/html; charset=utf-8');
include_once(dirname(__FILE__)."/BaseController.class.php");
class ExplistController extends BaseController {
	public function index(){
        $this->_login();
        if($this->is_mobile()){ 
            $this->display('index_wap');
        }else{ 
            $this->display();
        }
	}	
    //最新曝光查看更多
    public function bg_list(){

        //曝光动态
        $p=isset($_POST['k'])?intval(trim($_POST['k'])):0;
        $page_size = 10;
        $content = array();
        if($p <= 10)
        {
            $page_index = $p;
            $content['page_size']  = $page_size;
            $content['page_index'] = $page_index;
        }else{
            exit();
        }
        $result = $this->_call('Inexposal.dynamic',$content);
        if (200 == $result['status_code']) {
            $bgdt = $result['content']['list'];
            foreach ($bgdt as $key => $rs) {
                $bgdt[$key]['add_time'] = date('Y-m-d H:i:s',$rs['add_time']);
            }
            if(count($bgdt)>0){
                echo json_encode($bgdt);
                exit();
            }else{
                exit();
            }
        } 
    }
}