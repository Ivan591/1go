<?php
namespace app\lib\oAuth;
use think\Model;

class WeChat{
    //配置APP参数
    private $appid         = 'wxc469a3fd1e82968b';
    private $secret        = '64ec0bccf888099fc551ff5fcb4d0fba';
    private $re_url        = "http://1.xiangchang.com/index.php/mobile/Login/callback/type/wechat";
    //private $state         = 'state';
    private $access_token  = '';
    private $openid        = '';

    public function init($appid,$secret)
    {
        $this->appid=$appid;
        $this->secret=$secret;
    }

    public function get_code($callback='http://1.xiangchang.com/index.php/mobile/Login/callback/type/wechat')
    {
        //$this->get_state();
        $url = 'https://open.weixin.qq.com/connect/qrconnect?appid='.$this->appid.'&redirect_uri='.urlencode($callback).'&response_type=code&scope=snsapi_login#wechat_redirect';
        header('Location: '.$url);
    }

    public function get_info($code,$state){
        $this->get_access_token($code,$state);
        $userinfo = $this->get_user_info();
        return  $userinfo;
    }

    
    public function get_access_token($code)
    {

        //$this->is_state($state);
        //获取access_token
        $token_url           = 'https://api.weixin.qq.com/sns/oauth2/access_token?appid='.$this->appid.'&secret='.$this->secret.'&code='.$code.'&grant_type=authorization_code';
        $result              = json_decode($this->_curl_get_content($token_url),true);
        $this->access_token  = $result['access_token'];
        $this->openid        = $result['openid'];
        return $result;
    }
    
    public function get_user_info($token,$openid)
    {
        $url              = 'https://api.weixin.qq.com/sns/userinfo?access_token='.$token.'&openid='.$openid;
        $info             = json_decode($this->_curl_get_content($url), TRUE);
//        $info1['name']    = $info['nickname'];
//        $info1['sex']     = $info['sex'];
//        $info1['img']     = $info['headimgurl'];
//        $info1['openid']  = $info['openid'];
//        $info1['unid']    = $info['unionid'];

        return $info;
    }

    private function _curl_get_content($url)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_URL, $url);
        //设置超时时间为3s
        curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, 3);
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }

//    //生成随机参数
//    private function get_state() {
//        $str               = str_shuffle('qazxswedcvfrtgbnhyujmkiol123456789') . time();
//        $_SESSION['state'] = md5(md5($str));
//    }
//
//    //判断随机数
//    private function is_state($state) {
//       if($state!==$_SESSION[$this->state]){
//            exit('随机数检验失败，疑似csrf攻击');
//        }
//    }
}