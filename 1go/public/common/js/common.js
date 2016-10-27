var err_ico = "<i style='color:#357EBD;font-size: 16px;' class='fa fa-info-circle'></i>&nbsp;";
var loading_layer_index;
var upload_layer;
var scan_values = "";//扫描寄存器
var time_clock;//全局时间计时器
var common = {
    check_ajax_post: function (rt, success, error, not_obj) {
        var obj;
        if (typeof (rt) == 'string') {
            obj = common.str2json(rt);
        }
        else if (typeof (rt) == 'object') {
            obj = rt;
        }
        if (typeof(obj) == 'object') {
            if (obj.code == "1") {
                if (typeof (success) == 'function') {
                    success(obj);
                }
                else {
                    layer.msg(success);
                }
            }
            else {
                if (typeof (error) == 'function') {
                    error(obj);
                }
                else if (error === false) {
                }
                else {
                    console.log('请求错误');
                }
            }
        }
        else {
            if (typeof (not_obj) == 'function') {
                not_obj(obj);
            }
            else {
                layer.msg(not_obj);
            }
        }

    },
    //检测字符串是否在数组里
    "inarray": function (search, array) {
        for (var i in array) {
            if (array[i] == search) {
                return true;
            }
        }
        return false;
    },
    //ajax的post方法
    "ajax_post": function (url, param, async, success, loading, show_model) {
        loading = typeof(loading) == "undefined" ? false : loading;
        show_model = typeof(show_model) == "undefined" ? false : show_model;
        if (loading == true && !show_model) {
            common.loading_layer(2, false);
        }
        else if (loading == true && show_model === true) {
            common.loading_layer(2, [0.3, "#444"]);
        }
        else if (loading == true && show_model) {
            common.loading_layer(2, show_model);
        }
        else if (!common.empty(loading) && !show_model) {
            common.loading_layer(loading, show_model);
        }
        else {

        }


        var rtData;
        async = async ? true : false;
        var error;
        if (typeof(success.error) == 'function') {
            error = success.error;
        }
        if (typeof(success.success) == 'function') {
            success = success.success;
        }
        $.ajax({
            url: url,
            type: 'post',
            dataType: 'html',
            async: async,
            data: param,
            success: typeof(success) == "function" ? success : function (data) {
                rtData = data;
            },
            error: typeof(error) == "function" ? error : function () {
                if (loading) {
                    common.loading_layer_close();
                }
                console.log("请求出错");
            },
            complete: function () {
                if (loading) {
                    common.loading_layer_close();
                }
            }
        });
        return rtData;
    },
    //字符转json对象，成功返回对象，不成功返回false
    "str2json": function (str) {
        try {
            var json = eval('(' + str + ')');
            return json;
        } catch (e) {
            return false;
        }
    },
    //ajax的JSONP_post方法
    "ajax_jsonp": function (url, param, success, loading, show_model) {
        loading = typeof(loading) == "undefined" ? false : loading;
        show_model = typeof(show_model) == "undefined" ? false : show_model;
        if (loading) {
            common.loading_layer(show_model);
        }
        var rtData;
        $.ajax({
            url: url,
            type: "GET",
            dataType: 'jsonp',
            jsonp: "jsonpcallback",
            data: param,
            success: function (data) {
                if (loading) {
                    common.loading_layer_close();
                }
                if (typeof (success) == 'function') {
                    success(data);
                }
            },
            complete: function () {
                if (loading) {
                    common.loading_layer_close();
                }
            }
        });
        return rtData;
    },
    //显示loading层
    "loading_layer": function (ico, shade) {
        ico = typeof(ico) == "undefined" ? 1 : ico;
        shade = typeof(shade) == "undefined" ? [0.1, '#fff'] : shade;
        loading_layer_index = layer.load(ico, {
            shade: shade //0.1透明度的白色背景
        });
    },
    //关闭loading层
    "loading_layer_close": function () {
        layer.close(loading_layer_index);
    },
    //将字符串格式的时间转换为时间戳
    "str_to_time": function (datestr) {
        var new_str = datestr.replace(/:/g, "-");
        new_str = new_str.replace(/ /g, "-");
        var arr = new_str.split("-");
        for (var i = 0; i < 6; i++) {
            arr[i] = (typeof(arr[i]) != "string" || arr[i].length < 1) ? "00" : arr[i];
        }
        var datum = new Date(Date.UTC(arr[0], arr[1] - 1, arr[2], arr[3], arr[4], arr[5]));
        datum = datum.getTime() / 1000;
        datum -= 8 * 60 * 60;
        return datum; //为PHP所用
    },
    //字符串为空返回true,否则返回false
    "empty": function (str) {
        if (str == null || str == 0 || $.trim(str) == '' || typeof(str) == "undefined" || parseInt(str) == 0 || str == false || str == "false")
            return true;
        return false;
    },
    "round": function (val, len) {
        val = parseFloat(val);
        return val.toFixed(len);
    },
    delay: function (func, time, i, flag) {
        flag = flag ? true : false;
        if (typeof(func) != "function") {
            alert("请传入function格式的参数!");
            return;
        }
        if (common.empty(i))i = 1;
        time_clock = window.setInterval(function () {
            i--;
            func();
            if (!flag) {
                if (i <= 0) {
                    window.clearInterval(time_clock);
                }
            }

        }, time);
    },
    //校验字段,合格返回数字,不合格返回0
    chk_num: function (val) {
        if (!common.empty(val) || !isNaN(val)) {
            return val;
        }
        else return 0;
    },
    //把id内的循环的id用指定符号分割返回
    split_by_func: function (obj, id_tag, split) {
        !split && split == ',';
        var rt = '';
        $.each(obj, function (k) {
            var val = obj.eq(k).attr(id_tag);
            if (val) {
                rt = rt + val + split;
            }
        });
        return rt;
    },
    //分页函数
    page: function (cont, pages, curr, exec) {
        laypage({
            "cont": cont,
            "pages": pages,
            "curr": curr,
            jump: function (obj, first) {
                exec && exec(obj, first);
            }
        });
    },
    //倒计时,时分秒毫秒的容器
    count_down: function (sys_second, obj, callback) {
        var end = new Date().getTime() + sys_second;
        var timer = setInterval(function () {
            if (sys_second > 0) {
                sys_second = end - new Date().getTime();
                var day = Math.floor((sys_second / 1000 / 3600) / 24);
                var hour = Math.floor((sys_second / 1000 / 3600) % 24);
                var minute = Math.floor((sys_second / 1000 / 60) % 60);
                var second = Math.floor(sys_second / 1000 % 60);
                var haomiao = Math.floor(sys_second % 1000);
                haomiao = haomiao < 100 ? (haomiao + '0') : haomiao;
                var mss = haomiao.toString().substr(0, 2);
                obj.day && $(obj.day).html(day);//计算天
                obj.hour && $(obj.hour).html(hour < 10 ? "0" + hour : hour);//计算小时
                obj.min && $(obj.min).html(minute < 10 ? "0" + minute : minute);//计算分
                obj.sec && $(obj.sec).html(second < 10 ? "0" + second : second);// 计算秒
                obj.ms && $(obj.ms).html(mss);// 计算毫秒
            } else {
                clearInterval(timer);
                if (typeof(callback) == 'function') {
                    callback();
                }
                if (typeof(callback) == 'string') {
                    layer.msg(callback);
                }
            }
        }, 10);
    },
    //处理返回值,显示提示信息
    post_tips: function (rt, success, fail) {

        var obj = common.str2json(rt);

        if (typeof(obj) != 'object' || typeof(obj.code) == 'undefined') {
            layer.msg('返回值不正确');
            return false;
        }
        if (typeof (obj.msg) == 'undefined')obj.msg = ' ';

        var code = obj.code.toString();

        switch (code) {
            case '1':

                if (typeof(success) == 'function') {
                    success(obj);
                }
                else{
                    layer.msg(obj.msg, {icon: 1});
                }
                break;
            case '-1':

                if (typeof(fail) == 'function') {
                    fail(obj);
                }
                else{
                    layer.msg(obj.msg, {icon: 2});
                }
                break;
            default:
                layer.msg(obj.msg, {icon: 3});
        }
    },
    //上传图片
    upload_img:function(callback,config){
        var url = $("#upload_img_url_system").val();
        upload_layer = layer.open({
            move:false,
            id:'up_img_iframe',
            type: 2,
            area: ['700px', '410px'],
            fix: false, //不固定
            btn:["确定"],
            content: url,
            yes : function () {
                var name=$("#up_img_iframe").find('iframe').attr('name');
                var content = window.frames[name].document.getElementById('return_list').value;
                if(!common.empty(content)) {
                    var obj = common.str2json(content);
                    if(typeof(obj) == 'object'){
                        callback(obj);
                    }
                }
                layer.close(upload_layer);

            }
        });
    }
};


