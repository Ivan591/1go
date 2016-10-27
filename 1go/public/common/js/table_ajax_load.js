//自定义函数



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
            common.loading_layer(1,false);
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
    var url = $('#'+contentid).data('url');
    if (typeof(url) === 'undefined' && typeof(callback) === 'function') {
        callback();
    } else {
        $.turn_page(url, contentid, conditionid);
    }
};


var table = {
    //初始化
    init:function(){

        $.turn_page($('#form_content').data('url'), 'form_content', 'form_condition');
    },
    ajax_refrash_page: function () {
        $.trunTocurrenPage("form_content", "form_condition", false);
    },
    turn_pages:function(page){
        page = common.empty(page) ? 1 :page;
        page = isNaN(page) ? 1 :page;

        var url = $("#form_content").data('url');
        var param = $("#form_condition").serialize()+'&'+'page='+page;
        common.ajax_post(url,param,true,function(rt){
            $("#form_content").html(rt);
        });
        console.log('一刷新');
    }
};
//自定义函数_END




$(function () {
    //点击分页按钮操作
    $(document).on("click", ".basePageOperation", function () {
        $.turn_page($(this).data('url'), $(this).data('listid'), $(this).data('formid'));
    });
    //每页显示
    $(document).on("change", "#lineNumSelect", function () {
        var totalNum = $("span[class=pageAllNum]").html();
        if (totalNum > 0) {
            $.turn_page($('#pageNumSelect').val(), $(this).data('listid'), $(this).data('formid'));
        }
    });
    //改变页码
    $(document).on("change", "#pageNumSelect", function () {
        $.turn_page($(this).val(), $(this).data('listid'), $(this).data('formid'));
    });
    //搜索
    $(document).on("click", ".search_btn", function () {
        var obj = $(this);
        if(typeof(obj.data('url')) != "undefined"){
            $("#form_content").data("url",obj.data('url'));
            alert($("#form_content").attr("url"));
        }
        table.ajax_refrash_page();
    });

    //模糊查询选项卡
    $(document).on("click",".art_select",function(){
        //alert(0)
        var obj = $(this);
        obj.closest("div").find('.default-val').html(obj.text());
        obj.closest("div").find('.value').val(obj.data('value'));
    });

    //获取页码信息
    $(document).on("click",".get_page",function(){
        var obj = $(this);
        if(typeof (obj.data("url")) == 'undefined')return false;
        $("#form_content").data("url",obj.data("url"));
        table.ajax_refrash_page();
    });



    //新的翻页函数
    $(document).on("click","a.page_btn",function(){
        var obj = $(this);
        var page =obj.data('page');
        table.turn_pages(page);
    })
});
