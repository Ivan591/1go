$(function(){


    $('.conf_text').change(function(){

        var conf = $(this);
        var url = $('#update_conf').val();
        //询问框
        layer.confirm('您确定要改变配置么？', {
            btn: ['确定','取消'] //按钮
        }, function(){


            common.ajax_post(url,{id : conf.data('id'), value : conf.val(), table : 'order_list'},true,function(rt){
                common.post_tips(rt);
            });
        });
    });






})

