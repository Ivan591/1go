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

namespace think\console\output\formatter;


class Stack
{

    
    private $styles;

    
    private $emptyStyle;

    
    public function __construct(Style $emptyStyle = null)
    {
        $this->emptyStyle = $emptyStyle ?: new Style();
        $this->reset();
    }

    
    public function reset()
    {
        $this->styles = [];
    }

    
    public function push(Style $style)
    {
        $this->styles[] = $style;
    }

    
    public function pop(Style $style = null)
    {
        if (empty($this->styles)) {
            return $this->emptyStyle;
        }

        if (null === $style) {
            return array_pop($this->styles);
        }

        
        foreach (array_reverse($this->styles, true) as $index => $stackedStyle) {
            if ($style->apply('') === $stackedStyle->apply('')) {
                $this->styles = array_slice($this->styles, 0, $index);

                return $stackedStyle;
            }
        }

        throw new \InvalidArgumentException('Incorrectly nested style tag found.');
    }

    
    public function getCurrent()
    {
        if (empty($this->styles)) {
            return $this->emptyStyle;
        }

        return $this->styles[count($this->styles) - 1];
    }

    
    public function setEmptyStyle(Style $emptyStyle)
    {
        $this->emptyStyle = $emptyStyle;

        return $this;
    }

    
    public function getEmptyStyle()
    {
        return $this->emptyStyle;
    }
}