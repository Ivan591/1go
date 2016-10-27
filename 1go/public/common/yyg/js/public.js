

var public = {
    init: function () {

    },
    //退出登录
    login_out: function () {
        layer.confirm('确定退出登录吗?', {
            title: false,
            btn: ["退出登录", "返回"],
            closeBtn: false,
            shade: [0.3, "#444"]
        }, function () {
            var url = $("#login_out").val();
            common.ajax_post(url, false, true, function (rt) {
                common.check_ajax_post(rt, function () {
                    layer.msg("退出成功!页面正在刷新..");
                    common.delay(function () {
                        location.href = '/';
                    }, 1000, 1);
                }, function () {
                    layer.msg("退出登录失败");
                }, function () {
                    layer.msg("退出登录失败");
                });
            })
        });

    },
    //显示登录
    show_login: function () {
        var url = $("#show_login").val();
        common.ajax_post(url, false, true, function (rt) {
            public.check_need_verify();
            common.check_ajax_post(rt, function (obj) {
                var html = obj.html;
                layer.confirm(html, {
                    title: "请先登录",
                    move: false,
                    area: '500px',
                    btn: false,
                    type: 1
                });
            }, function () {
                layer.msg("请先登录~");
            })
        })
    },
    //检测是否需要验证码
    check_need_verify: function () {
        var url = $("#check_need_verify_url").val();
        common.ajax_post(url, false, true, function (rt) {
            common.check_ajax_post(rt, function () {
            }, function () {
                //不需要验证码
                $(".div_submit").show();
                $(".div_submit_need_verify").hide();
            })
        })
    },
    //登录
    div_login_do: function () {
        var url = $("#user_login_do_url").val();
        var param = $("#form_div_login").serialize();
        common.ajax_post(url, param, true, function (rt) {
            common.check_ajax_post(rt, function (obj) {
                layer.msg("登录成功!页面正在刷新..", {"shade": [0.3, "#333"]});
                $(".div_submit_need_verify").hide();
                $(".div_submit").show();

                common.delay(function () {
                    location.reload();
                }, 1000, 1)
            }, function (obj) {
                var tips = '';
                switch (obj.code) {
                    case "-100":
                        tips = '用户名格式不正确';
                        break;
                    case "-110":
                        tips = '用户密码格式不正确';
                        break;
                    case "-120":
                        tips = '验证码错误,请重新获取';
                        break;
                    case "-130":
                        tips = '验证码错误';
                        break;
                    case "-140":
                        tips = '用户信息不存在或已被禁用';
                        break;
                    case "-150":
                        $(".div_submit_need_verify").show();
                        $(".div_submit").hide();
                        tips = '用户名密码错误';
                        break;
                    case "-1":
                        tips = '登录失败';
                        break;
                    default:
                        tips = '登录失败';
                }
                layer.msg(tips, {time: 1000});
            });
        })
    },
    //调用geetest
    gee_test: function () {
        var jiyan = '';
        var url = $("#gee_test_url").val() + "?rand=" + Math.round(Math.random() * 10000);
        common.ajax_post(url, false, true, function (rt) {
            var obj = common.str2json(rt);
            jiyan_confirm = layer.confirm("<div class='show_jiyan'></div>", {
                "shade": [0.4, "#444"],
                "closeBtn": true,
                "type": 1,
                "btn": false,
                "title": false
            });
            //实例化极验
            initGeetest({
                gt: obj.gt,
                challenge: obj.challenge,
                product: "embed", // 产品形式
                offline: !obj.success
            }, function (captchaObj) {
                captchaObj.appendTo(".show_jiyan");
                //验证成功后回调
                captchaObj.onSuccess(function () {
                    var geetest_challenge = $(".geetest_challenge").val();
                    var geetest_validate = $(".geetest_validate").val();
                    var geetest_seccode = $(".geetest_seccode").val();

                    $("input[name='geetest_challenge']").val(geetest_challenge);
                    $("input[name='geetest_validate']").val(geetest_validate);
                    $("input[name='geetest_seccode']").val(geetest_seccode);
                    layer.close(jiyan_confirm);
                    public.div_login_do();
                });
            });
        }, true, [0.4, "#444"]);
    },
    //检测用户是否登录
    chk_user_login: function (success, faild) {
        var url = $("#get_user_login_info").val();
        common.ajax_post(url, false, true, function (rt) {
            common.check_ajax_post(rt, function () {
                success();//登录成功
            }, function () {
                faild();//登录失败
            });
        }, true)
    },
    //刷新购物车
    refresh_cart: function () {
        var url = $("#cart_list_div_url").val();

        common.ajax_post(url, false, true, function (rt) {
            common.check_ajax_post(rt, function (obj) {
                $("#cart_div_area").html(obj.html);
                typeof(obj.count) !== 'undefined' && $("#cart_num").html(obj.count);

            }, function () {
            });
        });

    },
    //去付款
    go_to_cart_list: function () {
        public.chk_user_login(function () {
            location.href = $("#cart_page_url").val();
        }, function () {
            public.show_login();
        });
    },
    //删除购物车的商品
    del_cart_by_nper_id: function (nper_id) {
        var url = $("#del_cart_by_nper_id_url").val();
        var param = {
            "nper_id": nper_id
        };
        common.ajax_post(url, param, true, function (rt) {
            common.check_ajax_post(rt, function () {
                layer.msg('已删除');
                public.refresh_cart();
            }, function () {
                layer.msg('删除失败');
            });
        }, true);
    },
    //全局触发检测
    trigger_open: function () {
        common.delay(function () {
            var url = $("#trigger_open_url").val();
            common.ajax_post(url, false, true, function (rt) {
                console.log(rt);
            });
        }, 30000, 1, true);

    },
    //全局触发彩票
    trigger_lottery: function () {
        common.delay(function () {
            var url = $("#collect_url").val();
            common.ajax_post(url, false, true, function (rt) {
                console.log(rt);
            });
        }, 30000, 1, true);

    }
};

