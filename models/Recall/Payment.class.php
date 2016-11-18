<?php

/**
 * Created by PhpStorm.
 * User: shenping zhou
 * Date: 2016/1/28
 * Time: 21:16
 */
class RecallPayment
{
    static $payInfoCacheLimited = array();//支付信息 缓存结果集   去掉了B角色成为好友前的记录
    static $payInfoCacheFull    = array();//支付信息 缓存结果集  较全的  计算是否有坏账时用到

    //返回uid对应的各个uid的总钻数
    static function getTotalCoins($uid)
    {
        return array_sum(self::getDailyCoins($uid));
    }

    static function getDailyCoins($uid)
    {
        $ret          = array();
        $related_uids = GetUidAuto::getRelatedUids($uid);

        foreach (self::$payInfoCacheLimited as $item) {
            //只计算当前uid相关的uid的支付情况
            if (!in_array($item['uid'], $related_uids)) {
                continue;
            }
            $date = date('Ymd', $item['time']);
            $ret[$date] += $item['coins'];
        }
        ksort($ret);//print_r($ret);

        return $ret;
    }

    static function updatePayInfoCache($uid_a0)
    {
        RecallBonusBase::$all_uid = RecallBonusBase::getAllRelatedUids($uid_a0);
        PayCache::updateCache(RecallBonusBase::$all_uid);

        self::$payInfoCacheFull    = PayCache::getRecordFromCache(RecallBonusBase::$all_uid);
        self::$payInfoCacheLimited = self::getPayInfoCacheLimited($uid_a0);
    }

    static function getPayInfoCacheLimited($uid_a0)
    {
        $relatedUids_a     = GetUidAuto::getRelatedUids($uid_a0);//角色A涉及的uid
        $arr_time_beFriend = RecallBonusBase::getTimeBeFriendAll($uid_a0);

        $ret = array();
        foreach (self::$payInfoCacheFull as $item) {
            //如果当前支付记录是被召回者的，则去掉ta被召回前的记录
            if (!in_array($item['uid'], $relatedUids_a)) {
                if ($item['time'] < $arr_time_beFriend[$item['uid']]) {
                    continue;
                }
                if (!RecallConfig::isInEventDays($item['time'])) {
                    continue;//如果当前支付记录是被召回者的，则去掉在活动时间段而外的记录
                }
            }
            $ret[] = $item;
        }

        return $ret;
    }

    static function hasNoChargeBack($uid)
    {
        $related_uids = GetUidAuto::getRelatedUids($uid);

        foreach (self::$payInfoCacheFull as $item) {
            if (!in_array($item['uid'], $related_uids)) {
                continue;
            }
            if ($item['status'] == 0) {
                return false;
            }
        }

        return true;
    }
}
