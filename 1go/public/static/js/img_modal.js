
$(function(){
    var _img_modal=(function(){
        var img_mo=$(".img_modal"),
            ww=$(window).width(),
            wh=$(window).height();
        if(img_mo.length<=0)
        {
            $("body").append("<style>" +
                    ".imm_close{transition:all 0.3s;-webkit-transition:all 0.3s}" +
                ".imm_close:hover{background:#f6f6f6;color:#333; }" +
                ".imm_content{overflow:auto;" +
                "-webkit-transition: all 0.4s;-moz-transition: all 0.4s;-ms-transition: all 0.4s;-o-transition: all 0.4s;transition: all 0.4s;}"+
                "</style>");
            img_mo=$("<div class='img_modal' style='position: fixed;z-index: 9999;display:none;'>" +
                "<div class='imm_bg' style='width:100%;height: 100%;background: #333;opacity: 0.6;position: fixed;top:0;left:0;z-index: 1;'></div>" +
                "<div class='imm_content' style='width:0;height:0;position: fixed;z-index: 2;border-radius: 6px;" +
                "background: #fff;'>" +
                "<img style='display: block;position: relative;top:15px;left:15px;-webkit-transition: all 0.5s;-moz-transition: all 0.5s;-ms-transition: all 0.5s;-o-transition: all 0.5s;transition: all 0.5s;'>" +
                "</div>"+
                "</div>");
            $("body").append(img_mo);
        }
        img_mo.find(".imm_close").on("click",function(){
            img_mo.fadeOut();
        });
        $(document).on("click",".img_modal",function(e){

                img_mo.fadeOut();


        });
        function modal_img(dom){
            $(document).on("click",dom,function(e){
                var src=$(this).attr("src");
                var img = new Image();
                img_mo.find("img").attr("src","").css({top:0,left:0});
                img_mo.show();
                e.preventDefault();
                e.stopPropagation();
                img.src = src;
                if (img.complete) {
                    var mh=img.height,
                        mw=img.width;
                    if(mw>=ww*0.9)
                    {
                        mw=ww*0.9;
                    }else{
                        mw=mw;
                    }
                    if(mh>=wh*0.9)
                    {
                        mh=wh*0.9;
                    }
                    else{
                        mh=mh;
                    }
                    img_mo.find(".imm_content").css({"width":mw+32,"height":mh+32,
                    "top":(wh-mh)/2,"left":(ww-mw)/2});
                    img_mo.find("img").attr("src",src).css({top:15,left:15});
                };
            });

        }
        return function(dom){
            modal_img(dom);
        };
    })();
    _img_modal(".imgWrap img");

})