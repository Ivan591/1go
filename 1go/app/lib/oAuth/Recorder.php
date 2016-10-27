<?php

namespace app\lib\oAuth;
use app\lib\oAuth\URL;
use app\lib\oAuth\ErrorCase;
use think\Model;

class Recorder{

    private static $data;
    private $inc;
    private $error;

    public function __construct(){
        $this->error = new ErrorCase();
      //-------读取配置文件
        $inc['appid']='101311754';
        $inc['appkey']='b5bb59cb0a157add0b9ac463342c5128';
        $inc['callback']='http://1.xiangchang.com/index.php/mobile/Login/callback/type/qq';
        $inc['scope']='get_user_info';
        $inc['errorReport']='true';
        $inc['storageType']='file';

        $inc = json_decode(json_encode($inc));

        $this->inc=$inc;
        if(empty($this->inc)){
            $this->error->showError("20001");
        }

        if(empty($_SESSION['QC_userData'])){
            self::$data = array();
        }else{
            self::$data = $_SESSION['QC_userData'];

        }
    }

    public function write($name,$value){
        self::$data[$name] = $value;
    }

    public function read($name){
        if(empty(self::$data[$name])){
            return null;
        }else{
            return self::$data[$name];
        }
    }

    public function readInc($name){
        if(empty($this->inc->$name)){
            return null;
        }else{
            return $this->inc->$name;
        }
    }

    public function delete($name){
        unset(self::$data[$name]);
    }

    function __destruct(){
        $_SESSION['QC_userData'] = self::$data;
    }
}
