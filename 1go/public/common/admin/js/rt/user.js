
$(function () {
    var times=0;
    var sum_times=0;
    var func = {
        init: function () {
            table.init();
        },
        bench_get: function () {
            var url = $('#api_user_url').val();
            layer.prompt({
                'title': "输入生成的数量[体验版]:(1-10)",
                'value': 10
            }, function (val) {
                $(".bench_get").hide();
                $(".stop_get").show();

                val = parseInt(val);
                if (!common.empty(val)) {
                    sum_times=val;
                    if (common.empty(url)) {
                        layer.msg('接口地址异常');
                        return;
                    }
                    layer.msg('正在获取,请勿关闭页面',{"time":false});
                    func.exec_get(url);
                }
                else {
                    layer.msg('请输入数字');
                }
            });
        },
        exec_get:function(url){
            times++;
            sum_times--;
            if(!sum_times){

                $(".stop_get").hide();
                $(".bench_get").show();
                layer.msg('执行完毕!');
                return;
            }

            common.ajax_post(url, false, true, function (rt) {
                common.post_tips(rt,function(){
                    layer.msg('['+times+']获取成功!');
                    table.ajax_refrash_page();
                    common.delay(function(){
                        func.exec_get(url);
                    },500,1,false)
                });
            })
        }
    };

    $(document).on("click", ".bench_get", function () {

        func.bench_get();
    });
    $(document).on("click", ".stop_get", function () {
        layer.msg('正在停止获取...',{'time':false});
        location.reload();
    });
    func.init();
});