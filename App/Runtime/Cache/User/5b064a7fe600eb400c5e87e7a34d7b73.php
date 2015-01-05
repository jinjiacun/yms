<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>添加商品</title>
	<script type="text/javascript" src="/yms/Public/js/jquery-1.9.1.min.js"></script>
	<script type="text/javascript" src="/yms/Public/js/comment.js"></script>
	<script type="text/javascript" src="/yms/Public/js/DatePicker/WdatePicker.js"></script>
	<script type='text/javascript'>

		function change_cat()
		{
			var cat_id = $('#post_cat').val();
			if(0 == cat_id)return;

			jQuery.ajax({  
		        type:"post",  
		        url:"<?php echo ($call_url); ?>",
		        timeout: 5000,  
		        dataType:"json",  
		        data:{"method":"Category.get_category_attr","type":"text","content":{"cat_id":cat_id}},
		        success: function aa(data) {  
		        	if(200 == data.status_code)
		        	{
		        		$('#id_spec').empty();
		        		var attr_list    = new Array();
		        		var attr_id_list = new Array();
		        		$.each(data.content, function(i, val){
		       				var attr_id       = val.attr_id;
		       				var attr_name     = val.attr_name;
		       				var attr_val_id   = val.attr_val_id;
		       				var attr_val_name = val.attr_val_name;
		       				attr_list[attr_id] = attr_name;
		       				if(attr_id_list[attr_id])
		       				{
		       					attr_id_list[attr_id] = attr_id_list[attr_id]+','
		       					                        + attr_id 
		       					                        + '-'+attr_val_id
		       					                        + '-'+attr_val_name;
		       				}
		       				else
		       				{
		       					attr_id_list[attr_id] = attr_id+'-'+attr_val_id+'-'+attr_val_name;
		       				}
		       			}); 

		       			for(var ele in attr_list)
		       			{
		       				var attr_val_list = attr_id_list[ele].split(',');
		       				var attr_str = '';
		       				for(var i=0; i< attr_val_list.length; i++)
		       				{
		       					var item_list = attr_val_list[i].split('-');
		       					attr_str += "<option value='{0}'>{1}</option>".print_f(item_list[1],
		       						                                                   item_list[2]);
		       				}
		       				var select = "{0}<input type='hidden' name='attr_id[]' value='{1}' />:<select name='attr_val_id[]'>{2}{3}</select>".print_f(attr_list[ele],
		       					                                              ele,
		       					                                              "<option>---select---</option>",
		       					                                              attr_str);
		       				$('#id_spec').append(select);
		       			}	   
		        	}		       		
		        	else
		        	{
		        		alert(data.content);
		        	}
		        }  
    		});  
		}

function add_pic()
{
	//cur count of pic list
	var pic_obj = $("input[name='picture[]']");
	if(4 < pic_obj.length)
	{
		alert('');
		return;
	}
	$('#id_pic').append("<input type='file' name='picture[]' /><a href='#' onclick='remove_pic(this);'>[-]</a><br/>");
}

function remove_pic(cur_obj)
{
	$(cur_obj).prev().remove();
	$(cur_obj).next().remove();
	$(cur_obj).remove();
}		

function is_show_validity(is_show)
{
	if(1 == is_show)
	{
		$('#end_of_date').css("display","");
	}
	else if(0 == is_show)
	{
		$('#end_of_date').css("display","none");
	}
}
</script>
</head>
<F5><body>
	<form name="theForm" method="post" enctype="multipart/form-data">
	邮品照片:<a href='#' onclick="javascript:add_pic();">[+]</a>	
    <div id="id_pic">
    	<input type="file" name="picture[]" /><br/>
    </div>
	品类:<select id="post_cat" name="post_cat" onchange="change_cat();">
        <option value="0">---请选择品类---</option>
        <?php if(is_array($_map_category)): $i = 0; $__LIST__ = $_map_category;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$cat): $mod = ($i % 2 );++$i;?><option value="<?php echo ($key); ?>"><?php echo ($cat); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
        </select><br/>

	<div id="id_spec">
	<!--
	
	-->
	</div>

	单位:<select name='post_unit'>
	 <option value="0">---select---</option>
		<?php if(is_array($_map_unit)): $i = 0; $__LIST__ = $_map_unit;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$post_unit): $mod = ($i % 2 );++$i;?><option value="<?php echo ($key); ?>"><?php echo ($post_unit); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
	</select><br/>
	数量:<input type="text" name="post_number"/><br/>
	单价:<input type="text" name="post_price"/><br/>
	总价<input type="text" name="post_shop_price"/><br/>
	交易类型<select name='transaction_type'>
			<option value="0">---select---</option>
			<?php if(is_array($_map_transaction_type)): $i = 0; $__LIST__ = $_map_transaction_type;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$transaction_type): $mod = ($i % 2 );++$i;?><option value="<?php echo ($key); ?>"><?php echo ($transaction_type); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
		  </select><br/>
	有效期至
	 <input type="radio" name="is_long" checked="checked" onclick="is_show_validity(1);" />
	  <input readonly="readonly" type="text" class="Wdate" name='end_of_date' id="end_of_date" onfocus="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss'})" />
	 <input type="radio" name="is_long" onclick="is_show_validity(0);" />长期有效
	<br/>
	承诺:
	<textarea name="promise"></textarea><br/>

	<input type="hidden" name="user_id" value="1"/>
	<input type="submit" name="submit" value="确定"/>
	</form>
</body>
</html>