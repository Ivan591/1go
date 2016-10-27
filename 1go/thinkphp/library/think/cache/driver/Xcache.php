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

namespace think\cache\driver;

use think\Cache;
use think\Exception;


class Xcache
{

    protected $options = [
        'prefix' => '',
        'expire' => 0,
        'length' => 0,
    ];

    
    public function __construct($options = [])
    {
        if (!function_exists('xcache_info')) {
            throw new Exception('_NOT_SUPPERT_:Xcache');
        }
        if (!empty($options)) {
            $this->options = array_merge($this->options, $options);
        }
    }

    
    public function get($name)
    {
        Cache::$readTimes++;
        $name = $this->options['prefix'] . $name;
        if (xcache_isset($name)) {
            return xcache_get($name);
        }
        return false;
    }

    
    public function set($name, $value, $expire = null)
    {
        Cache::$writeTimes++;
        if (is_null($expire)) {
            $expire = $this->options['expire'];
        }
        $name = $this->options['prefix'] . $name;
        if (xcache_set($name, $value, $expire)) {
            if ($this->options['length'] > 0) {
                // 记录缓存队列
                $queue = xcache_get('__info__');
                if (!$queue) {
                    $queue = [];
                }
                if (false === array_search($name, $queue)) {
                    array_push($queue, $name);
                }

                if (count($queue) > $this->options['length']) {
                    // 出列
                    $key = array_shift($queue);
                    // 删除缓存
                    xcache_unset($key);
                }
                xcache_set('__info__', $queue);
            }
            return true;
        }
        return false;
    }

    
    public function rm($name)
    {
        return xcache_unset($this->options['prefix'] . $name);
    }

    
    public function clear()
    {
        return;
    }
}
