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

namespace think;

class Config
{
    // 配置参数
    private static $config = [];
    // 参数作用域
    private static $range = '_sys_';

    // 设定配置参数的作用域
    public static function range($range)
    {
        self::$range = $range;
        if (!isset(self::$config[$range])) {
            self::$config[$range] = [];
        }
    }

    
    public static function parse($config, $type = '', $range = '')
    {
        $range = $range ?: self::$range;
        if (empty($type)) {
            $type = pathinfo($config, PATHINFO_EXTENSION);
        }
        $class = (false === strpos($type, '\\')) ? '\\think\\config\\driver\\' . ucwords($type) : $type;
        self::set((new $class())->parse($config), '', $range);
    }

    
    public static function load($file, $name = '', $range = '')
    {
        $range = $range ?: self::$range;
        if (!isset(self::$config[$range])) {
            self::$config[$range] = [];
        }
        // 记录加载信息
        APP_DEBUG && Log::record('[ CONFIG ] ' . $file, 'info');
        return is_file($file) ? self::set(include $file, $name, $range) : self::$config[$range];
    }

    
    public static function has($name, $range = '')
    {
        $range = $range ?: self::$range;
        $name  = strtolower($name);

        if (!strpos($name, '.')) {
            return isset(self::$config[$range][$name]);
        } else {
            // 二维数组设置和获取支持
            $name = explode('.', $name);
            return isset(self::$config[$range][$name[0]][$name[1]]);
        }
    }

    
    public static function get($name = null, $range = '')
    {
        $range = $range ?: self::$range;
        // 无参数时获取所有
        if (empty($name) && isset(self::$config[$range])) {
            return self::$config[$range];
        }
        $name = strtolower($name);
        if (!strpos($name, '.')) {
            // 判断环境变量
            if (isset($_ENV[ENV_PREFIX . $name])) {
                return $_ENV[ENV_PREFIX . $name];
            }
            return isset(self::$config[$range][$name]) ? self::$config[$range][$name] : null;
        } else {
            // 二维数组设置和获取支持
            $name = explode('.', $name);
            // 判断环境变量
            if (isset($_ENV[ENV_PREFIX . $name[0] . '_' . $name[1]])) {
                return $_ENV[ENV_PREFIX . $name[0] . '_' . $name[1]];
            }
            return isset(self::$config[$range][$name[0]][$name[1]]) ? self::$config[$range][$name[0]][$name[1]] : null;
        }
    }

    
    public static function set($name, $value = null, $range = '')
    {
        $range = $range ?: self::$range;
        if (!isset(self::$config[$range])) {
            self::$config[$range] = [];
        }
        if (is_string($name)) {
            $name = strtolower($name);
            if (!strpos($name, '.')) {
                self::$config[$range][$name] = $value;
            } else {
                // 二维数组设置和获取支持
                $name                                     = explode('.', $name);
                self::$config[$range][$name[0]][$name[1]] = $value;
            }
            return;
        } elseif (is_array($name)) {
            // 批量设置
            $config = array_change_key_case($name);
            if (!empty($value)) {
                self::$config[$range][$value] = isset(self::$config[$range][$value]) ?
                array_merge(self::$config[$range][$value], $config) :
                self::$config[$range][$value] = $config;
                return self::$config[$range][$value];
            } else {
                return self::$config[$range] = array_merge(self::$config[$range], $config);
            }
        } else {
            // 为空直接返回 已有配置
            return self::$config[$range];
        }
    }

    
    public static function reset($range = '')
    {
        $range                          = $range ?: self::$range;
        true === $range ? self::$config = [] : self::$config[$range] = [];
    }
}
