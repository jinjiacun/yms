<?php
namespace Home\Controller;
use Think\Controller;
class  EmptyController extends Controller {
    function  _empty(){
            header('HTTP/1.0  404  Not Found');
            $this->redirect('Home/Public/error_404');
    }
    function  index(){
            header('HTTP/1.0  404  Not Found');
            $this->redirect('Home/Public/error_404');
    }

} 

?>