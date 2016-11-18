<?

class ChristmasWishStatis
{
    static function allBonusStatis()
    {
        return DBHandle::select(
            ChristmasWishBonus::table,
            "1 GROUP BY `type` ORDER BY `type`",
            "`type`,count(*) AS c"
        );
    }

    static function usedBonusStatis()
    {
        return DBHandle::select(
            ChristmasWishBonus::table,
            "`uid` IS NOT NULL GROUP BY `type` ORDER BY `type`",
            "`type`,count(*) AS c"
        );
    }

    static function dailyUsedBonusStatis()
    {
        return DBHandle::select(
            ChristmasWishBonus::table,
            "`uid` IS NOT NULL GROUP BY `date`,`type` ORDER BY `date` DESC,`type`",
            "`date`,`type`,count(*) AS c"
        );
    }

    static function dailyWishStatis()
    {
        return DBHandle::select(
            ChristmasWishRecord::table,
            "1 GROUP BY `date`,`tried`,`tried_result` ORDER BY `date` DESC,`tried` DESC,`tried_result` DESC",
            "`date`,`tried`,`tried_result`,count(*) AS c"
        );
    }

    static function dailyBonusStatis()
    {
        return DBHandle::select(
            ChristmasWishBonus::table,
            "`date` IS NOT NULL GROUP BY `date`,`type` ORDER BY `date` DESC,`type` DESC",
            "`date`,`type`,count(*) AS c"
        );
    }
}
