<?php
/**
 * Created by PhpStorm.
 * User: shenping zhou
 * Date: 2015/5/28
 * Time: 19:24
 * 管理后台专用
 */
class AdminOasUserPlayed
{
    static function getCount($sid = 0, $uid = 0)
    {
        String::_filterNoNumber($sid);
        String::_filterNoNumber($uid);
        $sql = "SELECT COUNT(*) AS cc FROM `user_played` WHERE 1";

        if (!empty($sid)) $sql .= " AND `server_sid` = $sid";
        if (!empty($uid)) $sql .= " AND `uid` = {$uid}";
        $rs = DBHandle::query($sql);

        return $rs[0]['cc'];
    }

    static function getUserServer($sid = 0, $uid = 0, $start = 0, $limit = 1000)
    {
        String::_getInt($sid);
        String::_getInt($uid);
        String::_getInt($start);
        String::_getInt($limit);

        $sql = "SELECT * FROM `user_played` WHERE 1";
        if (!empty($sid)) $sql .= " AND `server_sid` = $sid";
        if (!empty($uid)) $sql .= " AND `uid` = {$uid}";

        $sql .= " ORDER BY `id` DESC";
        $sql .= " LIMIT {$start},{$limit}";

        return DBHandle::query($sql);
    }
}