var op = {};
$(function () {
    $("#table").treetable({ expandable: true, clickableNodeNames: true });
    op.Refresh = function () {
        $('#grid').load(controller+'/Modules/GetTable?r=' + new Date().getTime(), function () {
            $("#table").treetable({ expandable: true, clickableNodeNames: true }, true);
        });
    };
    op.x = function (type, pid, obj) {
        pid = pid || 0;
        require(["dialog"], function (dia) {
            var formId = "formId" + new Date().getTime(),
                ptype = $(obj).parents('tr').data("tt-parent-id");
            if (typeof (ptype) == "undefined") ptype = 0;
            else if (ptype != 0) {
                ptype = 4 - ($('[data-tt-id=' + ptype + ']').find("td").eq(3).html().split("，").length);
            } else {
                ptype = 4 - ($(obj).parents('tr').find("td").eq(3).html().split("，").length);
            }
            var htmlstr = '<form id="' + formId + '"><div class="row title"><h4>增加模块</h4></div>'
                + '<input name="MoPid" style="display:none;" type="text" value="' + pid + '"/>'
                + '<div class="row"><span class="col span">功能名称：</span><div class="col"><input name="MoName" id="MoName" type="text" autofocus/></div></div>'
                + '<div class="row"><span class="col span">页面地址：</span><div class="col"><input name="MoUrl" id="MoUrl" type="text" /></div></div>'
                + '<div class="row"><span class="col span">模块简介：</span><div class="col"><input name="MoIntro" id="MoIntro" type="text" /></div></div>'
                + '<div class="row"><span class="col span">所属版本：</span><div class="col">';
            if (ptype < 2) htmlstr += '<label style="padding: 0 10px; display: inline-block;"><input type="radio" name="MoType" value="1" />白金版</label>';
            if (ptype < 3) htmlstr += '<label style="padding: 0 10px; display: inline-block;"><input type="radio" name="MoType" value="2" />钻石版</label>';
            htmlstr += '<label style="padding: 0 10px; display: inline-block;"><input type="radio" name="MoType" value="3" />尊享版</label></div></div>'
                + '<div class="row"><span class="col span">必要模块：</span><div class="col">';
            if ($(obj).data("isneed") != 0) {
                htmlstr += '<label style="padding: 0 10px;display: inline-block;"><input type="radio" name="MoNeed" value="1" />&nbsp;是</label>' +
                    '<label style="padding: 0 10px;display: inline-block;"><input type="radio" name="MoNeed" value="0" checked="checked" />&nbsp;否</label>';
            } else {
                htmlstr += '<label style="padding: 0 10px;display: inline-block;"><input type="radio" name="MoNeed" value="0" checked="checked" />&nbsp;否</label>';
            }
            htmlstr += '</div></div>'
                + '<div style="margin-left: 330px;"><button id="btnAdd" class="btn btn-success" onclick="return false;">增加</button></div></form>';

            var layer = dia.LoadEle(htmlstr, function () {
                $("#MoName").attr({ "required": "required", "autocomplete": "off" });
                $("input[name='MoType']").first().attr("checked", "checked");
                $("#btnAdd").on("click", function () {
                    var name = $.trim($('#MoName').val());
                    if (!name || name == "") {
                        dia.MsgBox('warning', '请输入名称', function () { $("#MoName").focus(); }, 0.7);
                        return;
                    }
                    var tip = dia.ShowTip('请稍候...');
                    var formData = $("#" + formId).serializeArray();
                    $.post(controller+"/Modules/AddModel.html", formData, function (data) {
                        tip.close();
                        if (data && data.res && data.res == 1) {
                            layer.close(); op.Refresh(); dia.SuccessBox('增加成功');
                        } else {
                            dia.ErrorBox('操作失败');
                        }
                    }, "json");
                });
            });
        });
    };
    op.y = function (obj, id) {
        $(obj).attr("disabled", "disabled");
        require(["dialog"], function (dia) {
            dia.ConfirmBox("<div>您确定要删除吗？</div>", "确定", function () {
                var tip = dia.ShowTip('请稍候...');
                $.post(controller+"/Modules/DeleteModel.html", { mid: id }, function (data) {
                    tip.close();
                    if (data && data.res && data.res == 1) {
                        op.Refresh();
                        dia.SuccessBox("删除成功");
                    } else {
                        dia.ErrorBox("删除失败");
                    }
                });
            }, "取消", true, "warning");
        });
        $(obj).removeAttr("disabled");
    };
    op.z = function (obj, id) {
        var formId = "formId" + new Date().getTime(), ptype = '';
        $.get(controller+"/Modules/GetModel.html", { MoId: id }, function (model) {
            if (!model) window.location.reload();
            ptype = $(obj).parents('tr').data("tt-parent-id");
            if (ptype != 0) ptype = 4 - ($('[data-tt-id=' + ptype + ']').find("td").eq(3).html().split("，").length);
            require(["dialog"], function (dia) {
                var htmlstr = '<form id="' + formId + '"><div class="row title"><h4>修改模块</h4></div>'
                    + '<input name="MoId" style="display:none;" type="text" value="' + model.MoId + '"/>'
                    + '<div class="row"><span class="col span">功能名称：</span><div class="col"><input name="MoName" id="MoName" type="text" value="' + model.MoName + '"/></div></div>'
                    + '<div class="row"><span class="col span">页面地址：</span><div class="col"><input name="MoUrl" id="MoUrl" type="text" value="' + model.MoUrl + '"/></div></div>'
                    + '<div class="row"><span class="col span">模块简介：</span><div class="col"><input name="MoIntro" id="MoIntro" type="text" value="' + model.MoIntro + '" /></div></div>'
                    + '<div class="row"><span class="col span">所属版本：</span><div class="col">';
                if (ptype < 2) htmlstr += '<label style="padding: 0 10px; display: inline-block;"><input type="radio" name="MoType" value="1" />白金版</label>';
                if (ptype < 3) htmlstr += '<label style="padding: 0 10px; display: inline-block;"><input type="radio" name="MoType" value="2" />钻石版</label>';
                htmlstr += '<label style="padding: 0 10px; display: inline-block;"><input type="radio" name="MoType" value="3" />尊享版</label></div></div>'
                    + '<div class="row"><span class="col span">必要模块：</span><div class="col">'
                    + '<label style="padding: 0 10px;display: inline-block;"><input type="radio" name="MoNeed" value="1" />&nbsp;是</label>'
                    + '<label style="padding: 0 10px;display: inline-block;"><input type="radio" name="MoNeed" value="0" />&nbsp;否</label></div></div>'
                    + '<div style="margin-left: 276px;"><button id="btnUpdate" class="btn btn-success" onclick="return false;">修改</button>&nbsp;<button class="btn" onclick="$(\'.aui_close\').trigger(\'click\');return false;">取消</button></div></form>';
                var layer = dia.LoadEle(htmlstr, function () {
                    //$("input[name='MoType']").each(function (i, item) {
                    //    if (item.value == model.MoType) $(item).attr("checked", "checked").css("display", "none");
                    //    else $(item).parents("label").css("display", "none");
                    //}).parents(".row").css("display", "none");
                    //$("input[name='MoNeed']").each(function (i, item) {
                    //    if (item.value == model.MoNeed) $(item).attr("checked", "checked").css("display", "none");
                    //    else $(item).parents("label").css("display", "none");
                    //}).parents(".row").css("display", "none");
                    var isneed = $(obj).parents('td').find("button:first").data("isneed");
                    var pid = $(obj).parents('tr').data("tt-parent-id");
                    $("input[name='MoType']").each(function (i, item) {
                        if (item.value == model.MoType) $(item).attr("checked", "checked");
                    });
                    $("input[name='MoNeed']").each(function (i, item) {
                        if (item.value == model.MoNeed) $(item).attr("checked", "checked");
                        if (pid != 0 && isneed == 0 && item.value == 1) $(item).parents("label").css("display", "none");
                    });


                    $("#btnUpdate").on("click", function () {
                        var name = $.trim($('#MoName').val());
                        if (!name || name == "") { dia.MsgBox('warning', '请输入名称', function () { $("#MoName").focus(); }, 0.7); return; }
                        var tip = dia.ShowTip('请稍候...');
                        var formData = $("#" + formId).serializeArray();
                        $.post(controller+"/Modules/UpdateModel.html", formData, function (data) {
                            tip.close();
                            if (data && data.res && data.res == 1) {
                                op.Refresh(); layer.close(); dia.SuccessBox('修改成功');
                            } else {
                                dia.ErrorBox('操作失败');
                            }
                        }, "json");
                    });
                }, true);
            });
        });
    };
});