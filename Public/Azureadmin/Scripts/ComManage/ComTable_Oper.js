$(function () {
    initUploadify("fileComLogo", onUploadSuccess_ComLogo);
    initUploadify("fileComSLogo", onUploadSuccess_ComSLogo);
});

function initUploadify(id, funOnUploadSuccess) {
    $("#" + id).uploadify({
        'swf': resource+'/Scripts/Lib/uploadify/uploadify.swf',
        'buttonText': '上传图片',
        'buttonClass': 'btn btn-info btn-mini',
        'height': 30,
        'width': 80,
        'uploader': '/Uploadify/UpLoadImage.html',
        'formData': { 'comId': '' + $("#comId").val() + '' },
        'queueID': 'pop_editorFileQueue',
        'queueSizeLimit': 1,
        'auto': true,
        'multi': false,
        'removeCompleted': true,
        'fileSizeLimit': '10MB',
        'fileTypeDesc': 'Image Files',
        'fileTypeExts': '*.gif; *.jpg; *.png; *.bmp; *.jpeg',
        'onUploadSuccess': funOnUploadSuccess
    });
}

function onUploadSuccess_ComLogo(file, data, response) {
    if (response) {
        var image = new Image();
        image.src = data;
        image.onload = function () {
            if (image.width != 190 || image.height != 60) {
                require(["dialog"], function (dia) {
                    dia.ErrorBox("<p>图片的尺寸必须是 190px * 60px ！</p>");
                });
            } else {
                $("#ComLogo").attr("src", data);
                $("#hiddenComLogo").val(data);
            }
        };
    }
}

function onUploadSuccess_ComSLogo(file, data, response) {
    if (response) {
        var image = new Image();
        image.src = data;
        image.onload = function () {
            if (image.width != 120 || image.height != 120) {
                require(["dialog"], function (dia) {
                    dia.ErrorBox("<p>图片的尺寸必须是 120px * 120px ！</p>");
                });
            } else {
                $("#ComSLogo").attr("src", data);
                $("#hiddenComSLogo").val(data);
            }
        };
    }
}

function save() {
    if (!validForm()) {
        return;
    }
    $.ajax({
        type: "POST",
        url: "/ComManage/SaveComTable/",
        data: $('#operForm').serialize(),
        success: function (json) {
            require(["dialog"], function (dia) {
                if (json.msg == "") {
                    dia.SuccessBox("保存成功.", function () {
                        parent.window.location.reload();
                    });
                } else {
                    dia.ErrorBox("保存失败.");
                }
            });
        },
        error: function () {
            require(["dialog"], function (dia) {
                dia.ErrorBox("保存失败.");
            });
        }
    });
}

function validForm() {
    //热线电话
    var comPhone = $("#ComPhone");
    if (comPhone.val() == "") {
        $("#valid_" + comPhone.attr("id")).html("请输入热线电话");
    } else {
        var phone = new RegExp(/\d{3}-\d{8}$|\d{4}-\d{7}$|^400\d{6,7}$|^400-\d{3}-\d{3,4}$/);
        if (phone.test(comPhone.val())) {
            $("#valid_" + comPhone.attr("id")).html("");
        } else {
            $("#valid_" + comPhone.attr("id")).html("电话格式:0901-88888888、010-88888888<br />400xxxxxxx、400-xxx-xxxxx");
        }
    }
    //企业邮箱
    var comEmail = $("#ComEmail");
    if (comEmail.val() == "") {
        $("#valid_" + comEmail.attr("id")).html("请输入企业邮箱");
    } else {
        var email = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
        if (email.test(comEmail.val())) {
            $("#valid_" + comEmail.attr("id")).html("");
            //return true;
        } else {
            $("#valid_" + comEmail.attr("id")).html("邮箱格式:someone@example.com");
        }
    }
    //联系人
    var comLine = $("#ComLine");
    if (comLine.val() == "") {
        $("#valid_" + comLine.attr("id")).html("请输入联系人");
    } else {
        $("#valid_" + comLine.attr("id")).html("");
        //return true;
    }
    //联系电话
    var comMob = $("#ComMob");
    if (comMob.val() == "") {
        $("#valid_" + comMob.attr("id")).html("请输入联系电话");
    } else {
        var mobile = /(^(\d{3,4}-)\d{7,8}$)|^1[3|4|5|8][0-9]\d{8}$/;
        if (mobile.test(comMob.val())) {
            $("#valid_" + comMob.attr("id")).html("");
            //return true;
        } else {
            $("#valid_" + comMob.attr("id")).html("请输入正确的手机号码");
        }
    }
    //邮箱
    var comMail = $("#ComMail");
    if (comMail.val() == "") {
        $("#valid_" + comMail.attr("id")).html("请输入邮箱");
    } else {
        //var email = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
        if (email.test(comMail.val())) {
            $("#valid_" + comMail.attr("id")).html("");
            //return true;
        } else {
            $("#valid_" + comMail.attr("id")).html("邮箱格式:someone@example.com");
        }
    }
    //地址
    var comAddress = $("#ComAddress");
    if (comAddress.val() == "") {
        $("#valid_" + comAddress.attr("id")).html("请输入地址");
    } else {
        $("#valid_" + comAddress.attr("id")).html("");
        //return true;
    }
    var b = true;
    $("div[id^='valid_']").each(function () {
        if ($(this).html() != "") {
            b = false;
        }
    });

    return b;
}