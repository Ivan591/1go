<?php
namespace app\pay\controller;

use app\pay\model\ExecModel;
use app\pay\model\NotifyModel;
use app\pay\model\PublicModel;
use think\Controller;


Class Notify
{
    public $m_pub;
    private $pay_type = 'alipay';

    public function __construct()
    {
        set_time_limit(10000);
        ignore_user_abort(true);
        $this->m_pub = new PublicModel();
    }

    
    public function order_flow()
    {
        die('欢迎使用梦蝶一元购CMS管理系统
该域名尚未授权，请联系企业QQ：800133338
梦蝶官网：www.mengdie.com');

    }

    
    public function balance_flow()
    {
        set_time_limit(10000);

    }
    
    public function balance_flow_p($sign=null,$timestamp=null,$order_id=null)
    {
        set_time_limit(10000);

    }

    
    protected function next_order($order_id)
    {

    }

    
    private function auth($order_id, $timestamp, $sign)
    {

    }

    
    public function alipay()
    {

    }

    
    private function md5_sign($post, $info_sign)
    {

    }


    
    private function rsa_sign($post, $sign)
    {

    }

    
    private function start_flow($order_id)
    {


    }

    
    public function open($order_id)
    {
    }

    
    public function charge($order_id)
    {
    }

    
    public function check_balance_pay($order_id)
    {
    }

    
    public function reduce_balance($order_id)
    {
        
    }

    
    private function create_recharge_order($order_id, $money)
    {
    }

    
    private function jump($order_id)
    {
    }
}