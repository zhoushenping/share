<?php

/**
 * Created by PhpStorm.
 * User: shenping zhou
 * Date: 2016/1/21
 * Time: 19:50
 * 召回专题的码的类
 */
class RecallCode
{
    static $table = 'recall_code';

    static function getCode($uid, $type)
    {
        if ($type == false) {
            return '';
        }
        $oldCode = self::getOldCode($uid, $type);

        return ($oldCode != '') ? $oldCode : (self::getNewCode($uid, $type));
    }

    //根据传入的uid和type查得已经取到的码
    static function getOldCode($uid, $type)
    {
        foreach (self::getAllrecord() as $item) {
            if ($item['uid'] != $uid) {
                continue;
            }
            if ($item['type'] == $type) {
                return $item['code'];
            }
        }

        return '';
    }

    //根据传入的uid和type取得新码
    static function getNewCode($uid, $type)
    {
        global $_CURRENT_TIME;
        String::_filterNoNumber($uid);
        $type = addslashes($type);
        $time = $_CURRENT_TIME;
        $date = date('Y-m-d', $_CURRENT_TIME);
        DBHandle::update(self::$table, "`uid`=$uid,`time`=$time,`date`='$date'", "`type`='$type' AND `uid` IS NULL");

        self::getAllrecord(true);//刷新缓存

        return self::getOldCode($uid, $type);
    }

    static function getDateOfCode($code)
    {
        $ret = '';

        foreach (self::getAllrecord() as $item) {
            if ($item['code'] == $code) {
                $ret = date('Ymd', $item['time']);
            }
        }

        return $ret;
    }

    static function getAllrecord($flush = false)
    {
        static $ret = false;
        if ($ret === false || $flush) {
            $arr_uid = myArray::trimEmptyUid(RecallBonusBase::$all_uid);
            $str_uid = implode(',', $arr_uid);
            $ret     = DBHandle::select(self::$table, "`uid` IN (" . $str_uid . ")");
        }

        return $ret;
    }

    static function getExistCode($uid, $arr_type)
    {

        foreach (self::getAllrecord() as $item) {
            if ($item['uid'] != $uid) {
                continue;
            }
            if (in_array($item['type'], $arr_type)) {
                return $item['code'];
            }//如果自己已经领过$arr_type中的码   则不能再领同一类别的码  返回同一类别已有的码
        }

        return '';
    }
}
