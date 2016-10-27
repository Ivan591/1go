
$(function () {
    var func = {
        init: function () {

        },
        //保存内容
        submit: function () {

            var url = $("#submit_url").val();
            var param = $("#form_content").serialize();
            common.ajax_post(url, param, true, function (rt) {
                common.post_tips(rt, function () {
                    common.delay(function(){
                        location.href = $("#root_url").val();
                    },1000,1)
                });
            }, true);
        },
        admin_submit : function() {

            //
            var  treeObj = $.fn.zTree.getZTreeObj("treeDemo");

            var select_nodes = treeObj.getCheckedNodes(true);

            var select_length = select_nodes.length;

            var role_list = '';

            if(select_length > 0) {
                for (var i=0; i < select_length; i++) {
                    role_list += select_nodes[i].id+',';
                }
                role_list = role_list.substring(0,role_list.length-1);
            }


            var url = $("#submit_url").val();
            var param = $("#form_content").serialize();
            param = param+'&role_list='+role_list;

            common.ajax_post(url,param, true, function (rt) {
                common.post_tips(rt, function () {
                    common.delay(function(){
                        location.href = $("#root_url").val();
                    },1000,1)
                });
            }, true);



        }

    };

    $(document).on("click", ".submit_btn", function () {
        func.submit();
    });

    $(document).on("click", ".admin_submit_btn", function () {
        func.admin_submit();
    });

    func.init();


    $(".upload").click(function (ev) {
        ev.preventDefault();
        var upload_url = $('#upload_url').val();
        layer.open({
            id:'up_img_iframe',
            type: 2,
            area: ['700px', '530px'],
            fix: false, //不固定
            content: upload_url,
            cancel : function () {
                var name=$("#up_img_iframe").find('iframe').attr('name');
                var content = window.frames[name].document.getElementById('return_list').value;
                if(content != '') {
                    console.log(content);
                    var pic_info = $.parseJSON(content);
                    var pic_img = $('.pic_img');
                    $('.pic_id').val(pic_info[0]['id']);

                    if(pic_img.is(":hidden")) {
                        pic_img.show();
                    }
                    pic_img.attr('src',pic_info[0]['path']);
                }


            }
        });
    })



    //zTree代码
    var setting = {
        check: {
            enable: true
        },
        data: {
            simpleData: {
                enable: true
            }
        }
    };

    console.log($('#role_list').val());
    var zNodes =$.parseJSON($('#role_list').val());

    var code;

    function setCheck() {
        var zTree = $.fn.zTree.getZTreeObj("treeDemo"),
            py = "p",
            sy = "s",
            pn = "p",
            sn = "s",
            type = { "Y":py + sy, "N":pn + sn};
        zTree.setting.check.chkboxType = type;
        showCode('setting.check.chkboxType = { "Y" : "' + type.Y + '", "N" : "' + type.N + '" };');
    }
    function showCode(str) {
        if (!code) code = $("#code");
        code.empty();
        code.append("<li>"+str+"</li>");
    }

    var tree = $.fn.zTree.init($("#treeDemo"), setting, zNodes);
    setCheck();
    $("#py").bind("change", setCheck);
    $("#sy").bind("change", setCheck);
    $("#pn").bind("change", setCheck);
    $("#sn").bind("change", setCheck);


    $('#submit').click(function(){
        var  treeObj = $.fn.zTree.getZTreeObj("treeDemo");

        var nodes = treeObj.getCheckedNodes(true);
        console.log(nodes);
    });



});