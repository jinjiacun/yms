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
            $post_condition  = I('post.post_condition');    #邮票品相
            $post_spec       = I('post.post_spec');         #邮票规格
            $post_cat        = I('post.post_cat');          #邮票品类
            $post_price      = I('post.post_price');        #邮票单价
            $post_number     = I('post.post_number');       #邮票数量
            $post_shop_price = I('post.post_shop_price');   #销售价格
            
            $post_zodiac     = I('post.post_zodiac');       #生肖系列
            $zodiac_cat      = I('post.zodiac_cat');        #生肖种类
            $yearbook_spec   = I('post.yearbook_spec');     #年册规格
            $chronological   = I('post.chronological');     #编年年份
            $issue           = I('post.issue');             #发行日期
            $post_company    = I('post.post_company');      #邮票单位
            $transaction_type= I('post.transaction_type');  #交易类型
            $end_of_date     = I('post.end_of_date');       #有效期至
            $promise         = I('post.promise');           #承诺
            $add_time        = time();                      #添加日期

            if($_FILES["picture"])
            {
                $handler = $_FILES['picture'];
            }

    		$res = A('Callapi')->call_api('Goods.add', 
                                    array(
                                        'goods_sn'        => $goods_sn,          #商品编号
                                        'post_no'         => $post_no,           #邮票志号
                                        'post_name'       => $post_name,         #邮票名称
                                        'post_condition'  => $post_condition,    #邮票品相
                                        'post_spec'       => $post_spec,         #邮票规格
                                        'post_cat'        => $post_cat,          #邮票品类
                                        'post_price'      => $post_price,        #邮票单价
                                        'post_number'     => $post_number,       #邮票数量
                                        'post_shop_price' => $post_shop_price,   #销售价格
                                        
                                        'post_zodiac'     => $post_zodiac,       #生肖系列
                                        'zodiac_cat'      => $zodiac_cat,        #生肖种类
                                        'yearbook_spec'   => $yearbook_spec,     #年册规格
                                        'chronological'   => $chronological,     #编年年份
                                        'issue'           => $issue,             #发行日期
                                        'post_company'    => $post_company,      #邮票单位
                                        'transaction_type'=> $transaction_type,  #交易类型
                                        'end_of_date'     => $end_of_date,       #有效期至
                                        'promise'         => $promise,           #承诺
                                        'add_time'        => $add_time,          #添加日期
                                        ),
                                    'text',
                                  $handler);
            $result = $this->deal_re_call_api($res);
            if($result)
            {
                if(200 == $result['status_code']
                && 0   == $result['content']['is_success'])
                {
                    echo '成功添加';
                }
            }
    	}

        #查询邮件品相
        $where = array(
            'cat_id'=>2
            );
        $res = A('Callapi')->call_api('Dict.get_list',
                            $where,
                            'text',
                            $handler
                );
        $result = $this->deal_re_call_api($res);
        if(200 == $result['status_code'])
        {
            if($result['content']
            && 0 < count($result['content']['list'])
            && 0 <= $result['content']['record_count'])
            {
                $this->assign('post_condition_list', $result['content']['list']);
                $this->assign('record_count', $result);
            }
        }

        
       #查询规格
       $this->assign('post_spec_list', $this->get_post_spec());
       #查询品相
       $this->assign('post_condition_list', $this->get_post_condition());
       #获取计量单位
       $this->assign('unit_list', $this->get_unit());
       #获取交易类型
       
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
}