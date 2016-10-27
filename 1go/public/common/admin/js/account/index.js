
$(function(){
    var func = {
        init:function(){

        },
        submit:function(){
            var url = $("#submit_url").val();
            var param = $("#form_content").serialize();
            common.ajax_post(url,param,true,function(rt){

                common.post_tips(rt,function(obj){
                    layer.msg(obj.msg);
                    location.href=$('#root_url').val();
                },function(obj){
                    layer.msg(obj.msg);
                    $(".verify_img").trigger('click');
                });
            },true,[0.1,'#444']);
        }
    };



    $(document).on("click",".submit_btn",function(){
        func.submit();
    });
    func.init();
});