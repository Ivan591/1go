$(function () {
    var func = {
        //点击添加到购物车
        add_to_cart: function (nper_id, num, ref_img) {
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
                    layer.msg('不好意思,添加失败了!');
                });
            }, true);
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
        //改变购买数量
        change_num: function (input, type) {
            var last = parseInt(input.data("last"));
            isNaN(last) && (last = 1);
            var unit = parseInt(input.data("unit"));
            isNaN(unit) && (unit = 1);
            var min = parseInt(input.data("min"));
            min < unit && (min = unit);
            last < min && (min = last);
            var max = parseInt(input.data("max"));

            isNaN(min) && (min = 1);
            var now_num = parseInt(input.val());
            input.val(parseInt(now_num));
            isNaN(now_num) && input.val(min);

            if (type == 'reduce') {
                if ((parseInt(input.val()) - min) >= parseInt(min)) {
                    input.val(parseInt(input.val()) - min);
                }
                else {
                    input.val(min);
                }
            }
            else if (type == 'add') {
                var now_num = parseInt(input.val()) + min;
                input.val(now_num);
            }
            if ( now_num > max ) {
                layer.msg('该商品单次最多购买'+max+'次',{time:500});
                input.val(max);
            }

            if (parseInt(input.val()) == 0 || parseInt(input.val()) % min != 0) {
                input.val((parseInt(input.val() / min) + 1) * min)
            }
            last < parseInt(input.val()) && input.val(last);
        },


        //添加全部到购物车
        add_all_to_cart: function () {
            $("#buyAll").hide();
            //获取参数序列
            var obj = $(".w-quickBuyList-item");
            if (obj.length < 0) {
                layer.msg("没有可添加的商品哟~");
                return false;
            }

            var arr= new Array();


            $.each(obj, function (k, v) {
                var tmp = {nper_id:'',num:''};

                tmp.nper_id = obj.eq(k).data('nper');
                tmp.num = obj.eq(k).find('.participation_num').val();
                if(tmp.nper_id){
                    arr.push(tmp)
                }
            });

            var url = $("#add_to_cart_all").val();
            var param = {list:JSON.stringify(arr)};
            common.ajax_post(url,param,true,function(rt){
                $("#buyAll").show();
                common.post_tips(rt,function(){
                    layer.msg("添加成功!",{icon:1});
                    location.reload();
                });
            },true);

        }
    };
    //
    //$('.w-goods-btn-quickBuy').click(function(e){
    //    var $item = $(this).closest('.w-quickBuyList-item');
    //    func.quick_buy($item.data('nper'),$item.data('gid'));
    //});
    //$('.w-goods-btn-addToCart').click()
    //快速购买和添加购物车按钮
    $(document).on('click', '.w-goods-btn-quickBuy', function () {
        var $item = $(this).closest('.w-quickBuyList-item');
        func.quick_buy($item.data('nper'), $item.find('input').val());
    });
    $(document).on('click', '.w-goods-btn-addToCart', function () {
        var $item = $(this).closest('.w-quickBuyList-item');
        func.add_to_cart($item.data('nper'), $item.find('input').val(), $item.find('img').eq(0));
    });
    $(document).on('click', '.w-goods-buyRemain', function () {
        var $item = $(this).closest('.w-remainList-item');
        func.quick_buy($item.data('nper'), $item.data('last'));
    });
    //增加或减少数量的按钮
    $(document).on("click", ".w-number-btn.w-number-btn-plus", function (e) {
        var obj = $(this).siblings('input');
        func.change_num(obj, 'add');
    });
    //改变值的时候触发
    $(document).on("change", ".participation_num", function () {
        var obj = $(this);
        func.change_num(obj);
    });
    //离开值的时候触发
    $(document).on("mouseout", ".participation_num", function () {

        var obj = $(this);
        func.change_num(obj);
    });
    $(document).on('click', '.w-number-btn.w-number-btn-minus', function (e) {
        var obj = $(this).siblings('input');
        func.change_num(obj, 'reduce');
    });

    $(document).on("click", "#buyAll", function () {
        func.add_all_to_cart();
    });

});