<?php
namespace Admin\Controller;
use Think\Controller;
include_once(dirname(__FILE__).'/BaseController.class.php');
class AttrController extends BaseController {

	public function add()
	{
		if(I('post.submit'))
		{
			$name     = I('post.name');
			$attr_val_list = I('post.val');
            $attr_id = 0;

			#添加属性名称
			$res = A('Callapi')->call_api('Attr.add', 
                                    array(
                                        'name'        => urlencode($name),          #商品编号
                                        'add_time'    => time()
                                        ),
                                    'text',
                                  $handler);
            $result = $this->deal_re_call_api($res);
            if($result)
            {
                if(200 == $result['status_code']
                && 0   == $result['content']['is_success'])
                {
                    $attr_id = intval($result['content']['id']);
                    #添加属性值
                    if($attr_val_list
                    && 0<count($attr_val_list))
                    {
                        foreach($attr_val_list as $v)
                        {
                            #添加属性名称
                             $res = A('Callapi')->call_api('Attrval.add', 
                                    array(
                                        'attr_id'     => $attr_id,
                                        'name'        => urlencode($v),          #商品编号
                                        'add_time'    => time()
                                        ),
                                    'text',
                                  $handler);
                             $result = $this->deal_re_call_api($res);
                             if($result)
                             {
                                if(200 != $result['status_code']
                                || 0   != $result['content']['is_success'])
                                {
                                    echo '添加属性值错误';
                                    exit();
                                }

                             }

                        }
                        unset($v);
                    }

                    echo '成功添加';
                }
            }
		}

		$this->display();
	}

	public function edit()
	{
		if(I('post.submit'))
		{
            $attr_id = I('post.id');
            $attr_name = I('post.name');
            
            #修改属性名称
            $content['where'] = array(
                'id'=>$attr_id,
            );
            $content['data'] = array(
                                'name'=>urlencode($attr_name)
                                );
            $result = $this->_call("Attr.update", $content);
            if(!$result
            || 200 != $result['status_code']
            || -1  == $result['content']['is_success'])
            {
                //$this->error("修改属性名称失败");
            }
            unset($content);

            #旧的删除
            if(I("post.del_attr_val"))
            {
                #删除属性值
                $content["attr_val_ids"] = implode(',', I('post.del_attr_val'));
                $result = $this->_call("Attrval.del_by_val_ids", $content);
                if(!$result
                || 200 != $result['status_code']
                || -1  == $result['content']['is_success']
                )
                {
                    $this->error("删除属性值失败");
                }
            }
            unset($content);

            #新增属性值
            if(I('post.val'))
            {
                $content = array(
                    'attr_id' => $attr_id,
                    'attr_val_names' => urlencode(implode(',', I('post.val'))),
                    );
                $result = $this->_call("Attrval.add_mul", $content);
                if(!$result
                || 200 != $result['status_code']
                || -1  == $result['content']['is_success']
                )
                {
                    $this->error("新增属性值失败");
                }
            }

            #成功操作
            $this->success();
            exit();
		}
        $id = I('get.id');
        $content['where'] = array(
            'id'=> $id,
        );
        $result = $this->_call("Attr.get_list", $content);
        if($result
        && 200 == $result['status_code'])
        {
            $attr_info = $result['content']['list'][0];
            $this->assign('attr_info', $attr_info);
        }

        #通过属性id获取属性值信息
        $content = array(
            'attr_ids' => $id,
        );
        $result = $this->_call("Attrval.getlist_by_attr_ids",
                               $content);
        if($result
        && 200 == $result['status_code'])
        {
            $attr_val_list = $result['content'];
            $this->assign('attr_val_list', $attr_val_list);
        }
		$this->display();
	}

	public function get_list()
	{
        $content = array();
        if(I('post.submit'))
        {
            $content['where'] = array(
                                    'name'=>I('post.name'),
                                );
        }

        $result = $this->_call("Attr.get_list");
        if($result)
        {
            if(200 == $result['status_code'])
            {
                $attr_list = $result['content']['list'];
                $this->assign('record_count', $result['content']['record_count']);
                $this->assign('attr_list', $attr_list);

                $tmp_list = array();
                if($attr_list
                && 0<count($attr_list))
                {
                    foreach($attr_list as $v)
                    {
                        $tmp_list[] = $v['id'];
                    }    
                }
                
                if(0 == count($tmp_list))
                {
                    goto L;
                }
                $attr_ids  = implode(',', $tmp_list);
                $sub_result = $this->_call("Attrval.getlist_by_attr_ids",
                                           array('attr_ids'=>$attr_ids));
                if($sub_result)
                {
                    if(200 == $sub_result['status_code'])
                    {
                        $fmt_attr_val_list = array();
                        $attr_val_list = $sub_result['content'];
                        #格式化输出
                        if($attr_val_list
                        && 0< count($attr_val_list))
                        {
                            foreach($attr_val_list as $v)
                            {
                                if(isset($fmt_attr_val_list[$v['attr_id']]))
                                    $fmt_attr_val_list[$v['attr_id']] .= ','.$v['attr_val_name'];
                                else
                                    $fmt_attr_val_list[$v['attr_id']] = $v['attr_val_name'];
                            }
                        }
                        $this->assign('attr_val_list', $fmt_attr_val_list);
                    }
                }
            }
        }

    L:    $this->display();   
	}
}