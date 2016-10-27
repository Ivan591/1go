
$(function () {
    var sec = $(".count_down").data("sec");
    var func = {
        init: function () {
            $(".get_calc_result_list").trigger('click');
            $(".w-gallery-thumbnail-item").eq(0).addClass("w-gallery-thumbnail-item-selected");
            $(".w-gallery-thumbnail-item:odd").addClass("w-gallery-thumbnail-item-odd");

            func.init_times();
            func.count_down_now();
            func.start_check();


        },
        //初始化显示参与次数
        init_times: function () {
            var s = $('.participation_num');
            func.change_num(s);
        },
        //获取计算结果
        get_calc_result_list: function (page) {
            var url = $("#get_calc_result_list").val();
            var param = {
                "id": $("#nper_id").val(),
                "page": page
            };
            common.ajax_post(url, param, true, function (rt) {
                common.check_ajax_post(rt, function (obj) {
                    $('.calc_result_list_content').html(obj.html);
                    //移除再次请求事件
                    $(".get_calc_result_list").removeClass('get_calc_result_list');

                }, function () {
                    layer.msg('数据请求失败');
                });
            })
        },
        //获取夺宝记录信息,填入相应区域
        get_deposer_list: function (page) {
            var url = $("#get_deposer_list").val();
            var param = {
                "id": $("#nper_id").val(),
                "page": page
            };
            common.ajax_post(url, param, true, function (rt) {
                common.check_ajax_post(rt, function (obj) {
                    $('.deposer_list_content').html(obj.html);
                    //移除再次请求事件
                    $(".get_deposer_list").removeClass('get_deposer_list');
                }, function () {
                    layer.msg('数据请求失败');
                });

            })
        },
        //获取晒单记录信息,填入相应区域
        get_delivery_list: function (page) {
            var url = $("#get_delivery_list").val();
            var param = {
                "id": $("#goods_id").val(),
                "page": page
            };
            common.ajax_post(url, param, true, function (rt) {
                common.check_ajax_post(rt, function (obj) {
                    $('.delivery_list_content').html(obj.html);
                    //移除再次请求事件
                    $(".get_delivery_list").removeClass('get_delivery_list');
                }, function () {
                    layer.msg('数据请求失败');
                });
            })
        },
        //获取往期夺宝记录
        get_history_list: function (page) {
            var url = $("#get_history_list").val();
            var param = {
                "id": $("#goods_id").val(),
                "page": page
            };
            common.ajax_post(url, param, true, function (rt) {
                common.check_ajax_post(rt, function (obj) {
                    $('.history_content').html(obj.html);
                    //移除再次请求事件
                    $(".get_history_list").removeClass('get_history_list');
                    //初始化倒计时
                    var dom=$(".cd-t");
                    dom.each(function(k,o){
                        _count_down($(this),function(dom){
                            var url = $("#nper_open_api").val();
                            var param = {
                                "nper_id": dom.eq(k).data("nper")
                            };
                            common.ajax_jsonp(url, param, function (obj) {
                                common.check_ajax_post(obj, function () {
                                    func.get_history_list();
                                }, function () {

                                })
                            });
                        });
                    });

                }, function () {
                    layer.msg('数据请求失败');
                });
            })
        },
        //获取获奖用户幸运数字
        see_luck_num: function () {
            var url = $("#see_luck_num").val();
            var param = {
                "uid": $("#luck_uid").val(),
                "nper_id": $("#nper_id").val()
            };
            common.ajax_post(url, param, true, function (rt) {
                common.check_ajax_post(rt, function (obj) {
                    var tips = '<div style="width: 510px;max-height: 300px;overflow-y:auto ">' + obj.html + '</div>';
                    layer.confirm(tips, {
                        "area": '530px',
                        "btn": false,
                        "title": 'ta的夺宝号码',
                        move: false
                    });
                }, function () {
                    layer.msg('获取失败');
                })
            });
        },
        //点击添加到购物车
        add_to_cart: function (nper_id, num) {
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
                        func.add_cart_effect();
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
        //显示登录
        show_login: function () {

        },
        //添加购物车成功后的效果
        add_cart_effect: function (start, end) {
            start = $('.w-gallery-picture').find("img").eq(0);
            end = $('.w-miniCart');
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
        change_num: function (obj) {
            var input = $(".participation_num");
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
        },
        //倒计时开始
        count_down_now: function () {
            var sec = $(".count_down").data('sec');

            if (!common.empty(sec)) {
                common.count_down(sec, {
                    min: $('.cd_min'),
                    sec: $('.cd_sec'),
                    ms: $('.cd_ms')
                }, function () {
                    location.reload();
                });
            }

        },
        //开奖检测
        chk_lottery: function () {

            var url = $("#nper_open_api").val();
            var param = {
                "nper_id": $("#nper_id").val()
            };
            common.ajax_post(url,param,true,function(rt){
                common.check_ajax_post(rt, function () {
                    location.reload();
                }, function () {

                })
            });

        },
        //启动彩票开奖检测进程
        start_check: function () {
            var status = $('#nper_status').val();
            if (status == '2' || sec == '0') {
                func.chk_lottery();
                common.delay(function () {
                    func.chk_lottery();
                }, 5000, '-1', true);
            }
        }
    };

    //点击获取计算结果
    $(document).on("click", ".get_calc_result_list", function () {
        func.get_calc_result_list();
    });
    //点击获取夺宝记录
    $(document).on("click", ".get_deposer_list", function () {
        func.get_deposer_list();
    });
    //点击晒单获取晒单记录
    $(document).on("click", ".get_delivery_list", function () {
        func.get_delivery_list();
    });
    //点击获取往期夺宝
    $(document).on("click", ".get_history_list", function () {
        func.get_history_list();
    });
    //翻页
    $(document).on('click', '.page_btn', function () {
        var obj = $(this);
        var flag = obj.closest('.xc_pages').data('flag');
        var page = obj.data('page');
        switch (flag) {
            case 'calc_result':
                func.get_calc_result_list(page);
                break;
            case 'deposer':
                func.get_deposer_list(page);
                break;
            case 'deposer':
                func.get_deposer_list(page);
                break;
            case 'delivery':
                func.get_delivery_list(page);
                break;
            case 'history':
                func.get_history_list(page);
                break;
        }
    });
    //获取获奖用户幸运数字列表
    $(document).on('click', '.see_luck_num', function () {
        func.see_luck_num();
    });
    //立即购买
    $(document).on("click", ".buy_now_btn", function () {
        var obj = $(this);
        var type = obj.data('type');
        var id = obj.data('id');
        var nper = obj.data('nper');
        var num = obj.closest('#no_lottery').find('.participation_num').val();
        switch (type) {
            case "add_to_cart":
                func.add_to_cart(nper, num);
                break;
            case "quick_buy":
                func.quick_buy(nper, num);
                break;
            default:
                func.quick_buy(nper, num);
        }
    });
    //增加或减少数量的按钮
    $(document).on("click", ".change_num_btn", function () {
        var obj = $(this);
        func.change_num(obj);
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
    $(document).on("mouseenter", ".w-gallery-thumbnail-item", function () {
        $(".w-gallery-thumbnail-item").removeClass("w-gallery-thumbnail-item-selected");
        $(this).addClass("w-gallery-thumbnail-item-selected");
        $(".w-gallery-picture img").attr("src", $(this).find("img").attr("src"));
        $(".w-gallery i.ico-arrow").css({"left": $(this).index() * 86 + 32});
    });
    func.init();

});