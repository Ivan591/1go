$(function(){
    var func = {
        'ui_step_form':function(){
            $('.m-user-shareAdd-form').show().siblings('div').hide();
        },
        'ui_step_preview':function(){
            $('.m-user-shareAdd-preview').show().siblings('div').hide();
        },
        'init':function(){
        },
        'form_chek':function(){
            if($('.share-title .w-input-input').val().length>6){
                $('.titleTips').text('');
            }else{
                $('.titleTips').text('标题至少需要填写六个字');
                return false;
            }
            if($('.share-cont .w-input-input').val().length>30){
                $('.contTips').text('');
            }else{
                $('.contTips').text('为了更好地和网友分享您的喜悦，文字内容不少于30字。审核通过会获得直减红包奖励，最高价值10夺宝币！');
                return false;
            }
            if($('#imgList>.item.success').length<3){
                layer.msg('至少上传三张图片才能获得奖励哦 =3=');
                return false;
            }
            return true;
        },
        'submit_share':function(){
            var url = $('#share_form').attr('action');
            var param = $('#share_form').serialize();
            $.post(url,param,function(data){
                if(data.code==1){
                    layer.msg('晒单成功~~~');
                }else {
                    layer.msg('出了些错误;-(');
                }
            },'json');
        },
        'preview_share':function(){
            $('.preview-title').text($('.share-title .w-input-input').val());
            $('.preview-text').text($('.share-cont .w-input-input').val());

            $('.preview-images').empty();
            $('#imgList>.item.success').each(function(index,ele){
                var $new_img = $($.trim($('#previewTmplImg').html()));
                $new_img.find('img').attr('src',$(ele).attr('img_path'));
                $('.preview-images').append($new_img);
            });
        }
    }
    func.init();
    $('.toknow>.w-button,.preview-buttons>.toPreview').click(function(){
        func.ui_step_form();
    });
    $('.toPublish>.w-button').click(function(){
        if(func.form_chek()){
            func.submit_share();
        }
        return false;
    });
    $('.toPreview>a').click(function(){
        if(func.form_chek()){
            func.preview_share();
            func.ui_step_preview();
        }
        return false;
    });
    $('.share-title .w-input-input,.title-placeholder').click(function(){
        $('.share-title .w-input-input').focus();
        $('.title-placeholder').hide();
    });
    $('.share-cont .w-input-input,.cont-placeholder').click(function(){
        $('.share-cont .w-input-input').focus();
        $('.cont-placeholder').hide();
    });
    $('.share-title .w-input-input').blur(function(){
        if($.trim($(this).val()).length==0){
            $('.title-placeholder').show();
        }
    });
    $('.share-cont .w-input-input').blur(function(){
        if($.trim($(this).val()).length==0){
            $('.cont-placeholder').show();
        }
    });

    var uploader = WebUploader.create({

        // 自动上传。
        auto: true,

        // swf文件路径
        swf: $("#swf_path").val(),

        // 文件接收服务端。
        server: $("#server_path").val(),

        // 选择文件的按钮。可选。
        // 内部根据当前运行是创建，可能是input元素，也可能是flash.
        pick: '#filePicker',

        // 只允许选择文件，可选。
        accept: {
            title: 'Images',
            extensions: 'gif,jpg,jpeg,bmp,png',
            mimeTypes: 'image/*'
        },
        fileSizeLimit: 5 * 1024 * 1024 ,
        fileNumLimit:12
    });
    var $list = $('#imgList');
    // 当有文件添加进来的时候
    uploader.on('fileQueued', function( file ) {
        //var $li = $('#file_item_tpl').clone().removeAttr('id'),$img = $li.find('img');
        var $li = $($.trim($('#waitingTmpl').html()));
        var $img = $li.find('img');
        $list.append( $li );
        // 创建缩略图
        uploader.makeThumb( file, function( error, src ) {
            if ( error ) {
                $img.replaceWith('<span>不能预览</span>');
                return;
            }
            $img.attr( 'src', src );
            $img.attr( 'title', file.name );
        }, 80, 80 );
        //$li.find('.name').text(file.name);
        //$li.find('.size').text(format_size(file.size));
        $li.attr('id',file.id);
        $li.find('span').text('等待上传…');
        //$li.find('.cancel').click(file.id,function(e){
        //    uploader.removeFile(e.data,true);
        //});
        //$li.show();
    });
    window.uploader = uploader;
    //
    uploader.on('fileDequeued',function(file){
        $( '#'+file.id).remove();
    });
    uploader.on('uploadBeforeSend',function(object,data,headers){
        if(typeof(object.file._info)!='undefined'){
            typeof(object.file._info.width)!='undefined'?data.width=object.file._info.width:0;
            typeof(object.file._info.height)!='undefined'?data.height=object.file._info.height:0;
        }
    });
    // 文件上传过程中创建进度条实时显示。
    uploader.on( 'uploadProgress', function( file, percentage ) {
        var $li = $( '#'+file.id ),
            $percent = $li.find('.progress>.inner');
        $li.find('span').text('上传中...');
        $percent.css( 'width', percentage * 100 + '%' );
    });
    //
    // 文件上传成功，给item添加成功class, 用样式标记上传成功。
    uploader.on( 'uploadSuccess', function( file,data ) {
        var $li = $( '#'+file.id );
        $li.attr('img_path',data.img_path);
        $li.find('span').text('上传完成');
        $li.find('input').removeAttr('disabled').val(data.id);
        $li.addClass('success');
    });
    //
    //// 文件上传失败，现实上传出错。
    //uploader.on( 'uploadError', function( file ) {
    //    var $li = $( '#'+file.id );
    //    $li.find('.result').addClass('label-danger').text('上传失败');
    //});
    //
    // 完成上传完了，成功或者失败，先删除进度条。
    uploader.on( 'uploadComplete', function( file ) {
        var $li = $( '#'+file.id );
        $li.find('.progress>.inner').remove();
    });
    $(document).on('click','#imgList .close',function(){

    });
});