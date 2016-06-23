define(['dialog'], function (dialog) {
    return {
        refresh: function () {
            var p = $('#grid a[currpage]').attr('currpage');
            if (p == null) p = 1;
            $('#grid').load('/LogManager/GetTable?page=' + p + '&r=' + Math.random() + ' #grid');
        }
    }
});