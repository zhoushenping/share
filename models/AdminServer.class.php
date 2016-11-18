<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 15-5-24
 * Time: 下午7:28
 * 以下方法都只有admin后台才会触发，通常不用理会
 */
class AdminServer
{
    const table = 'server_list';

    static function selectAll()
    {
        static $serverlist = null;
        if (is_null($serverlist))
        {
            $serverlist = DBHandle::select(self::table);
        }

        return $serverlist;
    }

    static function selectOne($sid, $id_type = 'server_sid')
    {
        $ret = array();
        String::_filterNoNumber($sid);

        if (empty($sid)) return $ret;
        foreach (self::selectAll() as $item)
        {
            if ($item[$id_type] == $sid) return $item;
        }

        return $ret;
    }

//获取存在的字段
    static function getValidColumn()
    {
        static $ret = array();

        if (empty($ret))
        {
            $temp = self::selectAll();
            foreach ($temp[0] as $k => $v) $ret[] = $k;
            $ret = array_unique($ret);
        }

        return $ret;
    }

    static function addServer($serverinfo, $operator)
    {
        $sid          = String::filterNoNumber($serverinfo['server_sid']);
        $valid_column = self::getValidColumn();//事实上存在的字段
        $insert       = array();//待更新的数组
        $oldInfo      = self::selectOne($sid);

        if (empty($sid) || !empty($oldInfo)) return false;

        $serverinfo['create_time'] = time();
        $serverinfo['modify_time'] = time();
        $serverinfo['operator']    = $operator;

        foreach ($serverinfo as $k => $v)
        {
            if (!in_array($k, $valid_column)) continue;//不插入不存在的字段
            $insert[$k] = trim($v);
        }

        return DBHandle::MyInsert(self::table, Mysql::makeInsertString($insert));
    }

    static function updateServer($serverinfo, $operator)
    {
        $sid          = String::filterNoNumber($serverinfo['server_sid']);
        $update       = array();//待更新的数组
        $valid_column = self::getValidColumn();//事实上存在的字段
        $oldInfo      = self::selectOne($sid);

        if (empty($sid) || empty($oldInfo)) return false;

        foreach ($serverinfo as $k => $v)
        {
            $v = trim($v);
            if ($oldInfo[$k] != $v) $update[$k] = $v;//只可能更新和原有值不同的字段
        }

        $update['modify_time'] = time();
        $update['operator']    = $operator;

        foreach ($update as $k => $v)
        {
            if (!in_array($k, $valid_column)) unset($update[$k]);//不更新不存在的字段
        }

        return DBHandle::update(self::table, Mysql::makeInsertString($update), "`server_sid`=$sid");
    }

    //改变除了状态为2的服的状态
    static function setAllServerState($all = '', $operator)
    {
        if ($operator == '' || $all == '') return false;

        $new_valid = ($all == 'k') ? 1 : 0;
        $old_valid = ($all == 'k') ? 0 : 1;

        $arr = array(
            'valid'       => $new_valid,
            'operator'    => $operator,
            'modify_time' => time(),
        );

        return DBHandle::updateMulti(self::table, Mysql::makeInsertString($arr), "`valid`=$old_valid");
    }

    static function setServerState($v = '', $id, $operator = '')
    {
        String::_filterNoNumber($v);
        String::_filterNoNumber($id);

        if ($operator == '') return false;
        if (self::selectOne($id, 'server_id') == array()) return false;

        $arr = array(
            'valid'       => $v,
            'operator'    => $operator,
            'modify_time' => time(),
        );

        return DBHandle::update(self::table, Mysql::makeInsertString($arr), "`server_id`=$id");
    }

    static function openAll()
    {
        //todo
        //$sql = "";
        //DBHandle::execute($sql);
        self::deleteMem();
    }

    static function closeAll()
    {
        //todo
        //$sql = "";
        //DBHandle::execute($sql);
        self::deleteMem();
    }

    static function deleteSever($sid)
    {
        //todo
        //$sql = "";
        //DBHandle::execute($sql);
        self::deleteMem();
    }
}