$(function(){
    var func = {
        'update_table':function(url,container,param){
            $.post(url,param,function(data,e){
                if(data.code==1){
                    container.html(data.html);
                }else {
                    layer.msg(data.msg);
                }
            },'json');
        },
        'ajax_table':function(obj){
            var url = obj.data('url');
            var container = $('#'+obj.data('container'));
            var param = obj.data('param');
            func.update_table(url,container,param);
        },
        init:function(){
            $('[ajax_table][auto_load]').each(function(){
                    func.ajax_table($(this));
            });
        }
    };
    $(document).on('click','[ajax_table]',function(){
        func.ajax_table($(this));
    });
    func.init();
});