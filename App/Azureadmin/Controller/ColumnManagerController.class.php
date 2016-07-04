<?php
namespace Azureadmin\Controller;
use Think\Controller;
include_once(dirname(__FILE__).'/BaseController.class.php');
/*--栏目管理--*/
class ColumnManagerController extends BaseController {
    public function _initialize()
    {
        parent::_initialize();
        parent::get_dictionary();
        if(null == session('AdminName')
        || ''   == session('AdminName'))
        {
            $this->redirect('/Azureadmin/Login/index');
        }
    }

    /**
       功能:入口函数
     */
     public function Index(){
     	    $this->assign('title', '栏目管理');
	    $this->assign('menu_index', 2);

    	    //查询平台
    	    $page_index = 1;
    	    $page_size  = 20;
    	    $content    = array();
    	    $content['page_size'] = $page_size;
    	    $content['page_index'] = $page_index;    
    	    $content['where']['AMoType'] = 1;
    	    $content['where']['AMoPId'] = 0;
    	    $result = $this->_call('AModule.get_list', $content);

    	    $list = array();
    	    if($result)
    	    {
		if(200 == $result['status_code'])
        	{
			if(isset($result['content']['list'])
            		&& isset($result['content']['record_count']))
            		{
                	$list   = $result['content']['list'];   
                	$this->assign('list', $list);
            		}
        	}
    	    }
	    unset($result);
	    $id_list = array();
    	    $ids = '';
    	    //查询三级关系
    	    if($list && 0<count($list))
    	    {
      	       foreach($list as $v)
      	      {
               $id_list[] = $v['AMoId'];
      	      }


      	      if(0< count($id_list))
      	      {
               $ids = implode($id_list, ',');
               $content['where']['AMoType'] = 1;
               $content['where']['AMoPId'] = array('in', $ids);
               $result = $this->_call('AModule.get_list', $content);
               if($result)
               {
                  if(200 == $result['status_code'])
		  {
            	    if(isset($result['content']['list'])
            	    && isset($result['content']['record_count']))
            	    {
		       $tmp_list = $result['content']['list'];
              	       foreach($list as $k=>$v)
              	       {
			   foreach($tmp_list as $t_k=>$t_v)
                           {
                    	      if($v['AMoId'] == $t_v['AMoPId'])
                              {
                               $list[$k]['_ex'][] = $t_v;
                              }
                            }
                        }
                        $this->assign('list', $list);
                    }
                  }
               }
            }
           }	    


    	    //查询机构
    	    $content['where']['AMoType'] = 2;
    	    $content['where']['AMoPId'] = 0;
    	    $result = $this->_call('AModule.get_list', $content);

    	    $list = array();
    	    if($result)
    	    {
		if(200 == $result['status_code'])
        	{
			if(isset($result['content']['list'])
            		&& isset($result['content']['record_count']))
            		{
                	$list   = $result['content']['list'];   
                	$this->assign('list_ex', $list);
            		}
        	}
    	    }

    	    unset($result);
    	    $id_list = array();
    	    $ids = '';
    	    //查询三级关系
    	    if($list && 0<count($list))
    	    {
      	       foreach($list as $v)
      	      {
               $id_list[] = $v['AMoId'];
      	      }


      	      if(0< count($id_list))
      	      {
               $ids = implode($id_list, ',');
               $content['where']['AMoType'] = 2;
               $content['where']['AMoPId'] = array('in', $ids);
               $result = $this->_call('AModule.get_list', $content);
               if($result)
               {
                  if(200 == $result['status_code'])
		  {
            	    if(isset($result['content']['list'])
            	    && isset($result['content']['record_count']))
            	    {
		       $tmp_list = $result['content']['list'];
              	       foreach($list as $k=>$v)
              	       {
			   foreach($tmp_list as $t_k=>$t_v)
                           {
                    	      if($v['AMoId'] == $t_v['AMoPId'])
                              {
                               $list[$k]['_ex'][] = $t_v;
                              }
                            }
                        }
                        $this->assign('list_ex', $list);
                    }
                  }
               }
            }
           }

		$this->display();
   }

