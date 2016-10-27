<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------
namespace think\log\alarm;


class Email
{

    protected $config = [
        'address' => '',
    ];

    // 实例化并传入参数
    public function __construct($config = [])
    {
        $this->config = array_merge($this->config, $config);
    }

    
    public function send($msg = '')
    {
        return error_log($msg, 1, $this->config['address']);
    }

}
