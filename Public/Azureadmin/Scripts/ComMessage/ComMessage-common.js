
var dia_messageContent;
function ShowMessage(id) {
    $.post(controller+"/ComMessage/GetMessageContent/", { id: id }, function (json) {
        require(["dialog"], function (dia) {
            dia_messageContent = dia.LoadEle(json.html);
            if (json.isRefurbish) {
                $("#i_" + id).remove();
                if (window.GetComMessageCount) {
                    GetComMessageCount();
                }
            }
        });
    });
}

function DeleteOne(id) {
    FunDel("您确定要删除这条消息吗?", id);
}

function FunDel(tips, ids) {
    require(["dialog"], function (dia) {
        dia.ConfirmBox("<div style='padding:10px;'>" + tips + "<div>", "确定", function () {
            dia.Close(dia_messageContent);
            $.post(controller+"/ComMessage/DeleteMessage/", { ids: ids }, function (json) {
                if (json.msg == "") {
                    dia.SuccessBox("删除成功.");
                    //刷新
                    refurbishCurrentPage();
                } else {
                    dia.ErrorBox("删除失败.");
                }
            });
        }, "取消", function () {

        }, "warning");
    });
}
