<?php
APP::checkDenied();

require VENDORS_PATH . "/facebook/facebook.php";
$fb = new Facebook(array('appId' => APP_ID, 'secret' => APP_SECRET,));

$uid          = $oas_uid = '';
$access_token = $fb->getAccessToken();
$facebook_uid = $fb->getUser();
myFacebook::treatToken($access_token);//处理token往session和cookie中的写入

try {
    if ($facebook_uid > 0) {
        //必须走ODP::getUserInfoFromFacebookToken  该方法可以自动处理注册or update玩家的信息
        $myOASInfo = ODP::getUserInfoFromFacebookToken();

        if (!empty($myOASInfo['uid'])) {
            //请求成功
            $uid     = $myOASInfo['uid'];
            $oas_uid = $myOASInfo['all_info']['id'];
            if ($uid != $facebook_uid) {
                UserMap::add($facebook_uid, $uid);
            }
            cookie::setOasCookie('fbapp_oas_user', $myOASInfo['loginKey'], 7);
        }
        else {
            //通过分析日志 得知请求ODP得不到详细信息的概率大约为0.7% 加之此处原有的逻辑有潜在问题，所以直接top redirect
            Browser::topRedirect(APP_FB_URL);
        }
    }
    else {
        Invite::dealAPPinvite('step1');//处理invite请求 第1步  这是玩家应该还没有授权当前app 如果不在授权之前存储相关信息，之后就取不到了
        APP::goToDialogURL();
    }
} catch (Exception $e) {
    $rs   = $e->getResult();
    $info = $_REQUEST['__utmc'] . '|' . $rs['error']['code'] . '|' . $rs['error']['message'];
    Log::save_run_log($info, 'login_error');
    Browser::topRedirect(FB_URL);
}

if (OASUser::isExist($uid)) {
    $is_new_user = false;
    OASUser::updateLastLogin($uid, $oas_uid);
    $myFacebookInfo = OASUser::getUserInfo($uid);
}
else {
    $myFacebookInfo          = myFacebook::getMyInfo($facebook_uid);
    $is_new_user             = true;
    $user_profile            = $myFacebookInfo;
    $user_profile['id']      = $uid;//插入到oas_user表时  id字段使用玩游戏的uid
    $user_profile['oas_uid'] = $oas_uid;

    OASUser::addUserByProfile($user_profile);
    Log::save_run_log($uid . "|" . $_SERVER["HTTP_USER_AGENT"], 'browser');
}

$uname                       = $myFacebookInfo['name'];
$_SESSION['app_uid']         = $uid;
$_SESSION['uid']             = $uid;
$_SESSION['uname']           = $uname;
$_SESSION['uemail']          = $myFacebookInfo['email'];
$_SESSION['is_new_app_user'] = $is_new_user;
cookie::setOasCookie('app_uid', $uid, 1);
Invite::dealAPPinvite('step2', $facebook_uid);//处理invite请求 第2步
