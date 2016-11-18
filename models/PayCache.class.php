<?

class PayCache
{
    const table = 'pay_cache';

    public static function updateCache($arr_uids)
    {
        if (DEVELOP_MODE) {
            return false;
        }

        $info = Payment::getPayRecord($arr_uids);

        if (empty($info)) {
            return false;
        }

        self::deleteOldCache($arr_uids);
        self::inserNewCache($info);

        return false;
    }

    public static function getRecordFromCache($arr_uids)
    {
        $arr_uids = myArray::trimEmptyUid($arr_uids);
        $str_uids = implode(',', $arr_uids);

        $rs = DBHandle::select(self::table, "`uid` IN ($str_uids) ORDER BY `time` DESC");
        foreach ($rs as &$item) {
            if ($item['time'] < strtotime('2000-01-01')) {
                $item['time'] = strtotime($item['time']);
            }

            $item['str_date'] = date('Y-m-d H:i:s', $item['time']);
        }

        return $rs;
    }

    public static function deleteOldCache($arr_uids)
    {
        $arr_uids = myArray::trimEmptyUid($arr_uids);
        $str_uids = implode(',', $arr_uids);
        DBHandle::execute("DELETE FROM " . self::table . " WHERE `uid` IN ($str_uids)");
    }

    public static function inserNewCache($info)
    {
        $arr_columns = array('uid', 'coins', 'time', 'status',);//字段需要和data中的按顺序对应
        $data        = array();
        foreach ($info as $item) {
            $item['status'] = ($item['status']) ? 1 : 0;
            $data[]         = array($item['uid'], $item['coins'], $item['time'], $item['status'],);
        }

        DBHandle::insertMulti(self::table, $arr_columns, $data);
    }
}
