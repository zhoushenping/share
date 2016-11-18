<?php

/**
 * Created by PhpStorm.
 * User: shenping zhou
 * Date: 2016/1/21
 * Time: 16:54
 * A类角色
 */
class RecallRole
{
    static $tableB = 'recall_userlist_b';//可以作为角色B的uid的列表

    //无坏账且在$tableB中即可
    static function canBeRoleB($uid)
    {
        String::_filterNoNumber($uid);
        if ($uid == '') {
            return false;
        }
        //查有没有坏账
        if (RecallPayment::hasNoChargeBack($uid) == false) {
            return false;
        }

        $str_uids = implode(",", GetUidAuto::getRelatedUids($uid));

        return (DBHandle::select(self::$tableB, "`uid` IN ($str_uids)") != array());
    }

    //可以作为角色B或者(达到了50级 且无坏账)
    static function canBeRoleA($uid)
    {
        $temp = self::canBeRoleB($uid);
        if ($temp) {
            return true;
        }//B为true时A肯定为true

        $arr_grade = array();
        foreach (GetUidAuto::getRelatedUids($uid) as $u) {
            $grade = PlayGameLog::getMaxGrade($u);
            if ($grade >= RecallConfig::grade_canBe_A) {
                $arr_grade[] = 1;
            }
        }

        return empty($arr_grade) ? false : RecallPayment::hasNoChargeBack($uid);//查有没有坏账;
    }
}
