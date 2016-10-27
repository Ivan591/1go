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

use think\exception\ErrorException;

class Error
{
    
    public static function register()
    {
        set_error_handler([__CLASS__, 'appError']);
        set_exception_handler([__CLASS__, 'appException']);
        register_shutdown_function([__CLASS__, 'appShutdown']);
    }

    
    public static function appException($exception)
    {
        
        if (!(APP_DEBUG || IS_API)) {
            $error_page = Config::get('error_page');
            if (!empty($error_page)) {
                header("Location: {$error_page}");
            }
        }

        // 收集异常数据
        if (APP_DEBUG) {
            // 调试模式，获取详细的错误信息
            $data = [
                'name'    => get_class($exception),
                'file'    => $exception->getFile(),
                'line'    => $exception->getLine(),
                'message' => $exception->getMessage(),
                'trace'   => $exception->getTrace(),
                'code'    => self::getCode($exception),
                'source'  => self::getSourceCode($exception),
                'datas'   => self::getExtendData($exception),

                'tables'  => [
//                    'GET Data'              => $_GET,
//                    'POST Data'             => $_POST,
//                    'Files'                 => $_FILES,
//                    'Cookies'               => $_COOKIE,
//                    'Session'               => isset($_SESSION) ? $_SESSION : [],
//                    'Server/Request Data'   => $_SERVER,
//                    'Environment Variables' => $_ENV,
//                    'ThinkPHP Constants'    => self::getTPConst(),
                ],
            ];
            $log = "[{$data['code']}]{$data['message']}[{$data['file']}:{$data['line']}]";
        } else {
            // 部署模式仅显示 Code 和 Message
            $data = [
                'code'    => $exception->getCode(),
                'message' => Config::get('show_error_msg') ? $exception->getMessage() : Config::get('error_message'),
            ];
            $log = "[{$data['code']}]{$data['message']}";
        }

        // 记录异常日志
        Log::record($log, 'error');
        // 输出错误信息
        self::output($exception, $data);
        // 禁止往下传播已处理过的异常
        return true;
    }

    
    public static function appError($errno, $errstr, $errfile = null, $errline = 0, array $errcontext = [])
    {
        if ($errno & Config::get('exception_ignore_type')) {
            // 忽略的异常记录到日志
            Log::record("[{$errno}]{$errstr}[{$errfile}:{$errline}]", 'notice');
        } else {
            // 将错误信息托管至 think\exception\ErrorException
            throw new ErrorException($errno, $errstr, $errfile, $errline, $errcontext);
            // 禁止往下传播已处理过的异常
            return true;
        }
    }

    
    public static function appShutdown()
    {
        // 写入日志
        Log::save();

        if ($error = error_get_last()) {
            // 将错误信息托管至think\ErrorException
            $exception = new ErrorException(
                $error['type'],
                $error['message'],
                $error['file'],
                $error['line']
            );

            
            self::appException($exception);
            // 禁止往下传播已处理过的异常
            return true;
        }
        return false;
    }

    
    public static function output($exception, array $vars)
    {
    if(APP_DEBUG){
        echo $exception->getMessage()."\n";
        echo $exception->getFile()."\n";
        echo $exception->getLine()."\n";
        echo $exception->getCode()."\n";
        die();
    }
        http_response_code($exception instanceof Exception ? $exception->getHttpStatus() : 500);

        $type = Config::get('default_return_type');

        if (IS_API && 'html' != $type) {
            // 异常信息输出监听
            APP_HOOK && Hook::listen('error_output', $data);
            // 输出异常内容
            Response::send($data, $type, Config::get('response_return'));
        } else {
            //ob_end_clean();
            extract($vars);
            include Config::get('exception_tmpl');
        }
    }

    
    private static function getCode($exception)
    {
        $code = $exception->getCode();
        if (!$code && $exception instanceof ErrorException) {
            $code = $exception->getSeverity();
        }
        return $code;
    }

    
    private static function getSourceCode($exception)
    {
        // 读取前9行和后9行
        $line  = $exception->getLine();
        $first = ($line - 9 > 0) ? $line - 9 : 1;

        try {
            $contents = file($exception->getFile());
            $source   = [
                'first'  => $first,
                'source' => array_slice($contents, $first - 1, 19),
            ];
        } catch (Exception $e) {
            $source = [];
        }
        return $source;
    }

    
    private static function getExtendData($exception)
    {
        $data = [];
        if ($exception instanceof Exception) {
            $data = $exception->getData();
        }
        return $data;
    }

    
    private static function getTPConst()
    {
        return [
            'THINK_VERSION'    => defined('THINK_VERSION') ? THINK_VERSION : 'undefined',
            'THINK_PATH'       => defined('THINK_PATH') ? THINK_PATH : 'undefined',
            'LIB_PATH'         => defined('LIB_PATH') ? LIB_PATH : 'undefined',
            'EXTEND_PATH'      => defined('EXTEND_PATH') ? EXTEND_PATH : 'undefined',
            'MODE_PATH'        => defined('MODE_PATH') ? MODE_PATH : 'undefined',
            'CORE_PATH'        => defined('CORE_PATH') ? CORE_PATH : 'undefined',
            'TRAIT_PATH'       => defined('TRAIT_PATH') ? TRAIT_PATH : 'undefined',
            'APP_PATH'         => defined('APP_PATH') ? APP_PATH : 'undefined',
            'RUNTIME_PATH'     => defined('RUNTIME_PATH') ? RUNTIME_PATH : 'undefined',
            'LOG_PATH'         => defined('LOG_PATH') ? LOG_PATH : 'undefined',
            'CACHE_PATH'       => defined('CACHE_PATH') ? CACHE_PATH : 'undefined',
            'TEMP_PATH'        => defined('TEMP_PATH') ? TEMP_PATH : 'undefined',
            'VENDOR_PATH'      => defined('VENDOR_PATH') ? VENDOR_PATH : 'undefined',
            'MODULE_PATH'      => defined('MODULE_PATH') ? MODULE_PATH : 'undefined',
            'VIEW_PATH'        => defined('VIEW_PATH') ? VIEW_PATH : 'undefined',
            'APP_NAMESPACE'    => defined('APP_NAMESPACE') ? APP_NAMESPACE : 'undefined',
            'COMMON_MODULE'    => defined('COMMON_MODULE') ? COMMON_MODULE : 'undefined',
            'APP_MULTI_MODULE' => defined('APP_MULTI_MODULE') ? APP_MULTI_MODULE : 'undefined',
            'MODULE_ALIAS'     => defined('MODULE_ALIAS') ? MODULE_ALIAS : 'undefined',
            'MODULE_NAME'      => defined('MODULE_NAME') ? MODULE_NAME : 'undefined',
            'CONTROLLER_NAME'  => defined('CONTROLLER_NAME') ? CONTROLLER_NAME : 'undefined',
            'ACTION_NAME'      => defined('ACTION_NAME') ? ACTION_NAME : 'undefined',
            'MODEL_LAYER'      => defined('MODEL_LAYER') ? MODEL_LAYER : 'undefined',
            'VIEW_LAYER'       => defined('VIEW_LAYER') ? VIEW_LAYER : 'undefined',
            'CONTROLLER_LAYER' => defined('CONTROLLER_LAYER') ? CONTROLLER_LAYER : 'undefined',
            'APP_DEBUG'        => defined('APP_DEBUG') ? APP_DEBUG : 'undefined',
            'APP_HOOK'         => defined('APP_HOOK') ? APP_HOOK : 'undefined',
            'ENV_PREFIX'       => defined('ENV_PREFIX') ? ENV_PREFIX : 'undefined',
            'IS_API'           => defined('IS_API') ? IS_API : 'undefined',
            'APP_AUTO_RUN'     => defined('APP_AUTO_RUN') ? APP_AUTO_RUN : 'undefined',
            'APP_MODE'         => defined('APP_MODE') ? APP_MODE : 'undefined',
            'REQUEST_METHOD'   => defined('REQUEST_METHOD') ? REQUEST_METHOD : 'undefined',
            'IS_CGI'           => defined('IS_CGI') ? IS_CGI : 'undefined',
            'IS_WIN'           => defined('IS_WIN') ? IS_WIN : 'undefined',
            'IS_CLI'           => defined('IS_CLI') ? IS_CLI : 'undefined',
            'IS_AJAX'          => defined('IS_AJAX') ? IS_AJAX : 'undefined',
            'IS_GET'           => defined('IS_GET') ? IS_GET : 'undefined',
            'IS_POST'          => defined('IS_POST') ? IS_POST : 'undefined',
            'IS_PUT'           => defined('IS_PUT') ? IS_PUT : 'undefined',
            'IS_DELETE'        => defined('IS_DELETE') ? IS_DELETE : 'undefined',
            'NOW_TIME'         => defined('NOW_TIME') ? NOW_TIME : 'undefined',
            'LANG_SET'         => defined('LANG_SET') ? LANG_SET : 'undefined',
            'EXT'              => defined('EXT') ? EXT : 'undefined',
            'DS'               => defined('DS') ? DS : 'undefined',
            '__INFO__'         => defined('__INFO__') ? __INFO__ : 'undefined',
            '__EXT__'          => defined('__EXT__') ? __EXT__ : 'undefined',
        ];
    }
}
