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

namespace think\template;

use think\Exception;


class TagLib
{

    
    protected $xml  = '';
    protected $tags = []; // 标签定义
    
    protected $tagLib = '';

    
    protected $tagList = [];

    
    protected $parse = [];

    
    protected $valid = false;

    
    protected $tpl;

    protected $comparison = [' nheq ' => ' !== ', ' heq ' => ' === ', ' neq ' => ' != ', ' eq ' => ' == ', ' egt ' => ' >= ', ' gt ' => ' > ', ' elt ' => ' <= ', ' lt ' => ' < '];

    
    public function __construct($template)
    {
        $this->tpl = $template;
    }

    
    public function parseTag(&$content, $lib = '')
    {
        $tags = [];
        $_lib = $lib ? $lib . ':' : '';
        foreach ($this->tags as $name => $val) {
            $close                       = !isset($val['close']) || $val['close'] ? 1 : 0;
            $tags[$close][$_lib . $name] = $name;
            if (isset($val['alias'])) {
                // 别名设置
                $array = (array) $val['alias'];
                foreach (explode(',', $array[0]) as $v) {
                    $tags[$close][$_lib . $v] = $name;
                }
            }
        }

        // 闭合标签
        if (!empty($tags[1])) {
            $nodes = [];
            $regex = $this->getRegex(array_keys($tags[1]), 1);
            if (preg_match_all($regex, $content, $matches, PREG_SET_ORDER | PREG_OFFSET_CAPTURE)) {
                $right = [];
                foreach ($matches as $match) {
                    if ('' == $match[1][0]) {
                        $name = $match[2][0];
                        // 如果有没闭合的标签头则取出最后一个
                        if (!empty($right[$name])) {
                            // $match[0][1]为标签结束符在模板中的位置
                            $nodes[$match[0][1]] = [
                                'name'  => $name,
                                'begin' => array_pop($right[$name]), // 标签开始符
                                'end'   => $match[0], // 标签结束符
                            ];
                        }
                    } else {
                        // 标签头压入栈
                        $right[$match[1][0]][] = $match[0];
                    }
                }
                unset($right, $matches);
                // 按标签在模板中的位置从后向前排序
                krsort($nodes);
            }

            $break = '<!--###break###--!>';
            if ($nodes) {
                $beginArray = [];
                // 标签替换 从后向前
                foreach ($nodes as $pos => $node) {
                    // 对应的标签名
                    $name  = $tags[1][$node['name']];
                    $alias = $_lib . $name != $node['name'] ? ($_lib ? strstr($node['name'], $_lib) : $node['name']) : '';
                    // 解析标签属性
                    $attrs  = $this->parseAttr($node['begin'][0], $name, $alias);
                    $method = '_' . $name;
                    // 读取标签库中对应的标签内容 replace[0]用来替换标签头，replace[1]用来替换标签尾
                    $replace = explode($break, $this->$method($attrs, $break));
                    if (count($replace) > 1) {
                        while ($beginArray) {
                            $begin = end($beginArray);
                            // 判断当前标签尾的位置是否在栈中最后一个标签头的后面，是则为子标签
                            if ($node['end'][1] > $begin['pos']) {
                                break;
                            } else {
                                // 不为子标签时，取出栈中最后一个标签头
                                $begin = array_pop($beginArray);
                                // 替换标签头部
                                $content = substr_replace($content, $begin['str'], $begin['pos'], $begin['len']);
                            }
                        }
                        // 替换标签尾部
                        $content = substr_replace($content, $replace[1], $node['end'][1], strlen($node['end'][0]));
                        // 把标签头压入栈
                        $beginArray[] = ['pos' => $node['begin'][1], 'len' => strlen($node['begin'][0]), 'str' => $replace[0]];
                    }
                }
                while ($beginArray) {
                    $begin = array_pop($beginArray);
                    // 替换标签头部
                    $content = substr_replace($content, $begin['str'], $begin['pos'], $begin['len']);
                }
            }
        }
        // 自闭合标签
        if (!empty($tags[0])) {
            $regex   = $this->getRegex(array_keys($tags[0]), 0);
            $content = preg_replace_callback($regex, function ($matches) use (&$tags, &$_lib) {
                // 对应的标签名
                $name  = $tags[0][$matches[1]];
                $alias = $_lib . $name != $matches[1] ? ($_lib ? strstr($matches[1], $_lib) : $matches[1]) : '';
                // 解析标签属性
                $attrs  = $this->parseAttr($matches[0], $name, $alias);
                $method = '_' . $name;
                return $this->$method($attrs, '');
            }, $content);
        }
        return;
    }

    
    private function getRegex($tags, $close)
    {
        $begin   = $this->tpl->config('taglib_begin');
        $end     = $this->tpl->config('taglib_end');
        $single  = strlen(ltrim($begin, '\\')) == 1 && strlen(ltrim($end, '\\')) == 1 ? true : false;
        $tagName = is_array($tags) ? implode('|', $tags) : $tags;
        if ($single) {
            if ($close) {
                // 如果是闭合标签
                $regex = $begin . '(?:(' . $tagName . ')\b(?>[^' . $end . ']*)|\/(' . $tagName . '))' . $end;
            } else {
                $regex = $begin . '(' . $tagName . ')\b(?>[^' . $end . ']*)' . $end;
            }
        } else {
            if ($close) {
                // 如果是闭合标签
                $regex = $begin . '(?:(' . $tagName . ')\b(?>(?:(?!' . $end . ').)*)|\/(' . $tagName . '))' . $end;
            } else {
                $regex = $begin . '(' . $tagName . ')\b(?>(?:(?!' . $end . ').)*)' . $end;
            }
        }
        return '/' . $regex . '/is';
    }

    
    public function parseAttr($str, $name, $alias = '')
    {
        $regex  = '/\s+(?>(?<name>[\w-]+)\s*)=(?>\s*)([\"\'])(?<value>(?:(?!\\2).)*)\\2/is';
        $result = [];
        if (preg_match_all($regex, $str, $matches)) {
            foreach ($matches['name'] as $key => $val) {
                $result[$val] = $matches['value'][$key];
            }
            if (!isset($this->tags[$name])) {
                // 检测是否存在别名定义
                foreach ($this->tags as $key => $val) {
                    if (isset($val['alias'])) {
                        $array = (array) $val['alias'];
                        if (in_array($name, explode(',', $array[0]))) {
                            $tag           = $val;
                            $type          = !empty($array[1]) ? $array[1] : 'type';
                            $result[$type] = $name;
                            break;
                        }
                    }
                }
            } else {
                $tag = $this->tags[$name];
                // 设置了标签别名
                if (!empty($alias) && isset($tag['alias'])) {
                    $type          = !empty($tag['alias'][1]) ? $tag['alias'][1] : 'type';
                    $result[$type] = $alias;
                }
            }
            if (!empty($tag['must'])) {
                $must = explode(',', $tag['must']);
                foreach ($must as $name) {
                    if (!isset($result[$name])) {
                        throw new Exception('_PARAM_ERROR_:' . $name);
                    }
                }
            }
        } else {
            // 允许直接使用表达式的标签
            if (!empty($this->tags[$name]['expression'])) {
                static $_taglibs;
                if (!isset($_taglibs[$name])) {
                    $_taglibs[$name][0] = strlen(ltrim($this->tpl->config('taglib_begin'), '\\') . $name);
                    $_taglibs[$name][1] = strlen(ltrim($this->tpl->config('taglib_end'), '\\'));
                }
                $result['expression'] = substr($str, $_taglibs[$name][0], -$_taglibs[$name][1]);
                // 清除自闭合标签尾部/
                $result['expression'] = rtrim($result['expression'], '/');
                $result['expression'] = trim($result['expression']);
            } elseif (empty($this->tags[$name]) || !empty($this->tags[$name]['attr'])) {
                throw new Exception('_XML_TAG_ERROR_:' . $name);
            }
        }
        return $result;
    }

    
    public function parseCondition($condition)
    {
        $condition = str_ireplace(array_keys($this->comparison), array_values($this->comparison), $condition);
        $this->tpl->parseVar($condition);
        // $this->tpl->parseVarFunction($condition); // XXX: 此句能解析表达式中用|分隔的函数，但表达式中如果有|、||这样的逻辑运算就产生了歧异
        return $condition;
    }

    
    public function autoBuildVar(&$name)
    {
        $flag = substr($name, 0, 1);
        if (':' == $flag) {
            // 以:开头为函数调用，解析前去掉:
            $name = substr($name, 1);
        } elseif ('$' != $flag && preg_match('/[a-zA-Z_]/', $flag)) {
            // XXX: 这句的写法可能还需要改进
            // 常量不需要解析
            if (defined($name)) {
                return $name;
            }
            // 不以$开头并且也不是常量，自动补上$前缀
            $name = '$' . $name;
        }
        $this->tpl->parseVar($name);
        $this->tpl->parseVarFunction($name);
        return $name;
    }

    
    // 获取标签定义
    public function getTags()
    {
        return $this->tags;
    }
}