//注销
$(document).on("click", ".login_out", function () {
    public.login_out();
});
//点击登录
$(document).on("click", ".div_submit", function () {
    public.div_login_do();
});
//需要验证码的时候显示
$(document).on("click", ".div_submit_need_verify", function () {
    public.gee_test();
});
//去购物车页面
$(document).on("click", "#go_to_cart_list", function () {
    public.go_to_cart_list();
});
//显示右上角购物车框子
$(document).on("mouseover", "#cart_list_fade_in ,#cart_box_hidden", function () {
    $("#cart_box_hidden").show();
});
//隐藏右上角购物车框子
$(document).on("mouseout", "#cart_list_fade_in", function () {
    $("#cart_box_hidden").hide();
});
//隐藏右上角购物车框子
$(document).on("click", ".del_cart_btn", function () {
    var obj = $(this);
    public.del_cart_by_nper_id(obj.data('nper'));
});
//分类菜单
$(document).on({
    "mouseenter": function () {
        if ($(this).hasClass("m-catlog-normal"))
            return;
        $(this).removeClass("m-catlog-fold").addClass("m-catlog-unfold");
        var menus = $(this).find(".m-catlog-wrap li"),
            height = menus.length * menus.eq(0).height() + 30;
        $(this).find(".m-catlog-wrap").animate({height: height}, 200);
    },
    "mouseleave": function () {
        if ($(this).hasClass("m-catlog-normal"))
            return;
        $(this).removeClass("m-catlog-unfold").addClass("m-catlog-fold").find(".m-catlog-wrap").animate({height: 0}, 200);
    }
}, ".m-catlog");
//用户
$(document).on({
    "mouseenter": function () {
        $(this).addClass("m-toolbar-myDuobao-hover");
    },
    "mouseleave": function () {
        $(this).removeClass("m-toolbar-myDuobao-hover");
    }
}, ".m-toolbar-myDuobao");

$(window).on("scroll", function () {
    if ($(".m-catlog").hasClass("m-catlog-normal")) {
        $(".m-catlog").data("nav", "index");
    }
    var nav = $(".m-catlog").data("nav"),
        fixheight = nav == "index" ? 460 : 60;
    if ($(document).scrollTop() >= fixheight) {
        $(".g-header").addClass("g-header-fixed").css({"padding-bottom": "50px"});
        if (nav == "index") {
            $(".m-catlog").removeClass("m-catlog-normal").addClass("m-catlog-fold").find(".m-catlog-wrap").height(0);
        }
    } else {
        $(".g-header").removeClass("g-header-fixed").attr({"style": ""});
        if (nav == "index") {
            $(".m-catlog").addClass("m-catlog-normal").removeClass("m-catlog-fold").find(".m-catlog-wrap").attr("style", "");
        }
    }
});

public.refresh_cart();

//全局触发开奖
public.trigger_open();

//全局彩票
public.trigger_lottery();

//全局顶部点击标签搜索
$(document).on("click",".w-search-recKey",function(){
    var obj = $(this);
    $("input[name='keyword'].w-input-input").val(obj.text());
    $("button[type='submit'].w-search-btn").trigger("click");
});

