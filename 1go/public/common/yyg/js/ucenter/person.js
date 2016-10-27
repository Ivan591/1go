
$(function () {
    var img_id = $("input[name='user_pic']").val();
    var jiyan_confirm;
    var time_reset = 120;
    var time_sec;
    var time_index;
    var func = {
        init: function () {
            //func.chk_countdown();
        },
        //打开上传图片的页面
        open_upload_box: function () {
            var url = $("#open_cut_box").val();
            common.ajax_post(url, false, true, function (rt) {
                common.check_ajax_post(rt, function (obj) {
                    var index = layer.confirm(obj.html, {
                        type: 1,
                        title: '修改头像',
                        btn: ["确定保存", "取消"],
                        shade: [0.3, "#444"],
                        area: ["810px", "550px"]

                    }, function () {
                        if (img_id == $("input[name='user_pic']").val()) {
                            layer.msg('没有修改头像');
                            layer.close(index);
                            return true;
                        }
                        var url = $('#save_login_user_img').val();
                        var param = {
                            "id": $("input[name='user_pic']").val()
                        };
                        common.ajax_post(url, param, true, function (rt2) {
                            common.check_ajax_post(rt2, function () {
                                layer.msg('保存成功!');
                                $("#user_img").attr("src", $("input[name='user_pic_path']").val())
                                layer.close(index);
                            }, function (obj) {
                                var tips;
                                switch (obj.code) {
                                    case "-100":
                                        tips = '图片参数不能为空';
                                        break;
                                    case "-110":
                                        tips = '图片不存在';
                                        break;
                                    default:
                                        tips = '上传失败';
                                }
                                layer.tips(tips);
                            })
                        })


                    }, function () {
                    });
                    //获取用户头像信息
                    var url = $("#get_login_user_img").val();
                    common.ajax_post(url, false, true, function (rt1) {
                        common.check_ajax_post(rt1, function (obj1) {
                            $("img.img_40").attr("src", obj1.img_path);
                            $("img.img_90").attr("src", obj1.img_path);
                            $("img.img_160").attr("src", obj1.img_path);
                            $("img.img_280").attr("src", obj1.img_path);

                            $("input[name='user_pic']").val(obj1.img_id);
                        }, function () {

                        })
                    });


                    func.init_upload();
                }, function () {
                });
            }, true);
        },
        //初始化上传按钮
        init_upload: function () {
            var uploader = WebUploader.create({
                auto: true,
                duplicate: true,
                // swf文件路径
                swf: $("#swf_path").val(),
                // 文件接收服务端。
                server: $("#server_path").val(),
                // 选择文件的按钮。可选。
                // 内部根据当前运行是创建，可能是input元素，也可能是flash.
                pick: {
                    id: '#picker',
                    multiple: false
                },
                // 不压缩image, 默认如果是jpeg，文件上传前会压缩一把再上传！
                resize: false,
                // 只允许选择图片文件。
                accept: {
                    title: 'Images',
                    extensions: 'gif,jpg,jpeg,png',
                    mimeTypes: 'image
                    func.write_countdown(null);

                    $(".mobile_text").html(phone);
                    $(".cancel_edit_mobile").trigger("click");
                }, function (obj) {
                    var tips = "";
                    switch (obj.code) {
                        case "-100":
                            tips = "手机不能为空";
                            break;
                        case "-110":
                            tips = "验证码不能为空";
                            break;
                        case "-120":
                            tips = "手机号格式错误";
                            break;
                        case "-130":
                            tips = "该手机号已经注册";
                            break;
                        case "-200":
                            tips = "手机号不能为空";
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
                        default:
                            tips = "修改失败";
                    }
                    layer.msg(tips);
                })
            }, true, [0.3, "#444"])
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
            

            $(".vacode").addClass("disabled").removeClass("get_phone_code");
            $(".vacode").html(time_sec + "s再试");
            time_index = window.setInterval(function () {
                $(".vacode").html(--time_sec + "s再试");

                
                if (time_sec % 5 == 0 && time_sec != 0) {
                    func.write_countdown(time_sec);
                }
                

                if (time_sec == 0) {

                    
                    func.write_countdown(null);
                    


                    $(".vacode").html('再次获取').addClass("get_phone_code").removeClass("disabled");
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
    };
    //上传图片
    $(document).on("click", ".open_up_box", function () {
        func.open_upload_box();
    });


    //修改手机
    $(document).on("click", ".mobile_edit_btn", function () {
        func.edit_mobile();
    });
    //取消修改手机
    $(document).on("click", ".cancel_edit_mobile", function () {
        func.cancel_edit_mobile();
    });
    //保存修改手机
    $(document).on("click", ".save_phone", function () {
        func.save_phone();
    });
    //获取手机验证码
    $(document).on("click", ".get_phone_code", function () {
        var phone = $("input[name='phone']").val();
        var phone_rex = /[1][3-9][0-9]{9}/;

        if (!phone_rex.test(phone)) {
            layer.msg("请输入正确的手机号!");
            return;
        }
        func.vacode();
    });


    //修改昵称
    $(document).on("click", ".edit_nick_name_btn", function () {
        func.edit_nick_name();
    });
    //取消修改昵称
    $(document).on("click", ".cancel_edit_nick", function () {
        func.cancel_edit_nick();
    });
    //保存修改昵称
    $(document).on("click", ".save_nick_name", function () {
        func.save_nick_name();
    });
    func.init();
});