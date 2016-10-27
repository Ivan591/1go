$(function () {
    var func = {
        "init": function () {
            func.init_cart_li();
            func.async_rand_goods();
        },
        //初始化li
        init_cart_li: function () {
            var li = $(".cart_li");
            $.each(li, function (k, v) {
                var s = li.eq(k).find('.participation_num');
                func.change_num(s);
            });
            func.sum();
        },
        //计算总价
        sum: function () {
            var money_count = $(".money_count");
            var sum = 0;
            $.each(money_count, function (k, o) {
                sum = sum + parseInt(money_count.eq(k).html());
            });
            $("#total_amount").html(sum);
        },
        //改变购买数量
        change_num: function (obj) {


            var input =obj.closest('div').find(".participation_num");
            var type;
            if (obj.hasClass('reduce_num'))type = 'reduce';
            if (obj.hasClass('add_num'))type = 'add';


            var last = parseInt(input.data("last"));
            isNaN(last) && (last = 1);
            var unit = parseInt(input.data("unit"));
            isNaN(unit) && (unit = 1);
            var max = parseInt(input.data("max"));
            (isNaN(max)||(max>1000)) && (max = 1000);
            var min = parseInt(input.data("min"));
            min < unit && (min = unit);
            last < min && (min = last);

            isNaN(min) && (min = 1);
            var now_num = parseInt(input.val());
            input.val(parseInt(now_num));
            isNaN(now_num) && input.val(min);

            if (type == 'reduce') {
                if ((parseInt(input.val()) - min) >= parseInt(min)) {
                    input.val(parseInt(input.val()) - min);

                }
                else {
                    layer.msg('该商品单次最少购买'+min+'次',{time:500});
                    input.val(min);
                }
            }
            else if (type == 'add') {
                input.val(parseInt(input.val()) + min);
            }

            if (parseInt(input.val()) == 0 || parseInt(input.val()) % min != 0) {
                input.val((parseInt(input.val() / min) + 1) * min)
            }
            if(last < parseInt(input.val())) {
                input.val(last);
                layer.msg('本期商品只剩'+last+'次购买了',{time:500});
            }
            if(parseInt(input.val())>1000){
                input.val(1000);
                layer.msg('该商品单次最多购买'+max+'次',{time:500});
            }

            func.calc(obj, parseInt(input.val()), unit);
        },
        //更新数量
        update_cart_num: function (input) {
            var url = $("#update_cart_num_url").val();
            var param = {
                nper_id: input.data('nper'),
                num: input.val()
            };
            common.ajax_post(url, param, true, function (rt) {
                common.check_ajax_post(rt, function () {
                    console.log('success');
                }, false);
            })
        },
        //计算实时价格
        calc: function (obj, num, unit) {
            obj.closest("li").find('.money_count').html(parseInt(num) * parseInt(unit));
            func.sum();
        },
        //通过nper_id删除信息,返回成功返回1
        del_cart: function (ids) {
            layer.confirm("确定删除吗?", {
                title: '提示',
                shade: [0.4, "#444"]
            }, function () {
                ids = ids.toString();
                var url = $("#del_cart_by_ids_url").val();
                var param = {
                    ids: ids
                };
                common.ajax_post(url, param, true, function (rt) {
                    common.check_ajax_post(rt, function () {
                        layer.msg('删除成功!');
                        var arr = ids.split("|");

                        $.each(arr, function (k, v) {
                            if (v) {

                                $("li[data-nper_id='" + v + "']").remove();
                                func.init_cart_li();
                            }
                        });

                        var li = $(".cart_li");
                        if (li.length < 1) {
                            $("#content_ul").append('<div class="cart-empty-tips"><p>您的清单里还没有任何商品，<a href="/">马上去逛逛~</a></p></div>');
                            $(".no_goods_hide").hide()
                        }

                    }, function () {
                        layer.msg('删除失败!');
                    })
                }, true);
            });
        },
        //异步获取随机推荐商品
        async_rand_goods: function (load) {
            var url = $("#show_rand_goods_url").val();
            common.ajax_post(url, false, true, function (rt) {
                common.check_ajax_post(rt, function (obj) {
                    $(".rand_goods").html(obj.html);
                }, function () {
                })
            }, load)
        },
        //确认信息
        pay_info_sure: function () {
            var obj = $(".sel_one:checked");
            if (obj.length < 1) {
                layer.msg("请勾选需要购买的商品后再提交!");
                return;
            }
            var ids = common.split_by_func(obj, 'data-id', '|');
            var url = $("#pay_info_url").val();
            var param = {
                "ids": ids
            };
            common.ajax_post(url, param, true, function (rt) {
                common.check_ajax_post(rt, function (obj) {
                    $("#content_area").html(obj.html);
                }, function (obj) {
                    if (!obj.code) return false;
                    if (obj.code == '-110') {
                        layer.msg('订单失效,请清空购物车后重回新添加商品!');
                    }
                    if (obj.code == '-120') {
                        location.reload();
                    }
                })
            }, true, [0.3, "#333"]);
        },
        //生成订单
        create_order: function () {
            var ids = $("#submit_ids").val();
            if (!ids) {
                layer.msg('提交错误,可能是本期商品已售空,请刷新页面再试');
                return;
            }
            var url = $("#create_order_url").val();
            var param = {
                ids: ids
            };
            common.ajax_post(url, param, true, function (rt) {
                common.check_ajax_post(rt, function (obj) {
                    if(obj.order_id){
                        var url = $("#charge_url").val()+"?id="+obj.order_id;
                        location.href = url;
                    }

                }, function (obj) {
                    if (obj.code) {
                        var tips;
                        switch (obj.code) {
                            case "-100":
                                tips = '缺少必要的参数';
                                break;
                            case "-110":
                                tips = 'ids不能为空';
                                break;
                            case "-120":
                                tips = '获取不到您的订单信息应该是已经生成订单';
                                break;
                            case "-130":
                                tips = '订单信息有误,请重新下单';
                                break;
                            case "-140":
                                tips = '本期已经售空';
                                break;
                            case "-150":
                                tips = '订单信息有误';
                                break;
                            case "-1":
                                tips = '创建订单失败#1';
                                break;
                            default:
                                tips = "创建订单失败#2";
                        }
                    }
                    layer.msg(tips);
                });
            }, true, [0.3, "#444"]);
        }
    };
    //增加或减少数量的按钮
    $(document).on("click", ".change_num_btn", function () {
        var obj = $(this);
        func.change_num(obj);
        var input = obj.closest('div').find(".participation_num");
        func.update_cart_num(input);
    });
    //改变值的时候触发
    $(document).on("change", ".participation_num", function () {
        var obj = $(this);
        func.change_num(obj);
        var input = obj.closest('div').find(".participation_num");
        func.update_cart_num(input);
    });
    //离开值的时候触发
    $(document).on("mouseout", ".participation_num", function () {
        var obj = $(this);
        func.change_num(obj);
    });
    //删除一条
    $(document).on("click", ".del_one", function () {
        var obj = $(this);
        func.del_cart(obj.data("nper_id"));

    });
    //删除多个
    $(document).on("click", ".del_all", function () {
        var obj = $('.sel_one:checked');
        if (obj.length < 1) {
            layer.msg('请先勾选需要删除的内容');
            return;
        }
        var s = '';
        $.each(obj, function (k, o) {
            s = s + '|' + obj.eq(k).data("id");
        });
        func.del_cart(s);
    });
    //全选/非全选
    $(document).on("click", ".sel_all", function () {
        var obj = $(this);
        if (obj.prop("checked")) {
            $(".sel_one").prop("checked", true);
            $(".sel_all").prop("checked", true);
        }
        else {
            $(".sel_one").prop("checked", false);
            $(".sel_all").prop("checked", false);
        }

    });
    //单个选中
    $(document).on("click", ".sel_one", function () {
        var obj = $(this);
        if (!obj.prop("checked")) {
            $(".sel_all").prop("checked", false);
        }
    });
    //刷新推荐商品
    $(document).on("click", ".refresh_rand_goods", function () {
        func.async_rand_goods(true);
    });
    //确认商品
    $(document).on("click", ".sure_order_btn", function () {
        func.pay_info_sure();
    });
    //去支付
    $(document).on("click", ".go_to_pay", function () {
        func.create_order();
    });
    func.init();
});
