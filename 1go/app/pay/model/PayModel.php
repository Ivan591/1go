<?php
namespace app\pay\model;

use think\model\Adv;

Class PayModel extends Adv
{

    public function __construct()
    {
        parent::__construct();
    }

    
    public function get_p_order_info_by_filed($name, $value)
    {
        $m_order = M('order_list_parent', 'sp_');
        return $m_order->where(array($name => $value))->find();
    }

    
    public function get_user_info_by_filed($filed, $value)
    {
    }

    
    public function write_pay_info($post){
    }
}