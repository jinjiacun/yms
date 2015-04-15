// JavaScript Document

$(function(){
	
//首页搜索
   $(".searchbox ul li").click(function(){
	   $(".searchbox ul li").removeClass("active");
	   $(this).addClass("active");
	   
	   });

//头部fix
   $(window).scroll(function(){
	   if ($(window).scrollTop()>44){
	   $(".header_fixbox").addClass("fixbox");
	   }
	   else{
		    $(".header_fixbox").removeClass("fixbox");;
		   
		   }
   });

//上传照片_弹窗 Begin
	$(".tupian, .liulan").click(function(){
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
		$(".chuax1").val("")
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
		$(this).parents("#tcwindows1").hide();
		$(".bd_wd").hide();	
	});
	
 //查询最多
		$(".zuiduo li").hover(function(){
		$(this).children("a").stop(true,true).animate({"top": "-63"}, 300);
		},function(){
		$(this).children("a").stop(true,true).animate({"top": "0"}, 300);
		})


/////////////////////////////////////////////////曝光动态
   var le_height = $(".dongtai ol").height();
   if(le_height>685){
    var index = 0;
    var adtimer;
    var _wrap = $(".dongtai ol"); //
    var len = $(".dongtai ol li").length;
    //len=1;
    if (len > 1) {
        $(".dongtai").hover(function() {
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
            3000);
        }).trigger("mouseleave");
        function showImg(index) {
            var Height = $(".dongtai").height();
            $(".dongtai ol").stop().animate({
                marginTop: -_h + 'px'
            },
            1000);
        }


    }
	
 }
	
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
			 }
			 else{
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
			}else{
			$(this).text("收起回复");
			$(this).addClass("hfusd");
			$(this).parents(".hfpl_chd").children(".showhide").show();
			}
		
		
		});
	
	
	});				 
				 
				 	
		
	
	});
	

	
	