    /**
       功能:获取列表
     */
    public function GetTable(){

      //查询平台
          $page_index = 1;
          $page_size  = 20;
          $content    = array();
          $content['page_size'] = $page_size;
          $content['page_index'] = $page_index;    
          $content['where']['AMoType'] = 1;
          $content['where']['AMoPId'] = 0;
          $result = $this->_call('AModule.get_list', $content);

          $list = array();
          if($result)
          {
          if(200 == $result['status_code'])
          {
            if(isset($result['content']['list'])
                && isset($result['content']['record_count']))
                {
                  $list   = $result['content']['list'];
                }
          }
          }
	  unset($result);
	    $id_list = array();
    	    $ids = '';
    	    //查询三级关系
    	    if($list && 0<count($list))
    	    {
      	       foreach($list as $v)
      	      {
               $id_list[] = $v['AMoId'];
      	      }


      	      if(0< count($id_list))
      	      {
               $ids = implode($id_list, ',');
               $content['where']['AMoType'] = 1;
               $content['where']['AMoPId'] = array('in', $ids);
               $result = $this->_call('AModule.get_list', $content);
               if($result)
               {
                  if(200 == $result['status_code'])
		  {
            	    if(isset($result['content']['list'])
            	    && isset($result['content']['record_count']))
            	    {
		       $tmp_list = $result['content']['list'];
              	       foreach($list as $k=>$v)
              	       {
			   foreach($tmp_list as $t_k=>$t_v)
                           {
                    	      if($v['AMoId'] == $t_v['AMoPId'])
                              {
                               $list[$k]['_ex'][] = $t_v;
                              }
                            }
                        }
			$platform_list = $list;
                    }
                  }
               }
            }
           }

          //查询机构
          $content['where']['AMoType'] = 2;
          $content['where']['AMoPId'] = 0;
          $result = $this->_call('AModule.get_list', $content);

          $list = array();
          if($result)
          {
          if(200 == $result['status_code'])
          {
            if(isset($result['content']['list'])
                && isset($result['content']['record_count']))
                {
                  $list   = $result['content']['list'];
                }
          }
          }

          unset($result);
          $id_list = array();
          $ids = '';
          //查询三级关系
          if($list && 0<count($list))
          {
            foreach($list as $v)
            {
            $id_list[] = $v['AMoId'];
            }


            if(0< count($id_list))
            {
            $ids = implode($id_list, ',');
            $content['where']['AMoType'] = 2;
            $content['where']['AMoPId'] = array('in', $ids);
            $result = $this->_call('AModule.get_list', $content);
            if($result)
            {
            if(200 == $result['status_code']){
                 if(isset($result['content']['list'])
                 && isset($result['content']['record_count']))
                 {
                   $tmp_list = $result['content']['list'];
                   foreach($list as $k=>$v)
                   {
                   foreach($tmp_list as $t_k=>$t_v)
                   {
                    if($v['AMoId'] == $t_v['AMoPId'])
                    {
                      $list[$k]['_ex'][] = $t_v;
                    }
                  }
              }
               $company_list = $list;
            }
          }
        }
      }
    }

    //html格式化输出
    $html = '';
    
    //输出平台
    $html = '
    <tr data-tt-id="-1">
                    <td><span class="column">平台</span></td>
                    <td></td>
                    <td></td>
                    <td><button onclick="a(0,1)" class="btn btn-primary btn-mini">增加子栏目</button></td>
                </tr>
    ';
    foreach($platform_list as $item)
    {
      if($item['AMoType'] ==1
      && $item['AMoPId'] == 0)
      {
          $html .='
                  <tr data-tt-id="'.$item['AMoId'].'" data-tt-parent-id="-1">
                    <td><span class="column">'.$item['AMoName'].'</span></td>
                    <td><a target="_blank" href="'.$item['AMoUrl'].'">'.$item['AMoUrl'].'</a></td>
                    <td>平台</td>
                    <td><button onclick="a('.$item['AMoId'].',1)" class="btn btn-primary btn-mini">增加子栏目</button>&nbsp;<button onclick="a(0,1)" class="btn btn-mini">增加同级栏目</button>&nbsp;<button onclick="b('.$item['AMoId'].')" class="btn btn-danger btn-mini">删除栏目</button>&nbsp;<button onclick="c('.$item['AMoId'].')" class="btn btn-mini">修改栏目</button></td>
                </tr>';
      }
      foreach($item['_ex'] as $s_item){
         $html .= ' 
	       	  <tr data-tt-id="'.$s_item['AMoId'].'" data-tt-parent-id="'.$s_item['AMoPId'].'">
                    <td><span class="column">'.$s_item['AMoName'].'</span></td>
                    <td><a target="_blank" href="'.$s_item['AMoUrl'].'">'.$s_item['AMoUrl'].'</a></td>
                    <td>平台</td>
                    <td><button onclick="a(0,1)" class="btn btn-mini">增加同级栏目</button>&nbsp;<button onclick="b('.$s_item['AMoId'].')" class="btn btn-danger btn-mini">删除栏目</button>&nbsp;<button onclick="c('.$s_item['AMoId'].')" class="btn btn-mini">修改栏目</button></td>
                </tr>';
      }
    }

    //输出机构
    $html .= '
    <tr data-tt-id="-2">
                    <td><span class="column">机构</span></td>
                    <td></td>
                    <td></td>
                    <td><button onclick="a(0,2)" class="btn btn-primary btn-mini">增加子栏目</button></td>
                </tr>
    ';
    foreach($company_list as $item){
            $html .= '
                <tr data-tt-id="'.$item['AMoId'].'" data-tt-parent-id="-2">
                    <td><span class="column">'.$item['AMoName'].'</span></td>
                    <td><a target="_blank" href="'.$item['AMoUrl'].'">'.$item['AMoUrl'].'</a></td>
                    <td>机构</td>
                    <td><button onclick="a('.$item['AMoId'].',2)" class="btn btn-primary btn-mini">增加子栏目</button>&nbsp;<button onclick="a(0,2)" class="btn btn-mini">增加同级栏目</button>&nbsp;<button onclick="b('.$item['AMoId'].')" class="btn btn-danger btn-mini">删除栏目</button>&nbsp;<button onclick="c('.$item['AMoId'].')" class="btn btn-mini">修改栏目</button></td>
                </tr>';

          foreach($item['_ex'] as $s_item){
                $html .= '
                    <tr data-tt-id="'.$s_item['AMoId'].'" data-tt-parent-id="'.$s_item['AMoPId'].'">
                        <td><span class="column">'.$s_item['AMoName'].'</span></td>
                        <td><a target="_blank" href="'.$s_item['AMoUrl'].'">'.$item['AMoUrl'].'</a></td>
                        <td>机构</td>
                        <td><button onclick="a(0,1)" class="btn btn-mini">增加同级栏目</button>&nbsp;<button onclick="b('.$s_item['AMoId'].')" class="btn btn-danger btn-mini">删除栏目</button>&nbsp;<button onclick="c('.$s_item['AMoId'].')" class="btn btn-mini">修改栏目</button></td>
                    </tr>';
          }
    }
                  

    echo $html;
    exit();
    }

