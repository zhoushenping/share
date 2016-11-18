<?php

/**
 * Created by PhpStorm.
 * User: shenping zhou
 * Date: 2016/5/9
 * Time: 18:02
 */
class ThreeYearLotteryConfig
{
    public static $eventBegin = '2016-08-22';//todo online 20160822
    public static $eventEnd   = '2016-08-28';//todo online 20160828

    public static function getLotteryBonusConfig()
    {
        $ret['lottery1']  = array('rate' => 5, 'name_cn' => '飞天灵兔*1',);
        $ret['lottery2']  = array('rate' => 150, 'name_cn' => '高级纹身染料*50',);
        $ret['lottery3']  = array('rate' => 200, 'name_cn' => '高级凝神珠*10',);
        $ret['lottery4']  = array('rate' => 200, 'name_cn' => '高级圣魂石*10',);
        $ret['lottery5']  = array('rate' => 100, 'name_cn' => '伏尔甘礼包*5',);
        $ret['lottery6']  = array('rate' => 150, 'name_cn' => '宙斯的血液*10',);
        $ret['lottery7']  = array('rate' => 50, 'name_cn' => '纯净洗练石*20',);
        $ret['lottery8']  = array('rate' => 50, 'name_cn' => '精华洗炼石*20',);
        $ret['lottery9']  = array('rate' => 50, 'name_cn' => '精髓洗炼石*20',);
        $ret['lottery10'] = array('rate' => 45, 'name_cn' => '新守卫技能箱*30',);

        return $ret;
    }

    //mycount=已抽奖多少次 才可能出现本奖项
    //total=本奖项在活动期间内最多被抽中几次
    //daily=本奖项每天最多被抽中几次
    public static function getLotteryBonusLimit()
    {
        return array();
    }

    //获取码的类型的名字
    public static function getTypeName($type)
    {
        global $lang;

        foreach (self::getLotteryBonusConfig() as $t => $item) {
            if ($t == $type) {
                return $lang['typeName'][$t];
            }
        }

        return '';
    }

    static function isBeforeEvent()
    {
        global $_CURRENT_TIME;
        return $_CURRENT_TIME < Time::getDateFirstSecond(self::$eventBegin);
    }

    static function isAfterEvent()
    {
        global $_CURRENT_TIME;
        return $_CURRENT_TIME > Time::getDateLastSecond(self::$eventEnd);
    }
}
