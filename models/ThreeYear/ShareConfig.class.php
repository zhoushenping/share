<?php

/**
 * Created by PhpStorm.
 * User: shenping zhou
 * Date: 2016/5/9
 * Time: 18:02
 */
class ThreeYearShareConfig
{
    public static $maxShareCount = 3;
    public static $eventBegin    = '2016-06-01';//todo online 0701 ok
    public static $eventEnd      = '2016-06-30';//todo online 0731 ok

    static function isBeforeEvent()
    {
        return time() < Time::getDateFirstSecond(self::$eventBegin);
    }

    static function isAfterEvent()
    {
        return time() > Time::getDateLastSecond(self::$eventEnd);
    }
}
