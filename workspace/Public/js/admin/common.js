/**
添加按钮
*/

$("#button-add").click(function(){
    
    var url =SCOPE.add_url;
    window.location.href=url;
});


/**
添加
 */
$("#singcms-button-submit").click(function(){
    var data = $("#singcms-form").serializeArray();
    //console.log(data);
    postData={};
    $(data).each(function(i){
       postData[this.name]=this.value; 
    });
    //console.log(postData);
    //将数据post给服务器
    url = SCOPE.save_url;//跳转添加
    jump_url = SCOPE.jump_url;
    $.post(url,postData,function(result){
        if(result.status == 1){
            //成功
            return dialog.success(result.message,jump_url) ;
        }else if(result.status == 0){
            //失败
          return dialog.error(result.message) ;
            
        }
        
    },"JSON");
});