var sWidth = 740;
var index = 0;
var picTimer;
function init()
{
    var len = $("#slider_name .silder_panel").length;
    $(".silder_panel").width(sWidth);
    $(".silder_panel a").width(sWidth);
    $("#slider_name .silder_nav li").css({ "opacity": "0.6", "filter": "alpha(opacity=60)" }).mouseover(function () {
        index = $("#slider_name .silder_nav li").index(this);
        showPics(index);
    }).eq(0).trigger("mouseover"); 
    $("#slider_name .silder_con").css("width", sWidth * (len));
    // mouse 
    $("#slider_name").hover(function () {
        clearInterval(picTimer);
    }, function () {
        picTimer = setInterval(function () {
            showPics(index);
            index++;
            if (index == len) { index = 0; }
        }, 2000);
    }).trigger("mouseleave");

}
/*
$(function () {
    init();
    window.onresize = function () {
        sWidth = 740;
    }
});
*/
function showPics(index) {
    var nowLeft = -index * 740;
		$("#slider_name .silder_con").stop(true,false).animate({"left":nowLeft},300);
		$("#slider_name .silder_nav li").removeClass("current").eq(index).addClass("current"); 
		$("#slider_name .silder_nav li").stop(true,false).animate({"opacity":"1"},300).eq(index).stop(true,false).animate({"opacity":"1"},300);
		
        $("#slider_name .silder_h3 li").removeClass("current").eq(index).addClass("current"); 
}
