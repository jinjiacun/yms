$(function () {
    $('#search_LoginId,#search_UserName').placeholder();
});

function GetVipOptions() {
    $.ajax({
        type: "post",
        url: '/UserManage/GetVipOptions?selValue=&isAddFirst=true',
        //data: { selValue: "ss", isAddFirst: true },
        success: function (data) {
            $("#search_VipLevel").html(data);
            SetLink();
        },
        error: function () {
            alert("ajax出错。");
        }
    });
}

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
        }
    });
}

function EditUCState(ComUserId, UCState, strUCState) {
    require(["dialog"], function (dia) {
        dia.ConfirmBox("<div style='padding:10px;'>您确定要【" + strUCState + "】该用户吗？<div>", "确定", function () {
            $.post("/UserManage/EditUCState", { ComUserId: ComUserId, UCState: UCState }, function (json) {
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

function GetLink() {
    var link = "&LoginId=" + $("#search_LoginId").val() + "&UserName=" + ($("#search_UserName").val()) + "&VipLevel=" + $("#search_VipLevel").val() + " #grid',SetLink";
    return link;
}

function searchComUser() {
    var page = 1;
    $("#grid").load(window.location.href + '?page=' + page + GetLink());
}

function searchAll() {
    $("#search_LoginId").val("");
    $("#search_UserName").val("");
    $("#search_VipLevel").val("");
    searchComUser();
}

function refurbishCurrentPage() {
    var page = $(".dataTables_wrapper").find("a[currpage]").attr("currpage");
    $("#grid").load(window.location.href + '?page=' + page + " #grid");
}

var dia_edit;
function editOne(id) {
    $.ajax({
        type: "post",
        url: '/UserManage/Bind_Edit_ComUser?id=' + id,
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

function ShowDetail(id) {
    $.ajax({
        type: "post",
        url: '/UserManage/GetDetails?id=' + id,
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

function SaveComUser(id) {
    //alert($("#VipLevel").val());
    //return;
    var parm = { Id: id, VipLevel: $("#VipLevel").val(), UCState: $("#UCState").val() };
    $.post("/UserManage/SaveComUser", parm, function (json) {
        if (json.msg == "") {
            require(["dialog"], function (dia) {
                dia.Close(dia_edit);
                //$("#vipName_" + id).html(json.VipName);
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

function ResetUserPwd(uid) {
    var html = '<div style="padding:10px;"><h4 style="padding-bottom:5px;border-bottom:1px dashed #ccc">重置密码</h4><table><tr><td>请输入密码：</td><td><input type="password" style="margin-bottom:0" maxlength="16" id="reset_pwd"><div style="font-size:12px;margin:5px 0">6-16个字符,区分大小写</div></td></tr><tr><td>请输入确认密码：</td><td><input type="password" style="margin-bottom:0" maxlength="16" id="reset_repwd"><div style="font-size:12px;margin:5px 0">请重复输入登录密码</div></td></tr><tr><td><button class="btn" id="reset_submit">重置</button></td></tr></table></div>';
    require(["dialog"], function (dia) {
        var pop_ResetPwd = dia.LoadEle(html, function () {
            $("#reset_submit").on("click", function () {
                var pwd = $("#reset_pwd").val();
                var repwd = $("#reset_repwd").val();
                if (pwd == "") {
                    dia.ErrorBox("密码不能为空");
                    return;
                }
                if (pwd.length < 6 || pwd.length > 16) {
                    dia.ErrorBox("密码格式错误");
                    return;
                }
                if (repwd == "") {
                    dia.ErrorBox("确认密码不能为空");
                    return;
                }
                if (pwd != repwd) {
                    dia.ErrorBox("确认密码与密码不一致");
                    return;
                }
                $.ajax({
                    type: "POST",
                    url: "ResetUserPwd.html",
                    data: "uid=" + uid + "&pwd=" + encodeURIComponent(pwd) + "&repwd=" + encodeURIComponent(repwd),
                    success: function (json) {
                        if (json.Result == 1) {
                            dia.SuccessBox("重置成功！");
                            pop_ResetPwd.close();
                        }
                        else if (json.Result == 0) {
                            dia.ErrorBox("新密码与老密码相同，请重新输入");
                        }
                        else {
                            dia.ErrorBox("重置密码出错，请稍后再试！");
                        }
                    },
                    error: function () {
                        dia.ErrorBox("重置密码出错，请稍后再试！");
                    }
                });
            });
        }, null);
    });
}