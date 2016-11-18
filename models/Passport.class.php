<?php

/**
 * Created by PhpStorm.
 * User: shenping zhou
 * Date: 2015/5/18
 * Time: 18:57
 */
class Passport
{
    const PASSPORT_API_KEY = '996F75B947B0081F72B3FE84ED04DCA9';

    static function doRegister($uid)
    {
        $passport_url   = "//passport.oasgames.com/?m=fb_register";
        $oas_sp_promote = isset($_COOKIE['oas_sp_promote']) ? $_COOKIE['oas_sp_promote'] : '';
        $sp_promote     = isset($_GET['sp_promote']) ? $_GET['sp_promote'] :
            (isset($_GET['oauth_sp_promote']) ? $_GET['oauth_sp_promote'] : $oas_sp_promote);
        $params         = array(
            'uid'        => $uid,
            'ip'         => Browser::get_client_ip(),
            'lang'       => LANG_OAS,
            'sp_promote' => $sp_promote,
        );

        $rs_register = CURL::getJson($passport_url, $params);

        $status = strtolower($rs_register['status']);
        $msg    = $rs_register['val']['msg'];
        if ($status == 'ok' && $msg == 'successful') {
            cookie::setOasCookie("oas_is_new_register", 'yes', 0);
        }
        //如果玩家已经在passport注册过  msg会是update

        $oas_uid = $rs_register['val']['id'];
        OASUser::updateOasUid($uid, $oas_uid);
    }

    static function getUserInfoFromOasLoginKey($LoginKey = '')
    {
        if ($LoginKey == '') {
            $LoginKey = $_COOKIE['oas_user'];
        }
        $url = "//passport.oasgames.com/?m=getLoginUser&oas_user={$LoginKey}";

        return CURL::getJson($url);
    }

    static function getUidFromOasLoginKey($LoginKey = '')
    {
        $uid = 0;
        if ($LoginKey == '') {
            $LoginKey = $_COOKIE['oas_user'];
        }
        $user_info = self::getUserInfoFromOasLoginKey($LoginKey);
        if ($user_info['status'] == 'ok') {
            $val = $user_info['val'];
            $uid = !empty($val['snsUid']) ? $val['snsUid'] : $val['id'];
        }

        return $uid;
    }

    static function getUserInfoByUID($uid)
    {
        static $ret = array();
        if (empty($ret[$uid])) {
            $key       = md5($uid . self::PASSPORT_API_KEY);
            $url       = "//passport.oasgames.com/index.php?m=getUserById&uc_id=$uid&uc_key=$key";
            $rs        = CURL::getJson($url);
            $ret[$uid] = $rs['val'];
        }

        return $ret[$uid];
    }

    static function getUserSecurityLevel($uid)
    {
        $sign = md5($uid . self::PASSPORT_API_KEY);
        $url  = "//passport.oasgames.com/?a=Security&m=getUserSecurityLevel&uid={$uid}&auth={$sign}";

        $rs = CURL::getJson($url);

        return (int)($rs['val']['user_level']);
    }
}