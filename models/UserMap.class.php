<?php

/**
 * Created by PhpStorm.
 * User: shenping zhou
 * Date: 2015/5/22
 * Time: 18:50
 */
class UserMap
{
    const table = 'oas_user_map';

    //获取玩家玩游戏的uid  传入的$uid可以是facebook uid
    static function getPlayGameUid($uid)
    {
        $userInfo = self::getUserInfo($uid);
        if (!empty($userInfo)) $uid = $userInfo['oas_uid'];

        return $uid;
    }

    //获取facebook uid
    static function getFacebookUid($uid)
    {
        $userInfo = self::getUserInfo($uid);
        if (!empty($userInfo)) $uid = $userInfo['fb_uid'];

        return $uid;
    }

    static function isExist($uid)
    {
        $userInfo = self::getUserInfo($uid);

        return (!empty($userInfo));
    }

    static function add($facebook_uid, $uid)
    {
        String::_filterNoNumber($facebook_uid);
        String::_filterNoNumber($uid);

        if (empty($facebook_uid) || empty($uid) || $facebook_uid == $uid || self::isExist($facebook_uid) || self::isExist($uid)) return false;
        DBHandle::MyInsert(self::table, "`fb_uid`=$facebook_uid ,`oas_uid`=$uid");
        self::getUserInfo($facebook_uid, true);//更新cache
        self::getUserInfo($uid, true);//更新cache
    }

    static function getUserInfo($uid, $flush = false)
    {
        String::_filterNoNumber($uid);
        if ($uid == '') return array();

        static $ret = array();
        static $status = array();

        if ($status[$uid] == 0 || $flush)
        {
            $rs           = DBHandle::select(self::table, "`fb_uid`=$uid OR `oas_uid`=$uid");
            $ret[$uid]    = $rs[0];
            $status[$uid] = 1;//更新状态值
        }

        return $ret[$uid];
    }

    static function getMappedPlayUids($uids_query)
    {
        $ret = array();
        foreach ($uids_query as $v)
        {
            $v = String::filterNoNumber($v);
            if ($v == '') continue;
            $ret[$v] = $v;
        }

        if (empty($ret)) return $ret;

        $str_uids = implode(',', $ret);
        $rs       = DBHandle::select(self::table, "`fb_uid` IN ($str_uids) OR `oas_uid` IN ($str_uids)");
        foreach ($rs as $item)
        {
            $ret[$item['fb_uid']] = $item['oas_uid'];
        }

        return $ret;
    }
}