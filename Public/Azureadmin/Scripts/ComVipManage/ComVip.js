function EditVipState(CVipId, VipState, strVipState) {
    require(["dialog"], function (dia) {
        dia.ConfirmBox("<div style='padding:10px;'>您确定要【" + strVipState + "】该等级吗？<div>", "确定", function () {
            $.post("/ComVipManage/EditVipState", { CVipId: CVipId, VipState: VipState }, function (json) {
                if (json.msg == "") {
                    require(["dialog"], function (dia) {
                        refurbishCurrentPage();
                        dia.SuccessBox("编辑成功.");
                    });
                } else {
                    require(["dialog"], function (dia) {
                        dia.ErrorBox("编辑失败.");
                    });
                }
            });
        }, "取消", function () {
        }, "warning");
    });
}

var dia_edit;
function EditComVip(CVipId) {
    $.ajax({
        type: "post",
        url: '/ComVipManage/Bind_Edit_ComVip?CVipId=' + CVipId,
        success: function (json) {
            require(["dialog"], function (dia) {
                dia_edit = dia.LoadEle(json.html);
            });
        },
        error: function () {
            alert("ajax出错。");
        }
    });
}

function SaveComVip(CVipId) {
    var parm = { CVipId: CVipId, VipName: $("#VipName").val(), CVipIntro: $("#CVipIntro").val() };
    $.post("/ComVipManage/SaveComVip", parm, function (json) {
        if (json.msg == "") {
            require(["dialog"], function (dia) {
                dia.Close(dia_edit);
                refurbishCurrentPage();
                dia.SuccessBox("编辑成功.");
            });
        } else {
            require(["dialog"], function (dia) {
                dia.ErrorBox("编辑失败.");
            });
        }
    });
}

function refurbishCurrentPage() {
    var page = $(".dataTables_wrapper").find("a[currpage]").attr("currpage");
    $("#grid").load(window.location.href + '?page=' + page + " #grid");
}