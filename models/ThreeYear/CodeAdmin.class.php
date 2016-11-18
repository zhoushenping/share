<?php

/**
 * Created by PhpStorm.
 * User: shenping zhou
 * Date: 2016/5/9
 * Time: 17:09
 * 此类是码的管理类
 */
class ThreeYearCodeAdmin
{
    public static $table;

    public static function getTable($type)
    {
        return strpos($type, 'sign') !== false ? ThreeYearSignCode::table : ThreeYearLotteryCode::codeTable;
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
        $type_r   = $_REQUEST['type'];
        $code_r   = $_REQUEST['code'];
        $expire_r = $_REQUEST['expire'];
        $month_r  = $_REQUEST['month'];

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

        return self::insert($type_r, $arr_code, $expire_r, $month_r);
    }

    //去重并插入
    private static function insert($type, $arr_code, $expire, $month_r)
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
            $data[] = array($type, $v, $expire, $month_r);
        }

        return DBHandle::insertMulti(self::$table, array('type', 'code', 'expire', 'month'), $data);
    }

    //测试环境可以自动加码
    static function addAuto()
    {
        if (!DEVELOP_MODE || $_REQUEST['do'] != 'auto') {
            return false;
        }

        $a = ThreeYearLotteryConfig::getLotteryBonusConfig();
        $b = ThreeYearSignConfig::getSignBonusConfig();

        foreach (array_merge($a, $b) as $t => $item) {
            //foreach ($b as $t => $item) {
            $arr_code = array();
            for ($i = 0; $i < 200; $i++) {
                $arr_code[] = "TEST_{$t}_{$i}";
            }

            self::insert($t, $arr_code, '2013-07-21', date('Y-m'));
        }

        return false;
    }
}
