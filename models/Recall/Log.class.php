<?php

/**
 * Created by PhpStorm.
 * User: shenping zhou
 * Date: 2016/2/25
 * Time: 17:35
 */
class RecallLog
{
    static function log_source($uid)
    {
        $ip     = Browser::get_client_ip();
        $source = $_GET['source'];
        $info   = "$uid|$ip|$source";
        Log2::save_run_log($info, 'recall_source');
    }
}
