<?php

/**
 * Created by PhpStorm.
 * User: shenping zhou
 * Date: 2015/7/7
 * Time: 11:54
 */
class PlayGameRecord
{
    static function getAllRecord($uid, $full = 'no')
    {
        String::_filterNoNumber($uid);//去除非数字
        if ($uid == '') return array();

        $ret    = array();
        $record = PlayGameLog::getPlayRecord($uid, $full);
        foreach ($record as $item) $ret[] = $item;

        $record1 = OasUserPlayed::getAllRecords($uid, $full);
        foreach ($record1 as $item) $ret[] = $item;

        return $ret;
    }

    static function getLastPlayTime($uid, $sid = 0)
    {
        $ret = array();
        foreach (self::getAllRecord($uid) as $item)
        {
            if ($sid != 0 and $sid != $item['server_sid']) continue;
            $ret[] = !empty($item['m_time']) ? $item['m_time'] : $item['last_play_time'];
        }

        return max($ret);
    }

    static function getLastSid($uid)
    {
        $ret          = 0;
        $lastPlayTime = self::getLastPlayTime($uid);
        foreach (self::getAllRecord($uid) as $item)
        {
            if ($item['m_time'] == $lastPlayTime or $item['last_play_time'] == $lastPlayTime) $ret = $item['server_sid'];
        }

        return $ret;
    }

    static function isSidPlayed($uid, $sid)
    {
        $ret = false;
        foreach (self::getAllRecord($uid) as $item)
        {
            if ($item['server_sid'] == $sid) $ret = true;
        }

        return $ret;
    }

    static function getLastLoginType($uid, $sid = 0)
    {
        $ret = 3;
        foreach (self::getAllRecord($uid) as $item)
        {
            if ($sid != 0 and $sid != $item['server_sid']) continue;
            if (isset($item['login_type']))
            {
                $ret = $item['login_type'];
                break;
            }
        }

        return $ret;
    }

    static function getPlayedSids($uid, $full = 'no')
    {
        $ret  = array();
        $temp = array();
        foreach (self::getAllRecord($uid, $full) as $item)
        {
            $t        = !empty($item['m_time']) ? $item['m_time'] : $item['last_play_time'];
            $temp[$t] = $item['server_sid'];
        }

        krsort($temp);//按时间倒序排列

        foreach ($temp as $k => $v)
        {
            if (!in_array($v, $ret)) $ret[] = $v;//排重
        }

        return $ret;
    }
}