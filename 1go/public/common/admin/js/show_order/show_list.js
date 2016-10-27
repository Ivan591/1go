$(function(){
    
    $('.audit_show_order').click(function(){

        var obj = $(this);
        var url = $('#submit').val();

        //询问框
        layer.confirm('请审核该晒单', {
            btn: ['通过','禁用','取消'], //按钮,
            title : false,
            closeBtn: 0
        }, function(){
            common.ajax_post(url,{id : obj.data('id'), status : 1},true,function(rt){
                common.post_tips(rt);
                var reply_data = $.parseJSON(rt);
                if(reply_data.code == '1') {
                    obj.parent().parent().find('.status').html('正常');
                }
                obj.hide();

            });
        }, function(){
            common.ajax_post(url,{id : obj.data('id'), status : -2},true,function(rt){
                common.post_tips(rt);
                var reply_data = $.parseJSON(rt);
                if(reply_data.code == '1') {
                    obj.parent().parent().find('.status').html('禁用');
                }
                obj.hide();

            });
        });

    });


    
    $('.delete_show_order').click(function() {
        var obj = $(this);
        var url = $('#submit').val();

        //询问框
        layer.confirm('您确定删除该晒单么？', {
            btn: ['确定','取消'] //按钮
        }, function(){
            common.ajax_post(url,{id : obj.data('id'), status : -1},true,function(rt){
                common.post_tips(rt);
                var reply_data = $.parseJSON(rt);
                if(reply_data.code == '1') {
                    obj.parent().parent().hide();
                }

            });
        });

    });

    
    $('.check_all').change(function(){

        var check_all = $(this);
        var check = $(".check:enabled");

        if(check_all.is(':checked')) {
            check.prop('checked',true);
        }else{
            check.prop('checked',false);
        }
    });

    $('.check:enabled').change(function() {
        var check_all = $('.check_all');
        var check = $(this);

        if(!check.is(':checked') && check_all.is(':checked')) {
            check_all.prop('checked',false);
        }
    });

    
    $('.audit_all').click(function(ev){
        ev.preventDefault();

        var check_audit = $('.check:checked');
        var url = $('#audit_all').val();

        if(check_audit.length == 0) {
            layer.msg('请选择要审核的晒单');
            return false;
        }
        var check_str = '';
        check_audit.each(function () {
            check_str += $(this).data('id') + ',';

        });
        check_str = check_str.substring(0,check_str.length-1);
        //询问框
        layer.confirm('批量审核晒单', {
            btn: ['通过','禁用','取消'], //按钮,
            title : false,
            closeBtn: 0
        }, function(){
            common.ajax_post(url,{id : check_str, status : 1},true,function(rt){
                common.post_tips(rt);
                var reply_data = $.parseJSON(rt);
                if(reply_data.code == '1') {
                    window.location.reload();
                }

            });
        }, function(){
            common.ajax_post(url,{id : check_str, status : -2},true,function(rt){
                common.post_tips(rt);
                var reply_data = $.parseJSON(rt);
                if(reply_data.code == '1') {
                    window.location.reload();
                }

            });
        });

    });

});