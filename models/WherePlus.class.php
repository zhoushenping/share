<?php

/**
 * Created by PhpStorm.
 * User: shenping zhou
 * Date: 2015/5/19
 * Time: 17:33
 * 用来给sql语句加上  server_sid<2000 的类
 */
class WherePlus
{
    static function _AddSid(&$sql)
    {
        $where_plus = (defined('PLATFORM') and PLATFORM == 'app') ? "and `server_sid`<2000" : "";
        $sql        = str_replace('__sid__', $where_plus, $sql);
    }
}