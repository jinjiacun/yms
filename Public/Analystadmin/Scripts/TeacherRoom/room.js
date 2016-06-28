define(["ueditor", "dialog"], function (j, dia) {
    var CreateLiveEditor = function (editorId, params) {
        var defaults = {
            toolbars: [['bold', 'italic', 'forecolor', 'removeformat', '|', 'simpleupload', 'emotion', '|', 'fontsize']],
            maximumWords: 300,
            pasteplain: true,
            UploadImgParams: uploadImgParams
        };
        params = $.extend({}, defaults, params);
        var ue = UE.getEditor(editorId, params);
        return ue;
    };

    var CreateInterEditor = function (editorId, params) {
        var defaults = {
            toolbars: [['emotion']],
            contextMenu: [
              { label: '', cmdName: 'selectall' },
              { label: '', cmdName: 'copy' },
              { label: '', cmdName: 'cleardoc' }
            ],
            elementPathEnabled: false,
            pasteplain: true,
            maximumWords: 150
        };
        params = $.extend({}, defaults, params);
        var ue = UE.getEditor(editorId, params);
        return ue;
    };

    var EditRoomTitle = function () {
        $("#btn_EditTitle").on("click", function () {
            var $this = $(this);
            var $txt = $("#txt_EditTitle");
            var $con = $("#con_Title");
            var $sub = $("#btn_SubmitTit");
            $con.hide();
            $txt.val($con.html());
            $txt.show();
            $sub.show();
            $this.hide();
        });
        $("#btn_SubmitTit").on("click", function () {
            var $this = $(this);
            var $txt = $("#txt_EditTitle");
            var $con = $("#con_Title");
            var $edit = $("#btn_EditTitle");
            var btnText = $this.html();
            if ($txt.val() == "") {
                dia.ErrorBox("直播主题不能为空！");
                return;
            }
            $.ajax({
                type: "POST",
                url: "EditRoomTitle.html",
                data: "title=" + encodeURIComponent($txt.val()),
                beforeSend: function () {
                    $this.html("正在修改...");
                    $this.attr("disabled", "disabled");
                },
                success: function (json) {
                    switch (json.Result) {
                        case 200:
                            $con.show();
                            $con.html($txt.val());
                            $edit.show();
                            $txt.hide();
                            $this.hide();
                            dia.SuccessBox("修改成功！");
                            break;
                        case 502:
                            dia.ErrorBox("直播主题格式错误，请修正后再试！");
                            break;
                        default:
                            dia.ErrorBox("更新直播主题错误，请稍后再试！");
                            break;
                    }
                },
                error: function () {
                    dia.ErrorBox("更新直播主题错误，请稍后再试！");
                },
                complete: function () {
                    $this.html(btnText);
                    $this.removeAttr("disabled");
                }
            });
        });
    };

    var SendLive = function (ue, vipGrade, btnObj, btnOtherObj) {
        if (ue.hasContents()) {
            var $this = $(btnObj);
            var btnText = $this.html();
            var live = ue.getContent();
            if (ue.getContentLength(true) > 300) {
                dia.ErrorBox("直播内容长度不能大于300个字符！");
                return;
            }
            $.ajax({
                type: "POST",
                url: "SendLive.html",
                data: "live=" + encodeURIComponent(live) + "&vipGrade=" + vipGrade,
                beforeSend: function () {
                    $this.html('正在提交...');
                    $this.attr("disabled", "disabled");
                    btnOtherObj.attr("disabled", "disabled");
                },
                success: function (json) {
                    switch (json.Result) {
                        case 200:
                            dia.SuccessBox("直播发布成功！");
                            $("#LiveList").prepend(CreateLiveHtml(json.Live));
                            $('.nav-tabs li:eq(1) a').tab('show');
                            break;
                        default:
                            dia.ErrorBox("发布直播出错，请稍后再试！");
                            break;
                    }
                },
                error: function () {
                    dia.ErrorBox("发布直播出错，请稍后再试！");
                },
                complete: function () {
                    ue.execCommand('cleardoc');
                    $this.html(btnText);
                    $this.removeAttr("disabled");
                    btnOtherObj.removeAttr("disabled");
                }
            });
        }
        else {
            dia.ErrorBox("直播内容不能为空！");
        }
    };

    var SendInter = function (ue, btnObj) {
        if (ue.hasContents()) {
            var $this = $(btnObj);
            var btnText = $this.html();
            var inter = ue.getContent();
            if (ue.getContentLength(true) > 150) {
                dia.ErrorBox("互动内容长度不能大于150个字符！");
                return;
            }
            $.ajax({
                type: "POST",
                url: "SendInter.html",
                data: "inter=" + encodeURIComponent(inter),
                beforeSend: function () {
                    $this.html('正在提交...');
                    $this.attr("disabled", "disabled");
                },
                success: function (json) {
                    switch (json.Result) {
                        case 200:
                            $("#InterList").prepend(CreateInterHtml(json.Inter));
                            dia.SuccessBox("互动发布成功！");
                            $('.nav-tabs li:first a').tab('show');
                            break;
                        default:
                            dia.ErrorBox("互动发布出错，请稍后再试！");
                            break;
                    }
                },
                error: function () {
                    dia.ErrorBox("互动发布出错，请稍后再试！");
                },
                complete: function () {
                    ue.execCommand('cleardoc');
                    $this.html(btnText);
                    $this.removeAttr("disabled");
                }
            });
        }
        else {
            dia.ErrorBox("互动内容不能为空！");
        }
    };

    var DelInter = function (interId, delBtnObj) {
        dia.ConfirmBox('<div style="padding:10px;">确定删除这条互动信息？</div>', "确定", function () {
            $.ajax({
                type: "POST",
                url: "DelInter.html",
                data: "interId=" + interId,
                success: function (json) {
                    if (json.Result == 200) {
                        dia.SuccessBox("删除成功！");
                        delBtnObj.parents("li").hide("slow", function () {
                            delBtnObj.parents("li").remove();
                        });
                    }
                    else {
                        dia.ErrorBox("删除互动信息出错，请稍后再试！");
                    }
                },
                error: function () {
                    dia.ErrorBox("删除互动信息出错，请稍后再试！");
                }
            });
        }, "取消", true, "question");
    };

    var BatchDelInter = function () {
        var $selCkb = $("#InterList").find("input[type='checkbox']:checked");
        if ($selCkb.length == 0) {
            dia.ErrorBox("请选择需要删除的互动信息！");
            return;
        }
        var interIds = '';
        $selCkb.each(function (i, item) {
            interIds += $(item).data("interid") + ',';
        });
        dia.ConfirmBox('<div style="padding:10px;">确定批量删除这些互动信息？</div>', "确定", function () {
            $.ajax({
                type: "POST",
                url: "BatchDelInter.html",
                data: "interIds=" + interIds,
                success: function (json) {
                    if (json.Result == 200) {
                        dia.SuccessBox("批量删除成功！");
                        $selCkb.parents("li").hide("slow", function () {
                            $selCkb.parents("li").remove();
                        });
                    }
                    else {
                        dia.ErrorBox("批量删除互动信息出错，请稍后再试！");
                    }
                },
                error: function () {
                    dia.ErrorBox("批量删除互动信息出错，请稍后再试！");
                }
            });
        }, "取消", true, "question");
    };

    var AuditInter = function (interId, audBtnObj) {
        dia.ConfirmBox('<div style="padding:10px;">确定审核这条互动信息？</div>', "确定", function () {
            $.ajax({
                type: "POST",
                url: "AuditInter.html",
                data: "interId=" + interId,
                success: function (json) {
                    if (json.Result == 200) {
                        dia.SuccessBox("审核成功！");
                        var $parentLi = audBtnObj.parents("li");
                        audBtnObj.parents(".shenghe_menu").html('<a href="javascript:void(0)" class="del_Inter">删除</a>&nbsp;<a href="javascript:void(0)" class="yinYong_Inter">引用</a>&nbsp;<a href="javascript:void(0)" class="reply_Inter">回复</a>');
                        $parentLi.find(".con_txt .cl").remove();
                        $parentLi.find(".shenhe_ckb").after('<span class="shenghe">已审核</span>');
                        $parentLi.find(".shenhe_ckb").remove();
                        $parentLi.addClass("shenhed");
                    }
                    else {
                        dia.ErrorBox("审核互动信息出错，请稍后再试！");
                    }
                },
                error: function () {
                    dia.ErrorBox("审核互动信息出错，请稍后再试！");
                }
            });
        }, "取消", true, "question");
    };

    var BatchAuditInter = function () {
        var $selCkb = $("#InterList").find("input[type='checkbox']:checked");
        if ($selCkb.length == 0) {
            dia.ErrorBox("请选择需要审核的互动信息！");
            return;
        }
        var interIds = '';
        $selCkb.each(function (i, item) {
            interIds += $(item).data("interid") + ',';
        });
        dia.ConfirmBox('<div style="padding:10px;">确定批量审核这些互动信息？</div>', "确定", function () {
            $.ajax({
                type: "POST",
                url: "BatchAuditInter.html",
                data: "interIds=" + interIds,
                success: function (json) {
                    if (json.Result == 200) {
                        $selCkb.each(function (i, item) {
                            var $parentLi = $(item).parents("li");
                            $parentLi.find(".shenghe_menu").html('<a href="javascript:void(0)" class="del_Inter">删除</a>&nbsp;<a href="javascript:void(0)" class="yinYong_Inter">引用</a>&nbsp;<a href="javascript:void(0)" class="reply_Inter">回复</a>');
                            $parentLi.find(".con_txt .cl").remove();
                            $parentLi.find(".shenhe_ckb").after('<span class="shenghe">已审核</span>');
                            $parentLi.find(".shenhe_ckb").remove();
                            $parentLi.addClass("shenhed");
                        });
                        dia.SuccessBox("批量审核成功！");
                    }
                    else {
                        dia.ErrorBox("批量审核互动信息出错，请稍后再试！");
                    }
                },
                error: function () {
                    dia.ErrorBox("批量审核互动信息出错，请稍后再试！");
                }
            });
        }, "取消", true, "question");
    };

    //signalR接收数据
    require(["signalR"], function (s) {
        require(["/signalR/Hubs"], function () {
            var chat = $.connection.teacherRoomHub;

            chat.client.receiveInterMsg = function (group, msg) {
                var interMsg = $.parseJSON(msg);
                $("#InterList").prepend(CreateInterHtml(interMsg));
            };

            $.connection.hub.start().done(function () {
                chat.server.connect(roomInfo.RoomId);
            });
        });

    });

    function CreateInterHtml(data) {
        if (!$.isArray(data)) {
            data = [data];
        }
        var html = '';
        if (data.length > 0) {
            $.each(data, function (i, item) {
                html += ' <li';
                if (item.InterCheck == 1) {
                    html += ' class="shenhed" ';
                }
                html += '>';
                html += '<p class="name">';
                html += ' <b>' + item.UserNickName + '</b>';
                html += '<b class="tea">';
                if (roomInfo.RoomTeacher.indexOf(item.UserId.toString()) > -1) {
                    html += '（讲师）';
                }
                html += '</b>&nbsp;';
                html += '<span class="time" data-time="' + CommonFn.toDateFromJson(item.InterTime).format("yyyy-MM-dd HH:mm:ss") + '">' + CommonFn.toDateFromJson(item.InterTime).format("HH:mm:ss MM-dd") + '</span>';
                html += '</p>';
                html += '<div><p class="con_txt">';
                if (item.InterReturn != "") {
                    html += ' <span class="con_yinyong">【' + item.InterReturn + '】</span>';
                }
                html += '<span class="con">' + item.InterContent + '</span>';
                html += '</p>';
                if (item.InterCheck == 1) {
                    html += '<span class="shenghe">已审核</span>';
                }
                else {
                    html += '<input type="checkbox" class="shenhe_ckb" data-interid="' + item.InterId + '"/>';
                }
                html += '<span class="shenghe_menu"  data-interid="' + item.InterId + '">';
                if (item.InterCheck == 1) {
                    html += '<a href="javascript:void(0)" class="del_Inter">删除</a>&nbsp;<a href="javascript:void(0)" class="yinYong_Inter">引用</a>&nbsp;<a href="javascript:void(0)" class="reply_Inter">回复</a>';
                }
                else {
                    html += '<a href="javascript:void(0)" class="del_Inter">删除</a>&nbsp;<a href="javascript:void(0)" class="audit_Inter">审核</a>';
                }
                html += '</span>';
                html += '</div>';
                html += '<p class="cl"></p>';
                html += ' </li>';
            });
        }
        return html;
    }

    var GetInterTop = function () {
        var lastTime = $("#InterList li:last").find(".time").data("time");
        if (lastTime == undefined) {
            lastTime = new Date().format('yyyy-MM-dd HH:mm:ss');
        }
        var tip;
        $.ajax({
            type: "POST",
            url: "GetInterTop.html",
            data: "lastTime=" + lastTime,
            beforeSend: function () {
                tip = dia.ShowTip('正在获取，请稍后...');
            },
            success: function (json) {
                if (json.Result == 200) {
                    $("#InterList").append(CreateInterHtml(json.InterList));
                    $("html,body").animate({ scrollTop: $(document).height() }, function () {
                        $("#InterList").parent().animate({ scrollTop: $("#InterList").height() }, 'slow')
                    });
                    if (json.InterList.length < 50) {
                        var $btnTop = $("#btn_GetInterTop");
                        $btnTop.addClass("top_no");
                        $btnTop.html("已无更多数据");
                    }
                }
                else {
                    dia.ErrorBox("获取互动信息出错，请稍后再试！");
                }
            },
            error: function () {
                dia.ErrorBox("获取互动信息出错，请稍后再试！");
            },
            complete: function () {
                tip.close();
            }
        });
    };
    var ReplyInter = function (btnObj) {
        var name = btnObj.parents("li").find(".name b").first().html().trim();
        var cont = btnObj.parents("li").find(".con_txt .con").html().trim();
        var html = '<div style="margin:10px;word-break: break-all;word-wrap: break-word;"><p style="width:400px;">回复:<span style="color:red">' + name + '</span>【' + CommonFn.cutStr(100, CommonFn.clearHtml(CommonFn.clearImgTag(cont))) + '】</p><div id="pop_ReplyInterEditor" style="width:400px;height:100px;margin-bottom:10px;"></div><button id="btn_PopReplyInter" class="btn"><i class="icon-pencil"></i>&nbsp;提交</button></div>';
        var pop_ReplyInter = dia.LoadEle(html, function () {
            var pop_ReplyInterEditor = CreateInterEditor("pop_ReplyInterEditor", { zIndex: 3000 });
            $("#btn_PopReplyInter").on("click", function () {
                if (pop_ReplyInterEditor.hasContents()) {
                    var $this = $(this);
                    var btnText = $this.html();
                    var interId = btnObj.parent().data("interid");
                    var inter = pop_ReplyInterEditor.getContent();
                    if (pop_ReplyInterEditor.getContentLength(true) > 150) {
                        dia.ErrorBox("互动内容长度不能大于150个字符！");
                        return;
                    }
                    $.ajax({
                        type: "POST",
                        url: "ReplyInter.html",
                        data: "interId=" + interId + "&interContent=" + encodeURIComponent(inter) + "&returnUserName=" + encodeURIComponent(name) + "&returnInter=" + encodeURIComponent(cont),
                        beforeSend: function () {
                            $this.html('正在提交...');
                            $this.attr("disabled", "disabled");
                        },
                        success: function (json) {
                            switch (json.Result) {
                                case 200:
                                    $("#InterList").prepend(CreateInterHtml(json.Inter));
                                    pop_ReplyInter.hide();
                                    dia.SuccessBox("互动回复成功！");
                                    setTimeout(function () {
                                        pop_ReplyInter.close();
                                    }, 3000);
                                    break;
                                default:
                                    dia.ErrorBox("互动回复出错，请稍后再试！");
                                    break;
                            }
                        },
                        error: function () {
                            dia.ErrorBox("互动直播出错，请稍后再试！");
                        },
                        complete: function () {
                            pop_ReplyInterEditor.execCommand('cleardoc');
                            $this.html(btnText);
                            $this.removeAttr("disabled");
                        }
                    });
                }
                else {
                    dia.ErrorBox("互动内容不能为空！");
                }
            });
        }, function () {
            UE.delEditor("pop_ReplyInterEditor");
        });
    };

    var LoadRoomImg = function (url) {
        dia.LoadImg(url);
    };

    var SetLiveListHeight = function () {
        var height = 1000 - $("#liveTop_Container").height() - $(".live_his_top_btn").height() - $(".live_his_menu").height() - 32;
        $("#liveHis_Container").css("height", height);
    };

    function CreateTopLiveHtml(data) {
        if (!$.isArray(data)) {
            data = [data];
        }
        var html = '';
        if (data.length > 0) {
            $.each(data, function (i, item) {
                html += '<li>';
                html += '<p class="flag"></p>';
                html += '<div class="avatar_box">';
                html += '<div class="avatar">';
                html += '<img src="' + item.AdminAvartar + '" class="avatar_img" />';
                html += '</div>';
                html += '<p>' + item.AdminName + '</p>';
                html += '</div>';
                html += '<div class="con_box">';
                html += '<div class="jt"></div>';
                html += '<div class="txt_box">';
                html += '<div class="txt">' + item.LiveContent + '</div>';
                html += '<div class="time">' + CommonFn.toDateFromJson(item.LiveTime).format("HH:mm:ss MM-dd") + '</div>';
                html += '<div class="menu">';
                if (item.AdminId == userInfo.AdminId) {
                    html += ' <a href="javascript:;" data-liveId="' + item.LiveID + '" class="cancelTop_Live">取消置顶</a>';
                }
                html += '</div>';
                html += '</div>';
                html += '</div>';
                html += '</li>';
            });
        }
        return html;
    }

    function CreateLiveHtml(data) {
        if (!$.isArray(data)) {
            data = [data];
        }
        var html = '';
        if (data.length > 0) {
            $.each(data, function (i, item) {
                html += '<li>';
                if (item.LiveVipGrade > 0) {
                    html += '<div class="flag"></div>';
                }
                html += '<div class="avatar_box">';
                html += '<div class="avatar">';
                html += '<img class="avatar_img" src="' + item.AdminAvartar + '">';
                html += '</div>';
                html += '<p>' + item.AdminName + '</p>';
                html += '</div>';
                html += '<div class="con_box">';
                html += '<div class="jt"></div>';
                html += '<div class="txt_box">';
                if (item.LiveQuote != "") {
                    html += '<div class="yinyong">【引用】' + item.LiveQuote + '</div>';
                }
                html += ' <div class="txt">' + item.LiveContent + '</div>';
                html += ' <div class="time" data-time="' + CommonFn.toDateFromJson(item.LiveTime).format("yyyy-MM-dd HH:mm:ss") + '">' + CommonFn.toDateFromJson(item.LiveTime).format("HH:mm:ss MM-dd") + '</div>';
                html += '<div class="menu"  data-liveId="' + item.LiveID + '">';
                if (item.AdminId == userInfo.AdminId) {
                    html += ' <a href="javascript:void(0)" class="edit_Live">编辑</a>&nbsp;';
                    html += '<a href="javascript:void(0)" class="del_Live">删除</a>&nbsp;';
                    html += '<a href="javascript:void(0)" class="top_Live">置顶</a>&nbsp;';
                    html += '<span>|&nbsp;</span>';
                }
                html += '<a href="javascript:void(0)" class="yinYong_Live">引用</a>';
                html += '</div>';
                html += '</div>';
                html += '</div>';
                html += '</li>';
            });
        }
        return html;
    }

    var CancelLiveTop = function (liveId, canBtnObj) {
        dia.ConfirmBox('<div style="padding:10px;">确定取消置顶？</div>', "确定", function () {
            $.ajax({
                type: "POST",
                url: "CancelLiveTop.html",
                data: "liveId=" + liveId,
                success: function (json) {
                    if (json.Result == 200) {
                        dia.SuccessBox("取消置顶成功！");
                        canBtnObj.parents("li").hide("slow", function () {
                            canBtnObj.parents("li").remove();
                            SetLiveListHeight();
                        });
                    }
                    else {
                        dia.ErrorBox("取消置顶出错，请稍后再试！");
                    }
                },
                error: function () {
                    dia.ErrorBox("取消置顶出错，请稍后再试！");
                }
            });
        }, "取消", true, "question");
    };

    var SetLiveTop = function (liveId, setBtnObj) {
        dia.ConfirmBox('<div style="padding:10px;">确定置顶这条直播？</div>', "确定", function () {
            $.ajax({
                type: "POST",
                url: "SetLiveTop.html",
                data: "liveId=" + liveId,
                success: function (json) {
                    switch (json.Result) {
                        case 200:
                            dia.SuccessBox("置顶直播成功！");
                            $("#LiveTopList").append(CreateTopLiveHtml(json.Live));
                            SetLiveListHeight();
                            setBtnObj.parents("li").hide("slow", function () {
                                setBtnObj.parents("li").remove();
                            });
                            break;
                        case 504:
                            dia.ErrorBox("本直播室置顶条数已到最大限度，置顶失败！");
                            break;
                        case 505:
                            dia.ErrorBox("您已有一条置顶直播，置顶失败！");
                            break;
                        case 506:
                            dia.ErrorBox("置顶直播的内容包含图片，置顶失败！");
                            break;
                        default:
                            dia.ErrorBox("置顶直播出错，请稍后再试！");
                            break;
                    }
                },
                error: function () {
                    dia.ErrorBox("置顶直播出错，请稍后再试！");
                }
            });
        }, "取消", true, "question");
    };

    var DelLive = function (liveId, delBtnObj) {
        dia.ConfirmBox('<div style="padding:10px;">确定删除这条直播？</div>', "确定", function () {
            $.ajax({
                type: "POST",
                url: "DelLive.html",
                data: "liveId=" + liveId,
                success: function (json) {
                    if (json.Result == 200) {
                        dia.SuccessBox("删除成功！");
                        delBtnObj.parents("li").hide("slow", function () {
                            delBtnObj.parents("li").remove();
                        });
                    }
                    else {
                        dia.ErrorBox("删除直播出错，请稍后再试！");
                    }
                },
                error: function () {
                    dia.ErrorBox("删除直播出错，请稍后再试！");
                }
            });
        }, "取消", true, "question");
    };

    var GetLiveTop = function () {
        var lastTime = $("#LiveList li:last").find(".time").data("time");
        if (lastTime == undefined) {
            lastTime = new Date().format('yyyy-MM-dd HH:mm:ss');
        }
        var tip;
        $.ajax({
            type: "POST",
            url: "GetLiveTop.html",
            data: "lastTime=" + lastTime,
            beforeSend: function () {
                tip = dia.ShowTip('正在获取，请稍后...');
            },
            success: function (json) {
                if (json.Result == 200) {
                    $("#LiveList").append(CreateLiveHtml(json.LiveList));
                    $("html,body").animate({ scrollTop: $(document).height() }, function () {
                        $("#LiveList").parent().animate({ scrollTop: $("#LiveList").height() }, 'slow')
                    });
                    if (json.LiveList.length < 50) {
                        var $btnTop = $("#btn_GetLiveTop");
                        $btnTop.addClass("top_no");
                        $btnTop.html("已无更多数据");
                    }
                }
                else {
                    dia.ErrorBox("获取直播信息出错，请稍后再试！");
                }
            },
            error: function () {
                dia.ErrorBox("获取直播信息出错，请稍后再试！");
            },
            complete: function () {
                tip.close();
            }
        });
    };

    var EditLive = function (editBtnObj) {
        var cont = editBtnObj.parents("li").find(".txt").html();
        var html = '<div style="margin: 10px 20px 0 20px;"><textarea style="width: 500px; height: 100px;margin-bottom:10px;" id="pop_EditLiveEditor">' + cont + '</textarea><button class="btn" id="btn_PopEditLive"><i class="icon-pencil"></i>&nbsp;修改</button></div>';
        var pop_EditLive = dia.LoadEle(html, function () {
            var pop_EditLiveEditor = CreateLiveEditor("pop_EditLiveEditor", { zIndex: 3000 });
            $("#btn_PopEditLive").on("click", function () {
                if (pop_EditLiveEditor.hasContents()) {
                    var $this = $(this);
                    var btnText = $this.html();
                    var liveId = editBtnObj.parent("div").data("liveid");
                    var live = pop_EditLiveEditor.getContent();
                    if (pop_EditLiveEditor.getContentLength(true) > 300) {
                        dia.ErrorBox("互动内容长度不能大于300个字符！");
                        return;
                    }
                    $.ajax({
                        type: "POST",
                        url: "EditLive.html",
                        data: "liveId=" + liveId + "&live=" + encodeURIComponent(live),
                        beforeSend: function () {
                            $this.html('正在提交...');
                            $this.attr("disabled", "disabled");
                        },
                        success: function (json) {
                            switch (json.Result) {
                                case 200:
                                    pop_EditLive.hide();
                                    editBtnObj.parents("li").find(".txt").html(json.LiveContent);
                                    dia.SuccessBox("修改成功！");
                                    setTimeout(function () {
                                        pop_EditLive.close();
                                    }, 3000);
                                    break;
                                default:
                                    dia.ErrorBox("修改出错，请稍后再试！");
                                    break;
                            }
                        },
                        error: function () {
                            dia.ErrorBox("修改出错，请稍后再试！");
                        },
                        complete: function () {
                            pop_EditLiveEditor.execCommand('cleardoc');
                            $this.html(btnText);
                            $this.removeAttr("disabled");
                        }
                    });
                }
                else {
                    dia.ErrorBox("直播内容不能为空！");
                }
            });
        }, function () {
            UE.delEditor("pop_EditLiveEditor");
        });
    };

    var YinYongLive = function (name, cont, yyType) {
        var html = '<div style="margin:10px;word-break: break-all;word-wrap: break-word;"><p style="width:400px;">引用:<span style="color:red">' + name + '</span>【' + CommonFn.cutStr(100, CommonFn.clearHtml(cont)) + '】</p><div id="pop_YinYongLiveEditor" style="width:600px;height:100px;margin-bottom:10px;"></div><button class="btn" id="btn_PopSendLive"><i class="icon-plus"></i>发布直播</button>&nbsp;<button class="btn btn-primary" id="btn_PopSendVipLive"><i class="icon-share-alt icon-white"></i>发布操作建议</button></div>';
        var pop_YinYongLive = dia.LoadEle(html, function () {
            var pop_YinYongLiveEditor = CreateLiveEditor("pop_YinYongLiveEditor", { zIndex: 3000 });
            var sendLiveAndYy = function (vipGrade, btnObj, btnOtherObj) {
                if (pop_YinYongLiveEditor.hasContents()) {
                    var $this = $(btnObj);
                    var btnText = $this.html();
                    var live = pop_YinYongLiveEditor.getContent();
                    if (pop_YinYongLiveEditor.getContentLength(true) > 300) {
                        dia.ErrorBox("直播内容长度不能大于300个字符！");
                        return;
                    }
                    $.ajax({
                        type: "POST",
                        url: "YinYongLive.html",
                        data: "live=" + encodeURIComponent(live) + "&vipGrade=" + vipGrade + "&returnUserName=" + encodeURIComponent(name) + "&returnLive=" + encodeURIComponent(cont) + "&yyType=" + yyType,
                        beforeSend: function () {
                            $this.html('正在提交...');
                            $this.attr("disabled", "disabled");
                            btnOtherObj.attr("disabled", "disabled");
                        },
                        success: function (json) {
                            switch (json.Result) {
                                case 200:
                                    dia.SuccessBox("直播发布成功！");
                                    $("#LiveList").prepend(CreateLiveHtml(json.Live));
                                    pop_YinYongLive.hide();
                                    setTimeout(function () {
                                        pop_YinYongLive.close();
                                    }, 3000);
                                    break;
                                default:
                                    dia.ErrorBox("发布直播出错，请稍后再试！");
                                    break;
                            }
                        },
                        error: function () {
                            dia.ErrorBox("发布直播出错，请稍后再试！");
                        },
                        complete: function () {
                            pop_YinYongLiveEditor.execCommand('cleardoc');
                            $this.html(btnText);
                            $this.removeAttr("disabled");
                            btnOtherObj.removeAttr("disabled");
                        }
                    });
                }
                else {
                    dia.ErrorBox("直播内容不能为空！");
                }
            };

            $("#btn_PopSendLive").on("click", function () {
                sendLiveAndYy(0, this, $("#btn_PopSendVipLive"));
            });

            $("#btn_PopSendVipLive").on("click", function () {
                sendLiveAndYy(1, this, $("#btn_PopSendLive"));
            });
        }, function () {
            UE.delEditor("pop_YinYongLiveEditor");
        });
    };

    var GetTopLiveList = function () {
        $.ajax({
            type: "GET",
            url: "GetTopLiveList.html",
            cache: false,
            success: function (json) {
                if (json.Result == 200 && json.TopLiveList.length > 0) {
                    $("#LiveTopList").html(CreateTopLiveHtml(json.TopLiveList));
                    SetLiveListHeight();
                }
            }
        });
    };

    var GetLiveList = function (time) {
        var tip = dia.ShowTip("正在获取，请稍后...");
        $.ajax({
            type: "GET",
            url: "GetLiveList.html",
            cache: false,
            data: "time=" + time,
            success: function (json) {
                if (json.Result == 200) {
                    var $topBtnObj = $("#btn_GetLiveTop");
                    if (json.LiveList.length > 0) {
                        $("#LiveList").html(CreateLiveHtml(json.LiveList));
                        if (json.LiveList.length < 50) {
                            $topBtnObj.removeClass("top_no").addClass("top_no");
                            $topBtnObj.html("已无更多数据");
                        }
                        else {
                            $topBtnObj.removeClass("top_no");
                            $topBtnObj.html("查看上<b>50</b>条");
                        }
                        SetLiveListHeight();
                    }
                    else {
                        $topBtnObj.removeClass("top_no").addClass("top_no");
                        $topBtnObj.html("已无更多数据");
                        dia.ErrorBox("该日无记录！");
                    }
                }
            },
            complete: function () {
                tip.close();
            }
        });
    };

    var FilterLiveData = function () {
        var selLiveType = $("#selLiveType").val();
        var selLiveTea = $("#selLiveTea").val().trim();
        $("#LiveList li").each(function (i, item) {
            var $this = $(item);
            var flag = true;
            if (selLiveType != 0) {
                var liveType = $this.find(".flag").length > 0 ? 2 : 1;
                if (liveType != selLiveType) {
                    flag = false;
                }
            }
            if (selLiveTea != "全部") {
                var liveTea = $this.find(".avatar_box p").html().trim();
                if (liveTea != selLiveTea) {
                    flag = false;
                }
            }
            if (flag) {
                $this.show();
            }
            else {
                $this.hide();
            }
        });
    };

    return {
        CreateLiveEditor: CreateLiveEditor,
        CreateInterEditor: CreateInterEditor,
        EditRoomTitle: EditRoomTitle,
        SendLive: SendLive,
        SendInter: SendInter,
        DelInter: DelInter,
        BatchDelInter: BatchDelInter,
        AuditInter: AuditInter,
        BatchAuditInter: BatchAuditInter,
        GetInterTop: GetInterTop,
        ReplyInter: ReplyInter,
        LoadRoomImg: LoadRoomImg,
        SetLiveListHeight: SetLiveListHeight,
        CancelLiveTop: CancelLiveTop,
        SetLiveTop: SetLiveTop,
        DelLive: DelLive,
        GetLiveTop: GetLiveTop,
        EditLive: EditLive,
        YinYongLive: YinYongLive,
        GetTopLiveList: GetTopLiveList,
        GetLiveList: GetLiveList,
        FilterLiveData: FilterLiveData
    };
});