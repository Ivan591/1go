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


use think\console\Output;
use think\process\Builder as ProcessBuilder;
use think\process as ThinkProcess;
use think\process\exception\Failed as ProcessFailedException;

class Process extends Helper
{

    
    public function run(Output $output, $cmd, $error = null, $callback = null, $verbosity = Output::VERBOSITY_VERY_VERBOSE)
    {
        
        $formatter = $this->getHelperSet()->get('debug_formatter');

        if (is_array($cmd)) {
            $process = ProcessBuilder::create($cmd)->getProcess();
        } elseif ($cmd instanceof ThinkProcess) {
            $process = $cmd;
        } else {
            $process = new ThinkProcess($cmd);
        }

        if ($verbosity <= $output->getVerbosity()) {
            $output->write($formatter->start(spl_object_hash($process), $this->escapeString($process->getCommandLine())));
        }

        if ($output->isDebug()) {
            $callback = $this->wrapCallback($output, $process, $callback);
        }

        $process->run($callback);

        if ($verbosity <= $output->getVerbosity()) {
            $message = $process->isSuccessful() ? 'Command ran successfully' : sprintf('%s Command did not run successfully', $process->getExitCode());
            $output->write($formatter->stop(spl_object_hash($process), $message, $process->isSuccessful()));
        }

        if (!$process->isSuccessful() && null !== $error) {
            $output->writeln(sprintf('<error>%s</error>', $this->escapeString($error)));
        }

        return $process;
    }

    
    public function mustRun(Output $output, $cmd, $error = null, $callback = null)
    {
        $process = $this->run($output, $cmd, $error, $callback);

        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }

        return $process;
    }

    
    public function wrapCallback(Output $output, ThinkProcess $process, $callback = null)
    {
        
        $formatter = $this->getHelperSet()->get('debug_formatter');

        return function ($type, $buffer) use ($output, $process, $callback, $formatter) {
            $output->write($formatter->progress(spl_object_hash($process), $this->escapeString($buffer), ThinkProcess::ERR === $type));

            if (null !== $callback) {
                call_user_func($callback, $type, $buffer);
            }
        };
    }

    private function escapeString($str)
    {
        return str_replace('<', '\\<', $str);
    }

    
    public function getName()
    {
        return 'process';
    }
}