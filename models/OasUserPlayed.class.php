<?php

/**
 * Created by PhpStorm.
 * User: shenping zhou
 * Date: 2015/5/28
 * Time: 19:02
 */
class OasUserPlayed
{
    const table = 'user_played';

    static function addPlayedRecord($uid, $sidToPlay, $login_type = 1)
    {
        String::_filterNoNumber($uid);
        String::_filterNoNumber($sidToPlay);
        String::_filterNoNumber($login_type);
        if (empty($uid) or empty($sidToPlay)) return false;

        $serverInfo = ServerNew::getServerInfo($sidToPlay);

        $arr['server_name']    = $serverInfo['server_name'];
        $arr['login_type']     = $login_type;
        $arr['last_play_time'] = time();

        if (self::isSidPlayed($uid, $sidToPlay))
        {
            $sql = "UPDATE `" . self::table . "` SET " . Mysql::makeInsertString($arr) . " WHERE `uid`=$uid AND `server_sid`=$sidToPlay";

            return DBHandle::execute($sql);
        }
        else
        {
            $arr['uid']        = $uid;
            $arr['server_sid'] = $sidToPlay;
            $sql               = "INSERT INTO `" . self::table . "` SET " . Mysql::makeInsertString($arr);

            return DBHandle::insert($sql);
        }
    }

    static function getAllRecords($uid, $full = 'no')
    {
        String::_filterNoNumber($uid);
        if ($uid == 0) return array();

        static $ret = array();
        static $status = array();

        $sql = "SELECT * FROM `" . self::table . "` WHERE `uid`=$uid  __sid__  AND `server_sid`>0 ORDER BY `last_play_time` DESC";
        WherePlus::_AddSid($sql);
        if ($full == 'full') $sql = "SELECT * FROM `" . self::table . "` WHERE `uid`=$uid AND `server_sid`>0 ORDER BY `last_play_time` DESC";

        if ($status[$full][$uid] == 0)
        {
            $ret[$full][$uid]    = DBHandle::query($sql);
            $status[$full][$uid] = 1;
        }

        return $ret[$full][$uid];
    }

    static function isSidPlayed($uid, $sid)
    {
        $ret = false;
        $rs  = self::getAllRecords($uid);
        foreach ($rs as $item)
        {
            if ($item['server_sid'] == $sid) $ret = true;
        }

        return $ret;
    }
}