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


/**
编辑
*/

$('.singcms-table #singcms-edit').on('click',function(){
    var id = $(this).attr('attr-id');
    var url = SCOPE.edit_url+'&id='+id;
    window.location.href = url;
});

/*
删除
*/
$('.singcms-table #singcms-delete').on('click',function(){
    var  id = $(this).attr('attr-id');
    var  a = $(this).attr('attr-a');
    var  message = $(this).attr('attr-message');
    var  url = SCOPE.set_status_url;
    
    data={};
    data['id'] = id;
    data['status'] = -1;
    
    layer.open({
        type:0,
        title:'是否提交？',
        btn:['yes','no'],
        icon :3,
        closeBtn:2,
        content:"是否确定"+message,
        scrollbar:true,
        yes:function(){
            todelete(url,data);
        },
        
    });
    
});

function todelete(url, data){
    $.post(
        url,
        data,
        function(s){
            if(s.status == 1){
                return dialog.success(s.message,'');
            }else{
                return dialog.error(s.message);
            }
        }
       ,"JSON");
    
}


$("#button-listorder").click(function(){
    var data = $("#singcms-listorder").serializeArray();
    //console.log(data);
    postData={};
    $(data).each(function(i){
       postData[this.name]=this.value; 
    });
    //console.log(postData);
    //将数据post给服务器
    url = SCOPE.listorder_url;//跳转添加
    //jump_url = SCOPE.jump_url;
    $.post(url,postData,function(result){
        if(result.status == 1){
            //成功
            return dialog.success(result.message,result['data']['jump_url']) ;
        }else if(result.status == 0){
            //失败
          return dialog.error(result.message,result['data']['jump_url']) ;
            
        }
        
    },"JSON");
});

//修改
$('.singcms-table #singcms-on-off').on('click',function(){
    var  id = $(this).attr('attr-id');
    var  status = $(this).attr('attr-status');
    
    var  url = SCOPE.set_status_url;
    
    data={};
    data['id'] = id;
    data['status'] = status;
    
    layer.open({
        type:0,
        title:'是否提交？',
        btn:['yes','no'],
        icon :3,
        closeBtn:2,
        content:"是否确定修改状态",
        scrollbar:true,
        yes:function(){
            todelete(url,data);
        },
        
    });
    
});

//推送
$("#singcms-push").click(function(){
	var id = $("#select-push").val();
	//alert(id);测试
	if(id==0){
		return dialog.error("请选择推荐位");
		}
		push = {};
		postData = {};
		$("input[name = 'pushcheck']:checked").each(function(i){
			push[i]=$(this).val();
			});
			postData['push']=push;
			postData['position_id']=id;
			//测试有无获取到的推送数据
			//console.log(postData);return;
			var url = SCOPE.push_url;
			$.post(url,postData,function(result){
					if(result.status ==1){
						//-------
						return dialog.success(result.message,result['data']['jump_url']);
						}
					if(result.status ==0){
						//----
						 return dialog.error(result.message) ;
						}
				},"JSON");
	});
//修改状态
	