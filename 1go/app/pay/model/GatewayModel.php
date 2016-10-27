<?php
namespace app\pay\controller;

Class GatewayModel{
    public function __construct()
    {
    }
    public function get_p_info_by_order_id($order_id){
        $m_order = M('order_list_parent','sp_');
        return $m_order->where(array("order_id"=>$order_id))->find();
    }
}