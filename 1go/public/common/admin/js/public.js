

var pub = {
    init: function () {
        $("input[name='keywords']").keypress(function(e) {
            if(e.which == 13) {
                $(".search_btn").trigger('click');
                return false;
            }
            })
                with(this){
            init_return_top();
        }
    },
    close_page: function () {
        if (navigator.userAgent.indexOf("MSIE") > 0) {
            if (navigator.userAgent.indexOf("MSIE 6.0") > 0) {
                window.opener = null;
                window.close();
            } else {
                window.open('', '_top');
                window.top.close();
            }
        }
        else if (navigator.userAgent.indexOf("Firefox") > 0) {
            window.location.href = 'about:blank ';
        } else {
            window.opener = null;
            window.open('', '_self', '');
            window.close();
        }
    },
    del:function(id){
        layer.confirm('确认删除吗?',{title:false,closeBtn:false},function(){
            var url = $("#del_url").val();
            if(url=='undefined'){
                layer.msg('请求地址错误');
                return;
            }
            common.ajax_post(url,{"id":id},true,function(rt){
                common.post_tips(rt,function(){
                    table.ajax_refrash_page();
                    layer.msg('删除成功!');
                });
            });
        });
    },
    quit:function(){
        layer.confirm('确认退出吗?',{title:false,closeBtn:false},function(){
            var url = $("#user_quit").val();
            if(url=='undefined'){
                layer.msg('请求地址错误');
                return;
            }
            common.ajax_post(url,false,true,function(rt){
                common.post_tips(rt,function(){
                    location.reload();
                });

            });
        });
    },
    init_return_top:function(){
        if($("html body").scrollTop()>200)
        {
            $("#btn-scroll-up").show();
        }else
        {
            $("#btn-scroll-up").hide();
        }
    }
};
//关闭当前页
$(document).on("click",".close_page",function(){
    pub.close_page();
});
//表格删除按钮
$(document).on("click",".del_btn",function(){
    var obj=$(this);
    pub.del(obj.data('id'));
});
//退出登录
$(document).on("click",".quit_btn",function(){
    pub.quit();
});
$(document).on("scroll",pub.init_return_top);


pub.init();
