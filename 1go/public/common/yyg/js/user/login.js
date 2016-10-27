$(function () {
    var func = {
        init: function () {
            func.check_need_verify();
        },
        //检测是否需要验证码
        check_need_verify:function(){
            var url = $("#check_need_verify").val();
            common.ajax_post(url,false,true,function(rt){
                common.check_ajax_post(rt,function(){},function(){
                    //不需要验证码
                    $(".submit").show();
                    $(".submit_need_verify").hide();
                })
            })
        },
        //登录
        submit: function () {
            var url = $("#user_login_do").val();
            var param = $("#form_content").serialize();
            common.ajax_post(url, param, true, function (rt) {
                common.check_ajax_post(rt, function (obj) {
                    layer.msg("登录成功,正在为您跳转... ",{"shade":[0.3,"#333"]});
                    $(".submit_need_verify").hide();
                    $(".submit").show();

                    common.delay(function(){
                        location.href='/';
                    },1000,1)
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
                            $(".submit_need_verify").show();
                            $(".submit").hide();
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
                        func.submit();
                    });
                });
            }, true, [0.4, "#444"]);
        },
        //登陆成功
        success: function () {

        },
        //登录失败
        failed: function () {

        }
    };
    $(document).on("click", ".submit", function () {
        func.submit();
    });
    $(document).on("click", ".submit_need_verify", function () {
        func.gee_test();
    });

    func.init();
});