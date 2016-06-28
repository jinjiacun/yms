define(['dialog'], function (dialog) {
    return {
        refresh: function () {
            $('#grid').load('/ModuleManager/GetTable?' + 'r=' + Math.random(), init);
        },
        update: function (id, state) {
            var tip = dialog.ShowTip('请稍候...');
            $.post('/ModuleManager/Update', { 'id': id, 'state': state }, function (data) {
                tip.close();
                if (data.res == 1) {
                    a();
                } else {
                    dialog.ErrorBox('操作失败');
                }
            }, 'json');
        }
    }
});