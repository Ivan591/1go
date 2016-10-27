<?php
namespace app\pay\model;

use think\model\Adv;

Class PublicModel extends Adv
{
    private $my_db;

    public function __construct()
    {
        parent::__construct();
        $this->my_db = $this->db("1");
    }

    public function get_conf($name)
    {
        $m_conf = M('conf', 'sp_');
        $info = $m_conf->where(array('name' => $name))->find();
        return $info["value"];
    }

    
    public function set_conf($name, $value)
    {
        $m_conf = M('conf', 'sp_');
        return $m_conf->where(array('name' => $name))->save(array('value' => $value));
    }

    
    public function get_p_order_info($order_id)
    {
        return $this->my_db->table('sp_order_list_parent')->where(array("order_id" => $order_id))->find();
    }

    
    public function get_user_info_by_id($uid)
    {
        $m_order = M('users', 'sp_');
        return $m_order->where(array("id" => $uid))->find();
    }


    public function sign($order_id, $timestamp){
        
        $key = $this->get_conf('TOKEN_ACCESS');
        return md5($order_id.$timestamp.$key);
    }

    
    public function auth($order_id, $timestamp, $sign)
    {
        
        $key = $this->get_conf('TOKEN_ACCESS');
        
        $token = md5($order_id . $timestamp . $key);
        
        if ($sign !== $token) return rt("-100",$token);
        
        if (NOW_TIME - $timestamp > 7200) return rt("-200",date("Y-m-d H:i:s"));
        return rt("1","成功");
    }
}