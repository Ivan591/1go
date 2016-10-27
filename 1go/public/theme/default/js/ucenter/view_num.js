$(function(){
	var func = {
        //获取获奖用户幸运数字
        see_luck_num: function (uid,nper_id) {
            var url = $("#see_luck_num").val();
            var param = {
                "uid": uid,
                "nper_id": nper_id
            };
            common.ajax_post(url, param, true, function (rt) {
                common.check_ajax_post(rt, function (obj) {
                    var tips = '<div style="width: 510px;max-height: 300px;overflow-y:auto ">' + obj.html + '</div>';
                    layer.confirm(tips, {
                        "area": '530px',
                        "btn": false,
                        "title": '夺宝号码',
                        move: false
                    });
                }, function () {
                    layer.msg('获取失败');
                })
            },true);
        },
	}
    //获取获奖用户幸运数字列表
    $(document).on('click', '.see_luck_num', function () {
        var uid = $(this).data('uid');
        var nper_id = $(this).data('nper');
        func.see_luck_num(uid,nper_id);
    });
});