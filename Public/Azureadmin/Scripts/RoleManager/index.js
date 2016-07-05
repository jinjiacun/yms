define(['dialog'], function (dialog) {
    var searchCompany = '';
    return {
        refresh: function () {
            var p = $('#grid a[currpage]').attr('currpage');
            if (p == null) p = 1;
            $('#grid').load(
controller+'/RoleManager/GetTable?page=' + p + '&company=' + searchCompany + '&r=' + Math.random() + ' #grid');
        },
        search: function () {
            searchCompany = encodeURIComponent($.trim($('#txtSearchCompany').val()));
            $('#grid').load(controller+'/RoleManager/GetTable?page=1&company=' + searchCompany + '&r=' + Math.random() + ' #grid');
        },
        add: function () {
            var tip = dialog.ShowTip('请稍候...');
            $.post(controller+'/RoleManager/GetAllColumn', function (data) {
                tip.close();
                if (data.res == 1) {
                    var companyRow = data.data.company;
                    //if (data.type == 1) {
                    //    var options = '<option value="0">平台</option>';
                    //    for (var o in data.data.company) {
                    //        options += '<option value="' + data.data.company[o].id + '">' + data.data.company[o].name + '</option>';
                    //    }
                    //    companyRow = '<select class="width" id="selCompany">' + options + '</select>';
                    //} else {
                    //    companyRow = data.data.company;
                    //}
                    var layer = dialog.LoadEle('<div class="row title"><h4>增加角色</h4></div>'
                        + '<div class="row"><span class="col span">名称：</span><div class="col"><input id="txtName" type="text" /></div></div>'
                        + '<div class="row"><span class="col span">机构：</span><div class="col">' + companyRow + '</div></div>'
                        + '<ul id="treeColumn" class="ztree"></ul>'
                        + '<div class="row update"><button id="btnAdd" class="btn btn-success">增加</button></div>',
                        function () {
                            //if (data.type == 1) {
                            //    $('#selCompany').select2({ formatNoMatches: null }).change(function (c) {
                            //        $.fn.zTree.init($("#treeColumn"), { check: { enable: true }, data: { simpleData: { enable: true } } }, $.grep(data.data.column, function (v) {
                            //            return v.type == (c.val > 0 ? 2 : 1);
                            //        }));
                            //    }).change();
                            //} else {
                            //    $.fn.zTree.init($("#treeColumn"), { check: { enable: true }, data: { simpleData: { enable: true } } }, data.data.column);
                            //}
                            $.fn.zTree.init($("#treeColumn"), { check: { enable: true }, data: { simpleData: { enable: true } } }, data.data.column);
                            $('#btnAdd').click(function () {
                                var name = $.trim($('#txtName').val());
                                if (name == '') {
                                    dialog.MsgBox('warning', '请输入角色名称', function () { $("#txtName").focus(); }, 0.7);
                                    return;
                                }
                                var company = 0;
                                //if (data.type == 1) {
                                //    company = $("#selCompany").select2("val");
                                //    if (company == '') {
                                //        dialog.MsgBox('warning', '请选择机构', function () { $("#selCompany").select2("focus"); }, 0.7);
                                //        return;
                                //    }
                                //}
                                var checkedNodes = $.fn.zTree.getZTreeObj("treeColumn").getCheckedNodes();
                                var column = $.map(checkedNodes, function (v) { return v.id; }).join(',');
                                var tip = dialog.ShowTip('请稍候...');
                                $.post(controller+'/RoleManager/Add', { 'RoleName': name, 'ComId': company, 'column': column }, function (data) {
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
                } else {
                    dialog.ErrorBox('操作失败');
                }
            }, 'json');
        },
        del: function (id) {
            dialog.ConfirmBox("确定要删除吗？", "确定", function () {
                var tip = dialog.ShowTip('请稍候...');
                $.post(controller+'/RoleManager/Delete', { 'id': id }, function (data) {
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
            $.post(controller+'/RoleManager/GetRole', { 'RoleId': id }, function (data) {
                tip.close();
                if (data.res == 1) {
                    var layer = dialog.LoadEle('<div class="row title"><h4>修改角色</h4></div>'
                        + '<div class="row"><span class="col span">名称：</span><div class="col"><input id="txtName" type="text" value="' + data.data.role + '" /></div></div>'
                        + '<div class="row"><span class="col span">机构：</span><div class="col">' + data.data.company + '</div></div>'
                        + '<ul id="treeColumn" class="ztree"></ul>'
                        + '<div class="row update"><button id="btnUpdate" class="btn btn-success">修改</button></div>',
                        function () {
                            $.fn.zTree.init($("#treeColumn"), { check: { enable: true }, data: { simpleData: { enable: true } } }, data.data.column);
                            $('#btnUpdate').click(function () {
                                var name = $.trim($('#txtName').val());
                                if (name == '') {
                                    dialog.MsgBox('warning', '请输入角色名称', function () { $("#txtName").focus(); }, 0.7);
                                    return;
                                }
                                var checkedNodes = $.fn.zTree.getZTreeObj("treeColumn").getCheckedNodes();
                                var column = $.map(checkedNodes, function (v) { return v.id; }).join(',');
                                var tip = dialog.ShowTip('请稍候...');
                                $.post(controller+'/RoleManager/Update', { 'RoleId': id, 'RoleName': name, 'column': column }, function (data) {
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