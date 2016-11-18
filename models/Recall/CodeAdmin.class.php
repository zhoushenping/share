<?php

/**
 * Created by PhpStorm.
 * User: shenping zhou
 * Date: 2016/5/9
 * Time: 17:09
 * 此类是码的管理类
 */
class RecallCodeAdmin
{
    public static $table;

    public static function getTable($type)
    {
        return RecallCode::$table;
    }

    private static function getManyCode($start = 0, $limit = 10000)
    {
        $ret = array();
        $rs  = DBHandle::select(self::$table, "1 limit $start,$limit");
        foreach ($rs as $item) {
            $ret[] = $item['code'];
        }

        return $ret;
    }

    //手动加码
    static function addCode()
    {
        self::addAuto();
        $type_r = $_REQUEST['type'];
        $code_r = $_REQUEST['code'];

        if ($code_r == '' || $type_r == '') {
            return false;
        }

        if (DEVELOP_MODE) {
            preg_match_all('/[a-z0-9A-Z]{4,30}/', $code_r, $match);
        }

        if (!DEVELOP_MODE) {
            preg_match_all('/[a-z0-9A-Z]{10,30}/', $code_r, $match);
        }

        $arr_code = $match[0];

        return self::insert($type_r, $arr_code);
    }

    //去重并插入
    private static function insert($type, $arr_code)
    {
        self::$table = self::getTable($type);
        for ($i = 0; $i < 1000; $i++) {
            $code_exist = self::getManyCode($i * 10000);

            if ($code_exist == array()) {
                break;
            }

            $arr_code = array_diff($arr_code, $code_exist);
        }

        $data = array();

        foreach ($arr_code as $v) {
            $data[] = array($type, $v);
        }

        return DBHandle::insertMulti(self::$table, array('type', 'code'), $data);
    }

    //测试环境可以自动加码
    static function addAuto()
    {
        //lobr.oasgames.com/event/recall/admin/addCode.php?do=auto
        if (!DEVELOP_MODE || $_REQUEST['do'] != 'auto') {
            return false;
        }

        $arr_type = self::getTypeList();

        foreach ($arr_type as $t) {
            $arr_code = array();
            for ($i = 0; $i < 200; $i++) {
                $arr_code[] = "testcode_{$t}_{$i}";
            }

            self::insert($t, $arr_code);
        }

        return false;
    }

    static function getTypeList()
    {
        $arr_type = array();

        foreach (self::getTypeName() as $k => $v) {
            $arr_type[] = $k;
        }

        return $arr_type;
    }

    static function getTypeName()
    {
        static $ret = array();

        if (empty($ret)) {
            foreach (RecallConfig::$type_SelfChargeBonus as $v) {
                $a = RecallConfig::$config_SelfChargeBonus[$v][0];
                $b = RecallConfig::$config_SelfChargeBonus[$v][1];

                $ret[$v] = "我已充值{$a}-{$b}钻对应的奖励";
            }

            foreach (RecallConfig::$config_MaxGradeBonus as $v) {
                $ret["grade{$v}"] = "我的最高流失等级为{$v}级对应的奖励";
            }

            $ret["be_friends"] = "好友被召回给我的奖励";

            foreach (RecallConfig::$config_coins_roleB as $v) {
                $ret["{$v}coins"] = "我召回的好友自召回后，累计充{$v}钻给我的奖励";
            }
            foreach (RecallConfig::$B_active_days as $v) {
                $ret["{$v}day"] = "我召回的好友自召回后，累计活跃{$v}天给我的奖励";
            }
        }

        return $ret;
    }

    static function isSelfType($type)
    {
        return !($type == 'be_friends' || strpos($type, 'day') !== false || strpos($type, 'coins') !== false);
    }
}
