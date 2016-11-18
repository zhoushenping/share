<?php

/**
 * Created by PhpStorm.
 * User: shenping zhou
 * Date: 2015/5/27
 * Time: 16:49
 * 滚服判断逻辑
 */
class Roll
{
    static $info = array();

    static function getOtype($isFromAd, $uid, $sidToPlay, $sid_r)
    {
        $lastSid = PlayGameRecord::getLastSid($uid);
        if ($lastSid == 0)  //新玩家
        {
            $ret = $isFromAd ? 1 : 2;//广告新增与自然新增
        }
        else
        {
            //老玩家
            if (PlayGameRecord::isSidPlayed($uid, $sidToPlay) == false) //将要玩的服 之前没玩过 = 滚服了
            {
                if ($_GET['roll'] == 'beidong') //新的被动滚服
                {
                    $ret = $isFromAd ? 5 : 3;//广告被动滚服和自然被动滚服
                }
                else
                {
                    if (ServerNew::isVisibleServer($sid_r))
                    {
                        $ret = 4;//主动滚服    主动滚服的一个必要条件就是$sid_r有效
                    }
                    else
                    {
                        $ret = $isFromAd ? 5 : 3;//广告被动滚服和自然被动滚服
                    }
                }
            }
            else
            {
                $ret = 0;//没有滚服
            }
        }

        return $ret;
    }

    //判断玩家在sid服玩  是否达到了滚服条件
    //如果sid为0 判断其在最后一次玩的服中是否达到了滚服条件
    static function readyToRoll($uid, $sid = 0, $isAdUser = false)
    {
        global $_GAME_ROLL_SERVER_RULES;

        if ($sid == 0) $sid = PlayGameRecord::getLastSid($uid);

        $playTime    = PlayGameRecord::getLastPlayTime($uid, $sid);
        $grade       = PlayGameLog::getGrade($uid, $sid);
        $daysNotPlay = Time::getSleepDays($playTime);
        $ret         = false;

        foreach ($_GAME_ROLL_SERVER_RULES as $item)
        {
            if (
                $item[RSR_NEED_FROM_AD] == $isAdUser
                and $grade >= $item[RSR_GRADE_FROM]
                and $grade <= $item[RSR_GRADE_TO]
                and ($daysNotPlay >= $item[RSR_UNACTIVE_DAY])
            )
            {
                $ret = true;
                break;
            }
        }

        self::$info['uid']          = $uid;
        self::$info['sid']          = $sid;
        self::$info['promote']      = Promote::getPromote();
        self::$info['isAdUser']     = $isAdUser ? 1 : 0;
        self::$info['grade']        = $grade;
        self::$info['lastPlayTime'] = $playTime;
        self::$info['daysNotPlay']  = $daysNotPlay;
        self::$info['roll']         = $ret ? 1 : 0;

        self::deal_debug($isAdUser, $grade, $daysNotPlay, $ret);//处理管理滚服的debug请求

        return $ret;
    }

    static function deal_debug($isAdUser, $grade, $daysNotPlay, $ret)
    {
        if ($_GET['debugroll'])
        {
            $arr_debug = array(
                'isAdUser'    => $isAdUser,
                'grade'       => $grade,
                'daysNotPlay' => $daysNotPlay,
                'willRoll'    => $ret,
            );
            echo "<pre/>";
            print_r($arr_debug);
            die;
        }
    }
}

?>