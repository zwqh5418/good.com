/*
前端登陆业务类
*/
var login = {
    check  : function(){
        //alert(1);调试
        //获取登陆页面用户名和密码
        var username =$('input[name="username"]').val();
       // alert(username);
        var password =$('input[name="password"]').val();
       
       if(!username){
           dialog.error('用户名不能为空');
       }
         if(!password){
           dialog.error('密码不能为空');
       }
        
        //执行异步请求
        var url  ="/index.php?m=admin&c=login&a=check";
        var data = {'username':username,'password':password};
        $.post(url,data,function(result){
           if(result.status == 0) {
               return dialog.error(result.message);
           }
            
        },'JSON');
        
    }
}