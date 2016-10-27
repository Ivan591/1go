
$(function () {
    var func = {
        init: function () {

        },
        //保存内容
        submit: function () {
            var url = $("#submit_url").val();
            var param = $("#form_content").serialize();
            common.ajax_post(url, param, true, function (rt) {
                common.post_tips(rt, function () {
                    common.delay(function(){
                        layer.msg('保存成功');
                        location.href = $("#root_url").val();
                    },1000,1)
                });
            }, true);
        },
        'save_and_start':function(){
            var url = $("#save_and_start").val();
            var param = $("#form_content").serialize();
            common.ajax_post(url, param, true, function (rt) {
                common.post_tips(rt, function () {
                    common.delay(function(){
                        layer.msg('保存成功');
                        location.href = $("#root_url").val();
                    },1000,1)
                });
            }, true);
        },
        'save_and_stop':function(){
            var url = $("#save_and_stop").val();
            var param = $("#form_content").serialize();
            common.ajax_post(url, param, true, function (rt) {
                common.post_tips(rt, function () {
                    common.delay(function(){
                        layer.msg('保存成功');
                        location.href = $("#root_url").val();
                    },1000,1)
                });
            }, true);
        }
    };

    $(document).on("click", ".submit_btn", function () {
        func.submit();
    });
    $(document).on("click", ".start_btn", function () {
        func.save_and_start();
    });
    $(document).on("click", ".stop_btn", function () {
        func.save_and_stop();
    });
    func.init();


    $(".upload").click(function (ev) {
        ev.preventDefault();
        var upload_url = $('#upload_img_url_system').val();
        layer.open({
            id:'up_img_iframe',
            type: 2,
            area: ['700px', '530px'],
            fix: false, //不固定
            content: upload_url,
            cancel : function () {
                var name=$("#up_img_iframe").find('iframe').attr('name');
                var content = window.frames[name].document.getElementById('return_list').value;
                if(content != '') {
                    console.log(content);
                    var pic_info = $.parseJSON(content);
                    var pic_img = $('.pic_img');
                    $('.pic_id').val(pic_info[0]['id']);

                    if(pic_img.is(":hidden")) {
                        pic_img.show();
                    }
                    pic_img.attr('src',pic_info[0]['path']);
                }


            }
        });
    })



});