//模拟GET方法
var $_GET = (function () {
    var url = window.document.location.href.toString();
    var u = url.split("?");
    if (typeof(u[1]) == "string") {
        u = u[1].split("&");
        var get = {};
        for (var i in u) {
            var j = u[i].split("=");
            get[j[0]] = j[1];
        }
        return get;
    } else {
        return {};
    }
})();

var float_tip = function () {
    var fp = $("<div  style='padding:5px 10px;border-radius: 6px;background: rgba(0,0,0,0.7);+background:#666;background:#666\0;font-size:12px;color:#fff;position: fixed;display: none;'></div>");

    function set_tip(dom_selector, dom_attr, x_add, y_add) {
        if (!$(dom_selector) || !dom_attr)
            return;
        $("body").append(fp);
        $(document).on("mousemove mouseleave", dom_selector, function (e) { 
            if (e.type == "mousemove") {
                var tom = $(this);
                if (tom.attr(dom_attr)) {
                    var top = $(document).scrollTop();
                    fp.text(tom.attr(dom_attr));
                    fp.show().css("left", e.pageX + x_add).css("top", e.pageY - top + x_add);
                }
            }
            else {
                fp.hide();
            }
        });
    }

    return {
        
        init: function (dom_selector, dom_attr, x_add, y_add) {
            x_add = x_add ? x_add : 0;
            y_add = y_add ? y_add : 0;
            set_tip(dom_selector, dom_attr, x_add, y_add);
        }
    }
}();


