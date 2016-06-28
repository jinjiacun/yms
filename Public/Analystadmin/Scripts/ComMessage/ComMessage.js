
$(function () {
    $('#search_CMTitle,#search_CMCon').placeholder();
    SetLink();
});

function SetLink() {
    $(".dataTables_wrapper").find("a").each(function () {
        if (typeof ($(this).attr("onclick")) != "undefined") {
            var link = $(this).attr("onclick");
            var v = "";
            if (link.indexOf("?") = -1) {
                v = "?page=1";
            }
            link = link.replace(" #grid'", v + GetLink());
            $(this).attr("onclick", link);
            //alert(link);
        }
    });
}

//#region 
//#endregion


function GetLink() {
    var link = "&CMTitle=" + escape($("#search_CMTitle").val()) + "&CMCon=" + escape($("#search_CMCon").val()) + " #grid',SetLink";

    return link;
}

function searchComMessage() {

    var page = 1;
    $("#grid").load(window.location.href + '?page=' + page + GetLink());
}

function searchAll() {
    $("#search_CMTitle").val("");
    $("#search_CMCon").val("");
    searchComMessage();
}

function selectAll(obj) {
    $("#grid").find("input:checkbox").attr("checked", $(obj).attr("checked") == "checked");
}

function DeleteMessage() {
    if ($(".dataTables_wrapper").length == 0) {
        return;
    }
    var ids = isChecked("请您选择要删除的信息.");
    if (ids != "") {
        FunDel("您确定要删除这些消息吗?", ids);
    }

}

function getCheckedValue() {
    var ids = "";
    $("#grid").find("input:checkbox:checked").each(function () {
        if ($(this).val() != "") {
            ids += $(this).val() + ",";
        }
    });
    ids = ids.substr(0, ids.length - 1);
    return ids;
}

function isChecked(msg) {
    var ids = getCheckedValue();
    if (ids == "") {
        require(["dialog"], function (dia) {
            dia.ErrorBox(msg);
        });
    }
    return ids;
}

function refurbishCurrentPage() {
    var page = $(".dataTables_wrapper").find("a[currpage]").attr("currpage");
    $("#grid").load(window.location.href + '?page=' + page + " #grid");
}

function SomeIsRead() {
    if ($(".dataTables_wrapper").length == 0) {
        return;
    }
    var ids = isChecked("请您选择要标记为已读的信息.");
    if (ids != "") {
        FunIsRead("您确定要标记这些信息为已读?", ids);
    }
}

function AllIsRead() {
    if ($(".dataTables_wrapper").length == 0) {
        return;
    }
    FunIsRead("您确定全部标记为已读?", "");
}

function FunIsRead(tips, ids) {
    require(["dialog"], function (dia) {
        dia.ConfirmBox("<div style='padding:10px;'>" + tips + "<div>", "确定", function () {
            var parm = "";
            var funName = "";
            if (ids != "") {
                parm = { ids: ids }
                funName = "SomeMessageRead";
            } else {
                funName = "AllMessageRead";
            }
            $.post("/ComMessage/" + funName + "/", parm, function (json) {
                require(["dialog"], function (dia) {
                    if (json.msg == "") {
                        if (ids == "") {
                            refurbishCurrentPage();
                        } else {
                            var arr = ids.split(',');
                            for (var i = 0; i < arr.length; i++) {
                                $("#i_" + arr[i]).remove();
                            }
                        }
                        dia.SuccessBox("操作成功.");
                    } else {
                        dia.ErrorBox("操作失败.");
                    }
                });
            });
        }, "取消", function () {

        }, "warning");
    });
}