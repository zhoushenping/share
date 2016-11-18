<?php

/**
 * Created by PhpStorm.
 * User: shenping zhou
 * Date: 2015/5/28
 * Time: 19:42
 * 管理后台专用  不要将平时用到的方法写到这里面
 */
class AdminOasUsers
{
    static function getUserList($where = array(), $start = 0, $limit = '')
    {
        filterInput($where);
        $sql = "select * from `oas_users`  where 1";

        if ($where['uid'])
        {
            $sql .= "and  `uid` = '{$where['uid']}'";
        }

        if ($where['oas_uid'])
        {
            $sql .= " and `oas_uid` = '{$where['oas_uid']}'";
        }

        if ($where['name'])
        {
            $sql .= " and `name` = '{$where['name']}'";
        }

        if ($where['sp_promote_id'])
        {
            $sql .= " and `sp_promote_id` = '{$where['sp_promote_id']}'";
        }

        if ($where['email'])
        {
            $sql .= " and `email` = '{$where['email']}'";
        }

        if ($where['time1'])
        {
            $sql .= " and  `time` >= " . $where['time1'];
        }
        if ($where['time2'])
        {
            $sql .= " and `time` <" . $where['time2'];
        }
        if ($where['last_login1'])
        {
            $sql .= " and `last_login` >= " . $where['last_login1'];
        }
        if ($where['last_login2'])
        {
            $sql .= " and `last_login` < " . $where['last_login2'];
        }

        $sql .= " order by `id` desc ";

        if ($limit)
        {
            $sql .= " limit " . $start . "," . $limit;
        }

        return self::$db->query($sql);
    }

    static public function getUserListCount($where = array())
    {
        filterInput($where);
        $sql = "select count(*) as `cc` from `oas_users` where 1 ";

        if ($where['uid'])
        {
            $sql .= " and `uid` = '{$where['uid']}'";
        }

        if ($where['oas_uid'])
        {
            if ($where['uid'])
            {
                $sql .= " and `oas_uid` = '" . $where['oas_uid'] . "'";
            }
        }

        if ($where['name'])
        {
            $sql .= " and `name` = '" . $where['name'] . "'";
        }

        if ($where['sp_promote_id'] != "")
        {
            $sql .= " and `sp_promote_id` = '" . $where['sp_promote_id'] . "'";
        }

        if ($where['email'])
        {
            $sql .= " and `email` = '" . $where['email'] . "'";
        }

        if ($where['time1'])
        {
            $sql .= " and  `time` >= " . $where['time1'];
        }
        if ($where['time2'])
        {
            $sql .= " and `time` <" . $where['time2'];
        }
        if ($where['last_login1'])
        {
            $sql .= " and `last_login` >= " . $where['last_login1'];
        }
        if ($where['last_login2'])
        {
            $sql .= " and `last_login` < " . $where['last_login2'];
        }

        $rs = DBhandle::query($sql);

        return $rs[0]['cc'];
    }
}