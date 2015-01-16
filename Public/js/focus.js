//Tab切换
$(function() {
    //全局
    $(".tab_main").each(function(_tab) {
        $(".tab_main:eq(" + _tab + ") .tab_main_li:eq(0)").show();
        $(".tab_main:eq(" + _tab + ") .tab_main_a a").each(function(i) {
            $(this).mouseover(function() {
                $(".tab_main:eq(" + _tab + ") .tab_main_a a").removeClass();
                $(this).addClass("on");
                $(".tab_main:eq(" + _tab + ") .tab_main_li:visible").hide();
                $(".tab_main:eq(" + _tab + ") .tab_main_li:eq(" + i + ")").show();
            });
        });
    });
});

//幻灯片
$(function() {
    var delay_time = 1;
    //全局
    $(".pic_main").each(function(_pic) {
        var totalnum = $(".pic_main:eq(" + _pic + ") .pic_li li").length;
        var index = 0;
        $('.pic_main:eq(" + _pic + ") .pic_li li:eq(0)').fadeIn(delay_time);
        $(".pic_main:eq(" + _pic + ") .pic_a span").eq(0).addClass("on");
        $(".pic_main:eq(" + _pic + ") .pic_a span").mouseover(function() {
            //经过切换
            index = $(".pic_main:eq(" + _pic + ") .pic_a span").index(this);
            showImg(index);
        });
        var MyTime = setInterval(function() {
            //自动切换
            index++;
            if (index >= totalnum) {
                index = 0;
            }
            showImg(index);
        }, 5e3);
        function showImg(i) {
            //图片显示
            $(".pic_main:eq(" + _pic + ") .pic_li li").fadeOut(delay_time).eq(i).fadeIn(delay_time);
            $(".pic_main:eq(" + _pic + ") .pic_a span").eq(i).addClass("on").siblings().removeClass("on");
        }
        $(".pic_main:eq(" + _pic + ") .pic_li").hover(function() {
            //经过暂停 离开自动播放
            clearInterval(MyTime);
        }, function() {
            MyTime = setInterval(function() {
                index++;
                if (index >= totalnum) {
                    index = 0;
                }
                showImg(index);
            }, 5e3);
        });
    });
});

//首页新品发布
$(function() {
    $(".home_xpfb_ri li").hover(function() {
        $(this).addClass("on");
    }, function() {
        $(".home_xpfb_ri li").removeClass("on");
    });
    $(".home_xpfb_ri li:gt(2)").css({
        "border-bottom":"1px solid #dfdfdf","border-top":"none"
    });
     $(".home_xpfb_ri li:eq(2),.home_xpfb_ri li:eq(5)").css({
       "border-right":"none"
    });
    //礼品专区
     $(".home_lpzq_ul li").hover(function() {
        $(this).addClass("on");
    }, function() {
        $(".home_lpzq_ul li").removeClass("on");
    });
    
});

//指定属性
$(function() {
    $(".nav_top img").click(function() {
        $("body,html").animate({
            scrollTop:0
        }, 500);
    });
    $('.list_title li:last').css({border:'none'});
        var list_ri= $('.list_main').height();
        $('.list_main').height(list_ri-1);
});

$(function() {
    $(".nnav .left a:last").css("border", "none");
});

//浮动导航
$(function() {
    $(window).scroll(function() {
        var src_top = $(window).scrollTop();
        if (src_top < 132) {
            $(".AreaL").stop().animate({
                top:"0"
            },90);
        }
		if(src_top>2416){
			  $(".AreaL").stop().animate({top:"2284px"});
			  if($.browser.mozilla){
				   $(".AreaL").stop().animate({top:"2307px"});
				}
			}
		if(src_top>132 && src_top<2416) {
            $(".AreaL").stop().animate({
                top:src_top-132 + "px"
            },90);
        }
    });
});

//首页幻灯片
$(function() {
    var totalnum = $(".banner li").length;
    var index = 0;
    $(".banner li:eq(0)").show();
    $(".bth span").eq(0).addClass("on");
/*    $(".bth span").mouseover(function() {
        //经过切换
        index = $(".bth span").index(this);
        showImg(index);
    });
	
*/  
 
 
 $(".bth span").mouseover(function() {
        //经过切换
		if($(this).hasClass('on')){
			//index = $(".bth span").index(this);
       		//showImg(index);
			
        } else{
			index = $(".bth span").index(this);
			showImg(index);
			 }
    });
	
	
	

  var MyTime = setInterval(function() {
        //自动切换
        index++;
        if (index >= totalnum) {
            index = 0;
        }
        showImg(index);
    }, 5e3);
    function showImg(i) {
        //图片显示
        $(".banner li").fadeOut(300).eq(i).fadeIn(600);
        $(".bth span").eq(i).addClass("on").siblings().removeClass("on");
    }
    $(".banner").hover(function() {
        //经过暂停 离开自动播放
        clearInterval(MyTime);
    }, function() {
        MyTime = setInterval(function() {
            index++;
            if (index >= totalnum) {
                index = 0;
            }
            showImg(index);
        }, 5e3);
    });
});



$(function(){
    $('.home_lpzq_ul li,.home_xpfb_ri li').hover(function(){
            $(this).find('img.shop_b').show();
            $(this).find('img.shop_a').hide();
        },function(){
                $(this).find('img.shop_a').show();
                $(this).find('img.shop_b').hide();
            })  
});