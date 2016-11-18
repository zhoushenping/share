<?php

/**
 * Created by PhpStorm.
 * User: shenping zhou
 * Date: 2016/5/9
 * Time: 17:09
 * 此类是码的管理类
 */
class RecallStatis
{
    const table = 'recall_code';
    
    static function allStatis()
    {
        return DBHandle::select(
            self::table,
            "1 GROUP BY `type` ORDER BY `type`",
            "`type`,count(*) AS c"
        );
    }
    
    static function usedStatis()
    {
        return DBHandle::select(
            self::table,
            "`uid` IS NOT NULL GROUP BY `type` ORDER BY `type`",
            "`type`,count(*) AS c"
        );
    }
    
    static function dailyStatis()
    {
        return DBHandle::select(
            self::table,
            "`uid` IS NOT NULL GROUP BY `date`,`type` ORDER BY `date` DESC,`type`",
            "`date`,`type`,count(*) AS c"
        );
    }
}
