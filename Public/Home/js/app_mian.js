// JavaScript Document

$(function(){
//头部下载
  var oHeight = $(".dowm_app").outerHeight();
  $(window).scroll(function () {
    if($(window).scrollTop()>oHeight){
      $(".dowm_app").css("position", "fixed");
    }else{
      $(".dowm_app").css("position", "");
    }
  });
});
$(function(){
	//监管机构
	$(".tab_jg h3 a").click(function(){
		$(this).parents("h3").children("a").removeClass("current");
		$(this).addClass("current");
		for(var i = 0; i < $(this).parents("h3").children("a").length; i++)
	{
		if($(this).parents("h3").children("a").eq(i).attr("class") == "current")
	{
		$(this).parents("div.tab_jg").children("div.jg_nr").removeClass("show").addClass("hide");
		$(this).parents("div.tab_jg").children("div.jg_nr").eq(i).removeClass("hide").addClass("show");
			}
		}
	});	

  //结果页面切换
	$(".comment h4 a").click(function(){
		$(this).parents("h4").children("a").removeClass("current");
		$(this).addClass("current");
		for(var i = 0; i < $(this).parents("h4").children("a").length; i++)
	{
		if($(this).parents("h4").children("a").eq(i).attr("class") == "current")
	{
		$(this).parents("div.comment").children("div.comment_tab").removeClass("show").addClass("hide");
		$(this).parents("div.comment").children("div.comment_tab").eq(i).removeClass("hide").addClass("show");
			}
		}
	});
  //结果页面切换
  $(".comment h3 a").click(function(){
    $(this).parents("h3").children("a").removeClass("current");
    $(this).addClass("current");
    for(var i = 0; i < $(this).parents("h3").children("a").length; i++)
  {
    if($(this).parents("h3").children("a").eq(i).attr("class") == "current")
    {
    $(this).parents("div.comment").children("div.bg_shbox").removeClass("show").addClass("hide");
    $(this).parents("div.comment").children("div.bg_shbox").eq(i).removeClass("hide").addClass("show");
      }
    }
  });
  //个人中心页面切换
  $(".Center h3 a").click(function(){
    $(this).parents("h3").children("a").removeClass("current");
    $(this).addClass("current");
    for(var i = 0; i < $(this).parents("h3").children("a").length; i++)
  {
    if($(this).parents("h3").children("a").eq(i).attr("class") == "current")
    {
    $(this).parents("div.Center").children("div.bg_shbox").removeClass("show").addClass("hide");
    $(this).parents("div.Center").children("div.bg_shbox").eq(i).removeClass("hide").addClass("show");
      }
    }
  });
  //结果页面切换
  $(".com_text h3 a").click(function(){
    $(this).parents("h3").children("a").removeClass("current");
    $(this).addClass("current");
    for(var i = 0; i < $(this).parents("h3").children("a").length; i++)
  {
    if($(this).parents("h3").children("a").eq(i).attr("class") == "current")
  {
    $(this).parents("div.com_text").children("div.comment_tab").removeClass("show").addClass("hide");
    $(this).parents("div.com_text").children("div.comment_tab").eq(i).removeClass("hide").addClass("show");
      }
    }
  });
  //隐藏和显示切换
  $('#stop').click(function(){
    if($('.yy_list').is(':visible')){
      $("#stop").attr("class","open_ex");
      $('.yy_list').hide();
    }else{
      $("#stop").attr("class","stop");
      $('.yy_list').show();
    }
  });
});

//用户信息修改显示隐藏
$(document).ready(function() { 
  var myDiv = $(".disx");
  //语言头部的点击事件，显示语言列表 
  $("#dianji").live("click", function(e) { 
    if(myDiv.is(":visible")) 
    { 
      myDiv.hide(); 
    } else{
      myDiv.toggle(); 
    }
    e.stopPropagation(); //阻止事件冒泡，否则事件会冒泡到下面的文档点击事件 
  }); 
  //点击文档时，隐藏语言列表 
  $(document).on("touchend click", function(e) { 
    myDiv.hide(); 
  }); 
  $(myDiv).live("touchend click", function(e) { 
    e.stopPropagation(); 
  }); 
}); 

