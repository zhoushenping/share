<?php

/**
 * Created by PhpStorm.
 * User: shenping zhou
 * Date: 2015/10/30
 * Time: 19:55
 */
class Invite
{
    const table_invite_ok = 'invite_record_ok';

    static function dealAPPinvite($step = 'step1', $facebook_uid = 0)
    {
        //第一步
        //url样本   /?fb_source=notification&request_ids=1650141818568736&ref=notif&app_request_type=user_to_user&notif_t=app_invite
        //url样本   /?fb_source=notification&request_ids=1684159528536974&ref=notif&app_request_type=user_to_user&notif_t=app_request  //非邀请好友界面的邀请功能
        if ($step == 'step1' && $_REQUEST['app_request_type'] == 'user_to_user' && ($_REQUEST['notif_t'] == 'app_invite' || $_REQUEST['notif_t'] == 'app_request'))
        {
            $_SESSION['invite_request_ids'] = $_REQUEST['request_ids'];//将request_ids存到session里面以备授权之后使用   格式有可能是123456  也有可能是 123456,789012
        }

        //第二步
        if ($step == 'step2' && $_SESSION['invite_request_ids'] != '' && $facebook_uid != '')
        {
            foreach (explode(',', $_SESSION['invite_request_ids']) as $v)
            {
                if ($v == '') continue;
                $rs      = myFacebook::getInviteInfo($v);
                $invitor = $rs['from']['id'];
                if ($invitor != '' && $invitor != $facebook_uid) self::insertRecord($invitor, $facebook_uid);
            }
            $_SESSION['invite_request_ids'] = '';
        }
    }

    static function insertRecord($invitor, $facebook_uid)
    {
        $arr = array(
            'invitor'     => $invitor,       //发起邀请者   为避免以后糊涂，往该表写入的uid实际上均为facebook app uid
            'invited_uid' => $facebook_uid,  //受邀者
            'auth_time'   => time(),         //受邀者授权app的时间戳
        );
        DBHandle::MyInsert(self::table_invite_ok, Mysql::makeInsertString($arr));
    }

    static function getCountGreaterThan($facebook_uid_me, $grade = 15)
    {
        $ret             = array();
        $uids_my_invited = self::getInvitedUids($facebook_uid_me);
        $mapped_uids     = UserMap::getMappedPlayUids($uids_my_invited);
        foreach (PlayGameLog::getPlayRecordForMultiUser($mapped_uids) as $item)
        {
            if ($item['grade'] >= $grade) $ret[] = $item['uid'];
        }

        return count(array_unique($ret));
    }

    static function getInvitedUids($facebook_uid_me)
    {
        String::_filterNoNumber($facebook_uid_me);
        if ($facebook_uid_me == '') return array();
        $rs  = DBHandle::select(self::table_invite_ok, "`invitor`=$facebook_uid_me", "invited_uid");
        $ret = array();
        foreach ($rs as $item) $ret[] = $item['invited_uid'];

        return $ret;
    }
}