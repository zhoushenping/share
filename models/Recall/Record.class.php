<?php

/**
 * Created by PhpStorm.
 * User: shenping zhou
 * Date: 2016/1/21
 * Time: 16:54
 * 被召回的记录
 */
class RecallRecord
{
    static $table = 'recall_record';

    //判断给出的uid是否是被召回玩家
    static function isRecalledUid($uid)
    {
        String::_filterNoNumber($uid);
        $rs = DBHandle::select(self::$table, "`uid_b`=$uid");

        return !empty($rs);
    }

    //查询我所召回的人
    static function getMyFriends($uid)
    {
        $ret = array();
        foreach (self::getRecord($uid) as $item) {
            $ret[] = $item['uid_b'];
        }

        return $ret;
    }

    static function canBeRecalled($uid_b)
    {
        return !(self::isRecalledUid($uid_b));
    }

    //可否召回其他人
    static function canRecallOthers($uid_a)
    {
        return (count(self::getMyFriends($uid_a)) < RecallConfig::max_friends_count);//a已经召回的人小于或等于2时  才能召回别的玩家
    }

    static function insert($uid_a, $uid_b)
    {
        global $_CURRENT_TIME;
        $arr = array(
            'uid_a' => String::filterNoNumber($uid_a),
            'uid_b' => String::filterNoNumber($uid_b),
            'time'  => $_CURRENT_TIME,
            'date'  => date('Y-m-d', $_CURRENT_TIME),
        );

        return DBHandle::MyInsert(self::$table, Mysql::makeInsertString($arr));
    }

    static function getTimeRecalled($uid_a, $uid_b)
    {
        $ret = 0;

        foreach (self::getRecord($uid_a) as $item) {
            if ($item['uid_b'] == $uid_b) {
                $ret = $item['time'];
            }
        }

        return $ret;
    }

    static function getRecord($uid_a)
    {
        String::_filterNoNumber($uid_a);
        if ($uid_a == '') {
            return array();
        }

        static $ret = array();

        if ($ret[$uid_a] == array()) {
            $ret[$uid_a] = DBHandle::select(self::$table, "`uid_a`=$uid_a");
        }

        return $ret[$uid_a];
    }

    static function makeJsonURL($uid_a, $uid_b)
    {
        global $_CURRENT_TIME;
        $time = $_CURRENT_TIME;

        return "./api.php?uid_a=$uid_a&uid_b=$uid_b&time=$time&sign=" . md5($uid_a . $uid_b . $time . APP_SECRET);
    }
}
