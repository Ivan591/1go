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


class Test
{

    
    public function get($name)
    {
        return false;
    }

    
    public function set($name, $value, $expire = null)
    {
        return true;
    }

    
    public function rm($name)
    {
        return true;
    }

    
    public function clear()
    {
        return true;
    }
}
