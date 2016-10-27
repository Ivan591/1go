<?php
namespace app\pay\controller;

use app\pay\lib\Common;
use app\pay\model\PublicModel;
use think\Controller;


Class Alipay extends Controller
{
    private $m_pub;
    protected $money;


    public function __construct()
    {
        parent::__construct();
        $this->m_pub = new PublicModel();
    }

    
    public function index()
    {
    }

    
    private function construct_param($order_id)
    {

    }

    
    private function go_alipay($url)
    {

    }

    
    private function md5_sign($post)
    {
    }

    
    private function create_pay_url($post)
    {
    }

}