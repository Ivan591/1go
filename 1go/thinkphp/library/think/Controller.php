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

T('controller/Jump');

class Controller
{
    use \traits\controller\Jump;

    // 视图类实例
    protected $view = null;

    
    protected $beforeActionList = [];

    
    public function __construct()
    {
        $this->view = \think\View::instance(Config::get());

        // 控制器初始化
        if (method_exists($this, '_initialize')) {
            $this->_initialize();
        }

        // 前置操作方法
        if ($this->beforeActionList) {
            foreach ($this->beforeActionList as $method => $options) {
                is_numeric($method) ?
                $this->beforeAction($options) :
                $this->beforeAction($method, $options);
            }
        }
    }

    
    protected function beforeAction($method, $options = [])
    {
        if (isset($options['only'])) {
            if (is_string($options['only'])) {
                $options['only'] = explode(',', $options['only']);
            }
            if (!in_array(ACTION_NAME, $options['only'])) {
                return;
            }
        } elseif (isset($options['except'])) {
            if (is_string($options['except'])) {
                $options['except'] = explode(',', $options['except']);
            }
            if (in_array(ACTION_NAME, $options['except'])) {
                return;
            }
        }

        if (method_exists($this, $method)) {
            call_user_func([$this, $method]);
        }
    }

    
    public function fetch($template = '', $vars = [], $config = [])
    {
        return $this->view->fetch($template, $vars, $config);
    }

    
    public function display($template = '', $vars = [], $config = [])
    {
        return $this->view->fetch($template, $vars, $config);
    }

    
    public function show($content, $vars = [])
    {
        return $this->view->show($content, $vars);
    }

    
    public function assign($name, $value = '')
    {
        $this->view->assign($name, $value);
    }

    
    public function engine($engine, $config = [])
    {
        $this->view->engine($engine, $config);
    }
}
