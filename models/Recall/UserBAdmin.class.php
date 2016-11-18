<?php

/**
 * Created by PhpStorm.
 * User: shenping zhou
 * Date: 2016/5/9
 * Time: 17:09
 * 此类是码的管理类
 */
class RecallUserBAdmin
{
    const table = 'recall_userlist_b';

    private static function getMany($start = 0, $limit = 10000)
    {
        $ret = array();
        $rs  = DBHandle::select(self::table, "1 limit $start,$limit");
        foreach ($rs as $item) {
            $ret[] = $item['uid'];
        }

        return $ret;
    }

    //手动加记录
    static function add()
    {
        $uid_r = $_REQUEST['uid_r'];

        if ($uid_r == '') {
            return false;
        }

        if (DEVELOP_MODE) {
            preg_match_all('/[a-z0-9A-Z]{4,30}/', $uid_r, $match);
        }

        if (!DEVELOP_MODE) {
            preg_match_all('/[a-z0-9A-Z]{7,30}/', $uid_r, $match);
        }

        $arr_uid = $match[0];

        return self::insert($arr_uid);
    }

    //去重并插入
    private static function insert($arr_uid)
    {
        for ($i = 0; $i < 1000; $i++) {
            $uid_exist = self::getMany($i * 10000);

            if ($uid_exist == array()) {
                break;
            }

            $arr_uid = array_diff($arr_uid, $uid_exist);
        }

        $data = array();

        foreach ($arr_uid as $v) {
            $data[] = array($v);
        }

        return DBHandle::insertMulti(self::table, array('uid'), $data);
    }
}
