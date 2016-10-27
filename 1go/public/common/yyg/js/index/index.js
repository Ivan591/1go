
$(function(){
    var func = {
        init:function(){
            $(".w-countdown").each(function(){
                _count_down($(this),func.trigger_open);
            } );
            $(".w-slide").each(function(){
                func.init_slide($(this));
            });
            func.init_text_slide($("#one_rmb"));

        },
        
        'trigger_open' : function(dom){
            var $warp = $(dom).closest('.w-goods-newReveal');
            $warp.find('.opening-result').html($('#opening_tpl').html());
            $.ajax({
                type: "get",
                url: $('#nper_open_api').val(),
                data: {'nper_id': $warp.data("nper")},
                timeout: 30 * 1000,
                dataType:'json',
                beforeSend: function () {
                },
                success: function (data) {
                    if(data.code==1){
                        func.refresh_goods($warp);
                    }
                },
                error:function(){
                    window.location.reload();
                }
            });
        },
        
        refresh_goods :function ($warp) {
            $.ajax({
                type: "get",
                url: $('#refresh_results').val(),
                data: {'id': $warp.data("nper")},
                timeout: 10*1000,
                dataType:'json',
                beforeSend: function () {
                },
                success: function (data) {
                    $warp.find('.opening-result').html(data.html);
                },
                error:function(){
                    $warp.find('.opening-result').html($('#error_tpl').html());
                }
            });
        },
        init_slide:function(dom){
            var
                slider=dom;
            if(!slider||slider.length<=0)
                return;
            var
                warp=slider.find(".w-slide-wrap"),
                btn=slider.find(".w-slide-controller-btn"),
                nav=slider.find(".w-slide-controller-nav"),
                list=slider.find(".w-slide-wrap-list"),
                w=list.children().eq(0).width(),
                aw=(w+2)*list.children().length,
                index,timer,count;
            count=parseInt(warp.width()/w);
            list.width(aw);
            init_nav();
            init_con_btn();
            index=0;
            slide(0);
            timer=setInterval(auto_slide,3000);

            
            function slide(i){
                var l=list.children().length;
                if((i+count)>=l&&i<l)
                {
                    i=list.children().length-count;
                }else
                if(i>=l)  {
                    i=0;
                }else
                if(i<0&&(i+count)>0)
                {
                    i=0;
                }else
                if((i+count)<=0)
                {
                    i=list.children().length-count;
                }
                index=i;
                nav.children().removeClass("curr");
                nav.children().eq(parseInt(index/count)).addClass("curr");
                list.animate({left:-(w*index)},300);
            }
            
            function auto_slide(){
                index=index+count;
                slide(index);
            }
            
            function init_nav(){
                if(!nav||nav.length<=0)
                    return;
                nav.children().remove();

                for(var i=0 ;i<parseInt(list.children().length);i=i+count)
                {
                    nav.append("<a class='dot' href='javascript:void(0)'></a>");
                }
                nav.on("click",".dot",function(){
                    slide($(this).index());
                });
            }
            
            function init_con_btn(){
                slider.on({
                    "mouseenter":function(){
                        btn.show();
                        clearInterval(timer)
                    },
                    "mouseleave":function(){
                        btn.hide();
                        timer=setInterval(auto_slide,3000);
                    },
                });
                btn.on("click",".prev",function(){
                    index=index-count;
                    slide(index);
                });
                btn.on("click",".next",function(){
                    index=index+count;
                    slide(index);
                });
            }
        },
        init_text_slide:function(dom){
            var
                time_step=2000,
                warp=dom,
                list=warp.children(),
                h=warp.height()/(list.length);
            setInterval(function(){
                warp.animate({"margin-top":"-"+h+"px"},500,
                    function(){
                    warp.css({"margin-top":0});
                    var temp_dom=warp.children().eq(0).clone();
                    warp.children().eq(0).remove();
                    warp.append(temp_dom);
                    }
                );
            },time_step);
        }
    };

    func.init();
});