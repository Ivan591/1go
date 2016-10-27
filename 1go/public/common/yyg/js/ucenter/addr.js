
$(function () {

    var func = {
        init: function () {
            func.city_data();
            common.delay(function () {
                func.refresh_user_addr_list();
            }, 100, 1)
        },
        //city_data
        //初始化城市数据
        city_data: function () {
            $.cxSelect.defaults.url = $("#city_data").val();

            $('#city_china').cxSelect({
                selects: ['province', 'city', 'area']
            });


        },
        //获取用户地址列表
        refresh_user_addr_list: function () {
            var url = $("#addr_list").val();
            common.ajax_post(url, false, true, function (rt) {
                common.check_ajax_post(rt, function (obj) {
                    $(".addr_list").html(obj.html);
                    $(".addr_num").html(obj.num);
                    $(".addr_num_last").html(obj.last_num);
                }, function () {
                });
            })
        },
        //添加一条新地址
        add_new_addr: function () {
            var url = $("#add_new_addr").val();
            var param = $("#form_content").serialize();
            common.ajax_post(url, param, true, function (rt) {
                common.check_ajax_post(rt, function () {
                    func.refresh_user_addr_list();
                    if(!$("input[name='id']").val()){
                        layer.msg("添加成功");
                    }
                    else{
                        layer.msg("保存成功");
                        $("input[name='id']").val('');
                    }
                    $("#form_content")[0].reset();
                }, function (obj) {
                    var tips = "";
                    switch (obj.code) {
                        case "-100":
                            tips = "每个用户最多添加5条地址记录";
                            break;
                        case "-110":
                            tips = "参数错误";
                            break;
                        case "-120":
                            tips = "姓名不能为空";
                            break;
                        case "-130":
                            tips = "邮编不能为空";
                            break;
                        case "-140":
                            tips = "地址不能为空";
                            break;
                        case "-150":
                            tips = "手机不能为空";
                            break;
                        case "-160":
                            tips = "省份不能为空";
                            break;
                        case "-170":
                            tips = "城市不能为空";
                            break;
                        case "-180":
                            tips = "地区不能为空";
                            break;
                        default:
                            tips = "每个用户最多添加5条地址记录,请先删除再添加"
                    }
                    layer.msg(tips);
                });
            }, true)
        },
        //删除地址
        del_addr_by_id: function (id) {
            layer.confirm("确定删除吗?", {
                btn: ["删除", "不删除"],
                move: false,
                shade: [0.3, "#444"]
            }, function () {
                var url = $("#del_addr_by_id").val();
                var param = {
                    id: id
                };
                common.ajax_post(url, param, true, function (rt) {
                    common.check_ajax_post(rt, function () {
                        layer.msg("删除成功!");
                        func.refresh_user_addr_list();
                    }, function () {
                        layer.msg("删除失败!")
                    })
                }, true)
            });

        },
        //编辑地址
        edit_addr_by_id:function(id){
            //获取地址详情
            var url = $("#get_addr_info_by_id").val();
            var param= {
                id:id
            };
            common.ajax_post(url,param,true,function(rt){
                common.check_ajax_post(rt,function(obj){
                    if(obj.data.provice){
                        $("select[name='province']").find("option[value='"+obj.data.provice+"']").prop("selected",true).trigger("change");
                    }
                    if(obj.data.city){
                        $("select[name='city']").find("option[value='"+obj.data.city+"']").prop("selected",true).trigger("change");
                    }
                    if(obj.data.area){
                        $("select[name='area']").find("option[value='"+obj.data.area+"']").prop("selected",true).trigger("change");
                    }
                    //func.city_data();
                    if(obj.data.type){
                        $("input[name='default_addr']").prop('checked',true);
                    }
                    if(obj.data.phone){
                        $("input[name='phone']").val(obj.data.phone);
                    }
                    if(obj.data.address){
                        $("textarea[name='address']").html(obj.data.address);
                    }
                    if(obj.data.code){
                        $("input[name='code']").val(obj.data.code);
                    }
                    if(obj.data.name){
                        $("input[name='name']").val(obj.data.name);
                    }
                    if(obj.data.id){
                        $("input[name='id']").val(obj.data.id);
                    }
                    if(obj.data.sn_id){
                        $("input[name='sn_id']").val(obj.data.sn_id);
                    }
                },function(){
                    layer.msg("暂时无法修改")
                })
            },true)
        }

    };
    //保存地址
    $(document).on("click", ".save_btn", function () {
        func.add_new_addr();
    });
    //删除地址
    $(document).on("click", ".del_addr", function () {
        var obj = $(this);
        func.del_addr_by_id(obj.data("id"));
    });
    //编辑地址
    $(document).on("click", ".edit_addr", function () {
        var obj = $(this);
        func.edit_addr_by_id(obj.data("id"));
    });
    func.init();
});