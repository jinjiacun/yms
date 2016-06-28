/// <reference path="../../Views/ComManage/Edit_ComIntro.cshtml" />
function editComTable() {
    require(["dialog"], function (dia) {
        dia.OpenIframe("ComTable_Oper.html", " width='600' height='630' ", {
            fixed: false
    });
    });
}

function editImg() {
    require(["dialog"], function (dia) {
        dia.OpenIframe("ComTable_Img.html", " width='1200' height='600' ");
    });
}

function editComInit() {
    require(["dialog"], function (dia) {
        dia.OpenIframe("ComInit_Oper.html", " width='500' height='190' ");

    });
}

function editLogo() {
    require(["dialog"], function (dia) {
        dia.OpenIframe("ComTable_Logo.html", " width='500' height='490' ");
    });
}

function editComIntro() {
    window.open("/ComManage/Edit_ComIntro");
}

function editComSafe() {
    window.open("/ComManage/Edit_ComSafe");
}

