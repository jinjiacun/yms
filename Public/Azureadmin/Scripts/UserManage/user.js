define(['dialog'], function (dialog) {
    var searchCompany = '';
    return {
        ShowDetail:function (id) {
            var tip = dialog.ShowTip('请稍候...');
            $.post(controller+'/UserManager/GetDetails', { 'ComUserId': id}, function (data) {
                tip.close();
                var companyRow = '';
                var layer = dialog.LoadEle("<div class=\"widget-box\" id=\"div_edit\">"
                  +"<div class=\"widget-title\">"
                   +"           <span class=\"icon\">"
                   +"  <i class=\"icon-align-justify\"></i>"
                   +"           </span>"
                   +"<h5>编辑</h5>"
                  +"</div>"
                  +"    <div class=\"widget-content nopadding\">"
                  +"    <form id=\"form_edit\" action=\"/UserManage/SaveComUser/\" method=\"post\""
                  +"      class=\"form-horizontal\">"
                  +"      <div class=\"control-group\">"
                  +"         <label class=\"control-label\">VIP等级</label>"
                  +"         <div class=\"controls\">"
                  +"             <select id=\"VipLevel\" name=\"VipLevel\" class=\"s-auto\">{0}</select>"
                  +"          </div>"
                  +"      </div>"
                  +"      <div class=\"control-group\">"
                  +"          <label class=\"control-label\">状态</label>"
                  +"          <div class=\"controls\">"
                  +"              <select id=\"UCState\" name=\"UCState\" class=\"s-auto\">"
                  +"                  <option value=\"0\">禁用</option>"
                  +"                  <option value=\"1\">启动</option>"
                  +"</select>"
                  +"          </div>"
                  +"      </div>"
                  +"      <div class=\"form-actions\">"
                  +"          <button type=\"button\" onclick=\"SaveComUser('{2}');\" class=\"btn btn-primary\">保存</button>"
                  +"      </div>"
                  +"  </form>"
                +"</div>"
            +"</div>");

            }, 'json');
        }

    }
}); 
