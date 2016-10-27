$(function(){







    $('.trigger').click(function(){
        var obj = $(this);
        var url = obj.data('url');
        //询问框
        layer.confirm('手动触发的效果是:点击生成中奖用户,您确定要手动触发开奖吗？', {
            btn: ['确定','取消'] //按钮
        }, function(){


            common.ajax_post(url,false,true,function(rt){
                common.post_tips(rt);
            });


        });
    });

})

