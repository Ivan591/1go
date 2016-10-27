
$(function () {
    var index_chk_pay_result;
    var func = {
        init: function () {
            func.count_dowm();
            func.chk_balance_flag();
            //func.set_form_action();
        },
        //倒计时
        count_dowm: function () {
            var sec = parseInt($("#count_down").data('sec') * 1000);
            common.count_down(sec, {
                hour: "#count_down .hour",
                min: "#count_down .min",
                sec: "#count_down .sec"
            }, function () {
                location.reload();
            });
        },
        //计算使用余额后的价格
        "calc_still_price": function () {
            $("#id_still_pay").html();
        },
        chk_balance_flag: function () {
            var obj = $("#balance_flag");
            if (obj.prop("checked")) {
                $("#id_still_pay").html($("#still_money").val());
                $("input[name='balance_flag']").val("1")
                $("#submit_form").attr('target','_self');

            }
            else {
                $("#id_still_pay").html($("#price").val());
                $("input[name='balance_flag']").val("")
                $("#submit_form").attr('target','_blank');
            }
        },
        //设置form的action
        set_form_action: function () {
            //var url = $(".pay_btn").data("url");
            //$("#submit_form").attr("action", url);
        },
        //显示支付成功刷新信息
        show_msg: function () {
            var s = layer.confirm("", {
                title: "提示",
                "btn": ["我已支付", "重新选择支付方式"],
                shade: [0.4, "#444"],
                type: 1,
                move: false
            }, function () {
                var url = $("#check_pay_status").val();
                var param = {
                    "order": $_GET['id']
                };
                common.ajax_post(url, param, true, function (rt) {
                    common.check_ajax_post(rt,
                        //已付款
                        function (obj) {
                            location.reload();
                        },
                        //没付款
                        function (obj) {
                            layer.close(s);
                            layer.confirm("您还没有支付成功哦,请选择下一步的操作", {
                                "btn": ["继续支付", "返回首页"],
                                "end":function(){
                                    window.clearInterval(index_chk_pay_result);
                                }
                            }, function () {
                                location.reload();
                            }, function () {
                                location.href = '/';
                            });
                        });
                });
            }, function () {

            });
        },
        //检测订单支付状态
        chk_pay_result:function(){
            var url = $("#check_pay_status").val();
            var param = {
                "order": $_GET['id']
            };
            index_chk_pay_result = window.setInterval(function(){
                common.ajax_post(url, param, true, function (rt) {
                    common.check_ajax_post(rt,
                        //已付款
                        function (obj) {
                            location.reload();
                            console.log('已经付款');
                            window.clearInterval(index_chk_pay_result);
                        },
                        //没付款
                        function (obj) {
                            console.log('还没付款');
                        });
                });
            },3000);
        }
    };

    $(document).on("click", ".pay_btn", function () {
        var obj = $(this);
        $(".pay_btn").removeClass("w-pay-selected");
        obj.addClass("w-pay-selected");
    });
    //是否使用余额
    $(document).on("click", "#balance_flag", function () {
        func.chk_balance_flag();

    });
    //提交支付
    $(document).on("click", ".pay_right_now", function () {
        func.chk_balance_flag();
        if($("#balance_flag").prop("checked")){
            layer.msg('正在支付,请稍候...',{time:false,shade:[0.3,"#444"]});
        }
        else{
            func.show_msg();
            func.chk_pay_result();
        }
    });
    func.init();
});

