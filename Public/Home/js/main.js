// JavaScript Document
window.onload = function(){ 
　　var window_ht = $(window).height();
	var heiGht = $("#wrap").outerHeight();
	if(window_ht > heiGht){	
		$("#footer, #footer_zc").addClass("footer_fx");
	}
} 
$(function(){
	/*20150422个人中心-Begin*/	
	 $(".new_box .my_bg:last").css("borderBottom","none");
		$(".new_tit li").click(function(){
			$(this).parents("ul").children("li").removeClass("activ");
			$(this).addClass("activ");
			for(var i = 0; i < $(this).parents("ul").children("li").length; i++)
		{
			if($(this).parents("ul").children("li").eq(i).attr("class") == "activ")
		{
			$(this).parents("div.id_newbox_rt").children("div.new_box").removeClass("show").addClass("hide");
			$(this).parents("div.id_newbox_rt").children("div.new_box").eq(i).removeClass("hide").addClass("show");
				}
			}
	});	
	//修改个人信息显示
	$(".btn_xgzl").click(function(){
		$(".bd_wd").css("width", $(document).width());
        $(".bd_wd").css("height", $(document).height());
        $(".bd_wd").show();
		$(".tcwindows_grzx").show();
		
	});
	//修改个人信息关闭
	$(".qvxiao,.xg_gr h2 a").click(function(){
		$(".bd_wd").hide();
		$(".tcwindows_grzx").hide();
	});		
	
/*20150422个人中心-End*/	
	/*搜索列表页*/
	$(".hpt_box dt a").click(function(){
		$(this).parent(".hpt_box dt").children('b').show().delay(100).animate({top:'-25px',opacity:'0'},200);		
		});	

	$(".close_xgdlmm a").click(function(){
		$(".tcwindows_xgdlmm").hide();
		
		});
	$(".yzsbai .xigs").click(function(){
		$(".yzsbai").hide();
		
		});	
	//查询结果页区域选中
    $(".isspan").click(function(){
      $(this).find("input[type=radio]").attr("checked", 'checked');
    });
	//密码修改显示
	$(".xgmm").click(function(){
		$(".bd_wd").css("width", $(document).width());
        $(".bd_wd").css("height", $(document).height());
        $(".bd_wd").show();
		$(".tcwindows_xgdlmm").show();		
	});
	//密码修改关闭
	$(".close_xgdlmm a").click(function(){
		$(".bd_wd").hide();
		$(".tcwindows_xgdlmm").hide();
	});
	//失败关闭
	$(".yzsbai .xigs, .yzsbai_ex .xigs").click(function(){
		$(".yzsbai").hide();
		$(".bd_wd").hide();	
		$(".yzsbai_ex").hide();
		$(".bd_wd_ex").hide();	
		//window.location.reload();
	});	
	//成功关闭
	$(".yzsbai1 .xigs1").click(function(){
		$(".yzsbai1").hide();
		$(".bd_wd1").hide();	
		window.location.reload();
	});		
//首页搜索
    $(".searchbox ul li").click(function(){
	   var test =$(this).attr("alt");
	   $(".searchbox ul li").removeClass("active");
	   $(this).addClass("active");
	   $(this).parents('.searchbox').find(".chuax1").val(test);
	   inputTipText(); 
	   
	   });

//头部fix
   $(window).scroll(function(){
	   if ($(window).scrollTop()>44){
	   $(".header_fixbox").addClass("fixbox");
	   }
	   else{
		    $(".header_fixbox").removeClass("fixbox");
		   
		   }
		   });
//头部fix
   $(window).scroll(function(){
	   if ($(window).scrollTop()>44){
	      $("#header_new").addClass("fixbox");
	   }
	   else{
		  $("#header_new").removeClass("fixbox");
		   
		}
	});		  	   
//头部fix
   $(window).scroll(function(){
	   if ($(window).scrollTop()>44){
	   $(".cont_lta").addClass("fixboxs");
	   }
	   else{
		    $(".cont_lta").removeClass("fixboxs");
		   
		   }
		   });	   
//新闻右边滚动
   $(window).scroll(function(){
	   if ($(window).scrollTop()>44){
	   $(".textbox_rt").addClass("fixboxss");
	   }
	   else{
		    $(".textbox_rt").removeClass("fixboxss");
		   
		   }
		   });	  		   
 //关闭图片上传弹出窗口	
	$(".close_gb").click(function(){
		$(this).parents("#windows_ct").hide();
		$(".bd_wd").hide();	
	});
//确认上传
	$('.x_queren').live('click',function(){
	  if($("#msg li").size() >= 2){
	    $(this).parents("#windows_ct").hide();
	    $(".bd_wd").hide(); 
	  }else{
	    alert("请添加图片！");
	    return false;
	  }
	});
//取消上传
	$('.x_qvxiao').live('click',function(){
	  if($("#msg li").size() >= 2){
	    $('li').remove('.sx');
	    $("li").remove('.qc');
	    $(this).parents("#windows_ct").hide();
	    $(".bd_wd").hide(); 
	    return false;
	  }else{
	    $(this).parents("#windows_ct").hide();
	    $(".bd_wd").hide(); 
	    return false;
	  }  
	});
//删除添加的图片
	$('.delete').live('click',function(){
	  var id = $(this).attr('id');
	  $('li').remove('#li_'+id);
	  $('li').remove('#inp_'+id);
	});	
	
//上传照片_弹窗 Begin

	$(".tupian").click(function(){
        $(".filebox").show();
		$(".filebox ul li:eq(0)").show();
	});
	
	document.onclick = function (e) {
        var e = e ? e : window.event;
        var tar = e.srcElement || e.target;
        if (tar.type != "file"&&tar.className!="tupian"&&tar.tagName.toLocaleLowerCase()!="a") {
           $(".filebox").hide();
        }
    }
	
	$(".filebox ul li a").click(function(){
		var m=$(".filebox ul li a").index($(this))
		if(m!=4){
			$(this).parent("li").hide();
		}
		$(this).parent("li").find("input").val("");
	});	
	
	$(".filebox ul li input").change(function(){
		var texts = $(this).val();
		var i=$(".filebox ul li input").index($(this));
		if(texts != ""){
			$(".filebox ul li").eq(i+1).show();
			}
	});	

	$(".liulan").click(function(){
        $("#tcwindows_tp").show();
	});
	
	$(".close_tp a").click(function(){
		$(this).parents("#tcwindows_tp").hide();
	});
	
    $(".tipbox_tp ul li").hover(function(){ 
	
			$(this).children("span").css("display","block");
		 
		},function(){
			
			$(this).children("span").hide();
			
			}
		);
		
	 $(".tipbox_tp ul li span").click(function(){
		 
		 $(this).parent("li").remove();
		
		 });
		 
 $(".add").click(function(){
	
	var lengthbox = $(".tipbox_tp ul li").length;
	
		if(lengthbox<=5){	
			 $(this).parents("ul").children("li.last").before('<li class="filebox" ><input name="N' + ( lengthbox ++) + '" type="file"/><p>开始上传</p></li>');	
		}else{
				
			alert("对不起！您最多只能传5张。")
		}		 
	});	 
///////////////////////////////////////上传照片_弹窗 End	
	
//平台查询	
    $(".ptcx").click(function(){
	    $(".chuax1").select();
		$(".chuax1").val("");
		});
//打开登陆
	$(".hd_fix_rt2, .yidel").click(function(){
		$(".bd_wd").css("width", $(document).width());
        $(".bd_wd").css("height", $(document).height());
        $(".bd_wd").show();
        $("#tcwindows1").show();
	});

 //关闭弹出窗口	
	$(".close").click(function(){
		$(".input1").val(''); 
		$(".post2").val(''); 
		$(this).parents("#tcwindows1").hide();
		$(".bd_wd").hide();	
	});
	
 //查询最多
		$(".zuiduo li").hover(function(){
		$(this).children("a").stop(true,true).animate({"top": "-63"}, 300);
		},function(){
		$(this).children("a").stop(true,true).animate({"top": "0"}, 300);
		})
 //我要评论
    $('.wypll').click(function(){   
      var a = $(".fb_plbox").offset().top;
      $("html,body").animate({scrollTop:a}, 'slow'); 
      $("#saytext0").select();
      $("#saytext0").val("");
    });
//总数量切换
      var thisId = window.location.hash;
      if(thisId == "#basic_setting"){
        $(".p_bg").show();
        $(".p_pl").hide();
        $("#ss_mtbg").hide();
        $(".wdbgg").show();
        $(".wypll").hide();
      }else if(thisId == "#install_sql"){
        $(".p_pl").show();
        $(".p_bg").hide();
        $("#ss_mtbg").show();
        $(".wypll").show();
        $(".wdbgg").hide();
      }
      $("#link_install_sql").click(function(){
      	  var thisId = window.location.hash;
          if(thisId == "#install_sql"){
            $(".p_pl").show();
            $(".p_bg").hide();
            $("#ss_mtbg").show();
            $(".wypll").show();
            $(".wdbgg").hide();
          }
      });
      $("#link_basic_setting").click(function(){
      	  var thisId = window.location.hash;
          if(thisId == "#basic_setting"){
            $(".p_bg").show();
            $(".p_pl").hide();
            $("#ss_mtbg").hide();
            $(".wdbgg").show();
        	$(".wypll").hide();
          }
      });
	});
	
