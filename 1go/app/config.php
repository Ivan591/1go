<?php

return [
    'category_goods' => 'xiangchang',//默认的商品
    'url_route_on' => true,
    'log' => [
//        'type' => 'trace', // 支持 socket trace file
    ],
//    'template' => [
//        //标签库标签开始标签
//        'taglib_begin'  =>  '<',
//        //标签库标签结束标记
//        'taglib_end'    =>  '>',
//    ],
    // 默认模块名
    'default_module' => __default_module__,
    // 默认控制器名
    'default_controller' => 'Index',
    // 默认操作名
    'default_action' => 'index',
    'parse_str' => [
        '__image_path__' => '',
        '__static__' => '/theme/'.__demo_static__,
        '__common__' => '/common',
        '__yyg__' => '/common/yyg',
        '__upload__' => '',
        '__plugin__' => '/common/plugin',
        '__ROOT__' => '/',
        '__AVATAR__DEFAULT__'=>'/common/img/avatar.jpg',
        '__noimg__'=>'/common/yyg/images/empty_img.jpg',
        '__assets__' => '/common/admin/assets',
    ],
//    'default_return_type'=>'json'
    'extra_config_list' => ['database'],  // 扩展配置文件
    //SESSION配置
    'session' => [
        'id' => '',
        'var_session_id' => '',  // session_ID的提交变量,解决flash上传跨域
        'prefix' => 'xiangchang518',   // session 前缀
        'type' => '',  // 驱动方式 支持redis memcache memcached
        'auto_start' => true,  // 是否自动开启 session
    ],
    'TP_QINIU' => [
        'domain' => "http://7xs4s6.com1.z0.glb.clouddn.com",
        'bucket' => "xitie",
        'accessKey' => '9xgOyxTSh3zCDZcuN886ORGyVxnwld0j26ZJzLIq',
        'secretKey' => 'ZUBYtG1-7WUXp4XsNiqYHJIEAO97k_l2ygm0_JDx',
        'timeout' => '300',
        'Expires'=>3600
    ],
];
