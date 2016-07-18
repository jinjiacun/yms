<?php
namespace Azureadmin\Controller;
use Azureadmin\Controller;
include_once(dirname(__FILE__).'/ComBaseController.class.php');

class RefPDFController extends ComBaseController{
        public function _initialize()
	{
	   parent::_initialize();
	}

        public function index(){
            $this->assign('menu_p_index', 414);
            $this->assign('menu_index', 449);
            
            $page_index = 1;
            $page_size  = 20;
            $content    = array();
            if(I('get.p')){
                $page_index = I('get.p');
                $content['page_size'] = $page_size;
                $content['page_index'] = $page_index;
            }
            else{
                $content['page_size'] = $page_size;
                $content['page_index'] = $page_index;
            }
        
            if(session('ComId') > 0){
                $content['where']['ComId'] = session('ComId');
            }       

            $content['where']['NewsState'] = 1;
            $content['where']['ColumnId'] = 666;
        
            $result = $this->_call('ComNews.get_list', $content);

            $list = array();
            if($result){
                if(200 == $result['status_code']){
                    if(isset($result['content']['list'])
                    && isset($result['content']['record_count'])){
                        $list   = $result['content']['list'];   
                        $this->assign('list', $list);     
                        $record_count = $result['content']['record_count'];
                        $this->assign('record_count', $record_count);
                        //$this->get_page($record_count, $page_size);
                        $this->assign('page', $this->get_page_by_custom(C('controller').'/CompanyManager/GetTable', 1, $record_count, $page_size));
                    }
                }
            }
            unset($result);

            $this->display();
        }

        /**
           功能：删除
         */
        public function Delete(){
            $content['NewId'] = I('get.NewId');
            $result = $this->_call("ComNews.delete", $content);
            unset($content);
            if($result){
                if($result['status_code'] == 200
                && $result['content']['is_success'] == 0){
                    header('Content-type:text/json');
                    $out = array('res'=>1);
                    echo json_encode($out);
                    exit();
                }
            }

            header('Content-type:text/json');
            $out = array('res'=>1);
            echo json_encode($out);
            exit();
        }

        
        /**
           功能：保存

           参数：
           @@input
           @param $id string 
           @param $cid string 
           @param $title string 
           @param $content string 
           @param $docreader string 
           @param $newsPDF string 
           @param DateTime? showTime    
         */
        public function Save（）{

        }
}