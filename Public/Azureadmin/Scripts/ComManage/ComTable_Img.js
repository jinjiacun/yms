$(document).ready(function () {
    initUploadify();

    $("#btnSava").click(function () {
        var bannerLink = "";
        $.each($("input[name='BannerLink']"), function (i, o) {
            bannerLink += "|" + $(o).val();
        });
        $.ajax({
            url: controller+"/ComManage/SavaCom_Img.html",
            type: "post",
            data: { comid: $("#comId").val(), comMin: $("input[name='ComMin']:checked").val(), bannerLink: bannerLink },
            success: function (data) {
                if (data.success) {
                    require(["dialog"], function (dia) {
                        dia.MsgBox("succeed", "<p>保存成功</p>", null, 2);
                    });
                }
            }
        });
    });
});

function initUploadify() {
    $("#imgfile").uploadify({
        'swf': resource+'/Scripts/Lib/uploadify/uploadify.swf',
        'buttonText': '上传图片',
        'buttonClass': 'btn btn-info btn-mini',
        'height': 30,
        'width': 80,
        'uploader': controller+'/Uploadify/UpLoadImage_Focus.html',
        //'formData': { 'comId': '' + $("#comId").val() + '', 'comMin': '' + $("#hideComMin").val() + '' },这里的参数只能是静态的
        'queueID': 'pop_editorFileQueue',
        'queueSizeLimit': 0,
        'auto': true,
        'multi': true,
        'removeCompleted': true,
        'fileSizeLimit': '10MB',
        'fileTypeDesc': 'Image Files',
        'fileTypeExts': '*.gif; *.jpg; *.png; *.bmp; *.jpeg',
        'onSelect': function (file) {
            var image = new Image();
        },
        'onUploadStart': function (file) {
            $("#imgfile").uploadify("settings", "formData", { 'comId': '' + $("#comId").val() + '', 'comMin': '' + $("input[name='ComMin']:checked").val() + '' });
            //在onUploadStart事件中，也就是上传之前，把参数写好传递到后台。  
        },
        'onUploadSuccess': function (file, data, response) {
            if (response) {
                //2014-09-22 By Ewen Bgin
                var verify = true;
                switch (data) {
                    case "0":
                        require(["dialog"], function (dia) {
                            dia.MsgBox("error", "<p>系统错误，请稍后重试！</p>", null, 10);
                        });
                        verify = false;
                        break;
                    case "1":
                        require(["dialog"], function (dia) {
                            dia.MsgBox("error", "<p>矮背景图的尺寸必须是 1400px * 220px</p>", null, 10);
                        });
                        verify = false;
                        break;
                    case "2":
                        require(["dialog"], function (dia) {
                            dia.MsgBox("error", "<p>高背景图的尺寸必须是 1000px * 380px</p>", null, 10);
                        });
                        verify = false;
                        break;
                    default:
                        verify = true;
                        break;
                }
                if (!verify) {
                    return false;
                }
                var chk = $("input[name='ComMin']:checked").val();
                var imgType = "高类型图片";
                if (chk == "1") {
                    imgType = "矮类型图片";
                }
                $("#divImg").append("<div class=\"widget-content\"><span style='color: #666;font-family:微软雅黑'>" + imgType + "</span>&nbsp;<img width='1000' src='" + data + "' />&nbsp;&nbsp;<button type=\"button\" class=\"btn btn-danger\" onclick=\"delImg(this);\">删除</button><p style='margin-top: 10px;'><span style='position: relative; bottom: 5px;'>图片链接地址：</span><input type='text' name='BannerLink' value='' style='width: 800px;' /></p></div>");
            }
        }
    });


    $("#loginBack").uploadify({
        'swf': resource+'/Scripts/Lib/uploadify/uploadify.swf',
        'buttonText': '上传图片',
        'buttonClass': 'btn btn-info btn-mini',
        'height': 30,
        'width': 80,
        'uploader': controller+'/Uploadify/UpLoadImage_Login.html',
        'formData': { 'comId': '' + $("#comId").val() + '' },
        'queueID': 'pop_editorFileQueue',
        'queueSizeLimit': 0,
        'auto': true,
        'multi': true,
        'removeCompleted': true,
        'fileSizeLimit': '10MB',
        'fileTypeDesc': 'Image Files',
        'fileTypeExts': '*.gif; *.jpg; *.png; *.bmp; *.jpeg',
        'onSelect': function (file) {
            var image = new Image();
        },
        'onUploadSuccess': function (file, data, response) {
            if (response) {
                if (data == "0") {
                    require(["dialog"], function (dia) {
                        dia.MsgBox("error", "<p>系统错误，请稍后重试！</p>", null, 10);
                    });
                    return false;
                }
                if (data == "1") {
                    require(["dialog"], function (dia) {
                        dia.MsgBox("error", "<p>登录背景图的尺寸必须是 430px * 360px</p>", null, 10);
                    });
                    return false;
                }
                $("#backImg").attr("src", data).parent().show();
            }
        }
    });

}

function showPic(obj) {
    require(["dialog"], function (dia) {
        dia.LoadImg($(obj).find("img").attr("src"));
    });
}

function delImg(obj) {
    require(["dialog"], function (dia) {
        dia.ConfirmBox("<div style='padding:10px;'>您确定删除这张图片吗?<div>", "确定", function () {
            //数据库删除
            var url = $(obj).prev().attr("src");
            var link = $(obj).next().find("input").val();
            $.post(controller+"/ComManager/DeleteImage_Focus/", { url: url, link: link }, function (json) {
                if (json.res == 1) {
                    //页面移除
                    $(obj).parent().remove();
                } else {
                    require(["dialog"], function (dia) {
                        dia.ErrorBox("<p>删除失败.</p>");
                    });
                }
            });
        }, "取消", function () {

        }, "warning");
    });
}


//2014-09-28 By Ewen
$(function () {
    setImgType();
});

function setImgType() {
    $("#divImg img").each(function () {
        var image = new Image();
        image.src = $(this).attr("src");
        var imgType = "";
        if (image.width == 1000 && image.height == 380) {
            imgType = "高类型图片";
        } if (image.width == 1400 && image.height == 220) {
            imgType = "矮类型图片";
        }
        $(this).prev().html(imgType);
    });
}