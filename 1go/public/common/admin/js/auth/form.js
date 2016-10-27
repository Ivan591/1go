
$(function () {
    var func = {
        init: function () {

        },
        //保存内容
        submit: function () {


            //
            var  treeObj = $.fn.zTree.getZTreeObj("treeDemo");

            var select_nodes = treeObj.getCheckedNodes(true);

            var select_length = select_nodes.length;

            var auth_list = '';

            if(select_length > 0) {
                for (var i=0; i < select_length; i++) {
                    auth_list += select_nodes[i].id+',';
                }
                auth_list = auth_list.substring(0,auth_list.length-1);
            }



            var url = $("#submit_url").val();
            var param = $("#form_content").serialize();
            param = param+'&auth_list='+auth_list;

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
    func.init();



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


    var zNodes =$.parseJSON($('#menu_list').val());

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








});