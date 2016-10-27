

$(function () {
    var um =UM.getEditor('detail');
    var type= $("#type").val();
    var func = {
        init: function () {
            func.init_plat();
            func.sel_plat();
            if(type != 'add') {
                func.sel_goods();
            }
        },
        //编辑的时候选中默认的mid,选中默认的分类
        init_plat:function(){
            var mid = $("#mid").val();
            if(mid){
                $("#sel_plat").find("option[value='"+mid+"']").prop('selected',true);
            }

        },
        //保存内容
        submit: function () {
            var url = $("#submit_url").val();
            var param = $("#form_content").serialize();
            common.ajax_post(url, param, true, function (rt) {
                if(type=='add'){
                    common.post_tips(rt, function () {
                        layer.confirm("添加成功,需要继续添加商品推荐吗?",{
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
        //ajax获取平台分类内容
        sel_plat:function(){
            var url = $("#sel_plat_url").val();
            var param ={"id": $("#sel_plat").find("option:selected").val()};
            common.ajax_post(url,param,false,function(rt){
                common.post_tips(rt,function(obj){
                    $("select[name='category']").html(obj.html);
                });
                var category =$("#category").val();
                if(category){
                    $("select[name='category']").find("option[value='"+category+"']").prop('selected',true);
                }
            });
        },
        //ajax获取分类商品内容
        sel_goods:function(){
            var url = $("#sel_goods_url").val();
            var param ={"id": $("#sel_goods").find("option:selected").val()};
            common.ajax_post(url,param,false,function(rt){
                common.post_tips(rt,function(obj){
                    $("select[name='gid']").html(obj.html);
                });
                var goods =$("#goods").val();
                if(goods){
                    $("select[name='gid']").find("option[value='"+goods+"']").prop('selected',true);
                }
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


    //选择平台获取分类内容
    $(document).on("change", "#sel_plat", function () {
        func.sel_plat();
    });

    //选择分类获取商品内容
    $(document).on("change", "#sel_goods", function () {
        func.sel_goods();
    });


    func.init();

    $(".upload").click(function (ev) {
        ev.preventDefault();
        var upload_url = $('#upload_url').val();
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