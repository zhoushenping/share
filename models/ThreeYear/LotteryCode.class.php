<?php

/**
 * Created by PhpStorm.
 * User: shenping zhou
 * Date: 2016/5/9
 * Time: 17:09
 */
class ThreeYearLotteryCode
{
    const recordTable = 'three_year_lottery_record';
    const codeTable   = 'three_year_lottery_code';
    static $userRecordStatic = false;

    public static function getCode($uid, $chance, $type)
    {
        if ($uid == '') {
            return array();
        }

        $existRecord = self::getExistRecord($uid, $chance);

        if ($existRecord != array()) {
            return $existRecord;
        }
        else {
            self::getNewRecord($uid, $chance, $type);

            return self::getExistRecord($uid, $chance);
        }
    }

    public static function getUserRecord($uid)
    {
        String::_filterNoNumber($uid);

        static $ret;

        if (self::$userRecordStatic == false) {
            self::$userRecordStatic = true;

            $ret = DBHandle::select(self::recordTable, "`uid`=$uid ORDER BY `time` DESC,`chance` DESC");
        }

        return $ret;
    }

    public static function get100Record()
    {
        return DBHandle::select(self::recordTable, "`uid`!=0 ORDER BY `time` DESC LIMIT 0,100");
    }

    public static function getExistRecord($uid, $chance)
    {
        $ret = array();
        foreach (self::getUserRecord($uid) as $item) {
            if ($item['chance'] == $chance) {
                $ret = $item;
            }
        }

        return $ret;
    }

    public static function getNewRecord($uid, $chance, $type)
    {
        global $uname;
        String::_filterNoNumber($uid);

        if ($uid == '') {
            return false;
        }

        $code = '';//玩家执行抽奖时  并不立即得到相应的码  码用另外一个进程触发获取
        $arr  = array(
            'uid'    => $uid,
            'code'   => $code,
            'type'   => $type,
            'time'   => time(),
            'month'  => date('Y-m'),
            'date'   => date('Y-m-d'),
            'chance' => $chance,
            'uname'  => $uname,
        );

        DBHandle::MyInsert(self::recordTable, Mysql::makeInsertString($arr));
        self::$userRecordStatic = false;

        return false;
    }

    public static function getMyCount($uid)
    {
        $res = self::getUserRecord($uid);

        return count($res);
    }

    //所查类型活动期间被领取了几次
    public static function getCount($t)
    {
        $ret = 0;

        foreach (self::getDailyReport() as $item) {
            if ($item['type'] == $t) {
                $ret += $item['c'];
            }
        }

        return $ret;
    }

    //所查类型当天被领取了几次
    public static function getTodayCount($t)
    {
        $ret      = array();
        $date_now = date('Y-m-d');

        foreach (self::getDailyReport() as $item) {
            $ret[$item['type']][$item['date']] = $item['c'];
        }

        return (int)($ret[$t][$date_now]);
    }

    //每日报表  仅输出原始rs
    public static function getDailyReport($flush = false)
    {
        static $ret = array();

        if ($ret == array() || $flush) {
            $ret = DBHandle::select(
                self::recordTable,
                "`uid`!=0 GROUP BY `type`,`date`",
                "`type`,`date`,COUNT(*) AS c"
            );
        }

        return $ret;
    }

    public static function getDailyReportByChance($flush = false)
    {
        static $ret = array();

        if ($ret == array() || $flush) {
            $ret = DBHandle::select(
                self::recordTable,
                "`uid`!=0 GROUP BY `chance`,`date`",
                "`chance`,`date`,COUNT(*) AS c"
            );
        }

        return $ret;
    }

    public static function updateEmptyCode($uid)
    {
        foreach (self::getUserRecord($uid) as $item) {
            if ($item['code'] != '') {
                continue;
            }
            $code = self::getCodeFromLocal($uid, $item['type']);
            if ($code == '') {
                Log2::save_run_log("try to get bonus of {$item['type']} for $uid failed", 'lottery_fail');
            }
            else {
                DBHandle::update(self::recordTable, "`code`='$code'", "id={$item['id']}");
                ThreeYearShare::tryUpdateChance($uid, $item['chance']);//尝试更新分享表中的机会的信息
                self::$userRecordStatic = false;
            }
        }
    }

    public static function getDailyRecord($date)
    {
        $date = date('Y-m-d', strtotime($date));

        return DBHandle::select(self::recordTable, "`date`='$date' ORDER BY `time` DESC,`chance` DESC");
    }

    public static function getCodeFromLocal($uid, $type)
    {
        $code = '';

        $rs = DBHandle::select(self::codeTable, "`uid`=0 AND `type`='$type' LIMIT 0,1");

        if (!empty($rs)) {
            $code = $rs[0]['code'];
            $id   = $rs[0]['id'];

            $arr = array(
                'uid'  => $uid,
                'time' => time(),
            );
            DBHandle::update(self::codeTable, Mysql::makeInsertString($arr), "`id`=$id");
        }

        return $code;
    }
}
