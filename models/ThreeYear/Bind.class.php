<?

class ThreeYearBind
{
    const table = 'three_year_bind';

    static function getUserBind($uid)
    {
        $rs = self::getUserRecord($uid);

        return !empty($rs[0]['key']) ? $rs[0]['key'] : '';
    }

    static function updateUserBind($uid, $key)
    {
        String::_filterNoNumber($uid);
        if ($uid == '') {
            return false;
        }

        $key  = addslashes($key);
        $time = time();

        return DBHandle::update(self::table, "`key`='$key',`time`=$time", "`uid`=$uid");
    }

    static function insertUserBind($uid, $key)
    {
        $arr = array(
            'uid'  => $uid,
            'key'  => $key,
            'time' => time(),
        );
        DBHandle::MyInsert(self::table, Mysql::makeInsertString($arr));
    }

    static function getUserRecord($uid)
    {
        String::_filterNoNumber($uid);
        $ret = array();
        if ($uid == '') {
            return $ret;
        }

        return DBHandle::select(self::table, "`uid`=$uid");
    }

    static function isRightKey($key)
    {
        return 1 == preg_match('/^\d{1,6}_\d{3,30}$/', $key);//22_123456
    }
}
