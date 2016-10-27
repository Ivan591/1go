
$(function(){
    var func={
        
        "init":function(){
            func.set_foot();
            func.show_tip();
        },
        
        "set_foot":function(){
            if($(".g-footer")){
                var winheight = $(window).height(),
                    footdom = $(".g-footer"),
                    footheight = footdom.height(),
                    fot_top = parseInt(footdom.css("margin-top")),
                    offtop = footdom.offset().top,
                    main=$(".register");
                if (winheight > (footheight + offtop))
                    main.height(winheight - (footheight + offtop) + fot_top+parseInt(main.height()));
                footdom.css("margin-top", fot_top);
            }
        },
        "show_tip":function(){

        }
    };


    func.init();
});