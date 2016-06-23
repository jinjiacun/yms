// JavaScript Document
//评论切换
$(function(){
	
	var text_area =$(".wypl_wypl2 textarea").val();	
	$(".plbox1").click(function(e){
		
		if(text_area ==""){
		
			$(this).hide();	
			$(".plbox2").show();
			$("#saytext0").select();
            $("#saytext0").val("");
		};
		e.stopPropagation();			
	});	
	document.onclick = function (e) {
        var e = e ? e : window.event;
        var tar = e.srcElement || e.target;
		if($(tar).parents(".plbox2").length>0 || $(".wypl_wypl2 textarea").val()!="")
		{
			return;
		}
		$(".plbox2").hide();
		$(".plbox1").show();
    }
    //评论切换--end//
});