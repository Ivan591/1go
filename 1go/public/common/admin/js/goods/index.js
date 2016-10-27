
$(function(){
    var func = {
        init:function(){
            table.init();
        },
        //触发下一期开奖
        trigger_open:function(id){
            var url = $("#trigger_open_url").val()+'?goods_id='+id;
            common.ajax_post(url,false,true,function(rt){
                common.post_tips(rt);
            },true,[0.3,"#444"]);
        },

        lock_goods:function(id){
                var nper_url = $("#del_nper_url").val();
            if(nper_url=='undefined'){
                layer.msg('请求地址错误');
                return;
            }
                layer.confirm('是否要删除该商品下未开奖的期数?',{title:false,closeBtn:false},
                    function() {
                        common.ajax_post(nper_url,{"id":id},true,function(rt){
                            common.post_tips(rt,function(){
                                table.ajax_refrash_page();
                                layer.msg('删除期数成功!');
                            });
                        })
                    }
                )
        },

        del:function(id){
            layer.confirm('确认删除吗?',{title:false, btn: ['确定', '取消'],closeBtn:false},function(){
                var url = $("#del_url").val();
                var nper_url = $("#del_nper_url").val();
                if(url=='undefined'){
                    layer.msg('请求地址错误');
                    return;
                }

                common.ajax_post(url,{"id":id},true,'');

                layer.confirm('是否要删除该商品下未开奖的期数?',{title:false,closeBtn:false},
                    function() {
                        common.ajax_post(nper_url,{"id":id},true,function(rt){
                            common.post_tips(rt,function(){
                                table.ajax_refrash_page();
                                layer.msg('删除商品成功!');
                            });
                        })
                    },
                    function () {
                        table.ajax_refrash_page();
                        layer.msg('删除商品成功!');
                    }
                )
            });
        }

    };
    func.init();
    //二维码
    $(document).on("click", ".qr_code", function (ev) {
        var obj = $(this);
      //  func.trigger_open(obj.data("id"));
        ev.preventDefault();
        var upload_url = $('#qr_url').val();
        layer.open({
            id:'up_img_iframe',
            type: 2,
            scrollbar: false,
            area: ['600px', '530px'],
            fix: true, //不固定
            content: upload_url,
            cancel : function () {

                }



        });
    });

    //触发下一期开奖
    $(document).on("click", ".trigger_open", function () {
        var obj = $(this);
        func.trigger_open(obj.data("id"));
    });

    //删除商品期数
    $(document).on("click", ".lock_goods", function () {
        var obj = $(this);
        func.lock_goods(obj.data("id"));
    });

    //提示是否清除商品下未开奖的期数
    $(document).on("click", ".del_goods", function () {
        var obj = $(this);
        func.del(obj.data('id'));
    });

});