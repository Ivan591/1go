var _form_tip=(function() {
        
        var error = $("<div class='in-form-tip ift-error'><i class='iconfont'>&#xe606;</i><span></span></div>"),
            info = $("<div class='in-form-tip ift-info'><i class='iconfont'>&#xe605;</i><span></span></div>"),
            success = $("<div class='in-form-tip ift-success'><i class='iconfont'>&#xe604;</i><span></span></div>"),
            warning = $("<div class='in-form-tip ift-warning'><i class='iconfont'>&#xe603;</i><span></span></div>");
        
        function i() {
            var st = "<style>" +
                ".in-form-tip {position: absolute;top:0;font-size:14px;padding-left:40px;white-space: nowrap;}" +
                ".in-form-tip:after{visibility: hidden;height: 0;display: block;clear: both;content:'.'}" +
                ".in-form-tip>i{position: absolute;top:0;left:0;text-align: center;width:48px;font-size:20px;display: block;}" +
                ".in-form-tip>span{float:left;}" +
                ".ift-error{color:#ff1b00;}.ift-info{color:#199ee1;}.ift-success{color:#1aa260;;}.ift-warning{color:#8a6d3b;}"+
            "</style>";

            $("body").append(st);
        }

        
        function s(dom, state, html) {
            if (!dom)
                return;
            state = state ? state : "error";
            var left = dom.width(),
                l_height = dom.height();
            dom.parent().css("position", "relative");
            var tip;
            if (state == "error")
                tip = error.clone();
            if (state == "warning")
                tip = warning.clone();
            if (state == "success")
                tip == success.clone();
            if (state =="info")
                tip = info.clone();
            tip.css({"height": l_height+"px", "line-height": l_height+"px", "left": left + 10+"px"}).find("span").html(html);
            dom.parent().append(tip);
        }

        
        function h(dom) {
            if (!dom)
                $(".in-form-tip").remove()
            else
                dom.parent().find((".in-form-tip")).remove();
        }
        i();
        return {
            show: function (dom, type, content) {
                s(dom, type, content);
            },
            hide: function (dom) {
                h(dom);
            }
        }
    })();
