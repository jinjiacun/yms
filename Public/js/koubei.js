 var domain = 'http://192.168.1.131/yms/';
 function koubei_register(uname, mobile, vcode, password)
 {
 //注册
    $.ajax(  
     {  
            type:'post',  
            url : domain+'User/user_register',  
            data:{"nickname":uname, "mobile":mobile, "verify":vcode, "pswd":password, "ex":123, "submit":'submit'},
            success  : function(data) {
                if(1 == data)
                {
                    subok(1,"成功注册");
                }
                else if(-1 == data)
                {
                    GetSubmitState(-100, null);
                }
                else if(-2 == data)
                {
                    GetSubmitState(-101, null);
                }
                else if(-3 == data)
                {
                    GetSubmitState(-102, null);
                }
                else if(-4 == data)
                {
                    GetSubmitState(-103, null);
                }
                else{
                    GetSubmitState(0, null);
                }
            },  
            error : function() {  
                GetSubmitState(0, null);
            }  
     });
}