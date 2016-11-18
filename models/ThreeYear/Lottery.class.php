<?php

/**
 * Created by PhpStorm.
 * User: shenping zhou
 * Date: 2016/5/9
 * Time: 16:06
 */
class ThreeYearLottery
{
    const useMem = true;

    //尝试抽奖
    public static function tryLottery($uid)
    {
        Log2::save_run_log('每次尝试抽奖时都重新获取当日状态', 'lottery_all');
        ThreeYearLotteryCode::getDailyReport(true);
        $validChance = ThreeYearChance::getValidChance($uid);
        if ($validChance == false) {
            return array(
                'status' => 'fail',
                'msg'    => 'no valid chance to lottery',
            );
        }
        $chance = $validChance[0];
        $type   = self::getType($uid);
        $record = ThreeYearLotteryCode::getCode($uid, $chance, $type);
        if ($record == array()) {
            return array(
                'status' => 'fail',
                'type'   => $type,
                'msg'    => 'failed to get code of this type',
            );
        }

        return array(
            'status'   => 'ok',
            'type'     => $type,
            'typeName' => ThreeYearLotteryConfig::getTypeName($type),
            'code'     => '',
        );
    }

    //执行抽奖 按照公共配置和用户的私有信息 按几率计算他可以得到什么类型的码
    public static function getType($uid)
    {
        $myCount     = ThreeYearLotteryCode::getMyCount($uid);
        $config      = ThreeYearLotteryConfig::getLotteryBonusConfig();
        $bonus_limit = ThreeYearLotteryConfig::getLotteryBonusLimit();//读取关于奖项的限制

        foreach ($config as $t => $null) {
            if (!isset($bonus_limit[$t])) {
                continue;
            }

            $limit   = $bonus_limit[$t];
            $total_t = ThreeYearLotteryCode::getCount($t);//当前类型的码总共已经被领了多少个
            $daily_t = ThreeYearLotteryCode::getTodayCount($t);//当前类型的码今天被领了多少个

            if (isset($limit['mycount']) && $myCount < $limit['mycount']) {
                unset($config[$t]);
            }
            if (isset($limit['total']) && $total_t == $limit['total']) {
                unset($config[$t]);
            }
            if (isset($limit['daily']) && $daily_t == $limit['daily']) {
                unset($config[$t]);
            }
        }

        $box = array();
        foreach ($config as $type => $item) {
            $n = $item['rate'];
            for ($i = 1; $i <= $n; $i++) {
                $box[] = $type;
            }
        }

        shuffle($box);

        return $box[0];
    }

    public static function getBonusRecord($uid)
    {
        $ret = array();
        $rs  = ($uid == 'all') ? ThreeYearLotteryCode::get100Record() : ThreeYearLotteryCode::getUserRecord($uid);
        foreach ($rs as $item) {
            if ($item['code'] == '') {
                continue;
            }

            $insert = array();
            if ($uid == 'all') {
                $insert['id']       = $item['id'];
                $insert['userName'] = String::getHiddenUname($item['uname']);
            }
            else {
                $insert             = $item;
                $insert['time_str'] = date('Y-m-d H:i', $item['time']);
                $insert['expire']   = date('Y-m-d', $item['expire']);
            }
            $insert['bonus_name'] = ThreeYearLotteryConfig::getTypeName($item['type']);
            $ret[]                = $insert;
        }

        return $ret;
    }

    public static function getLock($uid)
    {
        if (self::useMem) {
            $key = "lottery{$uid}";
            $val = Mem::get($key);

            if ($val == '') {
                Mem::set($key, 1, 300);

                return 1;
            }
            else {
                return false;
            }
        }
        else {
            return 1;
        }
    }

    public static function releaseLock($uid)
    {
        if (self::useMem) {
            $key = "lottery{$uid}";
            Mem::delete($key, 0);
        }

        return false;
    }
}
