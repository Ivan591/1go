$(function () {
    var layer_conf = {"icon": "2", "move": false, "closeBtn": false, "title": false};
    var upload_preview = $(".upload_preview");
    var loading_index;
    var uploader;
    var func = {
        init: function () {
            func.uploader_init();
            func.bind_event();
        },
        //初始化上传
        uploader_init: function () {
            var config = func.config();
            uploader = WebUploader.create(config);
        },
        //配置信息
        config: function () {
            return {
                auto: true,
                // swf文件路径
                swf: $("#swf_path").val(),
                // 文件接收服务端。
                server: $("#server_path").val(),
                // 选择文件的按钮
                pick: {
                    id: '#img_picker',
                    label: '点击选择图片'
                },
                dnd: '#img_dnd_area',
                paste: document.body,
                accept: {
                    title: 'Images',
                    extensions: 'gif,jpg,jpeg,bmp,png',
                    mimeTypes: 'image/*'
                },
                formData:{
                    'uid':$("#auth").data('uid'),
                    'timestamp':$("#auth").data('timestamp'),
                    'token':$("#auth").data('token'),
                    'q':common.empty($_GET['q']) ? '' :$_GET['q']
                },
                disableGlobalDnd: true,
                chunked: true,
                fileNumLimit: 300,
                fileSizeLimit: 5 * 1024 * 1024,    // 200 M
                fileSingleSizeLimit: 1 * 1024 * 1024    // 50 M
            }
        },
        bind_event: function () {

            if (typeof uploader != 'object') {
                layer.alert("初始化插件失败!", layer_conf)
            }
            //图片载入时候
            uploader.onFileQueued = function (file) {
                //alert(print(file));
                if (file.getStatus() === 'invalid') {
                    layer.msg(file.statusText);
                } else {
                    // @todo lazyload
                    //$wrap.text( '预览中' );
                    uploader.makeThumb(file, function (error, src) {
                        if (error) {
                            layer.msg("不能预览!");
                            return;
                        }
                        var name = file.name;
                        var tmp = $('#up_template').html();
                        upload_preview.prepend(tmp);
                        var exec_obj = upload_preview.find('.upload_append_list').eq(0);
                        exec_obj.attr('id', file.id);//设置id
                        exec_obj.find('p.file_name').html(name);
                        exec_obj.find('.upload_image').attr('src', src);
                    }, 200, 200);
                }
            };
            //点击 上传 时触发
            uploader.onStartUpload = function () {
                var obj = uploader.getFiles('queued');
                if (obj.length > 0) {
                    loading_index = layer.msg('上传中,请稍候...', {"time": false});
                }
            };
            //所有文件 上传完毕 时触发
            uploader.onUploadFinished = function (file) {
                layer.msg('执行上传操作完毕');
                func.reget_img();
            };
            //上传进度
            uploader.onUploadProgress = function (file, percentage) {

                var now_obj = $("#" + file.id);
                now_obj.find('.file_progress').css("width", common.round(percentage * 100, 2) + "%");
            };
            //每个文件开始上传的时候触发
            uploader.onUploadStart = function (file) {

                var now_obj = $("#" + file.id);
                now_obj.find('.file_progress').show();
            };

            //每个文件 上传完毕 的时候触发
            uploader.onUploadComplete = function (file) {
                var now_obj = $("#" + file.id);
                now_obj.find('.file_progress').hide();
            };

            //每个文件 上传成功 的时候触发
            uploader.onUploadSuccess = function (file, response) {
                var now_obj = $("#" + file.id);
                if (response.code == '1') {
                    now_obj.find('.file_progress').show();
                    now_obj.find('.file_success').show();
                    now_obj.addClass('success_img');
                    now_obj.attr('data-img_id',response.id);
                    now_obj.attr('data-img_path',response.img_path);
                }
                else{
                    now_obj.find('.file_failure').show();
                }
            };

            //每个文件 上传出错 的时候触发
            uploader.onUploadError = function (file, reason) {
                var now_obj = $("#" + file.id);
                now_obj.find('.file_failure').show();
                //alert(reason)
            };

            //每个文件 被移除 的时候触发
            uploader.onFileDequeued = function (file) {
                layer.msg('图片:(' + file.name + ')移除成功')
            };
        },
        del: function (id) {
            uploader.removeFile(id);
            $("#" + id).remove();
        },
        //获取列表中已经成功的图片的id和存储地址的集合
        reget_img:function(){
            var arr = [];
            var obj = $(".success_img");
            $.each(obj,function(k,o){
                arr.push({"id":obj.eq(k).data('img_id'),"path":obj.eq(k).data('img_path')});
            });
            $("#return_list").val(JSON.stringify(arr));
        }
    };


    func.init();

    $(document).on("mouseover", ".upload_append_list", function () {
        var obj = $(this);
        obj.find(".file_bar").addClass('file_hover');
    });
    $(document).on("mouseout", ".upload_append_list", function () {
        var obj = $(this);
        obj.find(".file_bar").removeClass('file_hover');
    });

    //开始上传
    $(document).on("click", ".upload_btn", function () {
        uploader.upload();
    });

    //删除单张图片
    $(document).on("click", ".file_del", function () {
        var obj = $(this);
        var id = obj.closest('.upload_append_list').attr('id');
        var index = layer.confirm("确定删除吗?", {
            "move": false,
            "title": false,
            "closeBtn": false
        }, function () {
            func.del(id);
            layer.close(index);
        });

    });

    //重置上传
    $(document).on("click", ".img_reset", function () {
        layer.confirm("确定清除全部图片吗?", {
            "move": false,
            "title": false,
            "closeBtn": false
        }, function () {
            location.reload();
        });
    });
});

function print(obj) {
    try {
        seen = [];
        json = JSON.stringify(obj, function (key, val) {
            if (typeof val == "object") {
                if (seen.indexOf(val) >= 0) return;
                seen.push(val)
            }
            return val;
        });
        return json;
    } catch (e) {
        return e;
    }
}