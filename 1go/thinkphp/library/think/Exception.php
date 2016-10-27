<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 麦当苗儿 <zuojiazi@vip.qq.com> <http://zjzit.cn>
// +----------------------------------------------------------------------

namespace think;


class Exception extends \Exception
{
    
    protected $httpStatus = 500;

    
    protected $data = [];

    
    final protected function setData($label, array $data)
    {
        $this->data[$label] = $data;
    }

    
    final public function getData()
    {
        return $this->data;
    }

    
    final public function getHttpStatus()
    {
        return $this->httpStatus;
    }
}
