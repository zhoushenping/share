<?

class ThreeYearSign
{
    const table = 'three_year_sign_record';

    //每人每天最多可以签到1次
    public static function canSign($uid, $date)
    {
        if (!DEVELOP_MODE) {
            if (time() < ThreeYearSignConfig::getMinSignTime() || time() > ThreeYearSignConfig::getMaxSignTime()) {
                return false;
            }
        }

        $rs      = self::getRecord($uid);
        $counter = 0;
        foreach ($rs as $item) {
            if (strtotime($item['date']) == strtotime($date)) {
                $counter++;
            }
        }

        return ($counter < 1);
    }

    public static function writeRecord($uid, $date)
    {
        String::_filterNoNumber($uid);
        if ($uid == '') {
            return false;
        }

        $arr = array(
            'uid'  => $uid,
            'time' => time(),
            'date' => $date,
        );

        $ret = DBHandle::MyInsert(self::table, Mysql::makeInsertString($arr));
        self::getRecord($uid, true);//刷新当前uid对应的结果集缓存
        return $ret;
    }

    public static function getRecord($uid, $flush = false)
    {
        static $ret = array();
        static $cache_status = array();
        String::_filterNoNumber($uid);
        if ($uid == '') {
            return array();
        }

        if ($flush || $cache_status[$uid] != 1) {
            $ret[$uid]          = DBHandle::select(self::table, "`uid`=$uid ORDER BY `time` DESC");
            $cache_status[$uid] = 1;
        }

        return $ret[$uid];
    }

    //返回的结构$ret['2016-05'][] = '2016-05-10'
    public static function getSignedDate($uid)
    {
        $ret = array();
        foreach (self::getRecord($uid) as $item) {
            $ret[substr($item['date'], 0, 7)][] = $item['date'];
        }

        return $ret;
    }

    //获得的领码类型 按月分组
    //返回的结构$ret['2016-05']= array('sign7','sign15')
    public static function getBonusTypes($uid)
    {
        $ret        = array();
        $dateConfig = ThreeYearSignConfig::$signDateConfig;
        foreach (self::getSignedDate($uid) as $month => $dates) {
            $i = 0;
            foreach ($dates as $d) {
                $i++;
                if (in_array($i, $dateConfig)) {
                    $ret[$month][] = "sign{$i}";
                }
            }
        }

        return $ret;
    }

    //已经用掉的领码类型 按月分组
    //返回的结构$ret['2016-05']= array('sign7','sign15')
    public static function getUsedTypes($uid)
    {
        $ret = array();
        foreach (ThreeYearSignCode::getUserRecord($uid) as $item) {
            $ret[substr($item['date'], 0, 7)][] = $item['type'];
        }

        return $ret;
    }

    //剩余可用的领码类型 按月分组
    //返回的结构$ret['2016-05']= array('sign7','sign15')
    public static function getValidTypes($uid)
    {
        $ret       = array();
        $usedTypes = self::getUsedTypes($uid);
        foreach (self::getBonusTypes($uid) as $month => $month_types) {
            foreach ($month_types as $t) {
                if ($usedTypes[$month] == array() || in_array($t, $usedTypes[$month]) == false) {
                    $ret[$month][] = $t;
                }
            }
        }

        return $ret;
    }

    public static function getSignCount($uid, $month_r)
    {
        $res = self::getSignedDate($uid);
        $ret = 0;
        foreach ($res as $month => $days) {
            if ($month_r == 'this' && $month != date('Y-m')) {
                continue;
            }

            $ret += count($days);
        }

        return $ret;
    }

    public static function getDailyReport()
    {
        $ret = array();
        $rs  = DBHandle::select(self::table, "1 GROUP BY `date`", '`date`,COUNT(*) AS c');
        foreach ($rs as $item) {
            $ret[$item['date']] = $item['c'];
        }
        krsort($ret);

        return $ret;
    }

    //统计方法8
    public static function statis8($date, $count_r)
    {
        String::_filterNoNumber($count_r);
        $sql = "SELECT COUNT(*) AS c FROM "
               . self::table
               . " WHERE left(`date`,7)=left('$date',7) AND `date`<='$date' GROUP BY `uid`";
        $sql = "SELECT COUNT(*) as B FROM ($sql) t0  WHERE t0.c>=$count_r;";

        $rs = DBHandle::query($sql);

        return $rs[0]['B'];
    }

    public static function statis10($month_r)
    {
        $sql = "SELECT COUNT(*) AS c FROM " . self::table . " WHERE left(`date`,7)='$month_r' GROUP BY `uid`";
        $sql = "SELECT t0.c as A,COUNT(*) as B FROM ($sql) t0  GROUP BY t0.c ORDER BY t0.c;";

        return DBHandle::query($sql);
    }
}
