<?php
namespace app\lib;
class Condition
{

    public $wheresql = '';
    public $paramData = array();
    public $limitData = '';
    public $ordersql = array();
    protected $conditon_rules = array();
    protected $orderRules = array();
    protected $whereCondition = array();
    protected $page;
    protected $perpage = 10;

    

    
    public function __construct($conditon_rules, $page = 1, $perpage = '', $order_role = null)
    {

        $this->conditonRules = $conditon_rules;
        $this->orderRules = $order_role;
        $this->page = (int)$page;
        (int)$perpage && $this->perpage = (int)$perpage;
    }

    public function init()
    {
        $this->loadPages();
        $this->loadSearch();
        $this->loadOrder();
    }


    public function loadSearch()
    {
        $sql = "";
        foreach ($this->conditonRules as $k => $v) {
            empty($v['empty']) && $v['empty'] = false;
            empty($v['relation']) && $v['relation'] = "AND";
            empty($v['operator']) && $v['operator'] = "=";

            $v['relation'] = strtoupper(trim($v['relation']));
            $v['operator'] = strtoupper(trim($v['operator']));

            //不允许为空且值为空直接跳出
            if (!$v['empty'] && trim($v['value']) == "") continue;

            $sql_temp = "";
            switch ($v ['operator']) {
                case 'IN':
                    $sql_temp = $v['relation'] . ' ' . $v['field'] . ' IN (' . $v['value'] . ')';
                    break;
                case 'NOT IN':
                    $sql_temp = $v['relation'] . ' ' . $v['field'] . ' NOT IN (' . $v['value'] . ')';
                    break;
                case 'LIKE':
                    $sql_temp = $v['relation'] . ' ' . $v['field'] . " LIKE '%" . $v['value'] . "%'";
                    break;
                case 'NOT LIKE':
                    $sql_temp = $v['relation'] . ' ' . $v['field'] . " NOT LIKE '%" . $v['value'] . "%'";
                    break;
                case 'NO WHERE':
                    break;
                default:
                    $sql_temp = $v['relation'] . ' ' . $v['field'] . " " . $v['operator'] . "'" . $v['value'] . "'";
                    break;
            }
            $sql = $sql . " " . $sql_temp;
        }

        $this->wheresql = $sql;
    }

    public function loadOrder()
    {

        if (empty($this->orderRules)) return false;
        $sql = "";
        foreach ($this->orderRules as $k => $v) {

            //不允许为空且值为空直接跳出
            if (!$v['field']) continue;
            empty($v['direction']) && $v['direction'] = "";
            $sql = $sql . ',' . " " . $v['field'] . ' ' . strtoupper($v['direction']);
        }
        $this->ordersql = $sql;

    }


    public function loadPages()
    {
        $pageNum = $this->perpage;
        $startNum = ($this->page - 1) * $this->perpage;
        $this->limitData = " LIMIT " . $startNum . " , " . $pageNum;
    }


}