//翻页函数
$.turn_page = function (url, ajaxdiv, ajaxform) {
    if (typeof(ajaxform) == "undefined") {
        var data = "{}";
    } else {
        var data = $("#" + ajaxform).serialize();
    }

    var lineNum = $('#lineNumSelect').val() ? $('#lineNumSelect').val() : 10;
    if (url.indexOf('?') > 0) {
        url += "&line=" + lineNum;
    } else {
        url += "?&line=" + lineNum;
    }
    $.ajax({
        type: "POST",
        url: url,
        data: data,
        beforeSend: function () {
            //$("#" + ajaxdiv).html($('#loadShadeImg').html());
            common.loading_layer();
        },
        success: function (html) {
            $("#" + ajaxdiv).html(html);
            common.loading_layer_close();
            return false;
        }
    });
};


//ajax刷新当前页
//@param contentid 要被刷新的容器ID
//@param conditionid 搜索条件的表单ID，没有则传入空
//@param callback 刷新页面的回调函数（必须，如果数据只有一页的情况）
$.trunTocurrenPage = function (contentid, conditionid, callback) {
    var url = $('#currenPageId').data('url');
    if (typeof(url) === 'undefined' && typeof(callback) === 'function') {
        callback();
    } else {
        $.turn_page(url, contentid, conditionid);
    }
};


