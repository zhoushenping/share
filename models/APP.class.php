<?php

/**
 * Created by PhpStorm.
 * User: shenping zhou
 * Date: 2015/5/28
 * Time: 12:18
 */
class APP
{
    static function checkDenied()
    {
        if ($_GET['error'] == 'access_denied')
        {
            //样本   https://apps.facebook.com/firstblood_tr/?error=access_denied&error_code=200&error_description=Permissions+error&error_reason=user_denied#_=_

            $_GET['ip'] = Browser::get_client_ip();
            Log2::save_run_log(json_encode($_GET), 'oauth_deny');
            $oauth_deny_url = "https://www.facebook.com/games/?app_id=" . APP_ID;
            Browser::topRedirect($oauth_deny_url);
        }
    }

    static function goToDialogURL()
    {
        $dialog_url = "http://www.facebook.com/dialog/oauth?client_id="
            . APP_ID . "&redirect_uri=" . urlencode(APP_FB_URL)
            . "&scope=email,user_friends";

        Browser::topRedirect($dialog_url);
    }
}