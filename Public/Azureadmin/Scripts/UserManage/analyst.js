$(function () {
    Bind_ComAdminLTE();
});

function Bind_ComAdminLTE() {
    $.post("/UserManage/Bind_ComAdminLTE/", function (json) {
        //
        if (json.Adavatar != "") {
            $("#Adavatar").attr("src", json.Adavatar);
        }
        //
        var comAdminLTE = json.ComAdminLTE;
        for (var key in comAdminLTE) {
            $("#" + key).html(comAdminLTE[key]);
        }
    });
}

var dia_edit;
function EditComAdminLTE() {
    $.ajax({
        async: false,
        type: "post",
        url: '/UserManage/Bind_Edit_ComAdminLTE?id=' + $("#lblAdminId").html(),
        success: function (json) {
            require(["dialog"], function (dia) {
                dia_edit = dia.LoadEle(json.html);
                initUploadify();
            });
        },
        error: function () {
            alert("ajax出错。");
        }
    });


}

function initUploadify() {
    $("#imgfile").uploadify({
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
        'onSelect': function (file) {
            var image = new Image();
        },
        'onUploadSuccess': function (file, data, response) {
            if (response) {
                var image = new Image();
                image.src = data;
                image.onload = function () {
                    if (image.width != image.height || image.width != 136) {
                        require(["dialog"], function (dia) {
                            dia.ErrorBox("<p>图片的尺寸必须是 136px * 136px ！</p>");
                        });
                    } else {
                        $("#Adavatar").attr("src", data);
                    }
                }

            }
        }
    });
}

function SaveComAdminLTE(id) {
    var parm = {
        AdminId: id,
        Adavatar: $("#Adavatar").attr("src"),
        AdminName: $("#AdminName").val(),
        ComTLevel: $("#ComTLevel").val(),
        ComTStyle: $("#ComTStyle").val(),
        ComTIntro: $("#ComTIntro").val()
    };
    $.post("/UserManage/SaveComAdminLTE", parm, function (json) {
        if (json.msg == "") {
            require(["dialog"], function (dia) {
                dia.Close(dia_edit);
                //刷新
                Bind_ComAdminLTE();
                dia.SuccessBox("编辑成功.");
            });
        } else {
            require(["dialog"], function (dia) {
                dia.ErrorBox("编辑失败.");
            });
        }
    });
}
