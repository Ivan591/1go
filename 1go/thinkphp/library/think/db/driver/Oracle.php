<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

namespace think\db\driver;

use think\Config;
use think\Db;
use think\db\Driver;


class Oracle extends Driver
{

    private $table       = '';
    protected $selectSql = 'SELECT * FROM (SELECT thinkphp.*, rownum AS numrow FROM (SELECT  %DISTINCT% %FIELD% FROM %TABLE%%JOIN%%WHERE%%GROUP%%HAVING%%ORDER%) thinkphp ) %LIMIT%%COMMENT%';

    
    protected function parseDsn($config)
    {
        $dsn = 'oci:dbname=';
        if (!empty($config['hostname'])) {
            //  Oracle Instant Client
            $dsn .= '//' . $config['hostname'] . ($config['hostport'] ? ':' . $config['hostport'] : '') . '/';
        }
        $dsn .= $config['database'];
        if (!empty($config['charset'])) {
            $dsn .= ';charset=' . $config['charset'];
        }
        return $dsn;
    }

    
    public function execute($sql, $bind = [], $fetch = false)
    {
        $this->initConnect(true);
        if (!$this->linkID) {
            return false;
        }

        // 根据参数绑定组装最终的SQL语句
        $this->queryStr = $this->getBindSql($sql, $bind);
        if ($fetch) {
            return $this->queryStr;
        }
        $flag = false;
        if (preg_match("/^\s*(INSERT\s+INTO)\s+(\w+)\s+/i", $sql, $match)) {
            $this->table = Config::get("db_sequence_prefix") . str_ireplace(Config::get("database.prefix"), "", $match[2]);
            $flag        = (boolean) $this->query("SELECT * FROM all_sequences WHERE sequence_name='" . strtoupper($this->table) . "'");
        }
        //释放前次的查询结果
        if (!empty($this->PDOStatement)) {
            $this->free();
        }

        Db::$executeTimes++;
        try {
            // 记录开始执行时间
            $this->debug(true);
            $this->PDOStatement = $this->linkID->prepare($sql);
            // 参数绑定操作
            $this->bindValue($bind);
            $result = $this->PDOStatement->execute();
            $this->debug(false);
            $this->numRows = $this->PDOStatement->rowCount();
            if ($flag || preg_match("/^\s*(INSERT\s+INTO|REPLACE\s+INTO)\s+/i", $sql)) {
                $this->lastInsID = $this->linkID->lastInsertId();
            }
            return $this->numRows;
        } catch (\PDOException $e) {
            throw new \think\Exception($this->getError());
        }
    }

    
    public function getFields($tableName)
    {
        list($tableName) = explode(' ', $tableName);
        $url             = "select a.column_name,data_type,DECODE (nullable, 'Y', 0, 1) notnull,data_default, DECODE (A .column_name,b.column_name,1,0) pk from all_tab_columns a,(select column_name from all_constraints c, all_cons_columns col where c.constraint_name = col.constraint_name and c.constraint_type = 'P' and c.table_name = '" . strtoupper($tableName) . "' ) b where table_name = '" . strtoupper($tableName) . "' and a.column_name = b.column_name (+)";
        $result          = $this->query($url);
        $info            = [];
        if ($result) {
            foreach ($result as $key => $val) {
                $info[$val['column_name']] = [
                    'name'    => $val['column_name'],
                    'type'    => $val['data_type'],
                    'notnull' => $val['notnull'],
                    'default' => $val['data_default'],
                    'primary' => $val['pk'],
                    'autoinc' => $val['pk'],
                ];
            }
        }
        return $info;
    }

    
    public function getTables()
    {
        $result = $this->query("select table_name from all_tables");
        $info   = [];
        foreach ($result as $key => $val) {
            $info[$key] = current($val);
        }
        return $info;
    }

    
    public function parseLimit($limit)
    {
        $limitStr = '';
        if (!empty($limit)) {
            $limit = explode(',', $limit);
            if (count($limit) > 1) {
                $limitStr = "(numrow>" . $limit[0] . ") AND (numrow<=" . ($limit[0] + $limit[1]) . ")";
            } else {
                $limitStr = "(numrow>0 AND numrow<=" . $limit[0] . ")";
            }

        }
        return $limitStr ? ' WHERE ' . $limitStr : '';
    }
    
    protected function parseLock($lock = false)
    {
        if (!$lock) {
            return '';
        }

        return ' FOR UPDATE NOWAIT ';
    }

    
    protected function parseKey($key)
    {
        $key = trim($key);
        if (strpos($key, '$.') && false === strpos($key, '(')) {
            // JSON字段支持
            list($field, $name) = explode($key, '$.');
            $key                = $field . '."' . $name . '"';
        }
        return $key;
    }

    
    protected function parseRand()
    {
        return 'DBMS_RANDOM.value';
    }

    
    protected function getExplain($sql)
    {

    }
}
