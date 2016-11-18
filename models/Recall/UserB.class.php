<?php

/**
 * Created by PhpStorm.
 * User: shenping zhou
 * Date: 2016/5/9
 * Time: 17:09
 * 此类是码的管理类
 */
class RecallUserB
{
    const table = 'recall_userlist_b';

    static function inTable($uid)
    {
        String::_filterNoNumber($uid);
        if ($uid == '') {
            return false;
        }

        $str_uids = implode(",", GetUidAuto::getRelatedUids($uid));

        return (DBHandle::select(self::table, "`uid` IN ($str_uids)") != array());
    }
}
