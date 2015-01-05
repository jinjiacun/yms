<?php if (!defined('THINK_PATH')) exit();?><html>
<head>
	<title>商品列表</title>
</head>
<body>
	<form name="theForm" method="post" enctype="multipart/form-data">
	<table width="100%">
		<tr>
			<th>编号</th>
			<th>字号</th>
			<th>品类</th>
			<th>单位</th>
            <th>单价</th>			
			<th>数量</th>
            <th>售价</th>
			<th>操作</th>
		</tr>
			<?php if(is_array($goods_list)): $i = 0; $__LIST__ = $goods_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$goods): $mod = ($i % 2 );++$i;?><tr align="center">
					<td><?php echo ($goods["id"]); ?></td>
				<td><?php echo ($goods["post_no"]); ?></td>
					<td><?php echo ($_map_category[$goods['post_cat']]); ?></td>
					<td><?php echo ($_map_unit[$goods['post_unit']]); ?></td>
					<td><?php echo ($goods["post_price"]); ?></td>
					<td><?php echo ($goods["post_number"]); ?></td>
					<td><?php echo ($goods["post_shop_price"]); ?></td>
					<td>
					<a href="/yms/index.php/User/Goods/edit/id/<?php echo ($goods["id"]); ?>">编辑</a>
					</td>
				</tr><?php endforeach; endif; else: echo "" ;endif; ?>
	</table>
 <table width="95%" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
          <td height="6"><img src="/yms/Public/Admin/images/spacer.gif" width="1" height="1" /></td>
        </tr>
        <tr>
          <td colspan="5" align="right"><?php echo ($page); ?></td>
        </tr>
</table>
	</form>
</body>
</html>