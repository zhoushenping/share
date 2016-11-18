<?php

/**
 * Created by PhpStorm.
 * User: shenping zhou
 * Date: 2016-08-10
 * Time: 15:51
 */
class ThreeYearPlayInfo
{
    const table = 'three_year_play_info';

    static function getUserRecords($uid)
    {
        String::_filterNoNumber($uid);

        return DBHandle::select(self::table, "`uid0`=$uid ORDER BY `last_time` DESC");
    }
}
