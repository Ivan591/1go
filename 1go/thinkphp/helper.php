<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

//------------------------
// ThinkPHP 助手函数
//-------------------------

// 获取多语言变量
function L($name, $vars = [], $lang = '')
{
    return \think\Lang::get($name, $vars, $lang);
}

// 获取配置参数
function C($name = '', $value = null, $range = '')
{
    if (is_null($value) && is_string($name)) {
        return \think\Config::get($name, $range);
    } else {
        return \think\Config::set($name, $value, $range);
    }
}

// 获取输入数据 支持默认值和过滤
function I($key, $default = null, $filter = '', $merge = false)
{
    if (0 === strpos($key, '?')) {
        $key = substr($key, 1);
        $has = '?';
    } else {
        $has = '';
    }
    if ($pos = strpos($key, '.')) {
        // 指定参数来源
        $method = substr($key, 0, $pos);
        if (in_array($method, ['get', 'post', 'put', 'delete', 'param', 'request', 'session', 'cookie', 'server', 'globals', 'env', 'path', 'file'])) {
            $key = substr($key, $pos + 1);
        } else {
            $method = 'param';
        }
    } else {
        // 默认为自动判断
        $method = 'param';
    }
    return \think\Input::$method($has . $key, $default, $filter, $merge);
}


function G($start, $end = '', $dec = 6)
{
    if ('' == $end) {
        \think\Debug::remark($start);
    } else {
        return 'm' == $dec ? \think\Debug::getRangeMem($start, $end) : \think\Debug::getRangeTime($start, $end, $dec);
    }
}


function M($name = '', $tablePrefix = null, $connection = '')
{
    return \think\Loader::table($name, ['prefix' => $tablePrefix, 'connection' => $connection]);
}


function D($name = '', $layer = MODEL_LAYER)
{
    return \think\Loader::model($name, $layer);
}


function db($config = [])
{
    return \think\Db::connect($config);
}


function A($name, $layer = CONTROLLER_LAYER)
{
    return \think\Loader::controller($name, $layer);
}


function R($url, $vars = [], $layer = CONTROLLER_LAYER)
{
    return \think\Loader::action($url, $vars, $layer);
}


function import($class, $baseUrl = '', $ext = EXT)
{
    return \think\Loader::import($class, $baseUrl, $ext);
}


function vendor($class, $ext = EXT)
{
    return \think\Loader::import($class, VENDOR_PATH, $ext);
}


function T($class, $ext = EXT)
{
    return \think\Loader::import($class, TRAIT_PATH, $ext);
}


function E($msg, $code = 0)
{
    throw new \think\Exception($msg, $code);
}


function dump($var, $echo = true, $label = null)
{
    return \think\Debug::dump($var, $echo, $label);
}


function W($name, $data = [])
{
    return \think\Loader::action($name, $data, 'widget');
}

function U($url = '', $vars = '', $suffix = true, $domain = false)
{
    return \think\Url::build($url, $vars, $suffix, $domain);
}

function session($name, $value = '', $prefix = null)
{
    if (is_array($name)) {
        // 初始化
        \think\Session::init($name);
    } elseif (is_null($name)) {
        // 清除
        \think\Session::clear($value);
    } elseif ('' === $value) {
        // 判断或获取
        return 0 === strpos($name, '?') ? \think\Session::has(substr($name, 1), $prefix) : \think\Session::get($name, $prefix);
    } elseif (is_null($value)) {
        // 删除session
        return \think\Session::delete($name, $prefix);
    } else {
        // 设置session
        return \think\Session::set($name, $value, $prefix);
    }
}

function cookie($name, $value = '')
{
    if (is_array($name)) {
        // 初始化
        \think\Cookie::init($name);
    } elseif (is_null($name)) {
        // 清除
        \think\Cookie::clear($value);
    } elseif ('' === $value) {
        // 获取
        return \think\Cookie::get($name);
    } elseif (is_null($value)) {
        // 删除session
        return \think\Cookie::delete($name);
    } else {
        // 设置session
        return \think\Cookie::set($name, $value);
    }
}


function S($name, $value = '', $options = null)
{
    if (is_array($options)) {
        // 缓存操作的同时初始化
        \think\Cache::connect($options);
    } elseif (is_array($name)) {
        // 缓存初始化
        return \think\Cache::connect($name);
    }
    if ('' === $value) {
        // 获取缓存
        return \think\Cache::get($name);
    } elseif (is_null($value)) {
        // 删除缓存
        return \think\Cache::rm($name);
    } else {
        // 缓存数据
        if (is_array($options)) {
            $expire = isset($options['expire']) ? $options['expire'] : null; //修复查询缓存无法设置过期时间
        } else {
            $expire = is_numeric($options) ? $options : null; //默认快捷缓存设置过期时间
        }
        return \think\Cache::set($name, $value, $expire);
    }
}


function trace($log = '[think]', $level = 'log')
{
    if ('[think]' === $log) {
        return \think\Log::getLog();
    } else {
        \think\Log::record($log, $level);
    }
}


function V($template = '', $vars = [])
{
    return \think\View::instance(\think\Config::get())->fetch($template, $vars);
}
