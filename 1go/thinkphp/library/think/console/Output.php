<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2015 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: yunwuxin <448901948@qq.com>
// +----------------------------------------------------------------------

namespace think\console;

use think\console\output\Formatter;
use think\console\output\Stream;

class Output extends Stream
{

    
    private $stderr;

    public function __construct()
    {
        $outputStream = 'php://stdout';
        if (!$this->hasStdoutSupport()) {
            $outputStream = 'php://output';
        }

        parent::__construct(fopen($outputStream, 'w'));

        $this->stderr = new Stream(fopen('php://stderr', 'w'), $this->getFormatter());
    }

    
    public function setDecorated($decorated)
    {
        parent::setDecorated($decorated);
        $this->stderr->setDecorated($decorated);
    }

    
    public function setFormatter(Formatter $formatter)
    {
        parent::setFormatter($formatter);
        $this->stderr->setFormatter($formatter);
    }

    
    public function setVerbosity($level)
    {
        parent::setVerbosity($level);
        $this->stderr->setVerbosity($level);
    }

    
    public function getErrorOutput()
    {
        return $this->stderr;
    }

    
    public function setErrorOutput(Output $error)
    {
        $this->stderr = $error;
    }

    
    protected function hasStdoutSupport()
    {
        return ('OS400' != php_uname('s'));
    }
}