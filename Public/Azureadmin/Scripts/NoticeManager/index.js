define(['dialog'], function (dialog) {
    return {
        add: function () {
            var tip = dialog.ShowTip('请稍候...');
            $.post('/NoticeManager/GetAllCompany', function (data) {
                tip.close();
                if (data.res == 1) {
                    var options = "";
                    for (var o in data.data) {
                        options += '<option value="' + data.data[o].id + '">' + data.data[o].name + '</option>';
                    }
                    var layer = dialog.LoadEle('<div class="row title"><h4>增加公告</h4></div>'
                        + '<div class="row"><span class="col span">标题：</span><div class="col"><input class="width" id="txtTitle" type="text" /></div></div>'
                        + '<div class="row"><span class="col span">内容：</span><div class="col"><textarea class="width" id="txtContent"></textarea></div></div>'
                        + '<div class="row"><span class="col span">机构：</span><div class="col"><select class="sel" id="selCompany" multiple>' + options + '</select></div><div class="col"><input title="全部" id="chkAll" type="checkbox"></div></div>'
                        + '<div class="row update"><button id="btnAdd" class="btn btn-success">增加</button></div>',
                    function () {
                        $('#selCompany').select2({ formatNoMatches: null }).on('change', function (e) {
                            if (e.val.length == $("#selCompany option").length) {
                                $('#chkAll').attr('checked', true);
                            } else {
                                $('#chkAll').attr('checked', false);
                            }
                            $.uniform.update('#chkAll');
                        });
                        $('#chkAll').tooltip().uniform().click(function () {
                            if (this.checked) {
                                var val = [];
                                $("#selCompany option").each(function (i, e) { val.push(e.value); });
                                $("#selCompany").select2("val", val);
                            } else {
                                $("#selCompany").select2("val", null);
                            }
                        });
                        $("#btnAdd").click(function () {
                            var title = $.trim($("#txtTitle").val());
                            if (title == '') {
                                dialog.MsgBox('warning', '请输入标题', function () { $("#txtTitle").focus(); }, 0.7);
                                return;
                            }
                            var content = $.trim($("#txtContent").val());
                            if (content == '') {
                                dialog.MsgBox('warning', '请输入内容', function () { $("#txtContent").focus(); }, 0.7);
                                return;
                            }
                            var company = 0;
                            if (!$('#chkAll').attr('checked')) {
                                company = $("#selCompany").select2("val").join('|');
                                if (company == '') {
                                    dialog.MsgBox('warning', '请选择机构', function () { $("#selCompany").select2("focus"); }, 0.7);
                                    return;
                                }
                            }
                            var tip = dialog.ShowTip('请稍候...');
                            $.post('/NoticeManager/AddNotice', { 'title': title, 'content': content, 'company': company }, function (data) {
                                tip.close();
                                if (data.res == 1) {
                                    layer.close();
                                    dialog.SuccessBox('增加成功');
                                    require(["NoticeManager/index"], function (o) { o.refresh(); });
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
        get: function (id) {
            var tip = dialog.ShowTip('请稍候...');
            $.post('/NoticeManager/GetNotice', { 'id': id }, function (data) {
                tip.close();
                if (data.res == 1) {
                    dialog.LoadEle('<div style="height:400px; overflow-y:auto;">'
                        +'<div class="row title" style="margin-right:22px"><h4>查看公告</h4></div>'
                        + '<div class="row"><span class="col span">标题：</span><div class="col" style="width:300px;word-wrap:break-word">' + data.data.title + '</div></div>'
                        + '<div class="row"><span class="col span">内容：</span><div class="col" style="width:300px;word-wrap:break-word">' + data.data.content + '</div></div>'
                        +'</div>');
                } else {
                    dialog.ErrorBox('操作失败');
                }
            }, 'json');
        },
        //del: function (id) {
        //    dialog.ConfirmBox("确定要删除吗？", "确定", function () {
        //        var tip = dialog.ShowTip('请稍候...');
        //        $.post('/NoticeManager/Delete', { 'id': id }, function (data) {
        //            tip.close();
        //            if (data.res == 1) {
        //                require(["NoticeManager/index"], function (o) { o.refresh(); });
        //            } else {
        //                dialog.ErrorBox('操作失败');
        //            }
        //        }, 'json');
        //    }, "取消", true, "question");
        //},
        //update: function (id) {
        //    var tip = dialog.ShowTip('请稍候...');
        //    $.post('/NoticeManager/GetAllCompany', function (d1) {
        //        if (d1.res == 1) {
        //            $.post('/NoticeManager/GetNotice', { 'id': id }, function (d2) {
        //                tip.close();
        //                if (d2.res == 1) {
        //                    var options = "";
        //                    for (var o in d1.data) {
        //                        options += '<option value="' + d1.data[o].id + '">' + d1.data[o].name + '</option>';
        //                    }
        //                    var layer = dialog.LoadEle('<div class="row title"><h4>修改公告</h4></div>'
        //                        + '<div class="row"><span class="col span">标题：</span><div class="col"><input class="width" id="txtTitle" type="text" value="' + d2.data.title + '" /></div></div>'
        //                        + '<div class="row"><span class="col span">内容：</span><div class="col"><textarea class="width" id="txtContent">' + d2.data.content + '</textarea></div></div>'
        //                        + '<div class="row"><span class="col span">机构：</span><div class="col"><select class="sel" id="selCompany" multiple>' + options + '</select></div><div class="col"><input title="全部" id="chkAll" type="checkbox"></div></div>'
        //                        + '<div class="row update"><button id="btnUpdate" class="btn btn-success">修改</button></div>',
        //                    function () {
        //                        $('#selCompany').select2({ formatNoMatches: null }).on('change', function (e) {
        //                            if (e.val.length == $("#selCompany option").length) {
        //                                $('#chkAll').attr('checked', true);
        //                            } else {
        //                                $('#chkAll').attr('checked', false);
        //                            }
        //                            $.uniform.update('#chkAll');
        //                        });
        //                        $('#chkAll').tooltip().uniform().click(function () {
        //                            if (this.checked) {
        //                                var val = [];
        //                                $("#selCompany option").each(function (i, e) { val.push(e.value); });
        //                                $("#selCompany").select2("val", val);
        //                            } else {
        //                                $("#selCompany").select2("val", null);
        //                            }
        //                        });
        //                        var val = [];
        //                        if (d2.data.company == 0) {
        //                            for (var i in d1.data) {
        //                                val.push(d1.data[i].id)
        //                            }
        //                        } else {
        //                            val = d2.data.company.split('|');
        //                        }
        //                        $("#selCompany").select2("val", val);
        //                        if (val.length == d1.data.length) {
        //                            $('#chkAll').attr('checked', true);
        //                            $.uniform.update('#chkAll');
        //                        }
        //                        $("#btnUpdate").click(function () {
        //                            var title = $.trim($("#txtTitle").val());
        //                            if (title == '') {
        //                                dialog.MsgBox('warning', '请输入标题', function () { $("#txtTitle").focus(); }, 0.7);
        //                                return;
        //                            }
        //                            var content = $.trim($("#txtContent").val());
        //                            if (content == '') {
        //                                dialog.MsgBox('warning', '请输入内容', function () { $("#txtContent").focus(); }, 0.7);
        //                                return;
        //                            }
        //                            var company = 0;
        //                            if (!$('#chkAll').attr('checked')) {
        //                                company = $("#selCompany").select2("val").join('|');
        //                                if (company == '') {
        //                                    dialog.MsgBox('warning', '请选择机构', function () { $("#selCompany").select2("focus"); }, 0.7);
        //                                    return;
        //                                }
        //                            }
        //                            var tip = dialog.ShowTip('请稍候...');
        //                            $.post('/NoticeManager/UpdateNotice', { 'id': id, 'title': title, 'content': content, 'company': company }, function (d3) {
        //                                tip.close();
        //                                if (d3.res == 1) {
        //                                    layer.close();
        //                                    dialog.SuccessBox('修改成功');
        //                                    require(["NoticeManager/index"], function (o) { o.refresh(); });
        //                                } else {
        //                                    dialog.ErrorBox('操作失败');
        //                                }
        //                            }, 'json');
        //                        });
        //                    });
        //                } else {
        //                    dialog.ErrorBox('操作失败');
        //                }
        //            }, 'json');
        //        } else {
        //            tip.close();
        //            dialog.ErrorBox('操作失败');
        //        }
        //    }, 'json');
        //},
        refresh: function () {
            var p = $('#grid a[currpage]').attr('currpage');
            if (p == null) p = 1;
            $('#grid').load('/NoticeManager/GetTable?page=' + p + '&r=' + Math.random() + ' #grid');
        },
        showCompany: function (company) {
            company = '<p>' + company.replace(/，/g, '</p><p>') + '</p>';
            dialog.LoadEle('<div style="margin:10px 20px; 0px; height:270px; width:230px; overflow-y:auto;">' + company + '</div>');
        }
    }
});