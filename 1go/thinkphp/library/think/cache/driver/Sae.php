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


class Sae
{
    protected $handler = null;
    protected $options = [
        'host'       => '127.0.0.1',
        'port'       => 11211,
        'expire'     => 0,
        'timeout'    => false,
        'persistent' => false,
        'length'     => 0,
        'prefix'     => '',
    ];

    
    public function __construct($options = [])
    {
        if (!function_exists('memcache_init')) {
            throw new Exception('请在SAE平台上运行代码。');
        }
        $this->handler = memcache_init();
        if (!$this->handler) {
            throw new Exception('您未开通Memcache服务，请在SAE管理平台初始化Memcache服务');
        }
        if (!empty($options)) {
            $this->options = array_merge($this->options, $options);
        }
    }

    
    public function get($name)
    {
        Cache::$readTimes++;
        return $this->handler->get($_SERVER['HTTP_APPVERSION'] . '/' . $this->options['prefix'] . $name);
    }

    
    public function set($name, $value, $expire = null)
    {
        Cache::$writeTimes++;
        if (is_null($expire)) {
            $expire = $this->options['expire'];
        }
        $name = $this->options['prefix'] . $name;
        if ($this->handler->set($_SERVER['HTTP_APPVERSION'] . '/' . $name, $value, 0, $expire)) {
            if ($this->options['length'] > 0) {
                // 记录缓存队列
                $this->queue($name);
            }
            return true;
        }
        return false;
    }

    
    public function rm($name, $ttl = false)
    {
        $name = $_SERVER['HTTP_APPVERSION'] . '/' . $this->options['prefix'] . $name;
        return false === $ttl ?
        $this->handler->delete($name) :
        $this->handler->delete($name, $ttl);
    }

    
    public function clear()
    {
        return $this->handler->flush();
    }

    
    private function getKv()
    {
        static $kv;
        if (!$kv) {
            $kv = new \SaeKV();
            if (!$kv->init()) {
                throw new Exception('您没有初始化KVDB，请在SAE管理平台初始化KVDB服务');
            }
        }
        return $kv;
    }

    
    //[sae] 下重写queque队列缓存方法
    protected function queue($key)
    {
        $queue_name = isset($this->options['queue_name']) ? $this->options['queue_name'] : 'think_queue';
        $kv         = $this->getKv();
        $value      = $kv->get($queue_name);
        if (!$value) {
            $value = [];
        }
        // 进列
        if (false === array_search($key, $value)) {
            array_push($value, $key);
        }

        if (count($value) > $this->options['length']) {
            // 出列
            $key = array_shift($value);
            // 删除缓存
            $this->rm($key);
        }
        return $kv->set($queue_name, $value);
    }
}
