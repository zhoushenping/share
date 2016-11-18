<?

class ChristmasWishBonus
{
    const table = 'christmas_bonus';

    static function tryGetBonus($uid, $date, $time, $type)
    {
        String::_filterNoNormal($type);
        if (ChristmasWishRecord::tryChance($uid, $date, $time)) {
            $arr = array(
                'uid'  => $uid,
                'date' => $date,
                'time' => $time,
            );

            DBHandle::update(self::table, Mysql::makeInsertString($arr), "`type`='$type' AND `uid` IS NULL");

            return 1;
        }
        else {
            return 0;
        }
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

    static function canGetType($uid, $type)
    {
        $ret = true;
        foreach (self::getUserRecord($uid) as $item) {
            if ($item['type'] == $type) {
                $ret = false;
            }
        }

        return $ret;
    }

    //玩家今天是否可以领奖
    static function canGetBonusToday($uid, $date)
    {
        $ret = false;

        foreach (ChristmasWishRecord::getUserRecord($uid) as $item) {
            //该条许愿尚未尝试抽奖且是当天的
            if ($item['tried'] == 0 && $date == $item['date']) {
                $ret = true;
            }
        }

        return $ret;
    }
}
