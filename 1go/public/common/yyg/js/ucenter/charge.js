
$(function () {

    var func = {
        init: function () {
            common.delay(function () {
                func.charge_list();
            }, 200, 1)
        },
        //获取订单列表
        charge_list: function (page) {
             page = page?page:$(".page_btn.cur").val();
            var month_fitter = $("input[name='month_fitter']").val();
            var url = $("#charge_list").val();
            var param = {
                page: !page ? 1 : page,
                month_fitter: month_fitter
            };
            common.ajax_post(url, param, true, function (rt) {
                common.check_ajax_post(rt, function (obj) {
                    $(".charge_list").html(obj.html);
                }, function () {
                })
            })
        },
        //筛选几个月
        time_select: function (obj) {
            var text = obj.html();
            $("input[name='month_fitter']").val(obj.data("val"));
            $(".now_sel_month").html(text);
            func.charge_list();
        }
    }

    $(document).on("click", ".charge_sel li", function () {
        var obj = $(this);
        func.time_select(obj);
    });
    $(document).on("click", ".page_btn", function () {
        var obj = $(this);
        func.charge_list(obj.data('page'));
    });
    $(document).on("click", ".charge-record-wrapper .time", function () {
        $(this).toggleClass("active");
    });
    $(document).on("click", ".charge_sel li", function () {
        $(".charge-record-wrapper >.time").removeClass("active");
    });
    func.init();
});