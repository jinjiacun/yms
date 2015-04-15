var windowWidth,windowHeight,popstatus,	//超时时间
    outTime;
/*
* whWindow()	浏览器宽高的获取
*/
function whWindow() {
	windowWidth = $(window).width();
	windowHeight = $(window).height();
}
/*
* windowSize()	窗口监听函数
*/
$(window).resize(function() {
	whWindow();
	popStatuRe();
});
whWindow();
/*
* popStatus()	提示
* status	1正确，2提示，3加载，4失败
* html	提示信息
* timeout	提示时间,单位：秒
* url	是否跳转页面,没有则留空
* bremove	是否使用遮照,不为空时使用
*/
function popStatus(status, html, timeout, url, bremove) {
	//请求超时时间 
	var timeous = 20;
	clearTimeout(popstatus);
	clearTimeout(outTime);
	$('body #wstatus').remove();
	$('body #bremove').remove();
	if (status == 1) {
		$('body').append('<div id="wstatus"><div class="wstatus_s wstatus_s1"></div><span class="wstatus_f">'+html+'</span></div>');
	}else if (status == 2) {
		$('body').append('<div id="wstatus"><div class="wstatus_s wstatus_s2"></div><span class="wstatus_f">'+html+'</span></div>');
	}else if (status == 3) {
		$('body').append('<div id="wstatus"><div class="wstatus_s wstatus_s3"></div><span class="wstatus_f">'+html+'</span></div>');
	}else {
		$('body').append('<div id="wstatus"><div class="wstatus_s wstatus_s4"></div><span class="wstatus_f">'+html+'</span></div>');
	}
	popStatuRe();
	//是否使用遮照
	if (bremove) {
		$('body').append('<div id="bremove" />');
	}
	if (!url) {
		url = 0;
	}
	//抖动
	if (status == 2 || status ==4) {
		var sw = (windowWidth/2)-($('#wstatus').width()+18)/2;
		var sh = (windowHeight/2)-($('#wstatus').height()+18)/2;
		$('body #wstatus').animate({left:sw-15+'px'},100);
		$('body #wstatus').animate({left:sw+30+'px'},100);
		$('body #wstatus').animate({left:sw-30+'px'},100);
		$('body #wstatus').animate({left:sw+30+'px'},100);
		$('body #wstatus').animate({left:sw+'px'},100);
		$('body #wstatus').animate({top:sh-15+'px'},100);
		$('body #wstatus').animate({top:sh+30+'px'},100);
		$('body #wstatus').animate({top:sh-30+'px'},100);
		$('body #wstatus').animate({top:sh+30+'px'},100);
		$('body #wstatus').animate({top:sh+'px'},100);
	}
	popstatus = setTimeout(function() {
		//判断是否有跳转地址
		if (url != 0) {
			if (url == '?') {
				reloads();
			}else {
				location.href = url;
			}
		}
		$('body #wstatus').remove();
		$('body #bremove').eq(-1).remove();
	},timeout*1000);
	//超时时间设置
	if (timeout >= timeous) {
		outTime = setTimeout(function() {
			if ($('body #wstatus')) {
				clearTimeout(popstatus);
				$('body #wstatus').remove();
				popStatus(4, '阿哦,请求地址错误或超时,请重试！', 3, '', true);
			}
		},timeout*1000-1000);
	}
}
/*
* popStatuRe()	位置矫正
*/
function popStatuRe() {
	$('body #wstatus').css({'left':(windowWidth/2)-($('#wstatus').width()+18)/2+'px','top':(windowHeight/2)-($('#wstatus').height()+18)/2+'px'});
}



//------------------------------------------表单处理:begin------------------------------------------
function selectAll(){
	var obj = document.fom.elements;
	for (var i=0;i<obj.length;i++){
		if (obj[i].name == "delid" || obj[i].name == "id[]"){
			obj[i].checked = true;
		}
	}
}

function unselectAll(){
	var obj = document.fom.elements;
	for (var i=0;i<obj.length;i++){
		if (obj[i].name == "delid" || obj[i].name == "id[]"){
			if (obj[i].checked==true) obj[i].checked = false;
			else obj[i].checked = true;
		}
	}
}

function link(){
    document.getElementById("fom").action="addjihua.htm";
   document.getElementById("fom").submit();
}

function on_load(){
	var loadingmsg=document.getElementById("loadingmsg");
	var mainpage=document.getElementById("mainpage");
	loadingmsg.style.display="";
	mainpage.style.display="none";
	
	loadingmsg.style.display="none";
	mainpage.style.display="";
}

$(document).ready(
function(){
	//绑定全选
	$('#selectAll').on('click', selectAll);
	$('#unselectAll').on('click', unselectAll);	
});
//------------------------------------------表单处理:end------------------------------------------