<?php
namespace Admin\Controller;
use Think\Controller;
include_once(dirname(__FILE__).'/BaseController.class.php');
class CategoryController extends BaseController {
	
	public function add()
	{
		if(I('post.submit'))
		{
			$name = I('post.name');
			$attr_val_ids        = '';
			$goods_attr_val_ids = '';
			$fmt_attr_val_id_list = array();
			$fmt_attr_val_ids     = '';
			if(I('post.attr_val_id'))
			{
				$attr_val_id_list   = I('post.attr_val_id');
				$attr_id_list       = I('post.attr_id');
				$attr_val_name_list = I('post.attr_val_name');
				$attr_name_list     = I('post.attr_name');

				$attr_val_ids  = implode(',', $attr_val_id_list);
				$goods_attr_val_id_list = array();
				$count = count($attr_val_id_list);
				for($i=0; $i< $count; $i++)
				{
					$goods_attr_val_id_list[intval($attr_val_id_list[$i])] = 0;
					$fmt_attr_val_id_list[] = array(
						'attr_id'       =>	intval($attr_id_list[$i]),
						'attr_name'     =>  urlencode($attr_name_list[$i]),
						'attr_val_id'   =>	intval($attr_val_id_list[$i]),
						'attr_val_name'	=>	urlencode($attr_val_name_list[$i]),
					);
				}	
				unset($i, $count);
				$fmt_attr_val_ids = $fmt_attr_val_id_list;
				//implode('-',$fmt_attr_val_id_list);
				$goods_attr_val_ids = implode(',', $goods_attr_val_id_list);
				if(null == $goods_attr_val_ids)
					$goods_attr_val_ids = '';
			}
			
			//add name of category
			$content = array(
				'name' => urlencode($name),
				'attr_val_id'        => $attr_val_ids,
				'goods_attr_val_ids' => $goods_attr_val_ids,
				'fmt_attr_val_id'    => $fmt_attr_val_ids,
				'add_time'           => time(),
			);
			$result = $this->_call('Category.add', $content);
			if(!$result
			&& 200 != $result['status_code']
			&& 0   != $result['content']['is_success'])
			{
				$this->error('add cateory err');
			}
			unset($content);

			
/*			if(I('post.attr_id'))
			{
				$cat_id = $result['content']['id'];
				$attr_id_list     = I('post.attr_id');
				$attr_val_id_list = I('post.attr_val_id');
				if(0 <count($attr_id_list))
				{
					$count = count($attr_id_list);
					for($i=0; $i< $count; $i++)
					{
						$content[] = array(
							'cat_id'      => $cat_id,
							'attr_id'     => $attr_id_list[$i],
							'attr_val_id' => $attr_val_id_list[$i]
						);
					}
					$result = $this->_call('Catattrval.add_mul',
										   $content);
					if($result
					&& 200 == $result['status_code']
					&& 0   == $result['content']['is_success'])
					{
						$this->success("success");
					}
				}
			}*/
			
		}
		$this->get_attr();
		$this->display();
	}

	public function edit()
	{
		$id = I('get.id');

		if(0>= $id)
		{
			$this->error("param err");
		}

		if(I('post.submit'))
		{
			$id   = I('post.id');
			$name = I('post.name');
            $old_attr_id_list       = I('post.old_attr_id');
            $old_attr_val_id_list   = I('post.old_attr_val_id');
			$old_attr_name_list     = I('post.old_attr_name');
			$old_attr_name_val_list = I('post.old_attr_val_name');
            $attr_id_list           = I('post.attr_id');
			$attr_val_id_list       = I('post.attr_val_id');
			$attr_name_list         = I('post.attr_name');
			$attr_val_name_list     = I('post.attr_val_name');
			$del_attr_val_id_list   = I('post.del_attr_val_id');
			#update category
			if($old_attr_id_list
			&& 0< count($old_attr_id_list)
            )
            {
				$count = count($old_attr_id_list);
				for($i=0; $i< $count; $i++)
				{
					
				}
			}	
			$content['where'] = array(
				'id' => $id,
			);
			$content['data'] = array(
				'name' => urlencode($name),
			);
			$result = $this->_call("Category.update",
				                   $content);
			if(!$result
			|| 200 != $result['status_code'])
			{
				$this->error("change category err");
			}

			$this->success('success');
		}

		#get one of category
		$content = array(
			'cat_id' => $id,
		);
		$result = $this->_call('Category.get_category_info_by_id',
								$content);
		if($result
		&& 200 == $result['status_code'])
		{
			$this->assign('category_info', $result['content']);
			$attr_val_ids = $result['content']['attr_val_id'];
		}
		$this->get_attr();
		$this->display();
	}

	public function get_list()
	{
		$content = array();
		$page_index = 1;
		$page_size  = 10;
		if(I('post.Submit'))
		{
			if(I('post.name'))
			{
				$content['where'] = array(
					'name'=>urlencode(I('post.name')),
				);
			}
		}
		if(I('get.p'))
		{
			$page_index = I('get.p');
			$content['page_size'] = $page_size;
			$content['page_index'] = $page_index;
		}

        $result = $this->_call('Category.get_list', $content);
        if($result)
        {
            if(200 == $result['status_code'])
            {
            	$list = $result['content']['list'];
                $record_count = $result['content']['record_count'];
                $this->assign('record_count', $record_count);
                $this->get_page($record_count, 10);
                
                #获取分类下属性值映射
                $map_category_attr_val_id = array();
                $attr_val_ids = '';
                if($list
                && 0< $list)
				{
                	#获取当前属性值的id和名称映射
					$attr_val_id_list = array();
    	            $attr_id_list     = array();
     				foreach($list as $k => $v){
                        $category_attr_val_id = explode(',', $v['attr_val_id']);
                        $list[$k]['attr_val_id_list'] =  $category_attr_val_id;
                        $list[$k]['fmt_attr_val_id']  = $v['fmt_attr_val_id'];
                    }
				}
				$this->assign('category_list', $list);
				unset($v, $list);
            }
        }

		$this->display();
	}

	private function get_attr()
	{
		#获取所有属性
        $result = $this->_call('Attr.get_list');
        if($result
        && 200 == $result['status_code'])
        {
            $this->assign('attr_list', $result['content']['list']);
        }
        $this->assign('call_url', C('call_url'));
	}
}
