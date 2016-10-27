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

namespace think\console\helper;


use think\console\command\Command;

class Set implements \IteratorAggregate
{

    private $helpers = [];
    private $command;

    
    public function __construct(array $helpers = [])
    {
        
        foreach ($helpers as $alias => $helper) {
            $this->set($helper, is_int($alias) ? null : $alias);
        }
    }

    
    public function set(Helper $helper, $alias = null)
    {
        $this->helpers[$helper->getName()] = $helper;
        if (null !== $alias) {
            $this->helpers[$alias] = $helper;
        }

        $helper->setHelperSet($this);
    }

    
    public function has($name)
    {
        return isset($this->helpers[$name]);
    }

    
    public function get($name)
    {
        if (!$this->has($name)) {
            throw new \InvalidArgumentException(sprintf('The helper "%s" is not defined.', $name));
        }

        return $this->helpers[$name];
    }

    
    public function setCommand(Command $command = null)
    {
        $this->command = $command;
    }

    
    public function getCommand()
    {
        return $this->command;
    }

    public function getIterator()
    {
        return new \ArrayIterator($this->helpers);
    }
}
