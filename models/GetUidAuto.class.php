<?

class GetUidAuto
{
    const table = 'get_uid_auto';

    static function add($rs, $output_uid, $record_type = 0)
    {
        $oas_uid    = $rs['all_info']['id'];
        $fb_app_uid = ODP::getFBappUid($rs['all_info']['business_map']);
        $fb_sns_uid = $rs['all_info']['snsUid'];

        String::_filterNoNumber($oas_uid);
        String::_filterNoNumber($fb_app_uid);
        String::_filterNoNumber($fb_sns_uid);
        String::_filterNoNumber($output_uid);

        if ($oas_uid == '') return false;
        if ($output_uid == '') return false;

        $arr = array(
            'oas_uid'     => $oas_uid,
            'fb_app_uid'  => $fb_app_uid,
            'fb_sns_uid'  => $fb_sns_uid,
            'output_uid'  => $output_uid,
            'record_type' => $record_type,//记录的类型   类型的含义详见ODP类的getUidAuto方法
            'record_time' => time(),
        );

        if (self::get($oas_uid) == '') //不存在已有记录时  才执行插入操作 避免重复插入
        {
            DBHandle::MyInsert(self::table, Mysql::makeInsertString($arr));
            self::get($oas_uid, true);//刷新缓存
        }

        return $output_uid;
    }

    static function get($input_uid, $flush = false)
    {
        String::_filterNoNumber($input_uid);
        if ($input_uid == '') return '';

        static $status = array();
        static $ret = array();

        if ($flush || $status[$input_uid] == 0)     //当前process没有取过值  或者 收到刷新指令  则读取数据表
        {
            $rs = DBHandle::select(self::table, "`oas_uid` = $input_uid");

            $ret[$input_uid]    = $rs[0]['output_uid'];
            $status[$input_uid] = 1;
        }

        return $ret[$input_uid];
    }

    static function getRelated($uid)
    {
        String::_filterNoNumber($uid);
        if ($uid == '') return array();

        return DBHandle::select(self::table, "`oas_uid`=$uid OR `fb_app_uid`=$uid OR `fb_sns_uid`=$uid");
    }

    //获取当前uid实际可能涉及的几个uid
    static function getRelatedUids($uid)
    {
        static $ret = array();

        if (!isset($ret[$uid]))    //没有已知的结果集时 进行运算
        {
            $arr_uids = array($uid,);

            $rs = GetUidAuto::getRelated($uid);
            if ($rs != array())
            {
                //如果是facebook玩家，则将可能有的uid加入$arr_uids
                $arr_uids[] = $rs[0]['oas_uid'];
                $arr_uids[] = $rs[0]['fb_app_uid'];
                $arr_uids[] = $rs[0]['fb_sns_uid'];
            }
            sort($arr_uids);

            $ret[$uid] = array_unique($arr_uids);
        }

        return $ret[$uid];
    }
}