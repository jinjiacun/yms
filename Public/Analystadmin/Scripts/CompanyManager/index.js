define(['dialog'], function (dialog) {
    var searchCompany = '';
    return {
        setState: function (id, state) {
            var tip = dialog.ShowTip('请稍候...');
            $.post('/CompanyManager/SetState', { 'companyID': id, 'state': state }, function (data) {
                tip.close();
                if (data.res == 1) {
                    require(["CompanyManager/index"], function (o) { o.refresh(); });
                } else {
                    dialog.ErrorBox('操作失败');
                }
            }, 'json');
        },
        getDetail: function (id) {
            var tip = dialog.ShowTip('请稍候...');
            $.post(controller+'/CompanyManager/GetDetail', { 'ComId': id }, function (data) {
                tip.close();
                if (data.res == 1) {
                    var layer = dialog.LoadEle('<div class="row title"><h4>机构信息修改</h4></div>'
                        + '<div class="row"><span class="col span">公司名称：</span><div class="col">' + data.data.ComAllName + '</div></div>'
                        + '<div class="row"><span class="col span">公司官网：</span><div class="col"><a target="_blank" href="' + data.data.ComUrl + '">' + data.data.ComUrl + '</a></div></div>'
                        + '<div class="row"><span class="col span">联系人：</span><div class="col"><input id="contact" type="text" value="' + data.data.ComLine + '"/></div></div>'
                        + '<div class="row"><span class="col span">联系电话：</span><div class="col"><input id="mobile" type="text" value="' + data.data.ComMob + '" /></div></div>'
                        + '<div class="row"><span class="col span">联系邮箱：</span><div class="col"><input id="mail" type="text" value="' + data.data.ComMail + '" /></div></div>'
                        + '<div class="row"><span class="col span">热线电话：</span><div class="col"><input id="hotline" type="text" value="' + data.data.ComPhone + '" /></div></div>'
                        + '<div class="row"><span class="col span">企业邮箱：</span><div class="col"><input id="email" type="text" value="' + data.data.ComEmail + '" /></div></div>'
                        + '<div class="row"><span class="col span">地址：</span><div class="col"><input id="address" type="text" value="' + data.data.ComAddress + '" /></div></div>'
                        + (data.data.ComState != 0 ? '<div class="row"><span class="col span">过期时间：</span><div class="col"><input id="expTime" type="text" value="' + data.data.ExpTime + '" style="width:100px;cursor:pointer"></div><div class="col"><button id="btnExtendTime" class="btn btn-success">延期</button></div></div>' : '')
                        + (data.data.ComState != 0 ? '<div class="row"><span class="col span">登录帐号：</span><div class="col">' + data.data.AdminUserName + '</div></div>' : '')
                        + '<div class="row update"><button id="updateInfo" class="btn btn-primary">修改信息</button></div>',
                        function () {
                            $('#expTime').datepicker({ weekStart: 1, format: 'yyyy-mm-dd', language: 'zh-CN', autoclose: true, todayHighlight: true, startDate: data.data.nowTime });
                            $('#btnExtendTime').click(function () {
                                var tip = dialog.ShowTip('请稍候...');
                                $.post('/CompanyManager/ExtendTime', { 'companyID': id, 'date': $('#expTime').val() }, function (data) {
                                    tip.close();
                                    if (data.res == 1) {
                                        dialog.SuccessBox('延期成功');
                                    } else {
                                        dialog.ErrorBox('操作失败');
                                    }
                                }, 'json');
                            });                           
                            $('#updateInfo').click(function () {
                                var contact = $.trim($("#contact").val());
                                if (contact == '') {
                                    dialog.MsgBox('warning', '请输入联系人', function () { $("#contact").focus(); }, 0.7);
                                    return;
                                }
                                var mobile = $.trim($("#mobile").val());
                                if (mobile == '') {
                                    dialog.MsgBox('warning', '请输入联系电话', function () { $("#mobile").focus(); }, 0.7);
                                    return;
                                }
                                var mail = $.trim($("#mail").val());
                                if (mail == '') {
                                    dialog.MsgBox('warning', '请输入联系邮箱', function () { $("#mail").focus(); }, 0.7);
                                    return;
                                }
                                var hotline = $.trim($("#hotline").val());
                                if (hotline == '') {
                                    dialog.MsgBox('warning', '请输入热线电话', function () { $("#hotline").focus(); }, 0.7);
                                    return;
                                }
                                var email = $.trim($("#email").val());
                                if (email == '') {
                                    dialog.MsgBox('warning', '请输入企业邮箱', function () { $("#email").focus(); }, 0.7);
                                    return;
                                }
                                var address = $.trim($("#address").val());
                                if (address == '') {
                                    dialog.MsgBox('warning', '请输入地址', function () { $("#address").focus(); }, 0.7);
                                    return;
                                }
                                var tip = dialog.ShowTip('请稍候...');
                                $.post(controller+'/CompanyManager/UpdateInfo', { 'ComId': id, 'ComLine': contact, 'ComMob': mobile, 'ComEmail': email, 'ComAddress': address, 'ComMail': mail, 'ComPhone': hotline }, function (data) {
                                    tip.close();
                                    if (data.res == 1) {
                                        layer.close();
                                        dialog.SuccessBox('修改成功');
                                        require(["CompanyManager/index"], function (o) { o.refresh(); });
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
        pass: function (id) {
            var layer = dialog.LoadEle('<div class="row title"><h4>通过审核</h4></div>'
                + '<div class="row"><span class="col span">机构标签：</span><div class="col"><input title="该标签用于机构产品 URL" class="width" id="txtTag" type="text" /><div class="val-info">4-10 位字母数字组合</div></div></div>'
                + '<div class="row update"><button id="btnPass" class="btn btn-success">通过审核</button></div>',
            function () {
                $('#txtTag').tooltip();
                $('#btnPass').click(function () {
                    var tag = $.trim($('#txtTag').val());
                    if (tag == '') {
                        dialog.MsgBox('warning', '请输入机构标签&nbsp;', function () { $("#txtTag").focus(); }, 0.7);
                        return;
                    }
                    if (!/^[0-9a-zA-Z]{4,10}$/.test(tag)) {
                        dialog.MsgBox('warning', '机构标签不符合规则&nbsp;&nbsp;', function () { $("#txtTag").focus(); }, 0.7);
                        return;
                    }
                    dialog.ConfirmBox("确定要通过审核吗？", "确定", function () {
                        var tip = dialog.ShowTip('请稍候...');
                        $.post('/CompanyManager/Pass', { 'companyID': id, 'tag': tag }, function (data) {
                            tip.close();
                            if (data.res == 1) {
                                layer.close();
                                dialog.SuccessBox('操作成功');
                                require(["CompanyManager/index"], function (o) { o.refresh(); });
                            } else if (data.res == -5001) {
                                dialog.MsgBox('warning', '该机构标签已存在&nbsp;&nbsp;', function () { $("#txtTag").focus(); }, 1.2);
                            } else {
                                dialog.ErrorBox('操作失败');
                            }
                        }, 'json');
                    }, "取消", true, "question");
                });
            });
        },
        refresh: function () {
            var p = $('#grid a[currpage]').attr('currpage');
            if (p == null) p = 1;
            $('#grid').load(controller+'/CompanyManager/GetTable?page=' + p + '&company=' + searchCompany + '&r=' + Math.random() + ' #grid');
        },
        search: function () {
            searchCompany = encodeURIComponent($.trim($('#txtSearchCompany').val()));
            $('#grid').load(controller+'/CompanyManager/GetTable?page=1&company=' + searchCompany + '&r=' + Math.random() + ' #grid');
        }
    }
}); 