
$(function () {
    var func = {
        init: function () {
        },
        set_receive: function (value) {
            var url = $("#set_receive").val();
            var param = {
                value: value
            };
            common.ajax_post(url, param, true, function (rt) {
                common.check_ajax_post(rt, function () {
                    layer.msg("修改成功!");
                    location.reload();
                }, function () {
                    layer.msg("修改失败!");
                })
            }, true)
        }
    };
    $(document).on("click", ".set_receive", function () {
        var obj = $(this);
        func.set_receive(obj.data("val"));
    });
});