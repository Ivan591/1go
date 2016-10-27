
$(function () {
    var new_list = {
        
        "ajax_loading": (function () {

            var
            
                get_list_config = {
                    'count': 6,
                    'timeout': 2000,
                    'page': 0,
                    'total_items': 12,
                    'size': 6,
                    'is_loaded': false
                },

            
                links = {
                    'pull_list': $.trim($("#pull_results").val()),
                    'refresh_goods': $.trim($("#refresh_results").val()),
                    'goods_link': $.trim($("#goods_link").val()),
                    'user_link': $.trim($("#user_page").val()),
                    'temp': $(".w-revealList"),
                    'template': $("#temp_revealList li"),
                    'loading': $(".w-loading"),
                    'end_tip': $(".m-results-revealList-end"),
                    'nper_open_api': $("#nper_open_api").val(),

                },

            
                load_lock = true,

            
                init_loading = function () {
                    load_start();
                    $(window).on("scroll", auto_load);
                },
            
                load_start = function () {
                    load_goods();
                    var wh = $(window).height(),
                        dh = $(document).height();
                    if (wh >= dh && ((config.page) * config.size) < config.total_items) {
                        load_start();
                    }
                },
            
                load_goods = function (index) {
                    var config = get_list_config;
                    if (!index) {
                        index = config.page + 1;
                    }
                    get_list_config.page = index;
                    $.ajax({
                        type: "get",
                        url: links.pull_list,
                        data: {'page': index, 'size': get_list_config.size},
                        timeout: config.timeout,
                        beforeSend: function () {
                            links.loading.show();
                            load_lock = false;
                        },
                        success: function (data) {
                            links.loading.hide();
                            load_lock = true;
                            data = common.str2json(data);
                            if (index == 1) {
                                get_list_config.total_items = data.data.count;
                                get_list_config.is_loaded = true;
                            }
                            if (data && data.code == "1") {
                                //$.each(data.data.html,function(){
                                //    var temp=links.template.clone();
                                //    temp.data("id",this.goods_id);
                                //    temp.find(".w-goods-pic a").attr("href",links.goods_link+"?gid="+this.goods_id).find("img").attr("src",this.goods_image);
                                //    temp.find(".w-goods-title a").attr("href",links.goods_link+"?gid="+this.goods_id).text(this.goods_name);
                                //    temp.find(".w-goods-price").text("总需："+this.sum_times+"人次");
                                //    temp.find(".w-goods-period").text("期号："+this.nper_id);
                                //    set_goods(temp,this);
                                //
                                //});
                                links.temp.append(data.data.html);
                                $('.w-countdown').not(".flag_count").each(function(index,ele){
                                    _count_down($(ele),function(dom){
                                        trigger_open(dom);
                                    });
                                });
                                $('.w-countdown').addClass('flag_count', 'true');
                            }
                        }

                    });
                },

            
                auto_load = function () {
                    var config = get_list_config;
                    if (is_load() && ((config.page ) * config.size) <= config.total_items) {
                        load_goods();
                    }
                    if (((config.page) * config.size) >= config.total_items && config.is_loaded) {
                        $(window).off("scroll", auto_load);
                        links.end_tip.show();
                    }
                },

            
                is_load = function () {
                    var wh = $(window).height();
                    var scrollH = $(document).scrollTop();
                    return load_lock && ((wh + scrollH) >= parseInt(links.temp.offset().top) + links.temp.height());
                },

            
                refresh_goods = function ($warp) {
                    $.ajax({
                        type: "get",
                        url: links.refresh_goods,
                        data: {'id': $warp.data("id")},
                        timeout: 10*1000,
                        dataType:'json',
                        beforeSend: function () {
                        },
                        success: function (data) {
                            $warp.find('.results').html(data.html);
                        },
                        error:function(){
                            $warp.find('.results').html($('#error_tpl').html());
                        }
                    });
                },
                
                trigger_open = function(dom){
                    var $warp = $(dom).closest('.w-revealList-item');
                    $warp.find('.results').html($('#opening_tpl').html());
                    $.ajax({
                        type: "get",
                        url: links.nper_open_api,
                        data: {'nper_id': $warp.data("id")},
                        timeout: 30 * 1000,
                        dataType:'json',
                        beforeSend: function () {
                        },
                        success: function (data) {
                            if(data.code==1){
                                refresh_goods($warp);
                            }
                        },
                        error:function(){
                            window.location.reload();
                        }
                    });
                }
            
                set_goods = function (dom, data) {
                    var temp = dom,
                        luck_info = data;
                    if (parseInt(luck_info.status) <= 2) {
                        temp.find(".w-record").hide();
                        temp.find(".w-countdown").show().attr("time", data.open_time).data("goods_id", luck_info.goods_id);
                        _count_down(temp.find(".w-countdown"), function (dom) {
                            refresh_goods(dom);
                        });
                    }
                    if (parseInt(luck_info.status) >= 3) {
                        temp.find(".w-countdown").hide();
                        var record = temp.find(".w-record").show().data("uid", luck_info.luck_uid);
                        temp.find(".w-record-avatar img").attr("src", luck_info.avatar);
                        record.find(".user a").attr("href", links.user_link + "?id" + luck_info.luck_uid);
                        record.find(".user a").attr("title", luck_info.luck_user + "(ID:" + luck_info.luck_uid + ")").text(luck_info.luck_user);
                        record.find(".lucknum b").text(luck_info.luck_num);
                        record.find(".join_num b").text(luck_info.luck_num);
                        record.find(".open_time span").text(luck_info.open_time).attr("title", luck_info.open_time);
                        record.find(".detail_link").attr("href", links.goods_link + "?gid=" + luck_info.goods_id);
                    }
                };

            return function () {
                init_loading();
            };
        })()
    }

    new_list.ajax_loading();
});
