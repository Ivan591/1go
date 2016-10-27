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

namespace think\process\pipes;

abstract class Pipes
{

    
    public $pipes = [];

    
    protected $inputBuffer = '';
    
    protected $input;

    
    private $blocked = true;

    const CHUNK_SIZE = 16384;

    
    abstract public function getDescriptors();

    
    abstract public function getFiles();

    
    abstract public function readAndWrite($blocking, $close = false);

    
    abstract public function areOpen();


    
    public function close()
    {
        foreach ($this->pipes as $pipe) {
            fclose($pipe);
        }
        $this->pipes = [];
    }

    
    protected function hasSystemCallBeenInterrupted()
    {
        $lastError = error_get_last();

        return isset($lastError['message']) && false !== stripos($lastError['message'], 'interrupted system call');
    }

    protected function unblock()
    {
        if (!$this->blocked) {
            return;
        }

        foreach ($this->pipes as $pipe) {
            stream_set_blocking($pipe, 0);
        }
        if (null !== $this->input) {
            stream_set_blocking($this->input, 0);
        }

        $this->blocked = false;
    }
}