<?php if (!defined('THINK_PATH')) exit();?><html>
<head>
	<title>添加商品</title>
</head>
<body>
	<form name="theForm" method="post" enctype="multipart/form-data">
	邮品照片:<input type="file" name="picture"/><br/>
	邮品志号:<input type="text" name="post_no"/><br/>

	邮品品相:<select name='post_condition'>
		<?php if(is_array($post_condition_list)): $i = 0; $__LIST__ = $post_condition_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$post_condition): $mod = ($i % 2 );++$i;?><option value="<?php echo ($post_condition["sn"]); ?>"><?php echo ($post_condition["name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
	</select><br/>
	品相规格:<select name='post_condition'>
		<?php if(is_array($post_spec_list)): $i = 0; $__LIST__ = $post_spec_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$post_spec): $mod = ($i % 2 );++$i;?><option value="<?php echo ($post_spec["sn"]); ?>"><?php echo ($post_spec["name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
	</select><br/>
	单位:<select name='post_condition'>
		<?php if(is_array($post_spec_list)): $i = 0; $__LIST__ = $post_spec_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$post_spec): $mod = ($i % 2 );++$i;?><option value="<?php echo ($post_spec["sn"]); ?>"><?php echo ($post_spec["name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
	</select><br/>
	数量:<input type="text" name="post_number"/><br/>
	单价:<input type="text" name="post_price"/><br/>
	总价<input type="text" name="post_shop_price"/><br/>
	交易类型<select name='transaction_type'>
		<?php if(is_array($transaction_type_list)): $i = 0; $__LIST__ = $transaction_type_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$transaction_type): $mod = ($i % 2 );++$i;?><option value="<?php echo ($transaction_type["sn"]); ?>"><?php echo ($transaction_type["name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
	</select><br/>
	有效期至
	 <input type="radio" />
	  <select name="year"></select>年
	  <select name="month">
	  	
	  </select>月
	  <select name="day"></select>日
	  <select name="hour"></select>时
	 <input type="radio" />长期有效
	<br/>
	承诺:
	<areatext name="promise"></areatext>

	<input type="hidden" name="user_id" value="1"/>
	<input type="submit" name="submit" value="确定"/>
	</form>
</body>
</html>