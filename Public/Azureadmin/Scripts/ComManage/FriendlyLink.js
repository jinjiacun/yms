define(["dialog"], function (dia) {
    var SetShowType = function (obj) {
        var showType = obj.val();
        dia.ConfirmBox('<div style="padding:10px;">此操作会影响<font color="red">友链</font>和<font color="red">合作伙伴</font>的展示方式，确认修改？</div>', "确定", function () {
            $.ajax({
                type: "POST",
                url: "SetShowType.html",
                data: "showType=" + showType,
                success: function (json) {
                    if (json.Result == 200) {
                        dia.SuccessBox("修改成功！");
                        comLinkType = parseInt(showType);
                    }
                    else {
                        dia.ErrorBox("修改展示类型出错，请稍后再试！");
                    }
                },
                error: function () {
                    dia.ErrorBox("修改展示类型出错，请稍后再试！");
                }
            });
        }, "取消", function () {
            //取消后还原选择项
            if (showType == 0) {
                obj.val(1);
            }
            else {
                obj.val(0);
            }
        }, "question");
    };

    var DelFriendlyLink = function (obj) {
        var linkId = obj.data("linkid");
        dia.ConfirmBox('<div style="padding:10px;">确定删除此条信息？</div>', "确定", function () {
            $.ajax({
                type: "POST",
                url: controller+"/ComManager/DelFriendlyLink.html",
                data: "LinkId=" + linkId,
                success: function (json) {
                    if (json.res == 1) {
                        dia.SuccessBox("删除成功！");
                        obj.parents("tr").remove();
                    }
                    else {
                        dia.ErrorBox("删除出错，请稍后再试！");
                    }
                },
                error: function () {
                    dia.ErrorBox("删除出错，请稍后再试！");
                }
            });
        }, "取消", true, "question");
    };

    var AddFriendlyLink = function (addType) {
        var keyWord = "友链";
        if (addType == 1) {
            keyWord = "合作伙伴";
        }
        var html = '<div class="pop_cont"><div class="pop_tit"><h4>添加' + keyWord + '</h4></div><table class="pop_tab"><tr><td>' + keyWord + '名称：</td><td><input type="text" id="add_txtLinkName" maxlength="10"/></td></tr><tr id="add_LinkImgRow"><td>' + keyWord + '图片：<br /><font color="red">(88px*31px)</font></td><td><img id="add_LinkImg" src="" alt="" style="display:none;"/><button class="btn" id="add_btnLinkImg"><i class="icon-circle-arrow-up"></i>&nbsp;上传图片</button></td></tr><tr><td>' + keyWord + '链接：</td><td><input type="text" id="add_txtLink" maxlength="200"/></td></tr><tr><td><button class="btn" id="add_btnSubmit"><i class=" icon-plus "></i>&nbsp;增加</button></td></tr></table></div>';
        var pop_AddFriendlyLink = dia.LoadEle(html, function () {
            if (comLinkType == 0) {
                $("#add_LinkImgRow").remove();
            }

            $("#add_btnLinkImg").uploadify({
                'swf': resource+'/Scripts/Lib/uploadify/uploadify.swf',
                'buttonText': '上传图片',
                'buttonClass': 'btn btn-mini',
                'height': 30,
                'width': 100,
                'uploader': controller+'/Uploadify/UpLoadImage.html',
                'formData': { comId: comId },
                'queueSizeLimit': 1,
                'auto': true,
                'multi': false,
                'removeCompleted': true,
                'fileSizeLimit': '10MB',
                'fileTypeDesc': 'Image Files',
                'fileTypeExts': '*.gif; *.jpg; *.png; *.bmp; *.jpeg',
                'itemTemplate': '<div id="${fileID}" class="uploadify-queue-item">\
                    <span class="fileName">${fileName} (${fileSize})</span><span class="data"></span>\
                </div>',
                removeTimeout: 0,
                'onUploadSuccess': function (file, data, response) {
                    if (response) {
                        var image = new Image();
                        image.src = data;
                        image.onload = function () {
                            if (image.width != 88 || image.height != 31) {
                                dia.ErrorBox("<p>图片的尺寸必须是 88px * 31px ！</p>");
                            } else {
                                var $img = $("#add_LinkImg");
                                $img.show();
                                $img.attr("src", data);
                            }
                        };
                    }
                }
            });
        }, null);

        $("#add_btnSubmit").on("click", function () {
            var linkName = $("#add_txtLinkName").val();
            if (linkName == "") {
                dia.ErrorBox(keyWord + "不能为空！");
                return;
            }
            var linkImg = "";
            if (comLinkType == 1) {
                linkImg = $("#add_LinkImg").attr("src");
                if (linkImg == "") {
                    dia.ErrorBox("请上传" + keyWord + "图片！");
                    return;
                }
            }
            var link = $("#add_txtLink").val();
            if (link == "") {
                dia.ErrorBox(keyWord + "链接不能为空！");
                return;
            }
            var linkReg = /^http:\/\/.*$/;
            if (!linkReg.test(link)) {
                dia.ErrorBox(keyWord + "链接格式错误！");
                return;
            }
            $.ajax({
                type: "POST",
                url: controller+"/ComManager/AddFriendlyLink.html",
                data: "linkName=" + encodeURIComponent(linkName) + "&linkImg=" + encodeURI(linkImg) + "&linkUrl=" + link + "&comLinkType=" + comLinkType + "&addType=" + addType,
                success: function (json) {
                    if (json.res == 1) {
                        dia.SuccessBox("添加成功！");
                        window.location.reload();
                    }
                    else {
                        dia.ErrorBox("添加出错，请稍后再试！");
                    }
                },
                error: function () {
                    dia.ErrorBox("添加出错，请稍后再试！");
                }
            });
        });
    };

    var UpdateFriendlyLink = function (obj, updateType) {
        var keyWord = "友链";
        if (updateType == 1) {
            keyWord = "合作伙伴";
        }
        var html = '<div class="pop_cont"><div class="pop_tit"><h4>修改' + keyWord + '</h4></div><table class="pop_tab"><tr><td>' + keyWord + '名称：</td><td><input type="text" id="up_txtLinkName" maxlength="10"/></td></tr><tr id="up_LinkImgRow"><td>' + keyWord + '图片：<br /><font color="red">(88px*31px)</font></td><td><img id="up_LinkImg" src="" alt=""/><button class="btn" id="up_btnLinkImg"><i class="icon-circle-arrow-up"></i>&nbsp;上传图片</button></td></tr><tr><td>' + keyWord + '链接：</td><td><input type="text" id="up_txtLink" maxlength="200"/></td></tr><tr><td><button class="btn" id="up_btnSubmit"><i class="icon-pencil"></i>&nbsp;修改</button></td></tr></table></div>';
        var pop_AddFriendlyLink = dia.LoadEle(html, function () {
            var $parent = obj.parents("tr");
            $("#up_txtLinkName").val($parent.find("td:eq(1)").html());
            $("#up_txtLink").val($parent.find("td:eq(3) a").attr("href"));

            if (comLinkType == 0) {
                $("#up_LinkImgRow").remove();
            }
            else {
                $("#up_LinkImg").attr("src", $parent.find("td:eq(2) img").attr("src"));
            }

            $("#up_btnLinkImg").uploadify({
                'swf': resource+'/Scripts/Lib/uploadify/uploadify.swf',
                'buttonText': '上传图片',
                'buttonClass': 'btn btn-mini',
                'height': 30,
                'width': 100,
                'uploader': controller+'/Uploadify/UpLoadImage.html',
                'formData': { comId: comId },
                'queueSizeLimit': 1,
                'auto': true,
                'multi': false,
                'removeCompleted': true,
                'fileSizeLimit': '10MB',
                'fileTypeDesc': 'Image Files',
                'fileTypeExts': '*.gif; *.jpg; *.png; *.bmp; *.jpeg',
                'itemTemplate': '<div id="${fileID}" class="uploadify-queue-item">\
                    <span class="fileName">${fileName} (${fileSize})</span><span class="data"></span>\
                </div>',
                removeTimeout: 0,
                'onUploadSuccess': function (file, data, response) {
                    if (response) {
                        var image = new Image();
                        image.src = data;
                        image.onload = function () {
                            if (image.width != 88 || image.height != 31) {
                                dia.ErrorBox("<p>图片的尺寸必须是 88px * 31px ！</p>");
                            } else {
                                var $img = $("#up_LinkImg");
                                $img.show();
                                $img.attr("src", data);
                            }
                        };
                    }
                }
            });
        }, null);

        $("#up_btnSubmit").on("click", function () {
            var linkName = $("#up_txtLinkName").val();
            if (linkName == "") {
                dia.ErrorBox(keyWord + "名称不能为空！");
                return;
            }
            var linkImg = "";
            if (comLinkType == 1) {
                linkImg = $("#up_LinkImg").attr("src");
                if (linkImg == "") {
                    dia.ErrorBox("请上传" + keyWord + "图片！");
                    return;
                }
            }
            var link = $("#up_txtLink").val();
            if (link == "") {
                dia.ErrorBox(keyWord + "链接不能为空！");
                return;
            }
            var linkReg = /^http:\/\/.*$/;
            if (!linkReg.test(link)) {
                dia.ErrorBox(keyWord + "链接格式错误！");
                return;
            }

            var linkId = obj.parents("tr").find("td:eq(0)").html().trim();
            $.ajax({
                type: "POST",
                url: controller+"/ComManager/UpdateFriendlyLink.html",
                data: "LinkId=" + linkId + "&LinkName=" + encodeURIComponent(linkName) + "&LinkImg=" + encodeURI(linkImg) + "&LinkUrl=" + link + "&LinkType=" + comLinkType + "&updateType=" + updateType,
                success: function (json) {
                    if (json.res == 1) {
                        dia.SuccessBox("修改成功！");
                        window.location.reload();
                    }
                    else {
                        dia.ErrorBox("修改出错，请稍后再试！");
                    }
                },
                error: function () {
                    dia.ErrorBox("修改出错，请稍后再试！");
                }
            });
        });
    };

    return {
        SetShowType: SetShowType,
        DelFriendlyLink: DelFriendlyLink,
        AddFriendlyLink: AddFriendlyLink,
        UpdateFriendlyLink: UpdateFriendlyLink
    };
});