<?php
namespace User\Controller;
use Think\Controller;
include_once(dirname(__FILE__)."/BaseController.class.php");
class GoodsController extends BaseController {

    #添加商品
    public function info()
    {
    	if($_POST['submit']){
            $handler = null;


            $goods_sn        = I('post.goods_sn');          #商品编号
            $post_no         = I('post.post_no');           #邮票志号
            $post_name       = I('post.post_name');         #邮票名称
            $post_cat        = I('post.post_cat');          #邮票品类
            $post_price      = I('post.post_price');        #邮票单价
            $post_number     = I('post.post_number');       #邮票数量
            $post_shop_price = I('post.post_shop_price');   #销售价格
            
            $post_unit       = I('post.post_unit');         #邮票单位
            $transaction_type= I('post.transaction_type');  #交易类型
            $end_of_date     = I('post.end_of_date');       #有效期至
            $promise         = I('post.promise');           #承诺
            $add_time        = time();                      #添加日期

            #

            //add picture
            $content = array(
                'goods_sn'        => $goods_sn,          #商品编号
                'post_no'         => $post_no,           #邮票志号
                'post_name'       => $post_name,         #邮票名称                
                'post_cat'        => $post_cat,          #邮票品类
                'post_price'      => $post_price,        #邮票单价
                'post_number'     => $post_number,       #邮票数量
                'post_shop_price' => $post_shop_price,   #销售价格
                
                'post_unit'       => $post_unit,         #邮票单位
                'transaction_type'=> $transaction_type,  #交易类型
                'end_of_date'     => $end_of_date,       #有效期至
                'promise'         => $promise,           #承诺
                'add_time'        => $add_time,          #添加日期
            );
            $result = $this->_call(
                            'Goods.add',
                            $content
            );
            if($result)
            {
                if(200 == $result['status_code']
                && 0   == $result['content']['is_success'])
                {
                    //echo '成功添加';
                    if(isset($content)) unset($content);
                    $goods_id    = intval($result['content']['id']);
                    $pic_id_list = $this->upload_goods_picture();
                    var_dump($pic_id_list);
                    if($pic_id_list
                    && 0< count($pic_id_list))
                    {
                        foreach($pic_id_list as $v)
                        {
                            $content[] = array(
                                'goods_id' => $goods_id,
                                'media_id' => intval($v),
                                'add_time' => time(),
                            );
                        }
                        unset($pic_id_list, $v);
                        $result = $this->_call(
                                        'Goodspic.add_mul',
                                        $content
                        );
                        
                        if($result
                        && 200 == $result['status_code']
                        && 0   == $result['content']['is_success'])
                        {
                            $this->success('success');
                        }
                        else
                        {
                            $this->error('error');
                        }
                    }
                }
            }
    	}

        #查询邮件
        $result = $this->_call(
          'Category.get_list'  
        );
        if(200 == $result['status_code'])
        {
            if($result['content']
            && 0 < count($result['content']['list'])
            && 0 <= $result['content']['record_count'])
            {
                $this->assign('cat_list', $result['content']['list']);
            }
        }

       $this->assign('call_url', C('call_url'));
       #获取计量单位
       $this->assign('unit_list', $this->get_unit());
       $this->assign('transaction_type_list', $this->get_trade_type());
       $this->display();    	
    }

    #商品列表
    public function getlist()
    {
        $res = A('Callapi')->call_api('Goods.get_list', 
                                    null,
                                    'text',
                                  null);
        $result = $this->deal_re_call_api($res);

        $list = array();
        if($result)
        {
            if(200 == $result['status_code'])
            {
                if(isset($result['content']['list'])
                && isset($result['content']['record_count']))
                {
                    $list   = $result['content']['list'];   
                    $this->assign('goods_list', $list);     
                    $record_count = $result['content']['record_count'];
                    $this->assign('record_count', $record_count);
                }
            }
        }
        $this->display();   
    }

    #上传图片
    public function upload()
    {
        if($_POST['submit'])
        {
            $fp  = fopen($_FILES['picture']["tmp_name"], "rb");
            $buf = fread($fp, $_FILES['picture']['size']);
            fclose($fp);
            $filename = $_FILES['picture']["tmp_name"];


            $res = A('Callapi')->call_api('Media.upload', 
                                           array(
                                            'file_name'=>$filename,  #文件名称
                                            'buf'      =>$buf,       #要上传的二进制数据
                                            'file_ext' =>'jpg',      #图片后缀
                                            'module_sn'=>'015001',  #目标模块名称(015001-商品图片,015002-会员身份证)
                                            ),
                                          'resource',
                                          $fp);
            print_r($res);
            $result = $this->deal_re_call_api($res);
            if($result)
            {
                if(200 == $result['status_code']
                && 0   == $result['content']['is_success'])
                {
                    echo '上传成功';
                }
            }
        }
        $this->display();
    }

    #upload goods picture
    private function upload_goods_picture()
    {
        if(I('post.submit')
        && $_FILES)
        {
            $picture_list = $_FILES['picture']['name'];
            $pic_id_list  = array();

            if(0< count($picture_list))
            {
                foreach($picture_list as $k=>$v)
                {
                    $fp  = fopen($_FILES['picture']['tmp_name'][$k], "rb");
                    $buf = fread($fp, $_FILES['picture']['size'][$k]);
                    fclose($fp);
                    $content = array(
                        'file_name' => '123.jpg',
                        'buf'       => $buf,
                        'file_ext'  => 'jpg',
                        'module_sn' => '015001',
                    ); 
                    
                    $result = $this->_call(
                                  'Media.upload',
                                  $content,
                                  'resource'  
                            );
                    if($result
                    && 200 == $result['status_code']
                    && 0   == $result['content']['is_success']
                    )
                    {
                        $pic_id_list[] = intval($result['content']['id']);
                    }
                }
                unset($picture_list, $k, $v);
            }
        }

        return $pic_id_list;
    }
}