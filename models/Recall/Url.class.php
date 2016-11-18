<?php

/**
 * Created by PhpStorm.
 * User: shenping zhou
 * Date: 2016/1/21
 * Time: 16:54
 * A类角色
 */
class RecallUrl
{
    static $table = 'recall_url';

    static function makeURL($uid)
    {
        $id = self::getID($uid);

        return str_replace("[id]", $id, RecallConfig::url_template);
    }

    static function makeURLByID($id)
    {
        return str_replace("[id]", $id, RecallConfig::url_template);
    }

    private static function getID($uid)
    {
        $old_ID = self::getOldID($uid);

        return ($old_ID != 0) ? $old_ID : (self::getNewID($uid));
    }

    private static function getOldID($uid)
    {
        $ret = 0;

        String::_filterNoNumber($uid);
        $rs = DBHandle::select(self::$table, "`uid`=$uid");

        if ($rs != array()) {
            $ret = $rs[0]['id'];
        }

        return $ret;
    }

    private static function getNewID($uid)
    {
        global $_CURRENT_TIME;
        String::_filterNoNumber($uid);

        $arr = array(
            'uid'  => $uid,
            'nick' => RecallPlaygame::getMaxNick($uid),
            'time' => $_CURRENT_TIME,
            'date' => date('Y-m-d', $_CURRENT_TIME),
        );

        DBHandle::MyInsert(self::$table, Mysql::makeInsertString($arr));

        return self::getOldID($uid);
    }

    static function getRecallerInfo()
    {
        $id = String::filterNoNumber($_GET['id']);
        if ($id == '') {
            return array();
        }
        $rs = DBHandle::select(self::$table, "`id`=$id");

        return $rs[0];
    }

    //根据历史记录判断是到app还是到官网玩
    static function getUrlToPlay($uid, $sid)
    {
        $platform = 'home';//默认会去官网玩
        foreach (OasUserPlayed::getAllRecords($uid) as $item) {
            if ($item['server_sid'] == $sid) {
                $platform = ($item['login_type'] == 2) ? 'app' : 'home';
            }
        }

        $para = "?server_id=$sid&login_through=recall_page";

        return ($platform == 'home') ? "/fbapp/oasplay.php{$para}" : FB_URL . $para;
    }

    static function updateEmptyDate()
    {
        $rs = DBHandle::select(self::$table, "`date` IS NULL");

        if ($rs == array()) {
            return false;
        }

        foreach ($rs as $item) {
            $date = date('Y-m-d', $item['time']);
            DBHandle::update(self::$table, "`date`='$date'", "`uid`={$item['uid']}");
        }

        return true;
    }
}
