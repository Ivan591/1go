$(function(){


    $('.select_son_status').change(function(){
        var obj = $(this);
        var url = $('#submit_son').val();
        var status = obj.val();
        //询问框
        layer.confirm('您确定要改变订单状态么？', {
            btn: ['确定','取消'] //按钮
        }, function(){
            common.ajax_post(url,{id : obj.attr('id'), status : obj.val(), table : 'order_list'},true,function(rt){
                common.post_tips(rt);
            });

            if(status == -1) {
                obj.parent().parent().remove();
            }
        });
    });


    $('.see_luck').click(function(){
        var see_luck = $(this);
        var url = $('#see_luck_url').val();
        common.ajax_post(url,{order_id : see_luck.attr('order_id')},true,function(rt){
            common.post_tips(rt,function(obj){
                layer.alert(obj.list,{
                    title:'幸运数字列表'
                });
            });
        });
    });


    $('.select_status').change(function(){
        var obj = $(this);
        var url = $('#submit').val();
        var status = obj.val();
        //询问框
        layer.confirm('您确定要改变订单状态么？', {
            btn: ['确定','取消'] //按钮
        }, function(){


            common.ajax_post(url,{id : obj.attr('id'), status : obj.val(), table : 'order_list_parent'},true,function(rt){
                common.post_tips(rt);
            });

            if(status == -1) {
                obj.parent().parent().remove();
            }

        });
    });

});

