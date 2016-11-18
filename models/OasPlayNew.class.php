<?php

/**
 * Created by PhpStorm.
 * User: shenping zhou
 * Date: 2015/11/11
 * Time: 20:02
 */
class OasPlayNew
{
    const table = 'oas_play_new';

    static function setPlayNew($uid, $sid)
    {
        String::_filterNoNumber($uid);
        String::_filterNoNumber($sid);

        if ($uid == '' | $sid == '')
        {
            return false;
        }

        if (self::getRecord($uid, $sid) == array())
        {
            $arr = array(
                'uid'   => $uid,
                'sid'   => $sid,
                'ctime' => time(),
            );

            return DBHandle::MyInsert(self::table, Mysql::makeInsertString($arr));
        }
        else
        {
            $arr = array(
                'ctime' => time(),
            );

            return DBHandle::update(self::table, Mysql::makeInsertString($arr), "`uid`=$uid AND `sid`=$sid");
        }
    }

    private static function getRecord($uid, $sid)
    {
        //参数校验由其他方法执行了

        return DBHandle::select(self::table, "`uid`=$uid AND `sid`=$sid");
    }
}