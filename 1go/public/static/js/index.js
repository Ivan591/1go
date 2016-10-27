$(function(){
    var func = {
        //点击添加到购物车
        add_to_cart: function (nper_id, num,ref_img) {
            var url = $("#add_to_cart_url").val();
            var param = {
                "nper_id": nper_id,
                "num": num
            };
            common.ajax_post(url, param, true, function (rt) {
                //alert(rt);
                common.check_ajax_post(rt, function (obj) {
                    obj.num && $("#cart_num").text(obj.num);
                    if (obj.flag) {
                        if (obj.flag == '1') {
                            layer.msg('您购买本期商品数量已满,请先去购物车结算吧!');
                        }
                    }
                    else {
                        func.add_cart_effect(ref_img);
                        public.refresh_cart();
                    }

                }, function () {
                    layer.msg('本期可能已经买满,即将为您刷新页面..',{end:function(){location.reload()}});
                });
            });
        },
        //点击添加到购物车
        quick_buy: function (nper_id, num) {
            public.chk_user_login(
                //已登录
                function () {
                    var url = $("#add_to_cart_url").val();
                    var param = {
                        "nper_id": nper_id,
                        "num": num
                    };
                    common.ajax_post(url, param, true, function (rt) {
                        common.check_ajax_post(rt, function () {
                            location.href = $("#cart_page_url").val();
                        }, function () {
                            layer.msg('不好意思,添加失败了!');
                        });
                    });
                },
                function () {
                    //请求登录div
                    public.show_login();
                }
            );
        },
        //添加购物车成功后的效果
        add_cart_effect: function (start) {
            var end = $('.w-miniCart');
            var s = start.offset(),
                w = start.width(),
                h = start.height(),
                src = start.attr("src"),
                e = end.offset();
            var temp = $("<img>");
            temp.attr("style", "position:absolute;display:block;" +
                "transition:all 1s ease-in;-webkit-transition:all 1s ease-in;" +
                "z-index:999;border:1px solid #ccc;opacity:1;").css({
                "left": s.left - 1, "top": s.top - 1,
                "width": w, "height": h
            }).attr("src", src);
            $("body").append(temp);
            setTimeout(function () {
                temp.css({"left": e.left + 50, "top": e.top, "opacity": 0.3, "width": 0, "height": 0});
            }, 10)
        },
    };
    //
    //$('.w-goods-btn-quickBuy').click(function(e){
    //    var $item = $(this).closest('.w-quickBuyList-item');
    //    func.quick_buy($item.data('nper'),$item.data('gid'));
    //});
    //$('.w-goods-btn-addToCart').click()
    $(document).on('click','.w-button.w-goods-quickBuy',function(){
        var $item = $(this).closest('.w-goodsList-item,.w-goods-quickBuy-warp');
        func.quick_buy($item.data('nper'),$item.data('min'),$item.find('img'));
    });
    $(document).on('click','.w-button.w-button-addToCart',function(){
        var $item = $(this).closest('.w-goodsList-item,.w-goods-quickBuy-warp');
        func.add_to_cart($item.data('nper'),$item.data('min'),$item.find('img'));
    });
});