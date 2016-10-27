

$(function () {
    var um =UM.getEditor('detail');
    var type= $("#type").val();
    var func = {
        init: function () {
        },
        //设置图片列表赋值
        set_pic_list:function(){
            var obj = $(".img_list").find("li");
            var index_img=$('.img_list .set_main').data('id');
            var tmp = '';
            $.each(obj,function(k,v){
                if(!common.empty(obj.data("id"))){
                    if(obj.eq(k).data("id")!=index_img){
                        tmp = tmp + obj.eq(k).data("id")+',';
                    }
                }
            });
            $("input[name='pic_list']").val(index_img+','+tmp);
        },
        //保存内容
        submit: function () {
            func.set_pic_list();
            var url = $("#submit_url").val();
            var param = $("#form_content").serialize();
            common.ajax_post(url, param, true, function (rt) {
                    common.post_tips(rt,function(){
                        location.href = $("#root_url").val();
                    });
            }, true);
        },
        //上传图片
        upload_img: function () {
            common.upload_img(function (obj) {
                $.each(obj, function (k, o) {
                    var li = '<li data-id="' + obj[k].id + '"><div class="img_exec_box"><span class="set_img_main">主图</span><span class="del_img">删除</span></div><img src="' + obj[k].path + '" data-id="' + obj[k].id + '" alt=""><span class="success"></span></li>';
                    $(".img_list").prepend(li);
                });
                //判断是否存在主图,不存在设置第一张为主图
                var obj = $(".img_list").find(".set_main");
                if(!obj.length){
                    $(".img_list").find("li").eq(0).addClass("set_main");
                    $("input[name='index_img']").val($(".img_list").find(".set_main").eq(0).data("id"));
                }
                func.set_pic_list();
            });

        },
        //设置为主图
        set_img_main: function (obj) {
            layer.confirm("确定设为主图吗?", {"icon": 3, btn: ["设为主图", "返回"], closeBtn: false, title: false}, function () {
                obj.closest("ul").find("li").removeClass("set_main");
                obj.closest("li").addClass("set_main");
                $("input[name='index_img']").val(obj.closest("li").data("id"));
                func.set_pic_list();
                layer.msg("设置主图成功,保存商品后生效");
            });
        },
        //删除图片
        del_img: function (obj) {
            layer.confirm("确定删除吗?", {"icon": 3, btn: ["删除", "返回"], closeBtn: false, title: false}, function () {
                obj.closest("li").remove();
                layer.msg("删除成功,保存商品后生效");
            });
        }
    };

    $(document).on("click", ".submit_btn", function () {
        func.submit();
    });
    //上传图片
    $(document).on("click", ".upload_img", function () {
        func.upload_img();
    });
    //设置主图
    $(document).on("click", ".set_img_main", function () {
        var obj = $(this);
        func.set_img_main(obj);
    });
    //删除图片
    $(document).on("click", ".del_img", function () {
        var obj = $(this);
        func.del_img(obj);
    });


    //选择平台获取分类内容
    $(document).on("change", "#sel_plat", function () {
        func.sel_plat();
    });


    func.init();
});