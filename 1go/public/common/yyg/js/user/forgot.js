$(function () {
    var jiyan_confirm;
    var time_reset = 120;
    var time_index;
    var is_phone_sent = false;
    var forgot_token = '';
    var pattern_code = /\d{6}/;
    var time_redirect = 3;
    var func = {
        init: function () {
            func.chk_countdown();
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
            $(".vacode").addClass("disabled").removeClass("jiyan_phone_code");
            $(".vacode").html(time_sec + "秒后重试");
            time_index = window.setInterval(function () {
                $(".vacode").html(--time_sec + "秒后重试");
                if (time_sec == 0) {
                    $(".vacode").html('再次获取').addClass("jiyan_phone_code").removeClass("disabled");
                    window.clearInterval(time_index);
                }
                //alert(0)
            }, 1000)
        },
        
        get_phone_code: function () {
            var url = $("#get_phone_code_forgot").val();
            var param = $("#form_verify").serialize();
            common.ajax_post(url, param, true, function (rt) {
                common.check_ajax_post(rt, function () {
                    is_phone_sent = true;
                    layer.msg("获取短信验证码成功!");
                    func.time_clock(time_reset);
                }, function (obj) {
                    var tips = "";
                    switch (obj.code) {
                        case "-100":
                            tips = "手机号码格式不正确";
                            break;
                        case "-105":
                            tips = "该手机未注册";
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
        check_phone:function(){
            var url = $("#forgot_check_phone").val();
            var param = $("#form_verify").serialize();
            common.ajax_post(url, param, true, function (rt) {
                common.check_ajax_post(rt, function (obj) {
                    forgot_token = obj['token'];
                    func.ui_step_2();
                }, function (obj) {
                    var tips = "";
                    switch (obj.code) {
                        case "-200":
                            tips =  "手机号不能为空";
                            break;
                        case "-210":
                            tips = "手机验证码不能为空";
                            break;
                        case "-220":
                            tips = "手机验证码不存在";
                            break;
                        case "-230":
                            tips = "手机验证码已过期";
                            break;
                        case "-240":
                            tips = "使用次数超出规定范围";
                            break;
                        case "-250":
                            tips = "验证码不可用";
                            break;
                        case "-260":
                            tips = "设置验证码失败";
                            break;
                        case "-270":
                            tips = "验证码已失效";
                            break;
                        case "-290":
                            tips = "用户不存在";
                            break;
                    }
                    layer.msg(tips);
                });

            }, true, [0.3, "#444"])
        },
        set_passwd:function(){
            var url = $("#forgot_set_passwd").val();
            var param = {'passwd':$('input[name=password]').val(),'token':forgot_token};
            common.ajax_post(url, param, true, function (rt) {
                common.check_ajax_post(rt, function (obj) {
                    func.ui_step_3();
                }, function (obj) {
                    var tips = "";
                    switch (obj.code) {
                        case "-210":
                            tips =  "非法访问";
                            break;
                        case "-220":
                            tips = "修改失败";
                            break;
                    }
                    layer.msg(tips);
                });

            }, true, [0.3, "#444"])
        },
        ui_step_2:function(){
            $('.step>li').removeClass('active').eq(1).addClass('active');
            $('.reg-main>.reg_form').hide().eq(1).show();
        },
        ui_step_3:function(){
            $('.step>li').removeClass('active').eq(2).addClass('active');
            $('.reg-main>.reg_form').hide().eq(2).show();
            var redirect_timer = window.setInterval(function(){
                $('.redirect_timer').text(time_redirect--);
                if(time_redirect<=0){
                    window.location.href = $('.redirect_timer').next('a').attr('href');
                }
            },1000);
        }
    };


    
    $(document).on("click", '#btn_phone_code', function () {
        func.vacode();
    });
    //验证码获取
    $(document).on("click", ".jiyan_phone_code", function () {
        //func.time_clock(time_reset);
        func.vacode();
    });
    //验证码文本框输入事件
    $(document).on('keyup', 'input[name=code]', function (e) {
        var $this = $(this);
        console.log(pattern_code.test($this.val()),is_phone_sent);
        if(pattern_code.test($this.val()) && is_phone_sent){
            $('#step1_next').removeClass('disable');
        }else{
            $('#step1_next').addClass('disable');
        }
    });
    //验证完成
    $(document).on("click", '#step1_next', function () {
        var $this = $(this);
        if($this.hasClass('disable'))return false;
        func.check_phone();
    });
    $(document).on('click','#step2_finish',function(){
        var $this = $(this);
        if($('input[name=password]').val().length>0&&$('input[name=password]').val()==$('input[name=re_password]').val()){
            func.set_passwd();
        }else{
            layer.msg('请填写密码,并确认');
        }
    });
    func.init();
});