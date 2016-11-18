<?php

/**
 * Created by PhpStorm.
 * User: shenping zhou
 * Date: 2016/1/21
 * Time: 16:22
 */
class RecallBonusBase
{
    static $all_uid    = array();//当前页面循环所有可能设计的uid
    static $friendUids = array();

    static function getMyUid0($uid)
    {
        $temp = GetUidAuto::getRelated($uid);

        if (!empty($temp)) {
            $temp = $temp[0];

            return ($temp['output_uid'] == 99) ? $temp['fb_sns_uid'] : $temp['output_uid'];
        }

        return $uid;
    }

    static function formatDate($date)
    {
        return date('Y.m.d', strtotime($date));
    }

    static function getAllRelatedUids($uid_a0)
    {
        $all_uids = GetUidAuto::getRelatedUids($uid_a0);//角色A涉及的uid
        foreach (RecallRecord::getMyFriends($uid_a0) as $uid_b) {
            foreach (GetUidAuto::getRelatedUids($uid_b) as $uid_b_sub) {
                $all_uids[]                 = $uid_b_sub;
                self::$friendUids[$uid_b][] = $uid_b_sub;
            }
        }

        return $all_uids;
    }

    //传入一个uid 获取他邀请的每个好友涉及的uid的被邀请时间
    static function getTimeBeFriendAll($uid_a)
    {
        $ret = array();
        foreach (RecallRecord::getMyFriends($uid_a) as $uid_b) {
            $time = RecallRecord::getTimeRecalled($uid_a, $uid_b);

            foreach (GetUidAuto::getRelatedUids($uid_b) as $uid_b_sub) {
                $ret[$uid_b_sub] = $time;
            }
        }

        return $ret;
    }
}
