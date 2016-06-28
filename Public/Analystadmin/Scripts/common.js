/*--------------------------------------------扩展方法--------------------------------------------*/
String.prototype.trim = function () {
    if (arguments.length > 0) {
        var rstr = this;
        var arg = "";
        for (var i = 0; i < arguments.length; i++) {
            arg = arguments[i];
            //将字符串中出现的元字符进行转义
            arg = eleContains(arg);
            //正则删除前后匹配的字符
            rstr = rstr.replace(eval("/(^" + arg + "*)|(" + arg + "*$)/g"), "");
        }
        return rstr;
    }
    else
        return this.replace(/(^\s*)|(\s*$)/g, "");

    //将字符串中出现的元字符进行转义
    function eleContains(arg) {
        var elestr = "$(*+.[?\^{|";
        if (arg.length == 1) {
            if (elestr.indexOf(arg) > -1) {
                arg = "\\" + arg;
            }
            else if (arg == " ") {
                arg = "\\s";
            }
        }
        else if (arg.length > 1) { //删除多个字符
            var elearray = elestr.split("");
            for (var i = 0; i < elearray.length; i++) {
                if (arg.indexOf(elearray[i]) > -1)
                    arg = arg.replace(eval("/\\" + elearray[i] + "/g"), "\\" + elearray[i]);
                else if (arg.indexOf(" ") > -1)
                    arg = arg.replace(" ", "\\s");
            }
        }
        return arg;
    };
};
//日期格式化函数
Date.prototype.format = function (format) {
    var o =
    {
        "M+": this.getMonth() + 1, //month
        "d+": this.getDate(),    //day
        "H+": this.getHours(),   //hour
        "m+": this.getMinutes(), //minute
        "s+": this.getSeconds(), //second
        "q+": Math.floor((this.getMonth() + 3) / 3),  //quarter
        "S": this.getMilliseconds() //millisecond
    }
    if (/(y+)/.test(format))
        format = format.replace(RegExp.$1, (this.getFullYear() + "").substr(4 - RegExp.$1.length));
    for (var k in o)
        if (new RegExp("(" + k + ")").test(format))
            format = format.replace(RegExp.$1, RegExp.$1.length == 1 ? o[k] : ("00" + o[k]).substr(("" + o[k]).length));
    return format;
};
//计算时间与当前时间的距离
Date.prototype.getTimeSpan = function () {
    var timespan = (new Date() - this);

    if (timespan < (24 * 60 * 60 * 1000)) {
        if (timespan > (60 * 60 * 1000)) {
            if (arguments.length >= 1)
                return this.format(arguments[0]);
            else {
                return this.format("yyyy-MM-dd HH:mm");
            }
        }
        if (timespan > (60 * 1000)) return parseInt(timespan / (60 * 1000)) + "分钟前";
        return (parseInt(timespan / 1000) > 2 ? parseInt(timespan / 1000) : 2) + "秒前";
    }

    if (arguments.length >= 1)
        return this.format(arguments[0]);
    else {
        return this.format("yyyy-MM-dd HH:mm");
    }
};

/*--------------------------------------------公共方法--------------------------------------------*/
var CommonFn = {
    //货币格式化
    formatCurrency: function (num) {
        num = num.toString().replace(/\$|\,/g, '');
        if (isNaN(num))
            num = "0";
        sign = (num == (num = Math.abs(num)));
        num = Math.floor(num * 100 + 0.50000000001);
        cents = num % 100;
        num = Math.floor(num / 100).toString();
        if (cents < 10)
            cents = "0" + cents;
        for (var i = 0; i < Math.floor((num.length - (1 + i)) / 3) ; i++)
            num = num.substring(0, num.length - (4 * i + 3)) + ',' +
            num.substring(num.length - (4 * i + 3));
        return (((sign) ? '' : '-') + num + '.' + cents);
    },
    //加入收藏
    addfavorite: function () {
        try {
            if (document.all) {
                window.external.addFavorite(window.location.hostname, document.title);
            }
            else if (window.sidebar) {
                window.sidebar.addPanel(document.title, location.hostname, "");
            }
        }
        catch (e) {
            alert("加入收藏失败，请使用Ctrl+D进行添加");
        }
    },
    getQueryString: function (name) {
        var reg = new RegExp("(^|&)" + name + "=([^&]*)(&|$)", "i");
        var r = window.location.search.substr(1).match(reg);
        if (r != null) return unescape(r[2]);
        return null;
    },

    toFloat: function (str, length) {
        length = length || 2;
        if (str) {
            var a = parseFloat(str);
            return a.toFixed(length);
        }
    },
    toDate: function (str) {
        return new Date(Date.parse(str.replace(/-/g, "/")));
    },
    toDateFromJson: function (obj) {
        obj = eval("new Date(" + obj.replace(/[^\d]/g, "") + ")");
        return obj;
    },
    clearHtml: function (strhtml) {
        var stroutput = strhtml;
        var reg = /<[^>]+>|<\/[^>]+>/ig;
        stroutput = stroutput.replace(reg, "");
        return stroutput;
    },
    cutStr: function (length, strInput) {
        if (strInput == null) {
            return "";
        }
        else {
            var chineseReg = /[\u4E00-\u9FA5\uF900-\uFA2D]/ig;

            if (!chineseReg.test(strInput)) {
                if (strInput.length < length)
                    return strInput;
                else
                    return strInput.substr(0, length) + "...";
            }
            else {
                var checkstr = strInput.replace(chineseReg, "**");
                if (checkstr.length < length)
                    return strInput;
                else {
                    var strOut = "";
                    var strLength = 0;
                    for (var i = 0; i < strInput.length; i++) {
                        if (strLength >= length)
                            break;
                        strOut += strInput.substr(i, 1);
                        if (!chineseReg.test(strInput.substr(i, 1)))
                            strLength += 1;
                        else
                            strLength += 2;
                    }
                    return strOut.toString() + "...";
                }
            }
        }
    },
    clearImgTag: function (strhtml) {
        return strhtml.replace(/(<img\s([^>]{0,})>)/gi, "*");
    },
    getCookie: function (name) {
        var value = "";
        var cookie = ";" + document.cookie.replace(/;\s+/g, ";") + ";"
        var pos = cookie.indexOf(";" + name + "=");
        if (pos > -1) {
            var start = cookie.indexOf("=", pos);
            var end = cookie.indexOf(";", start);
            value = unescape(cookie.substring(start + 1, end));
        }
        return value;
    }
};

/*--------------------------------------------AJAX全局设置--------------------------------------------*/
$.ajaxSetup({
    cache: false
});