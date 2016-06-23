// JavaScript Document

	$(document).ready(function(){		
		$(".listbox ul li:nth-child(3n)").css({borderRight:"0",width:"316px"});		
		$(".news_wx").hover(function(){
			$(".news_wx .news_wx_ex span.close").show();
		},function(){	
			$(".news_wx .news_wx_ex span.close").hide();		
		});
		$(".news_wx .news_wx_ex span.close").click(function(){
			$(".news_wx").hide();	
		});					
	});
    $(window).scroll(function(){
	    if ($(window).scrollTop()>615){
	        $(".news_wx").addClass("fixbox");
	    }else{
		    $(".news_wx").removeClass("fixbox");
		   
		}
	});	