<?php

/**
 * Created by PhpStorm.
 * User: shenping zhou
 * Date: 2015/5/19
 * Time: 17:07
 */
class PlayGameLog
{
    const table = 'user_playgame_log';

    static function getPlayRecord($uid, $full = 'no')
    {
        String::_filterNoNumber($uid);//去除非数字

        if ($uid == '') return array();

        static $ret = array();
        static $status = array();

        if ($status[$full][$uid] == 0)
        {
            $sql = "SELECT * from `" . self::table . "` WHERE `uid`=$uid  __sid__   AND `server_sid`>0 ORDER BY m_time DESC";
            WherePlus::_AddSid($sql);
            if ($full == 'full') $sql = "SELECT * from `" . self::table . "` WHERE `uid`=$uid AND `server_sid`>0 ORDER BY m_time DESC";

            $ret[$full][$uid]    = DBHandle::query($sql);
            $status[$full][$uid] = 1;
        }

        return $ret[$full][$uid];
    }

    static function getPlayRecordForMultiUser($arr_uid, $type = 1)
    {
        if ($arr_uid == array()) return array();

        $orderBy = 'm_time';
        if ($type == 2) $orderBy = 'grade';

        $str_uids = implode(',', $arr_uid);
        $sql      = "SELECT * from `" . self::table . "` WHERE `uid` IN ($str_uids)  __sid__   AND `server_sid`>0 ORDER BY $orderBy DESC";
        WherePlus::_AddSid($sql);

        return DBHandle::query($sql);
    }

    //获取uid sid对应的记录  如果sid为0 表示获取该uid最后一次玩的记录
    static function getOneRecord($uid, $sid = 0)
    {
        $ret = array();
        $rs  = self::getPlayRecord($uid);
        if ($sid == 0)
        {
            $ret = $rs[0];
        }
        else
        {
            foreach ($rs as $item)
            {
                if ($item['server_sid'] == $sid)
                {
                    $ret = $item;
                    break;
                }
            }
        }

        return $ret;
    }

    //获取玩家在sid服内的等级
    //如果sid为0 获取在最后一次玩的服内的等级
    static function getGrade($uid, $sid = 0)
    {
        $rs = self::getOneRecord($uid, $sid);

        return (int)($rs['grade']);
    }

    static function getMaxGrade($uid)
    {
        $rs   = self::getPlayRecord($uid);
        $temp = array();
        foreach ($rs as $item)
        {
            $temp[] = $item['grade'];
        }

        return empty($temp) ? 0 : max($temp);
    }

    static function updateRecord($uid, $sid, $grade = 0)
    {
        String::_filterNoNumber($uid);
        String::_filterNoNumber($sid);
        String::_filterNoNumber($grade);

        $arr               = array();
        $arr['uid']        = $uid;
        $arr['server_sid'] = $sid;
        $arr['grade']      = $grade;
        $arr['m_time']     = time();
        $arr['m_ip']       = Browser::get_client_ip();

        if ($uid == 0 or $sid == 0) return false;

        $lastRecord_this = self::getOneRecord($uid, $sid);
        if (!empty($lastRecord_this))
        {
            if ($grade == 0) unset($arr['grade']);//update记录时  如果grade为0 不更新该字段
            $arr = myArray::trimSameItem($arr, $lastRecord_this);//去掉和原记录一致的字段
            return DBHandle::update(self::table, Mysql::makeInsertString($arr), "`uid`=$uid AND `server_sid`=$sid");
        }
        else
        {
            $arr['c_time'] = time();
            $arr['c_ip']   = Browser::get_client_ip();

            return DBHandle::MyInsert(self::table, Mysql::makeInsertString($arr));
        }
    }

    static function getFirstPlayTime($uid)
    {
        String::_filterNoNumber($uid);
        if ($uid == 0) {
            return 0;
        }

        $temp = array();
        $rs   = DBHandle::select(self::table, "`uid`=$uid");
        foreach ($rs as $item) {
            $temp[] = $item['c_time'];
        }

        return !empty($temp) ? min($temp) : 0;
    }
}