define(['artDialog'], function () {
    function Close(dialogObj) {
        if (typeof (dialogObj) == "object") {
            dialogObj.close();
        }
        else if (typeof (dialogObj) == "string") {
            var obj = $.dialog.get(dialogObj);
            obj.close();
            setTimeout(function () { obj.remove(); }, 1000);
        }
    }

    function LoadImg(url) {
        var bigImgId = "bigImg" + Math.random().toString().substr(2);
        var imgHtml = "<div style='padding:10px;'><img style='max-width:1200px;max-height:700px;' src='"+resource+"/Scripts/Lib/artDialog/skins/icons/loading.gif' id='" + bigImgId + "'/></div>";
        var pop_Img = LoadEle(imgHtml, null, null);
        var img = new Image();
        img.onload = function () {
            var $img = $("#" + bigImgId);
            $img.attr("width", img.width);
            $img.attr("height", img.height);
            $img.attr("src", img.src);
            pop_Img._reset();
        }
        img.src = url;
    }

    function LoadEle(htmcode, initfunc, close_callback) {
        return $.dialog({
            id: "LoadEle" + Math.random(),
            fixed: true,
            content: htmcode,
            lock: true,
            background: '#000',
            opacity: 0.3,
            title: false,
            esc: true,
            close: function () {
                if (typeof (close_callback) == "function")
                    close_callback();
            },
            init: typeof (initfunc) == "function" ? initfunc : null
        });
    }

    function RefreshPage(msg, callback) {
        var popRpForm = $.dialog({
            id: "RefreshPage" + Math.random(),
            content: "<div style=\"padding:30px 50px;color:#666;\">" + msg + "</div>",
            time: 2000,
            cancel: false,
            drag: false,
            init: function () {
                if (typeof (callback) == "function") {
                    callback();
                }
                else
                    setTimeout(function () { window.location.reload(); }, 500);
            }
        });
        return popRpForm;
    }

    function ConfirmBox(html, okStr, okfun, cancelStr, cancelfun, icon) {
        $.dialog({
            id: "ConfirmBox" + Math.random(),
            lock: true,
            icon: icon,
            background: '#000',
            opacity: 0.3,
            content: html,
            okVal: okStr,
            ok: okfun,
            cancelVal: cancelStr,
            cancel: cancelfun
        });
    }

    function MsgBox(icon, txt, close_callback, time) {
        return $.dialog({
            id: "MsgBox" + Math.random(),
            icon: icon,
            content: txt,
            background: '#000',
            opacity: 0.3,
            time: time || 1,
            lock: true,
            close: function () {
                if (typeof (close_callback) == "function")
                    close_callback();
            }
        });
    }

    function SuccessBox(txt, close_callback) {
        MsgBox("succeed", txt, close_callback, 1);
    }
    function ErrorBox(txt, close_callback) {
        MsgBox("error", txt, close_callback, 1);
    }
    function ShowTip(msg) {
        var popRpForm = $.dialog({
            id: "ShowTip" + Math.random(),
            content: "<div style=\"padding:30px 50px;color:#666;\">" + msg + "</div>",
            cancel: false,
            drag: false,
            lock: true,
            background: '#000',
            opacity: 0.3
        });
        return popRpForm;
    }
    function OpenIframe(url, iframeOps, options) {
        var defaults = {
            id: "OpenIframe" + Math.random(),
            fixed: true,
            lock: true,
            background: '#000',
            opacity: 0.3,
            title: false,
            esc: true,
            content: '<iframe src="' + url + '"' + iframeOps + '></iframe>'
        };
        options = $.extend({}, defaults, options);
        return $.dialog(options);
    }
    return {
        Close: Close,
        LoadImg: LoadImg,
        LoadEle: LoadEle,
        RefreshPage: RefreshPage,
        ConfirmBox: ConfirmBox,
        MsgBox: MsgBox,
        SuccessBox: SuccessBox,
        ErrorBox: ErrorBox,
        ShowTip: ShowTip,
        OpenIframe: OpenIframe
    };
});