
$(function () {
    var share_list = {
        "init_loading": (function () {
            var
            
                config = {
                    "timeout": 3000,
                    "col_num": 4,
                    "cur_page": 0,
                    "size": 8,
                    "total": 1000,
                },
            
                data = {
                    "user_link": $("#user_link").val(),
                    "share_get": $("#share_get").val(),
                    "share_link": $("#share_link").val(),
                    "goods_link": $("#goods_link").val(),
                    "warp": $(".m-shareList"),
                    "temp": $("#temp_share>.item"),
                    "loading": $(".m-share .w-loading"),
                    "load_enable": true,
                    "total": parseInt($("#spTotal").text())
                },
            
                get_shares = function (index) {
                    var
                        timeout = config.timeout,
                        page = (index) ? parseInt(index) : config.cur_page + 1,
                        size = config.size,
                        get_share = data.share_get,
                        loading = data.loading,
                        warp = data.warp,
                        temp = data.temp;
                    config.cur_page = page;

                    $.ajax({
                        type: "get",
                        url: get_share,
                        data: {'page': page, 'size': size},
                        timeout: timeout,
                        beforeSend: function () {
                            loading.show();
                            data.load_enable = false;
                        },
                        success: function (list) {

                            list = common.str2json(list);
                            if (list && list.code == "1") {
                                var tmp = $(list.data.html.replace(/\n/g, '').replace(/\r/g, ''));
                                $.each(tmp, function () {
                                    
                                    get_warp(warp).append($(this));
                                });
                                
                            }
                            data.load_enable = true;

                            loading.hide();
                        }

                    });
                },
            
                set_data = function (dom, data) {
                    var
                        user_link = $("#user_link").val()+'?id=',
                        share_link = $("#share_link").val(),
                        goods_link = $("#goods_link").val();
                    dom.find(".pic a").attr("title", data.title).attr("href", share_link + "id=" + data.id);
                    dom.find(".pic img").attr({"src": data.img_path, "alt": data.title});
                    dom.find(".name a").attr({
                        "href": goods_link + "id=" + data.good_id + '-' + data.nper_id,
                        "title": data.goods_name
                    }).text(data.goods_name);
                    dom.find(".code strong").text(data.luck_num);
                    dom.find(".title a").attr({
                        "href": share_link + "id=" + data.id,
                        "title": data.title
                    }).find("strong").text(data.title);
                    dom.find(".author a").attr({
                        "href": user_link + "id=" + data.uid,
                        "title": data.username + "(ID:" + data.uid + ")"
                    }).text(data.username);
                    dom.find(".time").text(data.create_time);
                    dom.find(".abbr").text(data.content);
                },
            
                load_start = function () {
                    get_shares();
                    var wh = $(window).height(),
                        dh = $(document).height();
                    if (wh >= dh && config.size * config.cur_page < total) {
                        load_start();
                    }
                },
            
                isget_share = function (dom) {
                    if (!data.load_enable)
                        return false;
                    var wh = $(window).height();
                    var scrollH = $(document).scrollTop();
                    return parseInt(wh + scrollH) >= (parseInt(dom.offset().top) + dom.height());
                },
            
                auto_get = function () {

                    var dom = data.warp,
                        total = data.total ? data.total : config.total;


                    if (isget_share(dom) && config.size * config.cur_page < total) {
                        get_shares();
                    }
                    if (config.size * config.cur_page >= total) {
                        $(window).off("scroll", auto_get);
                    }
                },
            
                get_warp = function (dom) {
                    var sel = 0,
                        list = dom.children();
                    list.each(function (index) {
                        if ($(this).height() < list.eq(sel).height()) {
                            sel = index;
                        }
                    });
                    return list.eq(sel);

                };

            return function () {
                load_start();
                $(window).on("scroll", auto_get);
            }
        })()
    }
    share_list.init_loading();
})