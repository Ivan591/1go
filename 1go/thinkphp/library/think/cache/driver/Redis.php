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


class Redis
{
    protected $handler = null;
    protected $options = [
        'host'       => '127.0.0.1',
        'port'       => 6379,
        'password'   => '',
        'timeout'    => false,
        'expire'     => false,
        'persistent' => false,
        'length'     => 0,
        'prefix'     => '',
    ];

    
    public function __construct($options = [])
    {
        if (!extension_loaded('redis')) {
            throw new Exception('_NOT_SUPPERT_:redis');
        }
        if (!empty($options)) {
            $this->options = array_merge($this->options, $options);
        }
        $func          = $this->options['persistent'] ? 'pconnect' : 'connect';
        $this->handler = new \Redis;
        false === $this->options['timeout'] ?
        $this->handler->$func($this->options['host'], $this->options['port']) :
        $this->handler->$func($this->options['host'], $this->options['port'], $this->options['timeout']);
        if ('' != $this->options['password']) {
            $this->handler->auth($this->options['password']);
        }
    }

    
    public function get($name)
    {
        Cache::$readTimes++;
        $value = $this->handler->get($this->options['prefix'] . $name);
        $jsonData  = json_decode( $value, true );
        // 检测是否为JSON数据 true 返回JSON解析数组, false返回源数据 byron sampson<xiaobo.sun@qq.com>
        return ($jsonData === null) ? $value : $jsonData;
    }

    
    public function set($name, $value, $expire = null)
    {
        Cache::$writeTimes++;
        if (is_null($expire)) {
            $expire = $this->options['expire'];
        }
        $name = $this->options['prefix'] . $name;
        //对数组/对象数据进行缓存处理，保证数据完整性  byron sampson<xiaobo.sun@qq.com>
        $value  =  (is_object($value) || is_array($value)) ? json_encode($value) : $value;
        if (is_int($expire)) {
            $result = $this->handler->setex($name, $expire, $value);
        } else {
            $result = $this->handler->set($name, $value);
        }
        if ($result && $this->options['length'] > 0) {
            if ($this->options['length'] > 0) {
                // 记录缓存队列
                $queue = $this->handler->get('__info__');
                $queue = explode(',', $queue);
                if (false === array_search($name, $queue)) {
                    array_push($queue, $name);
                }

                if (count($queue) > $this->options['length']) {
                    // 出列
                    $key = array_shift($queue);
                    // 删除缓存
                    $this->handler->delete($key);
                }
                $this->handler->set('__info__', implode(',', $queue));
            }
        }
        return $result;
    }

    
    public function rm($name)
    {
        return $this->handler->delete($this->options['prefix'] . $name);
    }

    
    public function clear()
    {
        return $this->handler->flushDB();
    }

}
