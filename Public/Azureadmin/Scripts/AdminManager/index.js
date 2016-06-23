define(['dialog'], function (dialog) {
    var searchCompany = '';
    return {
        add: function () {
            var tip = dialog.ShowTip('请稍候...');
            $.post('/AdminManager/GetAllRole', function (data) {
                tip.close();
                if (data.res == 1) {
                    var options = '';
                    if (data.type == 1) {
                        for (var key in data.data) {
                            var k = key.split('_');
                            options += '<optgroup label="' + k[1] + '" company=' + k[0] + '>';
                            $.each(data.data[key], function (i, v) { options += '<option value="' + v.rid + '">' + v.role + '</option>'; });
                            options += '</optgroup>';
                        }
                    } else {
                        for (var key in data.data) {
                            options += '<option value="' + data.data[key].rid + '">' + data.data[key].role + '</option>';
                        }
                    }
                    var layer = dialog.LoadEle('<div class="row title"><h4>增加管理员</h4></div>'
                        + '<div class="row"><span class="col span">姓名：</span><div class="col"><input class="width" id="txtName" type="text" /></div></div>'
                        + '<div class="row"><span class="col span">帐号：</span><div class="col"><input class="width" id="txtUname" type="text" /><div class="val-info">字母数字下划线组合，字母开头，3 位以上</div></div></div>'
                        + '<div class="row"><span class="col span">密码：</span><div class="col"><input class="width" id="txtPwd" type="password" /><div class="val-info">长度为 6-16 位</div></div></div>'
                        + '<div class="row"><span class="col span">角色：</span><div class="col"></div><select class="sel" id="selRole">' + options + '</select></div>'
                        + '<div class="row update"><button id="btnAdd" class="btn btn-success">增加</button></div>',
                    function () {
                        $('#selRole').select2({ formatNoMatches: null });
                        $("#btnAdd").click(function () {
                            var name = $.trim($("#txtName").val());
                            if (name == '') {
                                dialog.MsgBox('warning', '请输入姓名', function () { $("#txtName").focus(); }, 0.7);
                                return;
                            }
                            var uname = $.trim($("#txtUname").val());
                            if (uname == '') {
                                dialog.MsgBox('warning', '请输入帐号', function () { $("#txtUname").focus(); }, 0.7);
                                return;
                            }
                            if (!/^[a-zA-Z]\w{2,}$/.test(uname)) {
                                dialog.MsgBox('warning', '帐号格式不正确', function () { $("#txtUname").focus(); }, 0.7);
                                return;
                            }
                            var pwd = $("#txtPwd").val();
                            if (pwd == '') {
                                dialog.MsgBox('warning', '请输入密码', function () { $("#txtPwd").focus(); }, 0.7);
                                return;
                            }
                            if (pwd.length < 6 || pwd.length > 16) {
                                dialog.MsgBox('warning', '密码格式不正确', function () { $("#txtPwd").focus(); }, 0.7);
                                return;
                            }
                            var role = $("#selRole").select2("val");
                            if (role == '') {
                                dialog.MsgBox('warning', '请选择角色', function () { $("#selRole").select2("focus"); }, 0.7);
                                return;
                            }
                            var company = data.type == 1 ? $('#selRole option:selected').parent().attr('company') : 0;
                            var tip = dialog.ShowTip('请稍候...');
                            $.post('/AdminManager/Add', { 'name': name, 'uname': uname, 'pwd': pwd, 'role': role, 'company': company }, function (data) {
                                tip.close();
                                if (data.res == 1) {
                                    layer.close();
                                    dialog.SuccessBox('增加成功');
                                    d();
                                } else if (data.res == -5002) {
                                    dialog.ErrorBox('该帐号已存在');
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
        setState: function (id, state) {
            var tip = dialog.ShowTip('请稍候...');
            $.post('/AdminManager/SetState', { 'id': id, 'state': state }, function (data) {
                tip.close();
                if (data.res == 1) {
                    d();
                } else {
                    dialog.ErrorBox('操作失败');
                }
            }, 'json');
        },
        update: function (id) {
            var tip = dialog.ShowTip('请稍候...');
            $.post('/AdminManager/GetAllRole', function (data) {
                if (data.res == 1) {
                    $.post('/AdminManager/GetAdmin', { 'id': id }, function (data2) {
                        tip.close();
                        if (data2.res == 1) {
                            var roleRow = '';
                            var options = '';
                            if (data.type == 1) {
                                if (data2.data.company == 0) {
                                    for (var key in data.data) {
                                        var k = key.split('_');
                                        options += '<optgroup label="' + k[1] + '" company=' + k[0] + '>';
                                        $.each(data.data[key], function (i, v) {
                                            var isSel = v.rid == data2.data.role ? ' selected' : '';
                                            options += '<option value="' + v.rid + '"' + isSel + '>' + v.role + '</option>';
                                        });
                                        options += '</optgroup>';
                                    }
                                    roleRow = '<div class="row"><span class="col span">角色：</span><div class="col"><select class="sel" id="selRole">' + options + '</select></div></div>';
                                }
                            } else {
                                for (var key in data.data) {
                                    var isSel = data.data[key].rid == data2.data.role ? ' selected' : '';
                                    options += '<option value="' + data.data[key].rid + '"' + isSel + '>' + data.data[key].role + '</option>';
                                }
                                roleRow = '<div class="row"><span class="col span">角色：</span><div class="col"><select class="sel" id="selRole">' + options + '</select></div></div>';
                            }
                            var layer = dialog.LoadEle('<div class="row title"><h4>修改管理员</h4></div>'
                                + '<div class="row"><span class="col span">姓名：</span><div class="col"><input class="width" id="txtName" type="text" value="' + data2.data.name + '" /></div></div>'
                                + '<div class="row"><span class="col span">帐号：</span><div class="col"><input class="width" id="txtUname" type="text" value="' + data2.data.uname + '" /><div class="val-info">字母数字下划线组合，字母开头，3 位以上</div></div></div>'
                                + '<div class="row"><span class="col span">密码：</span><div class="col"><input class="width" id="txtPwd" type="password" /><div class="val-info">长度 6-16 位，空为不更改</div></div></div>'
                                + roleRow
                                + '<div class="row update"><button id="btnUpdate" class="btn btn-success">修改</button></div>',
                            function () {
                                if (data.type == 2 || data2.data.company == 0) {
                                    $('#selRole').select2({ formatNoMatches: null });
                                }
                                $("#btnUpdate").click(function () {
                                    var name = $.trim($("#txtName").val());
                                    if (name == '') {
                                        dialog.MsgBox('warning', '请输入姓名', function () { $("#txtName").focus(); }, 0.7);
                                        return;
                                    }
                                    var uname = $.trim($("#txtUname").val());
                                    if (uname == '') {
                                        dialog.MsgBox('warning', '请输入帐号', function () { $("#txtUname").focus(); }, 0.7);
                                        return;
                                    }
                                    if (!/^[a-zA-Z]\w{2,}$/.test(uname)) {
                                        dialog.MsgBox('warning', '帐号格式不正确', function () { $("#txtUname").focus(); }, 0.7);
                                        return;
                                    }
                                    var pwd = $("#txtPwd").val();
                                    if (pwd != '' && (pwd.length < 6 || pwd.length > 16)) {
                                        dialog.MsgBox('warning', '密码格式不正确', function () { $("#txtPwd").focus(); }, 0.7);
                                        return;
                                    }
                                    var role = 0;
                                    if (data.type == 2 || data2.data.company == 0) {
                                        role = $("#selRole").select2("val");
                                        if (role == '') {
                                            dialog.MsgBox('warning', '请选择角色', function () { $("#selRole").select2("focus"); }, 0.7);
                                            return;
                                        }
                                    }
                                    var company = 0;
                                    //var company = data.type == 1 ? $('#selRole option:selected').parent().attr('company') : 0;
                                    var tip = dialog.ShowTip('请稍候...');
                                    $.post('/AdminManager/Update', { 'id': id, 'name': name, 'uname': uname, 'pwd': pwd, 'role': role, 'company': company }, function (data) {
                                        tip.close();
                                        if (data.res == 1) {
                                            layer.close();
                                            dialog.SuccessBox('修改成功');
                                            d();
                                        } else if (data.res == -1) {
                                            dialog.ErrorBox('该帐号已存在');
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
                } else {
                    tip.close();
                    dialog.ErrorBox('操作失败');
                }
            }, 'json');
        },
        updatePwd: function (id) {
            var layer = dialog.LoadEle('<div class="row title"><h4>修改密码</h4></div>'
                + '<div class="row"><span class="col span">密码：</span><div class="col"><input class="width" id="txtPwd" type="password" /><div class="val-info">长度 6-16 位</div></div></div>'
                + '<div class="row"><span class="col span">确认：</span><div class="col"><input class="width" id="txtPwdAgain" type="password" /></div></div>'
                + '<div class="row update"><button id="btnUpdate" class="btn btn-success">修改</button></div>',
            function () {
                $("#btnUpdate").click(function () {
                    var pwd = $("#txtPwd").val();
                    if (pwd.length < 6 || pwd.length > 16) {
                        dialog.MsgBox('warning', '密码格式不正确', function () { $("#txtPwd").focus(); }, 0.7);
                        return;
                    }
                    var pwdAgain = $("#txtPwdAgain").val();
                    if (pwd != pwdAgain) {
                        dialog.MsgBox('warning', '两次输入的密码不一致', function () { $("#txtPwdAgain").focus(); }, 0.7);
                        return;
                    }
                    var tip = dialog.ShowTip('请稍候...');
                    $.post('/AdminManager/UpdatePwd', { 'id': id, 'pwd': pwd }, function (data) {
                        tip.close();
                        if (data.res == 1) {
                            layer.close();
                            dialog.SuccessBox('修改成功');
                        } else {
                            dialog.ErrorBox('操作失败');
                        }
                    }, 'json');
                });
            });
        },
        refresh: function () {
            var p = $('#grid a[currpage]').attr('currpage');
            if (p == null) p = 1;
            $('#grid').load('/AdminManager/GetTable?page=' + p + '&company=' + searchCompany + '&r=' + Math.random() + ' #grid');
        },
        search: function () {
            searchCompany = encodeURIComponent($.trim($('#txtSearchCompany').val()));
            $('#grid').load('/AdminManager/GetTable?page=1&company=' + searchCompany + '&r=' + Math.random() + ' #grid');
        }
    }
});