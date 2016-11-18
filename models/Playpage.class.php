<?php

/**
 * Created by PhpStorm.
 * User: shenping zhou
 * Date: 2015/6/12
 * Time: 17:57
 */
class Playpage
{
    static function getPlayUrl($uid, $sid, $logintype = 1, $source = 'app')
    {
        if ($_REQUEST['socialTest'] == 1) {
            return "/pages/?a=socialTest";
        }

        $key                    = 'play' . ZHUISUMA;
        $_SESSION[$key]['json'] = json_encode(
            array('uid' => $uid, 'sid' => $sid, 'logintype' => $logintype, 'source' => $source,)
        );

        return "/pages/?a=play&playKey=$key";
    }

    static function getParams()
    {
        $key = $_GET['playKey'];
        if (empty($_SESSION[$key])) {
            echo "session out";
            die;
        }
        else {
            $ret = json_decode($_SESSION[$key]['json'], 1);

            return $ret;
        }
    }

    static function destroySession()
    {
        $key = $_GET['playKey'];
        unset($_SESSION[$key]);
    }

    static function logLoginOas($uid, $sid_toPlay, $logName = 'login_oas')
    {
        $ad_sp        = trim($_COOKIE['oas_sp_promote']);
        $CLIENT_IP    = Browser::get_client_ip();
        $request_port = Browser::getRequestPort();
        Log2::save_run_log("$CLIENT_IP|$request_port|$uid|$sid_toPlay|$ad_sp", $logName);
    }

    static function makeLog($uid, $sid, $logintype, $source, $error_type)
    {
        $arr = array(
            'uid'        => $uid,
            'sid'        => $sid,
            'logintype'  => $logintype,
            'source'     => $source,
            'time'       => time(),
            'date'       => date('Y-m-d H:i:s'),
            'error_type' => $error_type,
        );
        Log2::save_run_log(json_encode($arr), 'playpage');
        if (!empty($error_type)) {
            Log2::save_run_log(json_encode($arr), 'playpageError');
        }//错误日志单独记录以便快速分析
    }

    static function getLoginType()
    {
        //传给游戏方logintype：1官网，2登陆器，3app，4新版登陆器
        $ret = (!empty($_GET['logintype'])) ? $_GET['logintype'] : 1;//默认为oas登录
        if ($_REQUEST['leftbar_collapse'] == 'yes') {
            $ret = 4;
        }

        return $ret;
    }

    static function  getGameEntrance($logintype = 0)
    {
        $ret = 'home';//默认
        if ($logintype == 2) {
            $ret = 'client';
        }
        if ($logintype == 3) {
            $ret = 'app';
        }
        if ($logintype == 4) {
            $ret = 'gbox';
        }

        return $ret;
    }
}
