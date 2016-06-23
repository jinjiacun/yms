/**
 * 名称：漫画原创弹出对话框提示层插件mh_dialog
 * 语言：原生javascript
 * 作者：邓剑彬（英文名：temdy）
 * 昵称：漫画之迷
 * 官网：http://www.jq-school.com
 * 日期：2015-05-14
 */

var mh_timer;
/**
 * @Description 页面加载时创建遮罩层和对话框层
 * @author temdy
 * @Date 2015-05-14
 */
window.onload=function(){
	var cssText = "html,body{width:100%;height:100%;margin:0;padding:0;}#mh_layer{background-color:#000;position:fixed;left:0;top:0;width:100%;height:100%;z-index:999999;display:none;background-color:rgba(0,0,0,0.6);}#mh_dialog{padding-top:55px;padding-bottom:20px; width:200px;text-align:center;border-radius:8px;position:fixed;left:50%;top:50%;margin-left:-106px;margin-top:-56px;z-index:10000000;background-color:#fff;background-repeat:no-repeat;font-size:14px;font-weight:bold;display:none;letter-spacing:1px;}.mh_success{background-image:url('Public/Home/images/success.png');color:#1fce11;background-size:32px 32px;background-position:center 20px;border:3px #1fce11 solid;}.mh_loading{background-image:url('Public/Home/images/loading.gif');color:#333333;background-size:50px 50px;background-position:center 15px;border:3px #333333 solid;}.mh_warning{background-image:url('Public/Home/images/warning.png');color:#F90;background-size:32px 32px;background-position:center 20px;border:3px #e44600 solid;}.mh_error{background-image:url('Public/Home/images/error.png');color:#F00;background-size:32px 32px;background-position:center 20px;border:3px #F00 solid;}";
	//初始化插件样式
	createStyle(cssText);
	//创建遮罩层
	var mh_layer_div = document.createElement("div"); 
	mh_layer_div.setAttribute("id","mh_layer"); 
	document.body.appendChild(mh_layer_div); 
	//创建对话框层
	var mh_dialog_div = document.createElement("div"); 
	mh_dialog_div.setAttribute("id","mh_dialog"); 
	document.body.appendChild(mh_dialog_div); 
}

/**
 * @Description 动态创建遮罩层和对话框层的样式
 * @author temdy
 * @Date 2015-05-14
 */
function createStyle(content){
	//创建样式节点
	var style=document.createElement("style");
	style.setAttribute("type", "text/css");
	if(style.styleSheet){// IE
		style.styleSheet.cssText = content;
	} else {// w3c
		var cssText = document.createTextNode(content);
		style.appendChild(cssText);
	}
	//获取头部标签对象
	var heads = document.getElementsByTagName("head");
	if(heads.length){
		heads[0].appendChild(style);
	}else{
		document.documentElement.appendChild(style);
	}
}


/**
 * @Description 弹出对话框层
 * @author temdy
 * @Date 2015-05-14
 * @param className 样式名称（成功：mh_success，失败：mh_error，加载：mh_loading，警告：mh_warning）
 * @param content 提示内容
 * @param timeout 定时关闭时间
 * @param flag 是否自动关闭
 * @param url 对话框关闭时跳转的url 
 * @return
 */
function mh_dialogShow(className,content,timeout,flag,url){
	//获取遮罩层对象
	var mh_layer = document.getElementById("mh_layer");
	//获取对话框层对象
	var mh_dialog = document.getElementById("mh_dialog");
	timeout = timeout || 3;
	flag = flag || false;
	url = url || "";
	mh_dialog.className = className;
	mh_dialog.innerHTML = content;
	mh_dialog.style.display = "block";
	mh_layer.style.display = "block";
	if(flag){
		mh_timer = window.setInterval(function(){
			mh_dialogClose(url);
			window.clearInterval(mh_timer);
		},timeout*1000);
	}
}

/**
 * @Description 关闭对话框层
 * @author temdy
 * @Date 2015-05-14
 * @param url 关闭层时跳转的url
 * @return
 */
function mh_dialogClose(url){
	//获取遮罩层对象
	var mh_layer = document.getElementById("mh_layer");
	//获取对话框层对象
	var mh_dialog = document.getElementById("mh_dialog");
	url = url || "";
	mh_dialog.style.display = "none";
	mh_layer.style.display = "none";
	if(url!=""){
		window.location.href = url;
	}
}