$(function () {
    initUploadify("fileComLogo", onUploadSuccess_ComLogo);
    initUploadify("fileComSLogo", onUploadSuccess_ComSLogo);
});

function initUploadify(id, funOnUploadSuccess) {
    $("#" + id).uploadify({
        'swf': '../../Scripts/Lib/uploadify/uploadify.swf',
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
    $.ajax({
        type: "POST",
        url: "/ComManage/SaveComTable_Logo/",
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