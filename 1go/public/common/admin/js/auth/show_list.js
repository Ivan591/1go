$(function(){


    
    $('.delete_role').click(function() {
        var obj = $(this);
        var url = $('#submit').val();

        //询问框
        layer.confirm('您确定删除该角色么？', {
            btn: ['确定','取消'] //按钮
        }, function(){
            common.ajax_post(url,{id : obj.data('id'), status : -1},true,function(rt){
                common.post_tips(rt);
                var reply_data = $.parseJSON(rt);
                if(reply_data.code == '1') {
                    obj.parent().parent().hide();
                }

            });
        });

    });



});