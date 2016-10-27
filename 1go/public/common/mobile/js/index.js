$(function() {
    //源自文件cart/qd.html		
    //$(".shanchu").click(function() {
    //    var a = $(this).index();
    //    $(".qd-1").fadeOut();
    //});

    ////加的效果
    //$(".add").click(function() {
    //    var n = $(this).prev().val();
    //    var num = parseInt(n) + 1;
    //    if (num == 0) {
    //        return;
    //    }
    //    $(this).prev().val(num);
    //});
    ////减的效果
    //$(".jian1").click(function() {
    //    var n = $(this).next().val();
    //    var num = parseInt(n) - 1;
    //    if (num == 0) {
    //        return
    //    }
    //    $(this).next().val(num);
    //
    //});

    //结束

    //源自文件grzx.html	
    $(".haha").click(function() {
        var a = $(this).index();
        $(".haha").eq(a).css("border-bottom", "2px solid red").siblings(".haha").css("border-bottom", "#fff");
        $(".zx1").eq(a).show().siblings(".zx1").hide();
    });

    //结束


    //结束	

    //源自文件dbjl.html	
    $(".k1").click(function() {
        $(".h3").css("border-bottom", "2px solid red");
        $(".h5").css("border-bottom", "none");
        $(".h6").css("border-bottom", "none");
    });
    $(".k2").click(function() {
        $(".h5").css("border-bottom", "2px solid red");
        $(".h3").css("border-bottom", "none");
        $(".h6").css("border-bottom", "none");
    });
    $(".k3").click(function() {
        $(".h6").css("border-bottom", "2px solid red");
        $(".h3").css("border-bottom", "none");
        $(".h5").css("border-bottom", "none");
    });
    $(".haha").click(function() {
        var a = $(this).index();
        $(".zx-11").eq(a).show().siblings(".zx-11").hide();
    })

    //结束		

    //源自文件/user/gmxz.html		
    $(".wt-11").click(function() {
        $(".bs2").toggle();
    });

    //结束	

    //源自文件/user/gz.html	
    $(".b1,.b2").click(function() {
        $(".bff").css("display", "block");
        $(".b1,.b2").css("display", "none");
    })

    //结束		

    //源自文件/user/wbhb.html		
    $(".k1").click(function() {
        $(".h3").css("border-bottom", "2px solid red");
        $(".h5").css("border-bottom", "none");
    });
    $(".k2").click(function() {
        $(".h5").css("border-bottom", "2px solid red");
        $(".h3").css("border-bottom", "none");
    })

    //结束		

});