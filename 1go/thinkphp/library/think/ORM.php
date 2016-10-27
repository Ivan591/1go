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

class ORM
{
    protected static $instance = [];
    protected static $config   = [];

    
    public function __set($name, $value)
    {
        self::__callStatic('__set', [$name, $value]);
    }

    
    public function __get($name)
    {
        return self::__callStatic('__get', [$name]);
    }

    
    public function __isset($name)
    {
        return self::__callStatic('__isset', [$name]);
    }

    
    public function __unset($name)
    {
        self::__callStatic('__unset', [$name]);
    }

    public function __call($method, $params)
    {
        return self::__callStatic($method, $params);
    }

    public static function __callStatic($method, $params)
    {
        $name = basename(str_replace('\\', '/', get_called_class()));
        if (!isset(self::$instance[$name])) {
            // 自动实例化模型类
            self::$instance[$name] = new \think\Model($name, static::$config);
        }
        return call_user_func_array([self::$instance[$name], $method], $params);
    }
}
