$(function () {
    var jiyan_confirm;
    var time_reset = 120;
    var time_sec;
    var time_index;
    var func = {
        init: function () {
            func.chk_countdown();
        },
        
        get_phone_code: function () {
            var url = $("#get_phone_code").val();
            var param = $("#form_content").serialize();
            common.ajax_post(url, param, true, function (rt) {
                common.check_ajax_post(rt, function () {
                    layer.msg("获取短信验证码成功!");
                    func.time_clock(time_reset);
                }, function (obj) {
                    var tips = "";
                    switch (obj.code) {
                        case "-100":
                            tips = "手机号码格式不正确";
                            break;
                        case "-105":
                            tips = "该手机已经存在";
                            break;
                        case "-110":
                            tips = "拖拽错误,请重新获取";
                            break;
                        case "-120":
                            tips = "验证码错误";
                            break;
                        default:
                            tips = "获取验证码失败";
                    }
                    layer.msg(tips);
                });

            }, true, [0.3, "#444"])
        },
        
        vacode: function () {
            //检查手机号是否符合规范
            var regx = /^[1][3-9][0-9]{9}$/;
            var phone=$("input[name='phone']").val();
            if(!regx.test(phone)){
                layer.msg('手机号格式不正确');
                return;
            }

            var jiyan = '';
            var url = $("#gee_test").val() + "?rand=" + Math.round(Math.random() * 10000);
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

                        func.get_phone_code();
                    });
                });
            }, true, [0.4, "#444"]);
        },
        
        time_clock: function (time_sec) {
            
            func.write_countdown(time_sec);
            

            $(".vacode").addClass("disabled").removeClass("jiyan_phone_code");
            $(".vacode").html(time_sec + "秒后重试");
            time_index = window.setInterval(function () {
                $(".vacode").html(--time_sec + "秒后重试");

                
                if (time_sec % 5 == 0 && time_sec != 0) {
                    func.write_countdown(time_sec);
                }
                

                if (time_sec == 0) {

                    
                    func.write_countdown(null);
                    


                    $(".vacode").html('再次获取').addClass("jiyan_phone_code").removeClass("disabled");
                    window.clearInterval(time_index);
                }
                //alert(0)
            }, 1000)
        },
        //向服务器写剩余时间
        write_countdown: function (func_time) {
            var url = $("#write_countdown").val();
            common.ajax_post(url, {"sec": func_time}, true, function (rt) {
                console.log(rt);
            });
        },
        //检查倒计时
        chk_countdown: function () {
            var url = $("#chk_countdown").val();
            common.ajax_post(url, false, true, function (rt) {
                common.check_ajax_post(rt, function (obj) {
                    var sec = obj.sec;
                    if (!isNaN(sec)) {
                        func.time_clock(sec);
                    }
                }, function () {
                    console.log('允许获取验证码');
                })
            });
        },
        //注册提交
        submit: function () {
            var url = $("#reg_do").val();
            var param = $("#form_content").serialize();
            common.ajax_post(url, param, true, function (rt) {
                common.check_ajax_post(rt, function (obj) {
                    func.success(obj);
                }, function (obj) {
                    func.failed(obj);
                });
            });
        },
        //注册成功
        success: function (obj) {
            if (obj.id) {
                var url = $("#set_user_location").val();

                var param = {

                    id: obj.id
                };
                common.ajax_post(url, param, true, function (rt) {
                    location.href = '/';
                });
            }

            layer.msg("注册成功,即将自动跳转到首页..", {
                "time": 5000,
                "end": function () {
                    location.href = '/';
                }
            })
        },
        //失败
        failed: function (obj) {
            $(".ift-error").remove();
            switch (obj.code) {
                case "-99":
                    layer.msg('请先勾选用户协议!');
                    break;
                case "-100":
                    _form_tip.show($("input[name='phone']"), "error", "手机号格式错误");
                    break;
                case "-110":
                    _form_tip.show($("input[name='password']"), "error", "密码格式错误");
                    break;
                case "-120":
                    _form_tip.show($("input[name='phone_code']"), "error", "手机验证码格式不正确");
                    break;
                case "-130":
                    _form_tip.show($("input[name='re_password']"), "error", "重复密码和原密码不同");
                    break;
                case "-140":
                    _form_tip.show($("input[name='phone']"), "error", "该手机号已注册");
                    break;

                case "-200":
                    _form_tip.show($("input[name='phone']"), "error", "手机号不能为空");
                    break;
                case "-210":
                    _form_tip.show($("input[name='phone_code']"), "error", "手机验证码不能为空");
                    break;
                case "-220":
                    _form_tip.show($("input[name='phone_code']"), "error", "手机验证码不存在");
                    break;
                case "-230":
                    _form_tip.show($("input[name='phone_code']"), "error", "手机验证码已过期");
                    break;
                case "-240":
                    _form_tip.show($("input[name='phone_code']"), "error", "使用次数超出规定范围");
                    break;
                case "-250":
                    _form_tip.show($("input[name='phone_code']"), "error", "验证码不可用");
                    break;
                case "-260":
                    _form_tip.show($("input[name='phone_code']"), "error", "设置验证码失败");
                    break;
                case "-270":
                    _form_tip.show($("input[name='phone_code']"), "error", "验证码已失效");
                    break;
                case "-1":
                    layer.msg('写入数据用户失败');
                    break;
                default:
                    layer.msg("提交失败");
            }
        }
    };


    
    $(document).on("click", ".submit", function () {
        func.submit();
    });
    //验证码获取
    $(document).on("click", ".jiyan_phone_code", function () {
        //func.time_clock(time_reset);
        func.vacode();
    });

    func.init();
});