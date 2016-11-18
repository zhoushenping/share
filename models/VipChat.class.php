<?php

/**
 * Created by PhpStorm.
 * User: shenping zhou
 * Date: 2015/8/6
 * Time: 11:49
 */
class VipChat
{
    static function getHost()
    {
        return DEVELOP_MODE ? "//onlinechat3.oasgames.com/" : "//vipsac.oasgames.com/";//测试:正式
    }

    static function getMsgCount($chat_uid)
    {
        static $ret = array();//使用静态输出  避免同一php进程反复查询同一用户的相应信息

        if (!isset($ret[$chat_uid]))
        {
            $rs             = CURL::getJson(self::getMsgCountURL($chat_uid));//样本 {"retcode":0,"retdescription":"success","msgcount":0,"admincount":0,"kefucount":0}
            $ret[$chat_uid] = (int)($rs['msgcount']);
        }

        return $ret[$chat_uid];
    }

    static function getMsgCountURL($chat_uid)
    {
        $lang = SYSTEM_LANG;
        $game = GAME_CODE_STANDARD;

        return self::getHost() . "api_admin_msg_count.php?oasuid=$chat_uid&lang=$lang&gamecode=$game";
    }

    static function InitData($uid, $sid_toPlay, $logintype)
    {
        return array(
            'vip_chat_uid'       => $uid,
            'vip_chat_sid'       => $sid_toPlay,
            'vip_chat_logintype' => $logintype,
            'isVipChatUser'      => VipUsers::isVip($uid),
            'vipChatCount'       => self::getMsgCount($uid),
        );
    }

    static function makeJsURL()
    {
        global $vip_chat_source;
        $lang      = SYSTEM_LANG;
        $gamecode  = GAME_CODE_STANDARD;
        $uid       = $_SESSION['vipchat'][$vip_chat_source]['vip_chat_uid'];
        $sid       = $_SESSION['vipchat'][$vip_chat_source]['vip_chat_sid'];
        $logintype = $_SESSION['vipchat'][$vip_chat_source]['vip_chat_logintype'];

        return self::getHost() . "userlistjs.php?lang=$lang&oasuid=$uid&gamecode=$gamecode&serverid=$sid&logintype=$logintype&signature=" . self::getSignature();
    }

    static function getSignature()
    {
        define('SIGNATURE_KEY_FOR_GUEST', "JSOJjojfo989jji1120wi");
        global $vip_chat_source;

        $input_array = array(
            "lang"      => SYSTEM_LANG,
            "gamecode"  => GAME_CODE_STANDARD,
            "oasuid"    => $_SESSION['vipchat'][$vip_chat_source]['vip_chat_uid'],
            "serverid"  => $_SESSION['vipchat'][$vip_chat_source]['vip_chat_sid'],
            "logintype" => $_SESSION['vipchat'][$vip_chat_source]['vip_chat_logintype'],
        );

        ksort($input_array);
        $sign_input = "";
        foreach ($input_array as $onekey => $onevalue)
        {
            $sign_input .= $onevalue;
        }

        $sign_input .= SIGNATURE_KEY_FOR_GUEST;

        $sign_input_md5 = md5($sign_input);

        return $sign_input_md5;
    }
}