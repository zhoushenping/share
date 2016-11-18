<?php

/**
 * Created by PhpStorm.
 * User: shenping zhou
 * Date: 2016/1/21
 * Time: 16:45
 * 被召回玩家的玩游戏记录
 */
class RecallPlaygame
{
    static $table = 'recall_playgame';

    static function readRecord($uid)
    {
        static $ret = array();

        if (!isset($ret[$uid])) {
            String::_filterNoNumber($uid);

            $ret[$uid] = DBHandle::select(self::$table, "`uid`=$uid");
        }

        return $ret[$uid];
    }

    static function getActiveDates($uid)
    {
        $ret = array();
        foreach (self::readRecord($uid) as $item) {
            $ret[] = $item['date'];
        }
        sort($ret);//日期按照小到大排列

        return $ret;
    }

    //每个uid每天只插入一次
    static function insertRecord($uid)
    {
        $uid  = RecallBonusBase::getMyUid0($uid);//插入的uid永远是基本uid
        $date = date('Ymd');

        if (!RecallConfig::isInEventDays()) {
            return false;
        }//在活动时间段而外 不插入记录
        if (RecallRecord::isRecalledUid($uid) == false) {
            return false;
        }//如果不是被召回玩家  不执行
        if (in_array($date, self::getActiveDates($uid))) {
            return false;
        }//如果今天已经插入  则不继续执行

        $arr = array(
            'uid'  => String::filterNoNumber($uid),
            'date' => $date,
        );

        return DBHandle::MyInsert(self::$table, Mysql::makeInsertString($arr));
    }

    static function readALLrecord()
    {
        static $ret = false;
        if ($ret === false) {
            $arr_uid = myArray::trimEmptyUid(RecallBonusBase::$all_uid);
            $str_uid = implode(',', $arr_uid);

            $ret = DBHandle::select(self::$table, "`uid` IN (" . $str_uid . ")");
        }

        return $ret;
    }

    //获取当前uid涉及的uid的最高等级角色的昵称
    static function getMaxNick($uid)
    {
        $arr_playRecord = PlayGameLog::getPlayRecordForMultiUser(GetUidAuto::getRelatedUids($uid), 2);
        $sid_max        = $arr_playRecord[0]['server_sid'];

        return Game::getRoleName($uid, $sid_max);
    }
}
