<?

class RecallSelfBonus
{
    //获取最高等级的流失角色对应的奖励的信息
    static function getMaxLostBonusInfo($uid)
    {
        $maxLostRecord = self::getMaxLostRecord($uid);
        $sid           = $maxLostRecord['server_sid'];
        $grade         = $maxLostRecord['grade'];

        //如果自己已经领过$arr_type中的码   则不能再领同一类别的码  返回同一类别已有的码
        $existCode = RecallCode::getExistCode($uid, RecallConfig::$type_MaxGradeBonus);
        if ($existCode != '') {
            return array(
                'sid'   => $sid,
                'role'  => Game::getRoleName($uid, $sid),
                'grade' => $grade,
                'bonus' => $existCode,
            );
        }

        $type  = myArray::getNearestVal(RecallConfig::$config_MaxGradeBonus, $grade);
        $bonus = ($type === false) ? '' : (RecallCode::getCode($uid, "grade{$type}"));

        return array(
            'sid'   => $sid,
            'role'  => Game::getRoleName($uid, $sid),
            'grade' => $grade,
            'bonus' => $bonus,
        );
    }

    //获取流失角色中最大的记录
    static function getMaxLostRecord($uid)
    {
        $temp = array();
        foreach (PlayGameLog::getPlayRecordForMultiUser(GetUidAuto::getRelatedUids($uid), 2) as $item) {
            //只考虑已经流失的角色
            if (Time::getSleepDays($item['m_time']) >= RecallConfig::lostDays
                && $item['grade'] >= RecallConfig::lostGrade
            ) {
                $temp[] = $item;
            };
        }

        return $temp[0];
    }

    static function getChargeBonusCode($uid, $coins = 0)
    {
        //如果自己已经领过$arr_type中的码   则不能再领同一类别的码  返回同一类别已有的码
        $existCode = RecallCode::getExistCode($uid, RecallConfig::$type_SelfChargeBonus);
        if ($existCode != '') {
            return $existCode;
        }

        return RecallCode::getCode($uid, self::getSelfChargeBonusType($coins));
    }

    static function getSelfChargeBonusType($coins)
    {
        $coins = (int)$coins;
        foreach (RecallConfig::$config_SelfChargeBonus as $type => $arr) {
            if ($coins >= $arr[0] && $coins <= $arr[1]) {
                return $type;
            }
        }

        return false;
    }
}
