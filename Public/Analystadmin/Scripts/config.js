require.config({
    baseUrl: resource+"/scripts",
    urlArgs: "r=" + Math.random(),
    paths: {
        artDialog: "lib/artDialog/jquery.artDialog",
        dialog: "dialog",
        ueditor: "Lib/ueditor/ueditor.all",
        signalR: "Lib/signalR/jquery.signalR-2.0.0.min",
        json2: "Lib/signalR/json2.min"
    },
    shim: {
        signalR: {
            deps: ['json2'],
            exports: 'signalR'
        }
    }
});