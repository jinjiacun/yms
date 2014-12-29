<?php if (!defined('THINK_PATH')) exit();?><html>
<head>
	<title>商品列表</title>
</head>
<body>
	<form name="theForm" method="post" enctype="multipart/form-data">
	<table width="100%">
		<tr>
			<th>编号</th>
			<th>名称</th>
			<th>字号</th>
			<th></th>
			<th></th>
			<th>操作</th>
		</tr>
			<?php if(is_array($goods_list)): $i = 0; $__LIST__ = $goods_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$goods): $mod = ($i % 2 );++$i;?><tr align="center">
					<td><?php echo ($goods["id"]); ?></td>
					<td><?php echo ($goods["goods_name"]); ?></td>
					<td><?php echo ($goods["post_no"]); ?></td>
					<td></td>
					<td></td>
					<td>
					<a href=''>编辑</a>
					<a href=''>查看</a>
					</td>
				</tr><?php endforeach; endif; else: echo "" ;endif; ?>
		<tr>
			<td>记录总数<?php echo ($record_count); ?></td>
			<td colspan="6"></td>
		</tr>
	</table>

	</form>
</body>
</html>