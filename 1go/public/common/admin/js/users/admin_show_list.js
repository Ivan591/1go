$(function(){
    
    $('.modify_admin_password').click(function(){


        var obj = $(this);
        var url = $('#modify_password').val();


        //prompt层
        layer.prompt({
            title: '修改密码',
            formType: 1 //prompt风格，支持0-2
        }, function(pass){
            layer.prompt({title: '确认密码', formType: 1}, function(re_pass){
                if(pass != re_pass) {
                    layer.msg('密码与确认密码不同');
                    return false;
                }
                common.ajax_post(url,{id : obj.data('id'), password : pass},true,function(rt){
                    common.post_tips(rt);

                });
            });
        });


    });






});