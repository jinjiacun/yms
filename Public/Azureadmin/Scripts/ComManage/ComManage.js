/// <reference path="../../Views/ComManage/Edit_ComIntro.cshtml" />
function editComTable() {
    require(["dialog"], function (dia) {
        dia.OpenIframe(controller+"/ComManager/ComTable_Oper.html", " width='600' height='630' ", {
            fixed: false
    });
    });
}

function editImg() {
    require(["dialog"], function (dia) {
        dia.OpenIframe(controller+"/ComManager/ComTable_Img.html", " width='1200' height='600' ");
    });
}

function editComInit() {
    require(["dialog"], function (dia) {
        dia.OpenIframe(controller+"/ComManager/ComInit_Oper.html", " width='500' height='190' ");

    });
}

function editLogo() {
    require(["dialog"], function (dia) {
        dia.OpenIframe(controller+"/ComManager/ComTable_Logo.html", " width='500' height='490' ");
    });
}

function editComIntro() {
    window.open(controller+"/ComManager/Edit_ComIntro");
}

function editComSafe() {
    window.open(controller+"/ComManager/Edit_ComSafe");
}

