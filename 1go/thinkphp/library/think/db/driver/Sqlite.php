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

use think\db\Driver;


class Sqlite extends Driver
{

    
    protected function parseDsn($config)
    {
        $dsn = 'sqlite:' . $config['database'];
        return $dsn;
    }

    
    public function getFields($tableName)
    {
        list($tableName) = explode(' ', $tableName);
        $result          = $this->query('PRAGMA table_info( ' . $tableName . ' )');
        $info            = [];
        if ($result) {
            foreach ($result as $key => $val) {
                $info[$val['name']] = [
                    'name'    => $val['name'],
                    'type'    => $val['type'],
                    'notnull' => 1 === $val['notnull'],
                    'default' => $val['dflt_value'],
                    'primary' => '1' == $val['pk'],
                    'autoinc' => '1' == $val['pk'],
                ];
            }
        }
        return $info;
    }

    
    public function getTables($dbName = '')
    {
        $result = $this->query("SELECT name FROM sqlite_master WHERE type='table' "
            . "UNION ALL SELECT name FROM sqlite_temp_master "
            . "WHERE type='table' ORDER BY name");
        $info = [];
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
                $limitStr .= ' LIMIT ' . $limit[1] . ' OFFSET ' . $limit[0] . ' ';
            } else {
                $limitStr .= ' LIMIT ' . $limit[0] . ' ';
            }
        }
        return $limitStr;
    }

    
    protected function parseRand()
    {
        return 'RANDOM()';
    }

    
    protected function getExplain($sql)
    {

    }
}
