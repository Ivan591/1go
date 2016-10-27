<?php
if(empty($_SERVER['SERVER_NAME'])){
    $demo_static = "1";
}
else{
    $demo_static =$_SERVER['SERVER_NAME'];
}

//根据域名区分模版
switch($demo_static){
    case '1.xiangchang.com':
        $demo_static = 'default';
        $category = 'xiangchang';
        $default_module = 'yyg';
        break;
    case 'demo1.xiangchang.com':
        $demo_static = 'awyyg';
        $category = 'aiwanyiyuangou';
        $default_module = 'yyg';
        break;
    case 'demo2.xiangchang.com':
        $demo_static = 'jzdb';
        $category = 'juziduobao';
        $default_module = 'yyg';
        break;
    case 'demo3.xiangchang.com':
        $demo_static = 'lndb';
        $category = 'laoniuduobao';
        $default_module = 'yyg';
        break;
    case 'demo4.xiangchang.com':
        $demo_static = 'ssyyg';
        $category = 'shishangyiyuangou';
        $default_module = 'yyg';
        break;
        break;
    case 'demo5.xiangchang.com':
        $demo_static = 'yymm';
        $category = 'yiyuanmaimi';
        $default_module = 'yyg';
        break;
    case 'admin.xiangchang.com':
        $demo_static = 'default';
        $category = 'xiangchang';
        $default_module = 'admin';
        break;
    default:
        $demo_static = 'default';
        $category = 'xiangchang';
        $default_module = 'yyg';
}

//区分静态资源
define('__demo_static__',$demo_static);

define('__static_ad__','欢迎使用梦蝶一元购CMS管理系统,该域名尚未授权，请联系企业QQ：800133338,梦蝶官网：www.mengdie.com');
//区分分类、商品数据
define('__demo_category__',$category);
//区分模块
define('__default_module__',$default_module);






header("Content-type:text/html;charset=utf-8");
// [ 应用入口文件 ]

// 定义应用目录
define('APP_PATH', __DIR__ . '/../app/');
// 开启调试模式
define('APP_DEBUG', true);
define('__DB__', 'xc');
define('__BASE0__', '10000000');//幸运数字相加的数字,不能变
define('__BASE1__', '10000001');//幸运数字相加的数字,不能变
define('__LOTTERY__', 'lottery');
define('__SPLIT_CODE_NUM__', '3000');//生成随机号码的分割数量,每多少条数据分一条,不能变
define("TOP_SDK_WORK_DIR", "/tmp/");
// 加载框架引导文件
require __DIR__ . '/../thinkphp/start.php';
