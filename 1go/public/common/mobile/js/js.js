$(function(){

	$(".jjxq-2-1").click(function(){
		$(".jjxq-2-2").slideToggle(300);
		 $(".jjxq-2-11").toggle();
	})


	$(".sect00,.quanp-01").click(function(){
		$(".quanp-1,.quanp").hide();
		$("").hide();
	});




	//回到顶部开始

	 $(".moreBtn1").click(function(){
		$(".quanp,.quanp-1").show();
	}) ;
	$(window).scroll(function(){
	 var a=$(window).scrollTop();

			if(a>300){
				$(".fhdb").fadeIn(1000);
			}else{
				$(".fhdb").fadeOut(1000);
				};
	});


	$(".fhdb").on("click",function(){
		$("body,html").animate({scrollTop:0},300);
		return false;
	})



	//回到顶部结束

	//点击通过高度变化显示和消失==-->
		$(".m-list-nav-catlog").on("click",function(){

			 $(".m-list-catlog").slideToggle();
		 });






	var _count_down= function(dom, callback) {

        var timer,//定时器
            step = 40,//步距
            tdata = parseInt(dom.attr("time")),//时间  毫秒
            end=new Date().getTime()+ tdata,
            timstr = [];//数值

        var set_time = function () {
            if(!tdata||tdata<0)
                return;
            tdata = end - new Date().getTime();
            timstr = [];
            if (tdata > 0) {
                var hh=parseInt(tdata/3600000);
                if(hh>0)
                {
                    timstr.push(parseInt(tdata / 36000000)%10);
                    timstr.push(parseInt(tdata / 3600000)%10)
                }
                timstr.push(parseInt(tdata / 600000)%10);
                timstr.push(parseInt(tdata / 60000)%10);
                timstr.push(parseInt((tdata % 60000)/10000));
                timstr.push(parseInt((tdata % 60000)/1000)%10);
                timstr.push(parseInt((tdata % 1000) / 100));
                timstr.push(parseInt((tdata % 100) / 10));
            } else if (callback) {
                clearInterval(timer);
                callback(dom);
            }
            var dom_str="<span class='w-countdown-nums'>";
            $.each(timstr,function(index){

                if(index<6) {
                    dom_str += "<b>" + this + "</b>";
                    if (index % 2 == 1 && index < 5)
                        dom_str += "<b>:</b>";
                }
            });
            dom_str+='<span>';

            dom.html(dom_str);
        };
        timer = setInterval(set_time, step);
    };

	_count_down($(".w-countdown"),function(dom){});



    $('.m-tip').click(function () {
        var img_path = $(this).parent().find('.w-goods-pic a img').attr('src');



        var img_src = '<img  style="z-index: 9999;" class="u-flyer"  src="' + img_path+'"/>';

        var offset = $('.end').offset(), flyer = $(img_src);
        starts=$(event.toElement).offset();
        console.log($(event.toElement).offset());
        console.log(offset);
        flyer.fly({
            start: {
                left: starts.left,
                top: starts.top-$("body").scrollTop()
            },
            end: {
                left: offset.left,
                top: offset.top-$("body").scrollTop(),
                width: 10,
                height: 10
            }
        });
    });




//	$('.m-tip').on('click', addProduct);
//function addProduct(event) {
//
//    var img_path = $(this).parent().parent().find('img').attr('scr');
//
//    var img_src = '<img class="u-flyer" src="' + img_path+'"/>';
//
//	var offset = $('.end').offset(), flyer = $(img_src);
//	starts=$(event.toElement).offset();
//	console.log($(event.toElement).offset());
//	console.log(offset);
//	flyer.fly({
//		start: {
//			left: starts.left,
//			top: starts.top-$("body").scrollTop()
//		},
//		end: {
//			left: offset.left,
//			top: offset.top-$("body").scrollTop(),
//			width: 20,
//			height: 20
//		}
//	});
//};

	$(".dbjl-trop02-left,.dbjl-trop02-02").on("click",function(){
		$(".mm").hide();
	});


	$(".mm1").on("click",function(){
		$(".mm").show();
	});


















})

