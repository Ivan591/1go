
$(function () {
    var func = {
        "init": function () {

        },
        sel_pay_money: function (obj) {
            $(".w-pay-money").removeClass('w-pay-money-selected');
            obj.addClass("w-pay-money-selected");
        },
        //提交充值
        submit:function(){
            var money = $(".w-pay-money.w-pay-money-selected").data("money");

            var plat =$(".w-pay-type.w-pay-selected").data("plat");
            var input = $(".w-pay-money.w-pay-money-selected").find(".w-input-input").val();
            if(!common.empty(parseInt(input)) && !isNaN(input))money = parseInt(input);
            if(common.empty(parseInt(plat)))plat ='alipay';
            if(isNaN(parseInt(money))||parseInt(money)==0){
                layer.msg("请输入正确的金额");return false;
            }

            $("input[name='pay_type']").val(plat);
            $("input[name='money']").val(money);
            //$("#form_recharge").submit();
        }
    };

    $(document).on("click", ".w-pay-money", function () {
        var obj = $(this);
        func.sel_pay_money(obj);
    });
    $(document).on("click", ".submit", function () {
        return func.submit();
    });
});