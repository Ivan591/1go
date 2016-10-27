$(function(){
    var func = {
        'update_table':function(url,container,param){

            $.post(url,param,function(data,e){
                if(data.code==1){
                    container.html(data.html);
                    if(typeof(data.count_stat)!='undefined'){
                        for(var i in data.count_stat){
                            if(data.count_stat[i]['status']==1)
                                $('.i-item[data-name=periodIng]>.txt-impt').text(data.count_stat[i]['c']);
                            if(data.count_stat[i]['status']==2)
                                $('.i-item[data-name=willReveal]>.txt-impt').text(data.count_stat[i]['c']);
                            if(data.count_stat[i]['status']==3)
                                $('.i-item[data-name=periodRevealed]>.txt-impt').text(data.count_stat[i]['c']);

                        }
                    }
                }else {
                    layer.msg(data.msg);
                }
            },'json');
        },
        init:function(){
            $('.m-user-comm-navLandscape>a').first().trigger('click');
        }
    };
    //$(document).on('click','.m-user-comm-navLandscape>a',function(){
    //    var $this = $(this);
    //    var url = $this.parent().data('url');
    //    $this.addClass('i-item-active').siblings().removeClass('i-item-active')
    //    var $container = $('.listCont[data-name=' + $this.data('name') + ']');
    //    $container.show().siblings().hide();
    //    if($this.data('loaded')==undefined){
    //        func.update_table(url,$container,{'action': $this.data('name')});
    //        $this.data('loaded',true);
    //    }
    //});
    $(document).on('click','[ajax_table]',function(){
        var url = $(this).data('url');
        var container = $('#'+$(this).data('container'));
        var param = $(this).data('param');
        func.update_table(url,container,param);
    });
    func.init();
});