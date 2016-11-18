<?php

/**
 * Created by PhpStorm.
 * User: shenping zhou
 * Date: 2015/11/11
 * Time: 20:11
 */
class OasUserOrigin
{
    const table = 'user_origin';

    static function setUserOrigin($uid, $sid, $otype)
    {
        String::_filterNoNumber($uid);
        String::_filterNoNumber($sid);
        String::_filterNoNumber($otype);

        if (empty($uid) || empty($sid) || empty($otype))
        {
            return false;
        }

        if (self::getTodayRecord($uid, $sid) == array())
        {
            $arr = array(
                'uid'   => $uid,
                'sid'   => $sid,
                'oday'  => date("Y-m-d"),
                'otype' => $otype,
                'ctime' => time(),
            );

            return DBHandle::MyInsert(self::table, Mysql::makeInsertString($arr));
        }
        else
        {
            return false;
        }
    }

    private static function getTodayRecord($uid, $sid)
    {
        //参数校验由其他方法执行了
        $oday = date("Y-m-d");

        return DBHandle::select(self::table, "`uid`=$uid AND `sid`=$sid AND `oday`='$oday'");
    }
}