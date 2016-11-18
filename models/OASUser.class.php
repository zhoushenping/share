<?php

/**
 * Created by PhpStorm.
 * User: shenping zhou
 * Date: 2015/5/22
 * Time: 18:45
 */
class OASUser
{
    const table = 'users';//oas_users

    static function isExist($uid)
    {
        $userInfo = self::getUserInfo($uid);

        return (!empty($userInfo));
    }

    static function getUserInfo($uid, $flush = false)
    {
        String::_filterNoNumber($uid);
        if ($uid == '') {
            return array();
        }

        static $ret = array();
        static $status = array();

        if ($status[$uid] == 0 || $flush == true) {
            $rs           = DBHandle::select(self::table, "`uid`=$uid");
            $ret[$uid]    = $rs[0];
            $status[$uid] = 1;
        }

        return $ret[$uid];
    }

    static function getUserInfoMulti($arr_uids)
    {
        $arr_uids = myArray::trimEmptyUid($arr_uids);

        return DBHandle::select(self::table, "`uid` IN (" . implode(',', $arr_uids) . ")");
    }

    static function addUserByProfile($user_profile)
    {
        $time                 = time();
        $arr['uid']           = $user_profile['id'];
        $arr['oas_uid']       = $user_profile['oas_uid'];
        $arr['name']          = $user_profile['name'];
        $arr['email']         = $user_profile['email'];
        $arr['locale']        = $user_profile['locale'];
        $arr['timezone']      = $user_profile['timezone'];
        $arr['gender']        = ($user_profile['gender'] == 'female') ? '0' : '1';
        $arr['birthday']      = strtotime($user_profile['birthday']);
        $arr['app']           = 'play';
//        $arr['sp_promote']    = Promote::getPromote();//lobr的users表没有这个字段
//        $arr['sp_promote_id'] = Promote::getPromoteID();//lobr的users表没有这个字段
        $arr['time']          = $time;
//        $arr['time_ip']       = Browser::get_client_ip();//lobr的users表没有这个字段
        $arr['last_login']    = $time;
//        $arr['last_login_ip'] = Browser::get_client_ip();//lobr的users表没有这个字段

        $rs = DBHandle::MyInsert(self::table, Mysql::makeInsertString($arr));
        self::getUserInfo($arr['uid'], true);//刷新缓存

        return $rs;
    }

    static function updateLastLogin($uid, $oas_uid_c)
    {
        String::_filterNoNumber($uid);
        String::_filterNoNumber($oas_uid_c);
        $user_info = self::getUserInfo($uid);
        if (empty($user_info)) {
            return false;
        }

		$oas_uid_l = $user_info['oas_uid'];//已有的oas_uid
        $l_date = date("Y-m-d", $user_info['last_login']);
        $s_date = date("Y-m-d");
        $str    = '';//lobr没有这个字段  故而修订。  $str    = ($l_date != $s_date) ? " `nums` = `nums`+1 ," : '';
        $str1      = ($oas_uid_c != 0 && $oas_uid_c != $oas_uid_l) ? " `oas_uid` = '$oas_uid_c'," : '';//传入的oas_uid不为空，且和已有的值不同时  才更新

        $arr['last_login']    = time();
//        $arr['last_login_ip'] = Browser::get_client_ip();//lobr没有这个字段

        $rs = DBHandle::update(self::table, $str . $str1 . Mysql::makeInsertString($arr), "`uid` = $uid");
        self::getUserInfo($uid, true);//刷新缓存

        return $rs;
    }

    static function updateOasUid($uid, $oas_uid)
    {
        String::_filterNoNumber($uid);
        String::_filterNoNumber($oas_uid);

        if ($uid == 0 or $oas_uid == 0) {
            return false;
        }

        $userInfo = self::getUserInfo($uid);
        if (empty($userInfo) or $userInfo['oas_uid'] == $oas_uid) {
            return false;
        }

        $rs = DBHandle::update(self::table, "`oas_uid`=$oas_uid", "`uid` = $uid");
        self::getUserInfo($uid, true);//刷新缓存

        return $rs;
    }
}