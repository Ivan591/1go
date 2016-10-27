$(function(){
    var func ={
        'addr_submit':function() {
            $('#confirm_addr_frm').submit();
        },
    };
    $(document).on('click','.bar-view>.address-bar',function(){
        var $this = $(this);

        $this.siblings().removeClass('bar-selected');
        $this.addClass('bar-selected');
        $this.find('input').prop('checked',true);

    });
    $('#confirm_addr').click(function(){
        if($('.bar-view>.bar-selected').length==0) {
            layer.msg('不填收获地址，我们就不知道该往哪里送哦');
            return false;
        }
        $('.w-mask').show();
        $('.w-msgbox .receiver').text($('.bar-view>.bar-selected .bar-item.receiver').text());
        $('.w-msgbox .address').text($('.bar-view>.bar-selected .bar-item.address').text());
        $('.w-msgbox .mobile').text($('.bar-view>.bar-selected .bar-item.mobile').text());
        $('#addr_id').val($('.bar-view>.bar-selected input[name=addr_id_sel]').val());
        $('.w-msgbox').show();
    });
    $('.w-msgbox .w-msgbox-close,.w-msgbox .confirm_cancel').click(function(){
        $('.w-msgbox').hide();
        $('.w-mask').hide();
    });
    $('.w-msgbox .confirm_ok').click(function(){
        func.addr_submit();
    });
    $('#confirm_prize_frm').submit(function(){
        return window.confirm('确认操作不可重复提交，请确认您已经收到商品；');
    });
});