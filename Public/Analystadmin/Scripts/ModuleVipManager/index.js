define(['dialog'], function (dialog) {
    return {
        refresh: function () {
            $('#grid').load('/ModuleVipManager/GetTable?' + 'r=' + Math.random(), init);
        },
        update: function (id) {
            var rows = $("#table tr[changed=1]");
            if (rows.length == 0) {
                dialog.MsgBox('warning', '您当前没有任何修改&nbsp;&nbsp;', null, 1);
                return;
            }
            var d = rows.map(function (v) {
                var m = $(this).attr('data-tt-id');
                var c = $(this).find('img[need=1],img[enable=1]').length > 0;
                //var c = $(this).find('img[need=1]').length > 0 ? true : $(this).find('input[vip=-1]').prop('checked');
                //var v = !c ? -1 : $(this).find('input[vip!=-1]').map(function () {
                //    if ($(this).prop('checked')) {
                //        return $(this).attr('vip');
                //    }
                //}).get().join(',');
                var v;
                if ($(this).find('img[need=1]').length > 0) {
                    v = '0';
                } else if ($(this).find('img[enable=0]').length > 0) {
                    v = '-1';
                } else {
                    v = $(this).find('input[vip!=-1]').map(function () {
                        if ($(this).prop('checked')) {
                            return $(this).attr('vip');
                        }
                    }).get().join(',');
                }
                return m + '_' + v;
            }).get().join('|');
            var tip = dialog.ShowTip('请稍候...');
            $.post('/ModuleVipManager/Update', { 'data': d }, function (data) {
                tip.close();
                if (data.res == 1) {
                    dialog.SuccessBox('保存成功');
                    a();
                } else {
                    dialog.ErrorBox('操作失败');
                }
            }, 'json');
        }
    }
});