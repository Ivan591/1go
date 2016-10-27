
var _count_down= function(dom, callback) {
    var timer,//定时器
        step = 40,//步距
        tdata = parseInt(dom.data("time")),//时间  毫秒
        end=new Date().getTime()+ tdata,
        timstr = [],//数值
        inittime=[0,0,0,0,0,0];
    var set_time = function () {
        if(!tdata||tdata<=0){
            clearInterval(timer);
            setTime(inittime);
            if(callback&&typeof(callback)=="function")
            {
                callback(dom);
            }
            return;
        }
        tdata = end - new Date().getTime();
        timstr = [];
        if (tdata > 0) {
            var hh=parseInt(tdata/3600000);
            if(hh>0)
            {
                timstr.push(parseInt(tdata / 36000000)%10);
                timstr.push(parseInt(tdata / 3600000)%10)
            }
            timstr.push(parseInt((tdata % 3600000) / 600000)%10);
            timstr.push(parseInt((tdata % 3600000) / 60000)%10);
            timstr.push(parseInt((tdata % 60000)/10000));
            timstr.push(parseInt((tdata % 60000)/1000)%10);
            timstr.push(parseInt((tdata % 1000) / 100));
            timstr.push(parseInt((tdata % 100) / 10));
            setTime(timstr);
        } else if (callback) {
            clearInterval(timer);
            setTime(inittime);
            if(callback&&typeof(callback)=="function")
            {
                callback(dom);
            }
            return;
        }
    };
    function setTime(dateArror){
        var text_area=dom.find("b");
        console.log(text_area);
        $.each(dateArror,function(index){
            if(index<6) {
                text_area.eq(index).text(this);
            }
        });
    }
    timer = setInterval(set_time, step);
}