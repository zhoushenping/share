<?php

/**
 * Created by PhpStorm.
 * User: shenping zhou
 * Date: 2015/5/21
 * Time: 11:20
 */
class OasCheckUser
{
    static function getAll()
    {
        static $all = array();
        if (empty($all))
        {
            $sql = "SELECT * from oas_check_user;";
            $all = DBHandle::query($sql);
        }

        return $all;
    }

    static function isWhiteUser($uid)
    {
        $all = self::getAll();
        $ret = false;
        foreach ($all as $item)
        {
            if ($item['uid'] == $uid and $item['type_id'] == 2) $ret = true;
        }

        return $ret;
    }

    static function isKillUser($uid)
    {
        $all = self::getAll();
        $ret = false;
        foreach ($all as $item)
        {
            if ($item['uid'] == $uid and $item['type_id'] == 1) $ret = true;
        }

        return $ret;
    }

    static function checkKillUser($uid, $chargebacks_url)
    {
        if (self::isKillUser($uid))
        {
            header("Location:$chargebacks_url");
            exit;
        }
    }
}