    /**
       功能:获取一条信息
       
       参数:
       @param $AMoId int 栏目id
     */
    public function Get(){
      $content['AMoId'] = I('post.AMoId');

      $result = $this->_call('AModule.get_info_by_key', $content);
      if($result){
        if($result['status_code'] == 200)
        {
          $data = array(
              'AMoName' => $result['content']['AMoName'],
              'AMoUrl' => $result['content']['AMoUrl'],
            );
          $out = array(
              'res' => 1,
              'data' =>$data
            );
          echo json_encode($out);
          exit();
        }
      }

      $out = array(
          'res' => -5000
        );
      echo json_encode($out);
      exit();
    }

    /**
       功能:更新
       
       参数:
       @param $AMoId int 栏目编号
       @param $AMoName string 栏目名称
       @param $AMoUrl string 栏目url地址
     */
    public function Update(){
      $content = array(
        'where' => array(
            'AMoId' => I('post.AMoId'),
          ),
        'data'  => array(
              'AMoName' => urlencode(I('post.AMoName')),
              'AMoUrl'  => I('post.AMoUrl'),
              'AMUpTime' => date('Y-m-d H:i:s'),
          ),
        );

      $result = $this->_call('AModule.update', $content);
      if($result)
      {
        if($result['status_code'] == 200 
        && $result['content']['is_success'] == 0)
        {
          $out = array('res'=>1);
          echo json_encode($out);
          exit();
        }
      }

     $out = array(
          'res' => -5000
        );
      echo json_encode($out);
      exit();   
    }

