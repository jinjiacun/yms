var ue_introduce;
var ue_download;
var ue_contact;
function SaveComIntro() {
    $("#div_soft").find("input[name='softName']").each(function () {

    });
    var comIntro = "{'Introduce':'" + ue_introduce.getContent() + "','Download':'" + ue_download.getContent() + "','Contact':'" + ue_contact.getContent() + "'}";
    $.post("/ComManage/SaveComIntro", { ComIntro: escape(comIntro) }, function (json) {
        if (json.msg == "") {
            require(["dialog"], function (dia) {
                dia.SuccessBox("保存成功.");
            });
        } else {
            require(["dialog"], function (dia) {
                dia.ErrorBox("保存失败.");
            });
        }
    });
}

$(function () {
    require(["ueditor"], function () {
        ue_introduce = UE.getEditor('introduce', {
            toolbars: [['source', 'link', 'simpleupload', 'insertimage']]
        });
        ue_download = UE.getEditor('download', {
            toolbars: [['source', 'link', 'simpleupload', 'insertimage', 'attachment']]
        });
        ue_contact = UE.getEditor('contact', {
            toolbars: [['source', 'link', 'simpleupload', 'insertimage']]
        });
    });

});