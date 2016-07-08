var dia_editpassword;
function changePassword() {
    var html = "";
    html += "<div id=\"div_edit\" class=\"widget-box\">";
    html += "    <div class=\"widget-title\">";
    html += "        <span class=\"icon\">";
    html += "            <i class=\"icon-align-justify\"></i>";
    html += "        </span>";
    html += "        <h5>修改密码</h5>";
    html += "    </div>";
    html += "    <div class=\"widget-content nopadding\">";
    html += "        <form id=\"form_edit\" action=\"\" method=\"post\"";
    html += "            class=\"form-horizontal\">";
    html += "            <div class=\"control-group\">";
    html += "                <label class=\"control-label\">原登录密码</label>";
    html += "                <div class=\"controls\">";
    html += "                    <input id=\"OldPassword\" placeholder=\"请输入原登录密码\" name=\"OldPassword\" type=\"password\" onkeyup=\"validOldPassword(this);\"><div id=\"div_OldPassword\" class=\"validtips\"></div>";
    //html += "                    <label class=\"control-label\">原登录密码</label>";
    html += "                </div>";
    html += "            </div>";
    html += "            <div class=\"control-group\">";
    html += "                <label class=\"control-label\">新登录密码</label>";
    html += "                <div class=\"controls\">";
    html += "                    <input id=\"NewPassword\" placeholder=\"请输入新登录密码\" name=\"NewPassword\" type=\"password\" onkeyup=\"validNewPassword(this);\"><div id=\"div_NewPassword\" class=\"validtips\"></div>";
    html += "                </div>";
    html += "            </div>";
    html += "            <div class=\"control-group\">";
    html += "                <label class=\"control-label\">新登录密码确认</label>";
    html += "                <div class=\"controls\">";
    html += "                    <input id=\"NewPassword2\" placeholder=\"请输入新登录密码\" name=\"NewPassword2\" type=\"password\" onkeyup=\"validNewPassword2(this);\"><div id=\"div_NewPassword2\" class=\"validtips\"></div>";
    html += "                </div>";
    html += "            </div>";
    html += "            <div class=\"form-actions\">";
    html += "                <input type=\"hidden\" id=\"Id\" name=\"Id\" value=\"\" />";
    html += "                <button type=\"button\" onclick=\"SavePassword();\" class=\"btn btn-primary\">保存</button>";
    html += "            </div>";
    html += "        </form>";
    html += "    </div>";
    html += "</div>";

    require(["dialog"], function (dia) {
        dia_editpassword = dia_edit = dia.LoadEle(html);
    });
}

function SavePassword() {
    var b = (validOldPassword($("#OldPassword")) && validNewPassword($("#NewPassword")) && validNewPassword2($("#NewPassword2")));
    if (!b) {
        return;
    }
    var OldPassword = $("#OldPassword").val();
    var NewPassword = $("#NewPassword").val();
    var NewPassword2 = $("#NewPassword2").val();
    $.post(controller+"/UserManage/SavePassword/", { OldPassword: OldPassword, NewPassword: NewPassword }, function (json) {
        if (json.msg == "") {
            require(["dialog"], function (dia) {
                dia.Close(dia_editpassword);
                dia.SuccessBox("修改成功.");
            });
        } else {
            require(["dialog"], function (dia) {
                dia.ErrorBox(json.msg);
            });
        }
    });
}

function validOldPassword(obj) {
    return validPassword(obj);
}

function validNewPassword(obj) {
    if (validPassword(obj)) {
        var objId = $(obj).attr("id");
        if ($(obj).val() == $("#OldPassword").val()) {
            $("#div_" + objId).html("新密码不能和原密码相同");
        } else {
            $("#div_" + objId).html("");
            return true;
        }
    }
    return false;
}

function validNewPassword2(obj) {
    var objId = $(obj).attr("id");
    if ($(obj).val() == $("#" + objId.replace("2", "")).val()) {
        $("#div_" + objId).html("");
        return true;
    } else {
        $("#div_" + objId).html("两次输入的新密码不一致");
    }
}

function validPassword(obj) {
    var objId = $(obj).attr("id");
    var Password = $(obj).val();
    var reg = /^(\w){6,16}$/;
    if (reg.test(Password)) {
        $("#div_" + objId).html("");
        return true;
    } else {
        $("#div_" + objId).html("6-16个字母,数字,下划线");
    }
    return false;
}

$(function () {
    GetComMessageCount();
});

function GetComMessageCount() {
    if ($("#ul_ComMessage").length == 0) {
        //说明没权限
        return;
    }
    $.post(controller+"/ComMessage/GetComMessageCount/", function (json) {
        if (json.count == 0) {
            $("#span_UnreadComMessageCount").css("display", "none");
        } else {
            $("#span_UnreadComMessageCount").css("display", "");
            $("#span_UnreadComMessageCount").html(json.count);
        }
        $("#ul_ComMessage").html(json.html);
    });

    //$(obj).find("td").each(function () {
    //    var color = $(this).css("background-color");
    //    if (color=="red") {
    //        //
    //        $(this).remove(function () {

    //        });
    //    }
    //});
}

