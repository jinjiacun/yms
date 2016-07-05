define(['dialog'], function (dialog) {
    return {
        refresh: function () {
            $('#grid').load(controller+'/ColumnManager/GetTable?' + 'r=' + Math.random(), function () {
                $("#table").treetable({ expandable: true }, true);
            });
        },
        add: function (pid, type) {
            var layer = dialog.LoadEle('<div class="row title"><h4>增加栏目</h4></div>'
                + '<div class="row"><span class="col span">栏目名称：</span><div class="col"><input id="txtName" type="text" /></div></div>'
                + '<div class="row"><span class="col span">页面地址：</span><div class="col"><input id="txtUrl" type="text" /></div></div>'
                + '<div class="row update"><button id="btnAdd" class="btn btn-success">增加</button></div>',
                function () {
                    $('#btnAdd').click(function () {
                        var name = $.trim($('#txtName').val());
                        if (name == '') {
                            dialog.MsgBox('warning', '请输入栏目名称', function () { $("#txtName").focus(); }, 0.7);
                            return;
                        }
                        var url = $.trim($('#txtUrl').val());
                        var tip = dialog.ShowTip('请稍候...');
                        $.post(controller+'/ColumnManager/Add', { 'AMoPId': pid, 'AMoName': name, 'AMoUrl': url, 'AMoType': type }, function (data) {
                            tip.close();
                            if (data.res == 1) {
                                layer.close();
                                dialog.SuccessBox('增加成功');
                                d();
                            } else {
                                dialog.ErrorBox('操作失败');
                            }
                        }, 'json');
                    });
                });
        },
        del: function (id) {
            dialog.ConfirmBox("警告：将会删除该栏目下的所有子栏目，确定要删除吗？&nbsp;&nbsp;&nbsp;", "确定", function () {
                var tip = dialog.ShowTip('请稍候...');
                $.post(controller+'/ColumnManager/Delete', { 'AMoId': id }, function (data) {
                    tip.close();
                    if (data.res == 1) {
                        dialog.SuccessBox('删除成功');
                        d();
                    } else {
                        dialog.ErrorBox('操作失败');
                    }
                }, 'json');
            }, "取消", true, "warning");
        },
        update: function (id) {
            var tip = dialog.ShowTip('请稍候...');
            $.post(controller+'/ColumnManager/GetModule', { 'AMoId': id }, function (data) {
                tip.close();
                if (data.res == 1) {
                    var layer = dialog.LoadEle('<div class="row title"><h4>栏目信息修改</h4></div>'
                        + '<div class="row"><span class="col span">栏目名称：</span><div class="col"><input id="txtName" type="text" value="' + data.data.AMoName + '" /></div></div>'
                        + '<div class="row"><span class="col span">页面地址：</span><div class="col"><input id="txtUrl" type="text" value="' + data.data.AMoUrl + '" /></div></div>'
                        + '<div class="row update"><button id="btnUpdate" class="btn btn-success">修改</button></div>',
                        function () {
                            $('#btnUpdate').click(function () {
                                var name = $.trim($('#txtName').val());
                                if (name == '') {
                                    dialog.MsgBox('warning', '请输入栏目名称', function () { $("#txtName").focus(); }, 0.7);
                                    return;
                                }
                                var url = $.trim($('#txtUrl').val());
                                var tip = dialog.ShowTip('请稍候...');
                                $.post(controller+'/ColumnManager/Update', { 'AMoId': id, 'AMoName': name, 'AMoUrl': url }, function (data) {
                                    tip.close();
                                    if (data.res == 1) {
                                        layer.close();
                                        dialog.SuccessBox('修改成功');
                                        d();
                                    } else {
                                        dialog.ErrorBox('操作失败');
                                    }
                                }, 'json');
                            });
                        });
                } else {
                    dialog.ErrorBox('操作失败');
                }
            }, 'json');
        }
    }
});