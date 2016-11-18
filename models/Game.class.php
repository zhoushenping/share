<?php

/**
 * Created by PhpStorm.
 * User: shenping zhou
 * Date: 2015/5/19
 * Time: 20:23
 */
class Game
{
    static function makeLoginUrl($uid, $sid)
    {
        $serverinfo = ServerNew::getServerInfo($sid);
        $time       = time();
        $password   = md5(rand(1, 999));
        $login_key  = $serverinfo['server_inner_ip'];
        $sign       = md5($uid . $password . $time . $login_key);
        $content    = "$uid|$password|$time|$sign";

        $server_url = $serverinfo['server_url'];
        $site       = $serverinfo['server_secret_key'];

        $login_web = $server_url . "createlogin?content=$content&site=" . $site;

        $rs = CURL::Request($login_web);

        if ("" . $rs === '0') {
            $login_url = $server_url . "client/game.jsp?user=$uid&key=$password&site=" . $site;
            if ($_SERVER['SERVER_PORT'] == 443) {
                $login_url = str_replace('http://', 'https://', $login_url);
            }

            return $login_url;
        }
        else {
            return WARING_SERVER_URL;
        }
    }

    static function getFlashUrl($uid, $sid)
    {
        $ret        = '';
        $serverinfo = ServerNew::getServerInfo($sid);
        $time       = time();
        $user       = $uid;
        $password   = md5(rand(1, 999));
        $server_url = $serverinfo['server_url'];
        $login_key  = $serverinfo['server_inner_ip'];
        $sign       = md5($uid . $password . $time . $login_key);
        $content    = "$uid|$password|$time|$sign";
        $site       = $serverinfo['server_secret_key'];

        $login_web = $server_url . "createlogin?content=$content&site=" . $site;

        $rs = CURL::Request($login_web);
        if ("" . $rs === '0') {
            $ret = $server_url . "client/Loading.swf?user=$user&site=" . $site . "&key=$password";
        }

        return $ret;
    }

    static function get_user_game_info($uid, $sid)
    {
        $serverinfo = ServerNew::getServerInfo($sid);
        $site       = $serverinfo['server_secret_key'];
        $server_url = $serverinfo['server_url'];

        $pay_web = $server_url . "loginselectlist?username=$uid&site=" . $site;

        $xmlstr = CURL::Request($pay_web);

        if (strpos($xmlstr, 'xml') === false) {
            return null;
        }
        $xml = new SimpleXMLElement($xmlstr);

        $user_game_info = array();
        foreach ($xml->Item as $item) {
            $user_game_info['nick']  = $item->attributes()->NickName;
            $user_game_info['grade'] = $item->attributes()->Grade;
            $user_game_info['id']    = $item->attributes()->ID;
        }

        return $user_game_info;
    }

    static function getGrade($uid, $sid)
    {
        if (DEVELOP_MODE and !empty($_REQUEST['grade'])) {
            return $_REQUEST['grade'];
        }//测试环境可以传入等级

        $key = "{$uid}--{$sid}";
        static $ret = array();
        if (!isset($ret[$key])) {
            $temp      = self::get_user_game_info($uid, $sid);
            $temp      = (array)($temp['grade']);
            $grade     = is_null($temp[0]) ? -1 : (int)($temp[0]);
            $ret[$key] = $grade;
        }

        return $ret[$key];
    }

    static function getRoleName($uid, $sid)
    {
        if (DEVELOP_MODE) return "nickname_" . substr($uid, -4) . "_{$sid}";
        $rs = self::get_user_game_info($uid, $sid);

        return $rs['nick'];
    }

    static function getkey($sid, $keyName)
    {
        $area_id = ServerNew::getSidArea($sid);

        return self::getkeyByArea($keyName, $area_id);
    }

    static function getkeyByArea($keyName, $area_id = 0)
    {
        $oaspay_config = array(
            //巴西服
            0 => array(
                'server_inner_ip'  => 'SNTTQ-16DD11-22-0brazil-67n1dDFN-7ROAD21-shenng-111SHEN',
                'server_public_ip' => 'CSIT-16dd22-33-0668wu-67n-5brazild44-7ROAD31-SHEANG-23SHEN'
            ),
            //葡萄牙服
            1 => array(
                'server_inner_ip'  => 'SNTTQ-16DD11-22-0brazPt-67n1dDFN-7ROAD21-shenng-111SHEN',
                'server_public_ip' => 'CSIT-16dd22-33-0668wu-67n-5brazPtd44-7ROAD31-SHEANG-23SHEN'
            ),
            //平台服
            2 => array(
                'server_inner_ip'  => 'SNTTQ-16DD11-22-0broas-67n1dDFN-7ROAD21-shenng-111SHEN',
                'server_public_ip' => 'CSIT-16dd22-33-0668wu-67n-5broasd44-7ROAD31-SHEANG-23SHEN'
            ),
        );

        return $oaspay_config[$area_id][$keyName];
    }
}
