<?php
/*数据库配置信息*/

$arrDBconf['online']  = array('host' => '127.0.0.1', 'port' => 3306, 'user' => 'root', 'pwd' => '281255', 'db_name' => 'shenqu_br',);
$arrDBconf['develop'] = array('host' => '127.0.0.1',      'port' => 3306, 'user' => 'root',      'pwd' => '123456',       'db_name' => 'share',);

$oas_db_conf               = $arrDBconf[DB_SET];
$oas_db_conf['db_charset'] = 'utf8';

$cache_server = array('10.1.5.3' => 11211);
