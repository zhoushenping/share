<?php

/**
 * Created by PhpStorm.
 * User: shenping zhou
 * Date: 2015/7/21
 * Time: 17:12
 */
class ActiveCodeNew
{
    const table = 'activecode';

    static function getCodeCount($where = 1)
    {
        $rs = DBHandle::select(self::table, $where, "COUNT(*) AS CC");

        return $rs[0]['CC'];
    }

    static function getFiltedCount($status_r, $uid_r, $sid_r)
    {
        $arr_where = '';
        if ($status_r == 1) $arr_where[] = "`uid` is null";//状态 0=全部 1=未领取  2=已领取
        if ($status_r == 2) $arr_where[] = "`uid` is not null";

        if ($uid_r != '') $arr_where[] = "`uid`='$uid_r'";
        if ($sid_r != 0) $arr_where[] = "`server`='$sid_r'";

        $where = Mysql::makeWhereFromArray($arr_where);

        return self::getCodeCount($where);
    }

    static function getCodeToShow($status_r, $uid_r, $sid_r, $start = 0, $limit = 100)
    {
        $arr_where = '';
        if ($status_r == 1) $arr_where[] = "`uid` is null";
        if ($status_r == 2) $arr_where[] = "`uid` is not null";

        if ($uid_r != '') $arr_where[] = "`uid`='$uid_r'";
        if ($sid_r != 0) $arr_where[] = "`server`='$sid_r'";

        $where = Mysql::makeWhereFromArray($arr_where);

        return DBHandle::select(self::table, $where . " ORDER BY `id` LIMIT $start,$limit", "*");
    }

    static function insert($codes)
    {
        $str_codes = implode("'),('", $codes);
        $sql       = "INSERT IGNORE INTO " . self::table . " (`code`) VALUES ('$str_codes')";

        return DBHandle::insert($sql);
    }
}