var base64EncodeChars = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/";
    var base64DecodeChars = new Array(
        -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1,
        -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1,
        -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, 62, -1, -1, -1, 63,
        52, 53, 54, 55, 56, 57, 58, 59, 60, 61, -1, -1, -1, -1, -1, -1,
        -1,  0,  1,  2,  3,  4,  5,  6,  7,  8,  9, 10, 11, 12, 13, 14,
        15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, -1, -1, -1, -1, -1,
        -1, 26, 27, 28, 29, 30, 31, 32, 33, 34, 35, 36, 37, 38, 39, 40,
        41, 42, 43, 44, 45, 46, 47, 48, 49, 50, 51, -1, -1, -1, -1, -1);
    //编码的方法
    function base64encode(str) {
        var out, i, len;
        var c1, c2, c3;
        len = str.length;
        i = 0;
        out = "";
        while(i < len) {
        c1 = str.charCodeAt(i++) & 0xff;
        if(i == len)
        {
            out += base64EncodeChars.charAt(c1 >> 2);
            out += base64EncodeChars.charAt((c1 & 0x3) << 4);
            out += "==";
            break;
        }
        c2 = str.charCodeAt(i++);
        if(i == len)
        {
            out += base64EncodeChars.charAt(c1 >> 2);
            out += base64EncodeChars.charAt(((c1 & 0x3)<< 4) | ((c2 & 0xF0) >> 4));
            out += base64EncodeChars.charAt((c2 & 0xF) << 2);
            out += "=";
            break;
        }
        c3 = str.charCodeAt(i++);
        out += base64EncodeChars.charAt(c1 >> 2);
        out += base64EncodeChars.charAt(((c1 & 0x3)<< 4) | ((c2 & 0xF0) >> 4));
        out += base64EncodeChars.charAt(((c2 & 0xF) << 2) | ((c3 & 0xC0) >>6));
        out += base64EncodeChars.charAt(c3 & 0x3F);
        }
        return out;
    }
    //解码的方法
    function base64decode(str) {
        var c1, c2, c3, c4;
        var i, len, out;
        len = str.length;
        i = 0;
        out = "";
        while(i < len) {
        
        do {
            c1 = base64DecodeChars[str.charCodeAt(i++) & 0xff];
        } while(i < len && c1 == -1);
        if(c1 == -1)
            break;
        
        do {
            c2 = base64DecodeChars[str.charCodeAt(i++) & 0xff];
        } while(i < len && c2 == -1);
        if(c2 == -1)
            break;
        out += String.fromCharCode((c1 << 2) | ((c2 & 0x30) >> 4));
        
        do {
            c3 = str.charCodeAt(i++) & 0xff;
           if(c3 == 61)
            return out;
            c3 = base64DecodeChars[c3];
        } while(i < len && c3 == -1);
        if(c3 == -1)
            break;
        out += String.fromCharCode(((c2 & 0XF) << 4) | ((c3 & 0x3C) >> 2));
        
        do {
            c4 = str.charCodeAt(i++) & 0xff;
            if(c4 == 61)
            return out;
            c4 = base64DecodeChars[c4];
        } while(i < len && c4 == -1);
        if(c4 == -1)
            break;
        out += String.fromCharCode(((c3 & 0x03) << 6) | c4);
        }
        return out;
    }

    function utf16to8(str) {
        var out, i, len, c;
        out = "";
        len = str.length;
        for(i = 0; i < len; i++) {
        c = str.charCodeAt(i);
        if ((c >= 0x0001) && (c <= 0x007F)) {
            out += str.charAt(i);
        } else if (c > 0x07FF) {
            out += String.fromCharCode(0xE0 | ((c >> 12) & 0x0F));
            out += String.fromCharCode(0x80 | ((c >>  6) & 0x3F));
          out += String.fromCharCode(0x80 | ((c >>  0) & 0x3F));
       } else {
           out += String.fromCharCode(0xC0 | ((c >>  6) & 0x1F));
           out += String.fromCharCode(0x80 | ((c >>  0) & 0x3F));
       }
       }
       return out;
  }
   function utf8to16(str) {
       var out, i, len, c;
       var char2, char3;
       out = "";
       len = str.length;
       i = 0;
       while(i < len) {
       c = str.charCodeAt(i++);
       switch(c >> 4)
       { 
         case 0: case 1: case 2: case 3: case 4: case 5: case 6: case 7:
           // 0xxxxxxx
           out += str.charAt(i-1);
           break;
         case 12: case 13:
           // 110x xxxx   10xx xxxx
           char2 = str.charCodeAt(i++);
           out += String.fromCharCode(((c & 0x1F) << 6) | (char2 & 0x3F));
           break;
         case 14:
           // 1110 xxxx  10xx xxxx  10xx xxxx
           char2 = str.charCodeAt(i++);
           char3 = str.charCodeAt(i++);
           out += String.fromCharCode(((c & 0x0F) << 12) |
                          ((char2 & 0x3F) << 6) |
                          ((char3 & 0x3F) << 0));
           break;
       }
       }
       return out;
   }
 //年月日、时分秒
 function getTime(/** timestamp=0 **/) {  
    var ts = arguments[0] || 0;  
    var t,y,m,d,h,i,s;  
    t = ts ? new Date(ts*1000) : new Date();  
    y = t.getFullYear();  
    m = t.getMonth()+1;  
    d = t.getDate();  
    h = t.getHours();  
    i = t.getMinutes();  
    s = t.getSeconds();  
    // 可根据需要在这里定义时间格式  
    return y+'-'+(m<10?'0'+m:m)+'-'+(d<10?'0'+d:d)+' '+(h<10?'0'+h:h)+':'+(i<10?'0'+i:i)+':'+(s<10?'0'+s:s);  
}
//年月日
function getTimeEx(/** timestamp=0 **/) {  
    var ts = arguments[0] || 0;  
    var t,y,m,d,h,i,s;  
    t = ts ? new Date(ts*1000) : new Date();  
    y = t.getFullYear();  
    m = t.getMonth()+1;  
    d = t.getDate();
    // 可根据需要在这里定义时间格式  
    return y+'-'+(m<10?'0'+m:m)+'-'+(d<10?'0'+d:d);  
} 
//时分秒
function getTimeExx(/** timestamp=0 **/) {  
    var ts = arguments[0] || 0;  
    var t,y,m,d,h,i,s;  
    t = ts ? new Date(ts*1000) : new Date();  
    y = t.getFullYear();  
    m = t.getMonth()+1;  
    d = t.getDate();  
    h = t.getHours();  
    i = t.getMinutes();  
    s = t.getSeconds();  
    // 可根据需要在这里定义时间格式  
    return (h<10?'0'+h:h)+':'+(i<10?'0'+i:i)+':'+(s<10?'0'+s:s);  
}  