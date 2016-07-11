var ue_invest;
var ue_guarantee;
var ue_suggest;
require(["ueditor"], function () {
    ue_invest = UE.getEditor('invest', {
        toolbars: [['source', 'link', 'simpleupload', 'insertimage']]
    });
    ue_guarantee = UE.getEditor('guarantee', {
        toolbars: [['source', 'link', 'simpleupload', 'insertimage']]
    });
    ue_suggest = UE.getEditor('suggest', {
        toolbars: [['source', 'link', 'simpleupload', 'insertimage']]
    });
});

function SaveComIntro() {
    var comSafe = "{'Invest':'" + ue_invest.getContent() + "','Guarantee':'" + ue_guarantee.getContent() + "','Suggest':'" + ue_suggest.getContent() + "'}";
    $.post(controller+"/ComManager/SaveComSafe", { 'Invest':ue_invest.getContent(),'Guarantee':ue_guarantee.getContent(),'Suggest':ue_suggest.getContent()}, function (json) {
        if (json.res == 1) {
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