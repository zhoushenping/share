<?php

/**
 * Created by PhpStorm.
 * User: shenping zhou
 * Date: 2015/5/18
 * Time: 20:55
 */
class Payment
{
    const PAY_MOBILE_ACCESS_KEY = '11110a90be21f4407176016d37782303';
	const PAY_ORDER_ACCESS_KEY = 'dt110a90bec1f237176016d37782303';

    static function getFacebookPayURL($uid, $server_sid)
    {
        return
            "https://pay.oasgames.com/games/"
            . GAME_CODE_STANDARD
            . "/fbpay.php?isInapp=1&server_sid=$server_sid&uid=$uid";
    }

    static function getOasPayURL($uid = 0, $sid = 0, $other_params = '', $from_iframe = false)
    {
        $params = array();
        if ($uid != 0) {
            $params[] = "uid=$uid";
        }
        if ($sid != 0) {
            $params[] = "server_sid=$sid";
        }

        $str_params = "?" . implode("&", $params) . "&" . $other_params;

        return
            ($from_iframe ? '' : 'http:')
            . "//pay.oasgames.com/games/"
            . GAME_CODE_STANDARD
            . "/oaspay.php{$str_params}";
    }

    static function isBlackUser($uid)
    {
        String::_filterNoNumber($uid);
        if ($uid == '') {
            return false;
        }

        //session中的相应数据为空或者超时时才回重新查接口
        if (time() - (int)($_SESSION[$uid]['black_cache']['time']) > 120) {
            $black_pay_url  = "http://pay.oasgames.com/core/_action.php?msg=getBlackList";
            $black_name_key = "e843a306864bsdf2B3FE84ED04DCA9";
            $sign           = md5($uid . $black_name_key);
            $url            = $black_pay_url . "&uid=$uid&oaskey=$sign";
            $rs             = CURL::getJson($url);

            $_SESSION[$uid]['black_cache']['status'] = (strtolower($rs['status']) == "ok");
            $_SESSION[$uid]['black_cache']['time']   = time();
        }

        return $_SESSION[$uid]['black_cache']['status'];
    }

    static function getPayStatus($uid)
    {
        String::_filterNoNumber($uid);
        if ($uid == '') {
            return array();
        }

        $secret = 'd9411ce0301eb928632daacf1431ec9f';
        $url    = "http://pay.oasgames.com/oasadmin/api/event_getGameCoins.php";
        $arr    = array(
            'game_code'  => GAME_CODE_STANDARD,
            'userid'     => $uid,
            'start_time' => strtotime('2010-01-01'),//不可传0
            'end_time'   => time(),
            'oaskey'     => md5(GAME_CODE_STANDARD . $uid . $secret),
        );

        $ret = CURL::getJson($url, $arr);//{"status":"ok","totalNums":"4","totalCoins":"480"}

        return $ret;
    }

    static function isToRedirect($uid)
    {
        define('BIG', 'big');
        define('SMALL', 'small');
        define('COINS_REDIRECT', 100 * 35);//达到多少钻就转向  100美金 每美金按35算
        String::_filterNoNumber($uid);
        if ($uid == '') {
            return false;
        }

        $key_cookie = GAME_CODE_STANDARD . "istoredirect{$uid}";

        if ($_COOKIE[$key_cookie] != '') {
            return ($_COOKIE[$key_cookie] == BIG);
        }

        //cookie中没有之前写入的结果 则查询接口
        $payStatus = self::getPayStatus($uid);
        if ($payStatus['status'] != 'ok') {
            return false;
        }//接口查询失败的情况

        $coins   = $payStatus['totalCoins'];
        $arr_log = array(
            'uid'   => $uid,
            'coins' => $coins,
        );

        Log2::save_run_log(json_encode($arr_log), 'tr_fb_oas_pay_coins');//记录钻数日志
        $userType   = ($coins >= COINS_REDIRECT) ? BIG : SMALL;
        $cookieTime = ($userType == BIG) ? 30 : 1 / 240;//如果已知是大额用户，则cookie寿命为30天，否则为6分钟
        cookie::setOasCookie($key_cookie, $userType, $cookieTime);

        return ($userType == BIG);
    }

    static function getPayRecord($arr_uids)
    {
        $ret       = array();
        $url_head  = "http://pay.oasgames.com/payment/api/getUserPayHistory_v2.php";
        $str_uid   = implode(",", $arr_uids);
        $game_code = GAME_CODE_STANDARD;
        $startTime = '';//需要是strtotime可以识别的格式
        $sign      = md5($str_uid . $game_code . $startTime . self::PAY_MOBILE_ACCESS_KEY);
        $url       = $url_head . "?uid={$str_uid}&gid={$game_code}&startTime={$startTime}&oaskey=$sign";
        $rs        = CURL::getJson($url);
        if (strtolower($rs['status']) != 'ok') {
            return array();
        }

        //{"userid":"576752854","game_coins":"160","status":true,"send_time":"1453321072"}   status=false表示为坏单
        foreach ($rs['val'] as $item) {
            $item['uid']   = $item['userid'];
            $item['coins'] = $item['game_coins'];
            $item['time']  = $item['send_time'];
            $ret[]         = $item;
        }

        return $ret;
    }

    public static function getRelatedPayRecords($uid)
    {
        $relatedUids = GetUidAuto::getRelatedUids($uid);
        $arr_uids    = $relatedUids == false ? array($uid) : $relatedUids;

        return self::getPayRecord($arr_uids);
    }

    //获得uid的错误类型（关系到是否显示还款界面）
    static function getErrorType($uid, $flush_cache = false)
    {
        $key = 'pay_error_type' . $uid;
        if ($flush_cache || !isset($_SESSION[$key])) {
            $_SESSION[$key] = self::getErrorTypeOnline($uid);
        }

        return $_SESSION[$key];
    }

    static function getErrorTypeOnline($uid)
    {
        $url = "http://pay.oasgames.com/payment/api/GetUserStatus.php?";//正式URL
        //$url = "http://debug.pay.oasgames.com/payment/api/GetUserStatus.php?";//测试URL

        $authData['userid']    = $uid;
        $authData['game_code'] = GAME_CODE_STANDARD;

        ksort($authData);
        $str = '';
        foreach ($authData as $k => $v) {
            $str .= $k . $v;
        }
        $authData['signature'] = md5($str . self::PAY_ORDER_ACCESS_KEY);

        foreach ($authData as $k => $v) {
            $url .= "$k=$v&";
        }

        $res = CURL::getJson($url);

        return $res['data']['web']['level'];
    }

    const table_errorType = 'pay_error_type';

    static function getErrorTypeLocal($uid)
    {
        $rs = DBHandle::select(self::table_errorType, "`uid`=$uid");

        return (int)($rs[0]['error_type']);
    }
}
