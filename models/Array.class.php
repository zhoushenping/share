<?php

/**
 * Created by PhpStorm.
 * User: shenping zhou
 * Date: 2015/5/20
 * Time: 12:38
 */
class myArray
{
    static function get($arr, $num)
    {
        $ret = array();
        $n   = 0;
        foreach ($arr as $k => $v)
        {
            if ($n < $num) $ret[$k] = $v;
            $n++;
        }

        return $ret;
    }
}