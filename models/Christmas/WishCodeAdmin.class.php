<?php

/**
 * Created by PhpStorm.
 * User: shenping zhou
 * Date: 2016/5/9
 * Time: 17:09
 * 此类是码的管理类
 */
class ChristmasWishCodeAdmin
{
    public static function getTable()
    {
        return ChristmasWishBonus::table;
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

        return self::insert($type_r, Preg::matchCode($code_r));
    }

    //插入 会自动排重
    private static function insert($type, $arr_code)
    {
        String::_filterNoNormal($type);
        $data = array();

        foreach ($arr_code as $v) {
            $data[] = array($type, $v);
        }

        return DBHandle::insertMultiIgnore(self::getTable(), array('type', 'code'), $data);
    }

    //测试环境可以自动加码
    static function addAuto()
    {
        //lobr.oasgames.com/event/Christmas2016/admin/addCode.php?do=auto
        if (!DEVELOP_MODE || $_REQUEST['do'] != 'auto') {
            return false;
        }

        foreach (ChristmasWishBonusConfig::getConfig() as $item) {
            $arr_code = array();
            for ($i = 0; $i < 200; $i++) {
                $arr_code[] = "testcode_{$item['type']}_{$i}";
            }

            self::insert($t, $arr_code);
        }

        return false;
    }
}
