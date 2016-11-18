<?php

/**
 * Created by PhpStorm.
 * User: shenping zhou
 * Date: 2016/5/9
 * Time: 18:13
 */
class ThreeYearPay
{
    const table = 'three_year_pay';

    public static function getPayCoins($uid)
    {
        String::_filterNoNumber($uid);
        $rs = DBHandle::select(self::table, "`uid`=$uid");

        return $rs;
    }
}
