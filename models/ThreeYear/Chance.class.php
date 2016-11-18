<?php

/**
 * Created by PhpStorm.
 * User: shenping zhou
 * Date: 2016/5/9
 * Time: 18:13
 */
class ThreeYearChance
{
    const chance_begin   = '2016-08-22';//online 8.22
    const chance_end     = '2016-08-28';//online 8.28
    const payChanceDaily = 100;//每日限制的最大机会数
    const perChanceCoins = 165;//每次抽奖机会需要达到的充值额

    const regDateLimit = '2016-05-01';//只有这个日期前注册的玩家的分享行为可能给自己带来抽奖机会,【注:此项在葡语中请忽略,在葡语中分享不送抽奖机会】

    //获取玩家的所有抽奖机会，充值行为带来的机会
    public static function getAllChance($uid)
    {
        return self::getChanceFromPay($uid);
    }

    public static function getValidChance($uid)
    {
        $used = self::getUsedChance($uid);
        $all  = self::getAllChance($uid);

        return array_values(array_diff($all, $used));//因为array_diff将保留原来的键  所以用array_values去掉原来的键
    }

    public static function getUsedChance($uid)
    {
        $ret = array();
        foreach (ThreeYearLotteryCode::getUserRecord($uid) as $item) {
            $ret[] = $item['chance'];
        }

        return $ret;
    }

    public static function getChanceFromPay($uid)
    {

        $amount_coins = self::getPayCoins($uid);

        return self::calculate($amount_coins);
    }

    public static function calculate($coins)
    {
        global $_CURRENT_TIME;
        $ret          = array();
        $chance_coins = self::perChanceCoins;
        for ($i = 1; $i < ($coins / $chance_coins + 1); $i++) {
            $m = $i * $chance_coins;
            if ($m > $coins) {
                break;
            }
            $m     = date('md', $_CURRENT_TIME) . "_" . $m;
            $ret[] = "coins{$m}";
        }

        return $ret;
    }

    public static function getPayCoins($uid)
    {
        global $_CURRENT_TIME;
        if (DEVELOP_MODE && $_GET['m'] != '') {
            $rs = ThreeYearPay::getPayCoins($uid);
        }
        else {
            $rs = Payment::getRelatedPayRecords($uid);
        }

        $ret = 0;
        if (!empty($rs)) {
            foreach ($rs as $item) {
                if ($item['status'] && self::inTime($item['time'])) {
                    $day         = date('Y-m-d', $item['time']);
                    $current_day = date('Y-m-d', $_CURRENT_TIME);
                    //只计算当天充值的总数
                    if ($day == $current_day) {
                        $ret += $item['coins'];
                    }
                }
            }
            $max_coins = self::payChanceDaily * self::perChanceCoins;
            $ret       = min($ret, $max_coins);//取最小值
        }

        return $ret;
    }

    public static function getChanceBegin()
    {
        return Time::getDateFirstSecond(self::chance_begin);
    }

    public static function getChanceEnd()
    {
        return Time::getDateLastSecond(self::chance_end);
    }

    public static function inTime($time = 0)
    {
        $time      = ($time == 0) ? time() : $time;
        $TimeBegin = self::getChanceBegin();
        $TimeEnd   = self::getChanceEnd();

        return ($time >= $TimeBegin && $time <= $TimeEnd);
    }
}