//查询动态		
$(function(){
	var le_height = $("#demo ol").height();
	if(le_height>278){
    var index = 0;
    var adtimer;
    var _wrap = $("#demo ol"); //
    var len = $("#demo ol li").length;
    //len=1;
    if (len > 1) {
        $("#demo").hover(function() {
            clearInterval(adtimer);
        },
        function() {
            adtimer = setInterval(function() {

                var _field = _wrap.find('li:first'); //此变量不可放置于函数起始处,li:first取值是变化的
                var _h = _field.height(); //取得每次滚动高度(多行滚动情况下,此变量不可置于开始处,否则会有间隔时长延时)
                _field.animate({
                    marginTop: -_h + 'px'
                },
                500,
                function() { //通过取负margin值,隐藏第一行
                    _field.css('marginTop', 0).appendTo(_wrap); //隐藏后,将该行的margin值置零,并插入到最后,实现无缝滚动
                })

            },
            2000);
        }).trigger("mouseleave");
        function showImg(index) {
            var Height = $("#demo").height();
            $("#demo ol").stop().animate({
                marginTop: -_h + 'px'
            },
            500);
        }

      }
    }
	
//企业认证	
	$(".tj_box_close").click(function(){		
		$(".tj_box, .tjsb_box").hide();		
	});	
	
//监管机构
	$(".yis1 ul li:last").css("border","none");
	$(".yis2 ul li:last").css("border","none");
	$(".tit li").hover(function(){
		$(this).parents("ul").children("li").removeClass("activ");
		$(this).addClass("activ");
		for(var i = 0; i < $(this).parents("ul").children("li").length; i++)
	{
		if($(this).parents("ul").children("li").eq(i).attr("class") == "activ")
	{
		$(this).parents("div.jigou").children("div.jg_nr").removeClass("show").addClass("hide");
		$(this).parents("div.jigou").children("div.jg_nr").eq(i).removeClass("hide").addClass("show");
			}
		}
	});		
	
//个人中心-- 修改个人信息 
	$(".xggrxx").click(function(){
		$(".tcwindows_grzx").show();
		});
	$(".qvxiao").click(function(){
		$(".tcwindows_grzx").hide();
		});	
		
//帮助中心--全部品种切换			
		
	$(".helps ul li").click(function(){
			$(".helps ul li").removeClass("actives");
			$(this).addClass("actives")
			$(this).children("div").show();
			
		});
		
	$(".helps ul li h3:last").css("border","none");
	
//主贴页面筛选切换
	$(".py_tit ul li").click(function(){
			$(".py_tit ul li").removeClass("activ");
			$(this).addClass("activ")	
	});
	
//找回密码--登录		
	$(".yidel").click(function(){		
		$("#longgin").show(); 	 
	})		
		
//认证平台推荐		
	$(".rzpttj ul li:last").css("border","none");		
//我要评论		
	$(window).scroll(function(){
		if ($(window).scrollTop()>655){
			$("#fixeds").addClass("fixeds");
		}else{
		    $("#fixeds").removeClass("fixeds");		 
		}
	});					 				 
//展开收起回复评论					 			 
$(".baoguan_pl2 dl.pinglubox dd.pinglubox_rt .hfpl_chd .timens p a.huifu_btn").each(function(){
	
	$(this).click(function(){
	 var val_tit = $(this).text();
		if(val_tit == "收起回复"){
			$(this).text("回复");
			$(this).removeClass("hfusd");
			$(this).parents(".hfpl_chd").children(".showhide").hide();
			$(this).parents(".hfpl_chd").find(".emem").show();
			$(this).parents(".hfpl_chd").find(".emem1").show();
			}else{
			$(this).text("收起回复");
			$(this).addClass("hfusd");
			$(this).parents(".hfpl_chd").children(".showhide").show();
			//$(this).parents(".hfpl_chd").children(".showhide").children('.fanbiaob').show();
			$(this).parents(".hfpl_chd").find(".emem").hide();
			$(this).parents(".hfpl_chd").find(".emem1").hide();
			}		
		});
	});	
});
/*失焦获焦*/
function inputTipText(){
	$("input[class*=common_text]") 
	.each(function(){
	   var oldVal=$(this).val();     
	   $(this)
	   .css({"color":"#c4c4c4"})    
	   .focus(function(){
	    	if($(this).val()!=oldVal){$(this).css({"color":"#c4c4c4"})}else{$(this).val("").css({"color":"#000"})}
		//$(this).css({"border":"1px solid #3b5998"})
	   })
	   .blur(function(){
	    	if($(this).val()==""){$(this).val(oldVal).css({"color":"#c4c4c4"})}
		//$(this).css({"border":"1px solid #dfdfdf"})
	   })
	   .keydown(function(){$(this).css({"color":"#000"})})	  	
	})
}

$(function(){
	inputTipText();    
})

function out(){ 
$('#bb').animate({top:'126'}, 500, function(){ 
$(this).css({display:'none', top:'126px'}); 
}); 
} 
 

/*返回顶部*/
$(document).ready(function(){
	//首先将#back-to-top隐藏
	$("#back-to-top").hide();
	//当滚动条的位置处于距顶部100像素以下时，跳转链接出现，否则消失
	$(function () {
	$(window).scroll(function(){
		if ($(window).scrollTop()>300){
			$("#back-to-top").fadeIn(1500);
		}
		else
		{
			$("#back-to-top").fadeOut(1500);
		}
	});
	//当点击跳转链接后，回到页面顶部位置
	$("#back-to-top").click(function(){
		$('body,html').animate({scrollTop:0},1000);
			return false;
		});
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