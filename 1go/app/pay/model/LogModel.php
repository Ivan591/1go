<?php
namespace app\pay\model;


Class LogModel
{
    private $m_log;

    public function __construct()
    {
        $this->notify_log = M("notify", "log_");
    }

    public function log_notify($order_id, $log_text)
    {
        $data = array(
            "order_id" => $order_id,
            "log" => $log_text,
            "create_time" => date("Y-m-d H:i:s"),
        );
        $this->notify_log->add($data);
    }

    
    public function balance_log($type = 'default', $money = 0.00, $desc = '', $uid = '0', $order_id = '0')
    {
        $m_log = M('balance', 'log_');
        $data = array(
            "uid" => $uid,
            "order_id" => $order_id,
            "type" => $type,
            "money" => $money,
            "desc" => $desc,
            "create_time" => date("Y-m-d H:i:s")
        );
        return $m_log->add($data);
    }

    
    public function open_log($desc = '', $uid = 0, $order_id = '')
    {
        $m_log = M('open', 'log_');
        $data = array(
            "uid" => $uid,
            "order_id" => $order_id,
            "desc" => $desc,
            "create_time" => date("Y-m-d H:i:s")
        );
        return $m_log->add($data);
    }
}