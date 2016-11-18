<?php

/**
 * Created by PhpStorm.
 * User: shenping zhou
 * Date: 2016/5/9
 * Time: 17:09
 */
class ThreeYearSignCode
{
    const table = 'three_year_sign_code';

    public static function getCode($uid, $type, $month = '')
    {
        if ($uid == '') {
            return '';
        }

        if ($month == '') {
            $month = date('Y-m');
        }

        $existCode = self::getExistCode($uid, $type, $month);

        if ($existCode != '') {
            return $existCode;
        }
        else {
            self::getNewCode($uid, $type, $month);

            return self::getExistCode($uid, $type, $month);
        }
    }

    public static function getUserRecord($uid, $flush = false)
    {
        static $ret = array();
        static $cache_status = array();
        String::_filterNoNumber($uid);
        if ($uid == '') {
            return array();
        }

        if ($flush || $cache_status[$uid] != 1) {
            $rs = DBHandle::select(self::table, "`uid`=$uid");

            foreach ($rs as $k => $item) {
                if (strpos($item['type'], 'sign') === false) {
                    unset($rs[$k]);
                }
            }

            $ret[$uid] = $rs;

            $cache_status[$uid] = 1;
        }

        return $ret[$uid];
    }

    public static function getExistCode($uid, $type, $month)
    {
        $code = '';
        foreach (self::getUserRecord($uid) as $item) {
            if ($item['type'] == $type && $item['month'] == $month) {
                $code = $item['code'];
            }
        }

        return $code;
    }

    public static function getNewCode($uid, $type, $month)
    {
        String::_filterNoNumber($uid);
        if ($uid == '') {
            return false;
        }
        $arr = array(
            'uid'  => $uid,
            'time' => time(),
            'date' => date('Y-m-d'),
        );

        DBHandle::update(self::table, Mysql::makeInsertString($arr), "`type`='$type' AND `month`='$month' AND `uid`=0");
        self::getUserRecord($uid, true);//更新查询缓存
    }

    public static function getReport()
    {
        return DBHandle::select(self::table, "`uid`!=0 GROUP BY `date`,`type`", "`date`,`type`,COUNT(*) AS c");
    }
}
