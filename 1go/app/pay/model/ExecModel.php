<?php
namespace app\pay\model;


use app\core\controller\Gdfc;
use think\model\Adv;

Class ExecModel extends Adv
{
    private $log;
    private $m;

    public function __construct()
    {
        parent::__construct();
        $this->log = new LogModel();
        $this->m = $this->db(1);

    }

    
    public function reduce_money($uid = 0, $money = 0.00, $order_id = '')
    {


    }

    
    public function add_money($uid = 0, $money = 0.00, $order_id = '')
    {
    }

    
    public function open_main($o_id)
    {
    }

    
    private function pop_lottery_num($post)
    {
    }

    
    public function get_p_info_by_id($id)
    {
        return $this->m->table('sp_order_list_parent')->where(array("id" => $id))->find();
    }

    
    public function get_p_info_by_order_id($order_id)
    {
        return $this->m->table('sp_order_list_parent')->where(array("order_id" => $order_id))->find();
    }

    
    public function set_order_status($order_id = null, $pay_status = null, $limit_status = null, $type = false)
    {
    }


    
    public function get_charge_order_by_pid($pid)
    {
        $m_order = M('order_list', 'sp_');
    }

    
    public function set_p_order_pay_time($order_id)
    {
        $m_p_order = M('order_list_parent', 'sp_');

    }
    
    public function set_c_order_pay_time($order_id)
    {
        $m_p_order = M('order_list', 'sp_');

    }
}