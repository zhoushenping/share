<?php

/**
 * Created by PhpStorm.
 * User: shenping zhou
 * Date: 2015/5/7
 * Time: 15:19
 */
class myFacebook
{
    static function getMyInfo($uid)
    {
        $token          = self::getToken();
        $isPrivateToken = self::isPrivateToken($token);
        $uid            = $isPrivateToken ? 'me' : $uid;
        $url            = "https://graph.facebook.com/v2.2/{$uid}?access_token={$token}";

        return CURL::getJson($url);
    }

    static function getFriendsInfo($uid)
    {
        $token          = self::getToken();
        $isPrivateToken = self::isPrivateToken($token);
        $uid            = $isPrivateToken ? 'me' : $uid;
        $url            = "https://graph.facebook.com/v2.2/{$uid}/friends?access_token={$token}&limit=100";

        return CURL::getJson($url);
    }

    static function getInvitableFriendsInfo($facebook_uid)
    {
        $token          = self::getToken();
        $isPrivateToken = self::isPrivateToken($token);
        $facebook_uid   = $isPrivateToken ? 'me' : $facebook_uid;
        $url            = "https://graph.facebook.com/v2.2/{$facebook_uid}/invitable_friends?access_token={$token}&limit=100";

        return CURL::getJson($url);
    }

    //判断传入的token是否是个人的token
    static function isPrivateToken($token)
    {
        return ($token != '' && strpos($token, APP_SECRET) === false);
    }

    static function getToken()
    {
        return !empty($_SESSION['access_token']) ? $_SESSION['access_token'] : APP_ID . '|' . APP_SECRET;
    }

    static function getFriendsID($fb_res)
    {
        $ret = array();
        foreach ($fb_res['data'] as $val)
        {
            $ret[] = $val['id'];
        }

        return $ret;
    }

    static function treatToken($access_token)
    {
        if (self::isPrivateToken($_COOKIE['app_access_token']) == false)
        {
            cookie::deleteOasCookie("app_access_token");                 //如果cookie中包含不安全信息  则清除该cookie
        }

        if (self::isPrivateToken($access_token))
        {
            cookie::setOasCookie('app_access_token', $access_token, 365);//如果token是个人的  则可以写入cookie

            $_SESSION['access_token'] = $access_token;
        }
    }

    static function isPageLiked()
    {
        $fql_query_url = 'https://graph.facebook.com/fql?q=SELECT+uid+from+page_fan+where+page_id=\'' . PAGE_ID . '\'+and+uid=me()&access_token=' . $_SESSION['access_token'];
        $fql_query_obj = CURL::getJson($fql_query_url);

        return $fql_query_obj['data'][0]['uid'] ? 1 : 0;
    }

    static function getInviteInfo($request_ids)
    {
        $url = "https://graph.facebook.com/v2.2/{$request_ids}?access_token=" . self::getToken();

        return CURL::getJson($url);
    }
}