    /**
       功能:新增

       参数:
       @param $AMoPId int 父栏目编号
       @param $AMoName string 栏目名称
       @param $AMoUrl string 栏目url地址
       @param $AMoType int 栏目类型
     */
    public function Add(){
      $content = array(
          'AMoPId'    => intval(I('post.AMoPId')),
          'AMoName'   => urlencode(I('post.AMoName')),
          'AMoUrl'    => urlencode(I('post.AMoUrl')),
          'AMoType'   => intval(I('post.AMoType')),
          'AdminId'   => intval(session('AdminId')),
          'AMoState'  => 1
      );

      $result = $this->_call('AModule.add', $content);
      if($result)
      {
        if($result['status_code'] == 200 
        && $result['content']['is_success'] == 0)
        {
          $out = array('res'=>1);
          echo json_encode($out);
          exit();
        }
      }

     $out = array(
          'res' => -5000
        );
      echo json_encode($out);
      exit();    
    }
    
    /**
       功能:删除

       参数:
       @param $AMoId int 栏目id
     */
    public function Delete(){
      //$content['AMoId'] = I('post.AMoId');
      $AMoId = I('post.AMoId');


      //查找该栏目的子栏目
      $content['where']['AMoId'] = $AMoId;
      $content['where']['AMoPId'] = $AMoId;
      $content['where']['_logic'] = 'OR';
      $list = array();
      $result = $this->_call('AModule.get_list', $content);
      unset($content);
      if($result)
      {
        if($result['status_code'] == 200)
        {
          $list = $content['list'];
        }
      }
      unset($result);

      $AMIdList = array();
      $AMIdStr = '';
      if(0<count($list))  
      {
        foreach($list as $v)
        {
          $AMIdList[] = intval($v['AMoId']);
        }

        $AMIdStr = implode(',', $AMIdList);
        unset($AMIdList);

        //删除角色权限关联
        //return Content("{\"res\":-1}");
        $content['AMId'] = array('in', $AMIdStr);
        $result = $this->_call('ComRoMo.delete', $content);
        unset($content);
        if($result)
        {
          if(200 == $result['status_code']
          && $result['content']['is_success'] !=0)
          {
              $out = array('res'=>-1);
              echo json_encode($out);
              exit();
          }
        }
        unset($result);
      }

      //删除栏目及子栏目
      //return Content("{\"res\":-2}");
      $content['AMoId'] = $AMoId;
      $content['AMoPId'] = $AMoId;
      $content['_logic'] = 'OR';
      $result = $this->_call('AModule.delete', $content);
      unset($content);
      if($result)
      {
        if($result['status_code'] == 200 
        && $result['content']['is_success'] == 0)
        {
          $out = array('res'=>1);
          echo json_encode($out);
          exit();
        }
      }
      unset($result);

     $out = array(
          'res' => -5000
        );
      echo json_encode($out);
      exit();     
    }

    public function quit()
    {
        session('AdminName',null);
        $this->redirect("Index/index");
        exit();
    }
}