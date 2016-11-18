<?

class ChristmasWishRecord
{
    const table = 'christmas_wish';

    static function tryInsertWishRecord($arr)
    {
        $arr_columns = array();
        foreach ($arr as $k => $v) {
            $arr_columns[] = $k;
        }

        $arr_data = array($arr,);

        return DBHandle::insertMultiIgnore(self::table, $arr_columns, $arr_data);
    }

    static function getUserRecord($uid)
    {
        String::_filterNoNumber($uid);

        static $ret = array();

        if (!isset($ret[$uid])) {
            $ret[$uid] = DBHandle::select(self::table, "`uid`=$uid ORDER BY `date` DESC");
        }

        return $ret[$uid];
    }

    static function getWishedDate($uid)
    {
        $ret = array();
        foreach (self::getUserRecord($uid) as $item) {
            $ret[] = $item['date'];
        }

        return $ret;
    }

    static function haveWishedToday($uid, $date)
    {
        $ret = false;
        foreach (self::getUserRecord($uid) as $item) {
            if ($date == $item['date']) {
                $ret = true;
            }
        }

        return $ret;
    }

    static function getMultiRecord($count = 200)
    {
        String::_filterNoNumber($count);

        return DBHandle::select(
            self::table,
            "`verified_level`>0 ORDER BY `verified_level` DESC,`time` DESC LIMIT 0,$count",
            "`uname`,`msg`"
        );
    }

    static function tryChance($uid, $date, $time)
    {
        String::_filterNoNumber($uid);
        $date = date('Y-m-d', strtotime($date));
        $ret  = rand(1, 100) <= 45 ? 1 : 0;
        $arr  = array(
            'tried'        => 1,
            'tried_result' => $ret,
            'tried_time'   => $time,
        );

        DBHandle::update(self::table, Mysql::makeInsertString($arr), "`uid`=$uid AND `date`='$date'");

        return $ret;
    }

    static function getRecord($where, $str_columns = '*')
    {
        return DBHandle::select(self::table, $where, $str_columns);
    }

    static function dealVerify($change)
    {
        if (empty($change)) {
            return false;
        }
        foreach ($change as $id => $level) {
            String::_filterNoNumber($id);
            String::_filterNoNumber($level);
            DBHandle::update(self::table, "`verified_level`=$level,`verified`=1", "`id`=$id");
        }
        Browser::callback(array('status' => 'ok'));
    }
}
