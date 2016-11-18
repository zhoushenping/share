<?php

/**
 * Created by PhpStorm.
 * User: shenping zhou
 * Date: 2015/5/19
 * Time: 20:29
 */
class ServerNew
{
    const table = 'server_list';

    static function getServerInfo($sid)
    {
        static $all = array();
        if (empty($all)) {
            foreach (self::getAllServer() as $item) {
                $all[$item['server_sid']] = $item;
            }
        }

        return $all[$sid];
    }

    static function getServerFullName($sid)
    {
        $item = self::getServerInfo($sid);

        return $item['fullname'];
    }

    //获取服的热度
    static function getServerHot($sid)
    {
        $item = self::getServerInfo($sid);

        return $item['hot'];
    }

    //获取区域内的最大服
    static function getMaxAreaSid($area_r = 0)
    {
        $temp = array();
        foreach (self::getVisibleServer() as $item) {
            $temp['all'][]         = $item['server_sid'];
            $temp[$item['area']][] = $item['server_sid'];
        }

        return ($area_r != 0 and !empty($temp[$area_r])) ? max($temp[$area_r]) : max($temp['all']);
    }

    static function isValidServer($sid)
    {
        $ret = false;
        foreach (self::getVisibleServer() as $item) {
            if ($item['valid'] == 0) {
                continue;
            }
            if ($item['server_sid'] == $sid) {
                $ret = true;
            }
        }

        return $ret;
    }

    static function isVisibleServer($sid)
    {
        $ret = false;
        foreach (self::getVisibleServer() as $item) {
            if ($item['server_sid'] == $sid) {
                $ret = true;
            }
        }

        return $ret;
    }

    static function getSidArea($sid)
    {
        $ret        = 0;
        $serverlist = self::getAllServer();
        foreach ($serverlist as $server) {
            if ($server['server_sid'] == $sid) {
                $ret = $server['area'];
            }
        }

        return (int)$ret;
    }

    //获得玩家目前可以看到的服  包含 正常的服（valid=1且已到开服时间）   已经开了但是处于维护状态的（已到开服时间但valid=0）
    static function getVisibleServer($area_r = 0)
    {
        $ret  = array();
        $time = time();
        foreach (self::getAllServer() as $k => $item) {
            if ($area_r != 0 and $item['area'] != $area_r) {
                continue;
            }
            if ($item['valid'] >= 2) {
                continue;
            }
            if ($item['start_time'] != 0 and $item['start_time'] > $time) {
                continue;
            }
            if (defined('PLATFORM') and PLATFORM == 'app' and $item['server_sid'] >= 2000) {
                continue;
            }
            $ret[] = $item;
        }

        return $ret;
    }

    static function getAllServer()
    {
        global $oaspay_config;
        static $serverlist = null;
        if (is_null($serverlist)) {
            $serverlist = DBHandle::select(self::table, "1 ORDER BY `server_sid` DESC");

            //在源头处修订服务器的信息
            foreach ($serverlist as $k => $item) {
                $item['hot']         = self::makeHot($item);
                $item['fullname']    = self::makeFullname($item);
                $item['server_type'] = ($item['server_sid'] > 2000) ? 1 : 0;
                $item['url']         = (PLATFORM == 'app') ? "/fbapp/index.php?server_id={$item['server_sid']}" :
                    "/fbapp/oasplay.php?server_id={$item['server_sid']}";
                //$item['server_inner_ip']  = $oaspay_config[$item['area']]['server_inner_ip'];//葡语的这两个值已经写到数据表里面了  不要干预
                //$item['server_public_ip'] = $oaspay_config[$item['area']]['server_public_ip'];//葡语的这两个值已经写到数据表里面了  不要干预
                $serverlist[$k] = $item;
            }
        }

        return $serverlist;
    }

    static function makeHot($item)
    {
        return ($item['recommand'] == 1 or $item['recommand_oas'] == 1 or $item['recommand_area'] == 1) ? 100 :
            rand(90, 99);
    }

    static function makeFullname($item)
    {
        $sid       = $item['server_sid'];
        $prex      = ($sid > 2000) ? "OAS" : "S";
        $sid_after = ($sid > 2000) ? ($sid - 2000) : $sid;

        return "{$prex}{$sid_after}:{$item['server_name']}";
    }

    static function getHotType($item)
    {
        $ret      = '';
        $t        = $item['start_time'];
        $time_new = time() - 3600 * 24 * 7;
        $time_now = time();
        if ($t >= $time_new && $t <= $time_now) {
            $ret = 'new';
        }
        if (RecommendServer::isRecommend($item['server_sid'])) {
            $ret = 'hot';
        }

        return $ret;
    }
}
