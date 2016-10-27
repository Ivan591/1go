

$(function () {
    var um =UM.getEditor('detail');
    var type= $("#type").val();
    var func = {

        //保存内容
        submit: function () {
            var url = $("#submit_url").val();
            var param = $("#form_content").serialize();
            param=param+"&type="+type;
            common.ajax_post(url, param, true, function (rt) {
                if(type=='add'){
                    common.post_tips(rt, function () {
                        layer.confirm("添加成功,需要继续添加文章吗?",{
                            "icon":1,
                            "title":false,
                            "closeBtn":false,
                            "btn":["继续添加","返回列表"]
                        },function(){
                            layer.msg("请稍候...",{'time':500});
                            $("input[name='name']").val('');
                            $("input[name='sub_title']").val('');
                            $("input[name='price']").val('');
                            $("input[name='pic_list']").val('');
                            $("input[name='index_img']").val('');
                            $(".img_list").html('');
                            UM.getEditor('detail').setContent(' ', false);
                        },function(){
                            layer.msg("请稍候...");
                            common.delay(function () {
                                location.href = $("#root_url").val();
                            }, 1000, 1)
                        });

                    });
                }
                else {
                    common.post_tips(rt,function(){
                        location.href = $("#root_url").val();
                    });

                }

            }, true);
        },


    };

    $(document).on("click", ".submit_btn", function () {
        func.submit();
    });
});