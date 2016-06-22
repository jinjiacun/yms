// JavaScript Document
//结果页面tab切换
//jQuery.noConflict();
function jQuery(id) {
    return document.getElementById(id);
}
function createFunction(obj, strFunc) {
    var args = [];
    if (!obj) obj = window;
    for (var i = 2; i < arguments.length; i++) args.push(arguments[i]);
    return function () {
        obj[strFunc].apply(obj, args);
    }
}
function addEvent(obj, type, fn) {
    if (obj.attachEvent) {
        obj.attachEvent('on' + type, fn);
    } else
        obj.addEventListener(type, fn, false);
}
function monitHashChange(hashChangeFire) {
    var hash = window.location.hash.substring(1);
    if (('onhashchange' in window)
        && ((typeof document.documentMode === 'undefined')
        || document.documentMode == 8)) {
        window.onhashchange = function () {
            hashChangeFire(window.location.hash.substring(1));
        };
    } else {
        setInterval(function () {
            var ischanged = hash != window.location.hash.substring(1);
            if (ischanged) {
                hash = window.location.hash.substring(1);
                hashChangeFire(hash);
            }
        }, 150);
    }
}
function show_panel(link) {
    link = typeof (link) == "string" ? link : link.id.replace("link_", "");
    window.location.hash = link;
    if (link.length == 0)
        link = "install_sql";
    var links = ["install_sql", "basic_setting"];
    for (var i = 0; i < links.length; i++) {
        var n = links[i];
        if (n == link) {
            jQuery("link_" + n).setAttribute("class", "activ");
            jQuery("div_" + n).style.display = "block";
        }
        else {
            jQuery("link_" + n).removeAttribute("class");
            jQuery("div_" + n).style.display = "none";
        }
    }
}
var link = (!window.location.hash) ? "install_sql" : window.location.hash.substring(1);
addEvent(window, "load", createFunction(null, "show_panel", link));
addEvent(window, "load", createFunction(null, "monitHashChange", show_panel));

	
	