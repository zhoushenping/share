<?php

/**
 * Created by PhpStorm.
 * User: shenping zhou
 * Date: 2016/2/25
 * Time: 17:35
 */
class RecallConfig
{
    const begin_date        = '2016-09-20';
    const end_date          = '2016-10-31';
    const lostDays          = 15;//判定为流失 需要的天数
    const lostGrade         = 55;//判定为流失  需要的等级
    const grade_canBe_A     = 50;//可以充当A角色需要的等级
    const max_friends_count = 10;
    const url_template      = "http://lobr.oasgames.com/?recall_id=[id]";//分享出去的链接的模板

    static $arr_sid_newplay    = array();//将要在 畅玩新服 界面显示的服的sid
    static $config_coins_roleB = array(200, 500, 1000, 2000, 5000, 10000);//关于B的充值行为的钻数的配置

    //自己的充值行为相关配置
    static $config_SelfChargeBonus = array(
        'copper'  => array(0, 999),
        'silver'  => array(1000, 9999),
        'gold'    => array(10000, 99999),
        'diamond' => array(100000, 99999999),
    );
    static $type_SelfChargeBonus   = array('copper', 'silver', 'gold', 'diamond',);
    static $config_MaxGradeBonus   = array(50, 60, 70, 80);//自己的流失等级奖励     等级配置  升序排列
    static $type_MaxGradeBonus     = array('grade50', 'grade60', 'grade70', 'grade80',);
    static $B_active_days          = array(2, 5, 10, 15, 20);//关于B活跃天数的配置

    static function initNewServerList()
    {
        $temp = array();

        foreach (ServerNew::getVisibleServer(0) as $item) {
            if ($item['start_time'] > 0 && self::isInEventDays($item['start_time'])) {
                $temp[] = $item['server_sid'];
            }
        }

        self::$arr_sid_newplay = $temp;
    }

    //是否在活动的时间范围以内
    static function isInEventDays($time = 0)
    {
        global $_CURRENT_TIME;
        if ($time == 0) {
            $time = $_CURRENT_TIME;
        }

        if ($time > Time::getDateLastSecond(self::end_date)) {
            return false;
        }
        if ($time < Time::getDateFirstSecond(self::begin_date)) {
            return false;
        }

        return true;
    }

    static function isBeforeEvent()
    {
        global $_CURRENT_TIME;

        return $_CURRENT_TIME < Time::getDateFirstSecond(self::begin_date);
    }

    static function isAfterEvent()
    {
        global $_CURRENT_TIME;

        return $_CURRENT_TIME > Time::getDateLastSecond(self::end_date);
    }
}
