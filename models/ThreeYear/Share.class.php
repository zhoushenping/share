<?

class ThreeYearShare
{
    const table = 'three_year_share';
    static $cached = false;

    //每人每天最多可以分享3次，避免一个人一天内多次分享造成刷屏
    public static function canShare($uid)
    {
        $counter = self::getTodayShareCount($uid);

        return ($counter < ThreeYearShareConfig::$maxShareCount);
    }

    //以下为数据库操作的方法

    public static function writeRecord($uid)
    {
        String::_filterNoNumber($uid);
        if ($uid == '') {
            return false;
        }
        $counter     = self::getTodayShareCount($uid);
        $have_chance = ($counter == 0 && self::canGetChance($uid) && ThreeYearChance::inTime());

        $data         = array(
            'uid'         => $uid,
            'time'        => time(),
            'date'        => date('Y-m-d'),
            'have_chance' => ($have_chance ? 1 : 0),
            'chance_used' => 0,
        );
        self::$cached = false;

        return DBHandle::MyInsert(self::table, Mysql::makeInsertString($data));
    }

    public static function getRecord($uid)
    {
        String::_filterNoNumber($uid);

        if ($uid == '') {
            return array();
        }

        static $ret = array();

        if (self::$cached == false) {
            self::$cached = true;
            $ret          = DBHandle::select(self::table, "`uid`=$uid ORDER BY `time` DESC");
        }

        return $ret;
    }

    public static function getTodayShareCount($uid)
    {
        $rs      = self::getRecord($uid);
        $counter = 0;
        foreach ($rs as $item) {
            if ($item['date'] == date('Y-m-d')) {
                $counter++;
            }
        }

        return $counter;
    }

    //获取能够产生抽奖机会的分享日
    public static function getValidSharedDate($uid)
    {
        $ret = array();
        foreach (self::getRecord($uid) as $item) {
            if ($item['have_chance'] == 1) {
                $ret[] = $item['date'];
            }
        }

        return array_unique($ret);
    }

    public static function canGetChance($uid)
    {
        $relatedUids = GetUidAuto::getRelatedUids($uid);
        $arr_uids    = $relatedUids == false ? array($uid) : $relatedUids;
        $time_limit  = strtotime(ThreeYearChance::regDateLimit);

        foreach ($arr_uids as $id) {
            $time = PlayGameLog::getFirstPlayTime($id);
            if ($time > 0 && $time < $time_limit) {
                return true;
            }
        }

        return false;
    }

    public static function tryUpdateChance($uid, $chance)
    {
        $date0 = String::filterNoNumber($chance);
        if (strpos($chance, 'share') !== false) {
            foreach (self::getRecord($uid) as $item) {
                $date1 = String::filterNoNumber($item['date']);
                if ($item['have_chance'] == 1 && $date0 == $date1) {
                    DBHandle::update(self::table, "`chance_used`=1", "`id`={$item['id']}");
                    self::$cached = false;
                }
            }
        }
    }

    public static function getAllRecord($uid_related)
    {
        $uid_related = myArray::trimEmptyUid($uid_related);
        if (empty($uid_related)) {
            return array();
        }

        $str_uid = implode(',', $uid_related);

        return DBHandle::select(self::table, "`uid` IN ($str_uid)");
    }
    public static function doQuery($str_where, $str_columns = '*')
    {
        return DBHandle::select(self::table, $str_where, $str_columns);
    }
}
