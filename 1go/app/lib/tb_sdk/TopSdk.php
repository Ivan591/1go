<?php
namespace app\lib\tb_sdk;

    

    

if (!defined("TOP_SDK_WORK_DIR")) {
    define("TOP_SDK_WORK_DIR", "/tmp/");
}


if (!defined("TOP_SDK_DEV_MODE")) {
    define("TOP_SDK_DEV_MODE", true);
}

if (!defined("TOP_AUTOLOADER_PATH")) {
    define("TOP_AUTOLOADER_PATH", dirname(__FILE__));
}


require("Autoloader.php");