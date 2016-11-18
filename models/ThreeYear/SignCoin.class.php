<?

//神曲币对应的类
class ThreeYearSignCoin
{
    const table = 'three_year_sign_coin';

    static function updateUserCoins($uid, $coins)
    {
        String::_filterNoNumber($uid);
        String::_filterNoNumber($coins);
        if ($uid == '' || $coins == '') {
            return false;
        }

        $userCoins = self::getUserCoins($uid);

        if ($userCoins == 0) {
            $arr = array(
                'uid'    => $uid,
                'coins'  => $coins,
                'c_time' => time(),
                'm_time' => time(),
            );
            DBHandle::MyInsert(self::table, Mysql::makeInsertString($arr));
        }
        else {
            $arr = array(
                'coins'  => $coins,
                'm_time' => time(),
            );
            DBHandle::update(self::table, Mysql::makeInsertString($arr), "`uid`=$uid");
        }

        return self::getUserCoins($uid, true);
    }

    static function getUserCoins($uid, $flush = false)
    {
        static $ret = array();
        static $cache_status = array();
        String::_filterNoNumber($uid);
        if ($uid == '') {
            return 0;
        }

        if ($flush || $cache_status[$uid] != 1) {
            $rs = DBHandle::select(self::table, "`uid`=$uid");

            $ret[$uid] = (!empty($rs)) ? $rs[0]['coins'] : 0;

            $cache_status[$uid] = 1;
        }

        return $ret[$uid];
    }
}
