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

namespace think;

class View
{
    // 视图实例
    protected static $instance = null;
    // 模板引擎实例
    public $engine = null;
    // 模板主题名称
    protected $theme = '';
    // 模板变量
    protected $data = [];
    // 视图参数
    protected $config = [
        'theme_on'          => false,
        'auto_detect_theme' => false,
        'var_theme'         => 't',
        'default_theme'     => 'default',
        'view_path'         => '',
        'view_suffix'       => '.html',
        'view_depr'         => DS,
        'view_layer'        => VIEW_LAYER,
        'parse_str'         => [],
        'engine_type'       => 'think',
        'namespace'         => '\\think\\view\\driver\\',
    ];

    public function __construct(array $config = [])
    {
        $this->config($config);
        $this->engine($this->config['engine_type']);
    }

    
    public static function instance(array $config = [])
    {
        if (is_null(self::$instance)) {
            self::$instance = new self($config);
        }
        return self::$instance;
    }

    
    public function assign($name, $value = '')
    {
        if (is_array($name)) {
            $this->data = array_merge($this->data, $name);
            return $this;
        } else {
            $this->data[$name] = $value;
        }
        return $this;
    }

    
    public function config($config = '', $value = null)
    {
        if (is_array($config)) {
            foreach ($this->config as $key => $val) {
                if (isset($config[$key])) {
                    $this->config[$key] = $config[$key];
                }
            }
        } elseif (is_null($value)) {
            // 获取配置参数
            return $this->config[$config];
        } else {
            $this->config[$config] = $value;
        }
        return $this;
    }

    
    public function engine($engine, array $config = [])
    {
        if ('php' == $engine) {
            $this->engine = 'php';
        } else {
            $class        = $this->config['namespace'] . ucwords($engine);
            $this->engine = new $class($config);
        }
        return $this;
    }

    
    public function theme($theme)
    {
        if (true === $theme) {
            // 自动侦测
            $this->config['theme_on']          = true;
            $this->config['auto_detect_theme'] = true;
        } elseif (false === $theme) {
            // 关闭主题
            $this->config['theme_on'] = false;
        } else {
            // 指定模板主题
            $this->config['theme_on'] = true;
            $this->theme              = $theme;
        }
        return $this;
    }

    
    public function fetch($template = '', $vars = [], $config = [], $renderContent = false)
    {
        // 模板变量
        $vars = $vars ? $vars : $this->data;
        if (!$renderContent) {
            // 获取模板文件名
            $template = $this->parseTemplate($template);
            // 开启调试模式Win环境严格区分大小写
            // 模板不存在 抛出异常
            if (!is_file($template) || (APP_DEBUG && IS_WIN && realpath($template) != $template)) {
                throw new Exception('template file not exists:' . $template, 10700);
            }
            // 记录视图信息
            APP_DEBUG && Log::record('[ VIEW ] ' . $template . ' [ ' . var_export($vars, true) . ' ]', 'info');
        }
        // 页面缓存
        ob_start();
        ob_implicit_flush(0);
        if ('php' == $this->engine || empty($this->engine)) {
            // 原生PHP解析
            extract($vars, EXTR_OVERWRITE);
            is_file($template) ? include $template : eval('?>' . $template);
        } else {
            // 指定模板引擎
            $this->engine->fetch($template, $vars, $config);
        }
        // 获取并清空缓存
        $content = ob_get_clean();
        // 内容过滤标签
        APP_HOOK && Hook::listen('view_filter', $content);
        // 允许用户自定义模板的字符串替换
        if (!empty($this->config['parse_str'])) {
            $replace = $this->config['parse_str'];
            $content = str_replace(array_keys($replace), array_values($replace), $content);
        }
        if (!Config::get('response_auto_output')) {
            // 自动响应输出
            return Response::send($content, Response::type());
        }
        return $content;
    }

    
    public function show($content, $vars = [])
    {
        return $this->fetch($content, $vars, '', true);
    }

    
    private function parseTemplate($template)
    {
        if (is_file($template)) {
            return realpath($template);
        }
        if (strpos($template, $this->config['view_suffix'])) {
            return $template;
        }
        $depr     = $this->config['view_depr'];
        $template = str_replace(['/', ':'], $depr, $template);

        // 获取当前模块
        $module = defined('MODULE_NAME') ? MODULE_NAME : '';
        if (strpos($template, '@')) {
            // 跨模块调用模版文件
            list($module, $template) = explode('@', $template);
        }
        // 获取当前主题的模版路径
        defined('THEME_PATH') || define('THEME_PATH', $this->getThemePath($module));

        // 分析模板文件规则
        if (defined('CONTROLLER_NAME')) {
            if ('' == $template) {
                // 如果模板文件名为空 按照默认规则定位
                $template = str_replace('.', DS, CONTROLLER_NAME) . $depr . ACTION_NAME;
            } elseif (false === strpos($template, $depr)) {
                $template = str_replace('.', DS, CONTROLLER_NAME) . $depr . $template;
            }
        }
        return THEME_PATH . $template . $this->config['view_suffix'];
    }

    
    private function getTemplateTheme($module)
    {
        if ($this->config['theme_on']) {
            if ($this->theme) {
                // 指定模板主题
                $theme = $this->theme;
            } elseif ($this->config['auto_detect_theme']) {
                // 自动侦测模板主题
                $t = $this->config['var_theme'];
                if (isset($_GET[$t])) {
                    $theme = $_GET[$t];
                } elseif (Cookie::get('think_theme')) {
                    $theme = Cookie::get('think_theme');
                }
                if (!isset($theme) || !is_dir(APP_PATH . (APP_MULTI_MODULE ? $module . DS : '') . $this->config['view_layer'] . DS . $theme)) {
                    $theme = $this->config['default_theme'];
                }
                Cookie::set('think_theme', $theme, 864000);
            } else {
                $theme = $this->config['default_theme'];
            }
            return $theme . DS;
        }
        return '';
    }

    
    protected function getThemePath($module = '')
    {
        // 获取当前主题名称
        $theme = $this->getTemplateTheme($module);
        // 获取当前主题的模版路径
        $tmplPath = $this->config['view_path']; // 模块设置独立的视图目录
        if (!$tmplPath) {
            // 定义TMPL_PATH 则改变全局的视图目录到模块之外
            $tmplPath = defined('TMPL_PATH') ? TMPL_PATH . $module . DS : APP_PATH . (APP_MULTI_MODULE ? $module . DS : '') . $this->config['view_layer'] . DS;
        }
        return realpath($tmplPath) . DS . $theme;
    }

    
    public function __set($name, $value)
    {
        $this->data[$name] = $value;
    }

    
    public function __get($name)
    {
        return $this->data[$name];
    }

    
    public function __isset($name)
    {
        return isset($this->data[$name]);
    }
}
