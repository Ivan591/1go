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

namespace think\console\helper\question;


class Confirmation extends Question
{

    private $trueAnswerRegex;

    
    public function __construct($question, $default = true, $trueAnswerRegex = '/^y/i')
    {
        parent::__construct($question, (bool)$default);

        $this->trueAnswerRegex = $trueAnswerRegex;
        $this->setNormalizer($this->getDefaultNormalizer());
    }

    
    private function getDefaultNormalizer()
    {
        $default = $this->getDefault();
        $regex   = $this->trueAnswerRegex;

        return function ($answer) use ($default, $regex) {
            if (is_bool($answer)) {
                return $answer;
            }

            $answerIsTrue = (bool)preg_match($regex, $answer);
            if (false === $default) {
                return $answer && $answerIsTrue;
            }

            return !$answer || $answerIsTrue;
        };
    }
}