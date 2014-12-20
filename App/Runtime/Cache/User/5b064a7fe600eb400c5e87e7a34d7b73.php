<?php if (!defined('THINK_PATH')) exit();?><html>
<head>
	<title>添加商品</title>
</head>
<body>
	<form name="theForm" method="post" enctype="multipart/form-data">
	商品编号:<input type="text" name="goods_name"/><br/>
	字号:<input type="text" name="post_no"/><br/>
	商品图片:<input type="file" name="picture"/><br/>
	邮票品相:<select name='post_condition'>
		<?php if(is_array($post_condition_list)): $i = 0; $__LIST__ = $post_condition_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$post_condition): $mod = ($i % 2 );++$i;?><option value="<?php echo ($post_condition["sn"]); ?>"><?php echo ($post_condition["name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
	</select><br/>
	邮票规格:<select name='post_condition'>
		<?php if(is_array($post_condition_list)): $i = 0; $__LIST__ = $post_condition_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$post_condition): $mod = ($i % 2 );++$i;?><option value="<?php echo ($post_condition["sn"]); ?>"><?php echo ($post_condition["name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
	</select><br/>
	<input type="submit" name="submit" value="确定"/>
	</form>
</body>
</html>