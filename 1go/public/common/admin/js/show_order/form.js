
$(function () {
    var func = {
        init: function () {

        },
        //保存内容
        submit: function () {
            var url = $("#submit_url").val();
            var id = $("input[name='id']").val();
            var status = $("#select_status").val();
            common.ajax_post(url, {id:id,status:status}, true, function (rt) {
                common.post_tips(rt, function () {
                    common.delay(function(){
                        location.href = $("#root_url").val();
                    },1000,1)
                });
            }, true);
        }
    };

    $(document).on("click", ".submit_btn", function () {
        func.submit();
    });
    func.init();






});