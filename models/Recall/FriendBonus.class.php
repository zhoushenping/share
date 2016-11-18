<?

class RecallFriendBonus
{
    static $friendActiveDates = array();

    //获取用户B们的登录行为给俺产生的奖励
    static function getBonus($uid_a, $type = 'play')
    {
        $rs_bonus = array();
        foreach (RecallRecord::getMyFriends($uid_a) as $uid_b) {
            //此项循环实际上最多3次
            $rs = ($type == 'play') ? (self::updatePlayBonus($uid_a, $uid_b)) :
                (self::updateChargeBonus($uid_a, $uid_b));
            foreach ($rs as $date => $dailyBonus) {
                foreach ($dailyBonus as $item) {
                    $rs_bonus[$date][] = $item;
                }
            }
        }
        krsort($rs_bonus);

        foreach ($rs_bonus as $d => &$arr) {
            usort($arr, "mysort_Friend_bounus");
        }

        return $rs_bonus;
    }

    static function updatePlayBonus($uid_a, $uid_b)
    {
        $ret            = array();
        $array_config   = RecallConfig::$B_active_days;
        $date_beFriends = date('Ymd', RecallRecord::getTimeRecalled($uid_a, $uid_b));//获得b被召回的日期

        $ret[$date_beFriends][] = array(
            'code'      => RecallCode::getCode($uid_b, 'be_friends'),
            'code_type' => 'be_friends',
        );

        $i                               = 0;
        $temp                            = RecallPlaygame::getActiveDates($uid_b);
        self::$friendActiveDates[$uid_b] = $temp;
        foreach ($temp as $date) {
            $i++;
            if (in_array($i, $array_config)) {
                $ret[$date][] = array(
                    'code_type' => "{$i}day",
                    'code'      => RecallCode::getCode($uid_b, "{$i}day"),
                );
            }
        }

        return $ret;
    }

    static function updateChargeBonus($uid_a, $uid_b)
    {
        $ret                 = array();
        $sum_coins           = 0;
        $coins_level_already = array();//已经生成码的钻数
        foreach (RecallPayment::getDailyCoins($uid_b) as $date => $daily_coins) {
            $sum_coins += $daily_coins;

            foreach (RecallConfig::$config_coins_roleB as $coins_level) {
                if ($sum_coins < $coins_level) {
                    continue;
                }
                //避免重复生成同一钻数级别的码
                if (in_array($coins_level, $coins_level_already)) {
                    continue;
                }
                $bonus_type            = "{$coins_level}coins";
                $ret[$date][]          = array(
                    'code_type' => $bonus_type,
                    'code'      => RecallCode::getCode($uid_b, $bonus_type),
                );
                $coins_level_already[] = $coins_level;
            }
        }

        return $ret;
    }
}
