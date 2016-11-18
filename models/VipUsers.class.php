<?

class VipUsers
{
    const VIPCORE_API_KEY = 'SJFOJ293JDFOAJSOF12';
    const VIPCORE_URL     = '//vipcore.oasgames.com/';//测试 //test.vip.oasgames.com/   10.1.5.2
    const table           = 'vip_users';

    static function getVipLevel($uid)
    {
        $rs = self::getVipInfo($uid);

        return (int)($rs[0]['userinfo']['vip_level']);
    }

    static function doSign($uid)
    {
        $lang      = SYSTEM_LANG;
        $signature = md5($lang . $uid . self::VIPCORE_API_KEY);
        $url       = self::VIPCORE_URL . "api/vip_user_sign.php?uid=$uid&lang=$lang&signature=$signature";

        return CURL::getJson($url);
    }

    static function isTodaySigned($uid)
    {
        $rs = self::getSignInfo($uid);

        return $rs['today_sign_flag'];
    }

    static function getSignRecord($uid)
    {
        $rs = self::getSignInfo($uid);

        return $rs['sign_info'];
    }

    static function getSignInfo($uid)
    {
        static $ret;

        if ($ret[$uid] == '') {
            $lang      = SYSTEM_LANG;
            $signature = md5($lang . $uid . self::VIPCORE_API_KEY);
            $url       = self::VIPCORE_URL . "api/vip_user_sign_info.php?uid=$uid&lang=$lang&signature=$signature";

            $ret[$uid] = CURL::getJson($url);
        }

        return $ret[$uid];
    }

    static function getVipInfo($uid)
    {
        static $ret;

        if ($ret[$uid] == '') {
            $sign = md5($uid . self::VIPCORE_API_KEY);
            $url  = self::VIPCORE_URL . "api/vip_userinfo.php?uid={$uid}&signature={$sign}";

            $ret[$uid] = CURL::getJson($url);
        }

        return $ret[$uid];
    }

    //获取玩家的积分
    static function getCredit($uid)
    {
        $rs = self::getVipInfo($uid);

        return (int)($rs[0]['userinfo']['credit_value']);
    }

    static function makeSignUrl($uid)
    {
        return "/oasplay/api/sign.php?uid=$uid&sign=" . md5($uid . self::VIPCORE_API_KEY);
    }

    static function treatByDB($uid)
    {
        $rs = DBHandle::select(self::table);
        foreach ($rs as $item) {
            if ($item['status'] == 1 && $item['uid'] == $uid) {
                return true;
            }
        }

        return false;
    }

    static function isVip($chat_uid)
    {
        $rs = self::getRecord($chat_uid);

        return !empty($rs);
    }

    static function getRecord($chat_uid)
    {
        String::_filterNoNumber($chat_uid);
        if (empty($chat_uid)) {
            return false;
        }

        $relatedUids = GetUidAuto::getRelatedUids($chat_uid);
        $relatedUids = myArray::trimEmptyUid($relatedUids);

        return DBHandle::select(self::table, "`uid` IN (" . implode(',', $relatedUids) . ")");
    }

    /*
    static function treatByApi($chat_uid)
    {
        $url = "http://www.oasgames.com/?a=vip&m=getVip&uid=$chat_uid";
        $rs  = CURL::getJson($url);

        return ($rs['status'] == 'ok');
    }
    */

    static function insertRecord($arr_uids, $operator)
    {
        $arr_uids = myArray::trimEmptyUid($arr_uids);

        $arr_data = array();
        $time     = time();
        foreach ($arr_uids as $uid) {
            $arr_data[] = array($uid, $time, $operator);
        }

        $arr_columns = array('uid', 'time', 'operator');

        return DBHandle::insertMultiIgnore(self::table, $arr_columns, $arr_data);
    }
}
