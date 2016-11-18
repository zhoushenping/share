<?

class Promote
{
    static function getAreaFromPromote($promote = '')
    {
        return 0;//当前游戏不分地区
    }

    static function getPromote()
    {
        //$_REQUEST中会包含$_GET $_POST $_COOKIE 且$_COOKIE的优先级最高!!!
        $promote = '';
        if (!empty($_COOKIE['oas_sp_promote']))    $promote = $_COOKIE['oas_sp_promote'];//优先级最低
        if (!empty($_REQUEST['oauth_sp_promote'])) $promote = $_REQUEST['oauth_sp_promote'];
        if (!empty($_GET['sp_promote']))           $promote = $_GET['sp_promote'];//POST和GET优先级相对较高
        if (!empty($_GET['oas_sp_promote']))       $promote = $_GET['oas_sp_promote'];//POST和GET优先级相对较高
        return strtolower($promote);
    }

    //获取promote的类型
    static function getPromoteType()
    {
        $ret = 'none';
        if (!empty($_COOKIE['oas_sp_promote']))    $ret = 'cookie_oas_sp_promote';
        if (!empty($_REQUEST['oauth_sp_promote'])) $ret = 'request_oauth_sp_promote';
        if (!empty($_GET['sp_promote']))           $ret = 'get_sp_promote';
        if (!empty($_GET['oas_sp_promote']))       $ret = 'get_oas_sp_promote';

        return $ret;
    }

    static function getPromoteID()
    {
        $temp        = array();
        $sp_promote  = self::getPromote();
        $promote_arr = explode(";", $sp_promote);
        foreach ($promote_arr as $v)
        {
            if (!empty($v)) $temp[] = $v;
        }
        $temp = array_reverse($temp);

        return $temp[0];
    }

    static function isAdUser()
    {
        $p = self::getPromote();
        return !empty($p);
    }

    static function writeLog($uid, $sid_toPlay)
    {
        $CLIENT_IP    = Browser::get_client_ip();
        $request_port = Browser::getRequestPort();
        $lastSid      = PlayGameRecord::getLastSid($uid);
        $area_r       = Promote::getAreaFromPromote();
        $sid_r        = String::getInt($_REQUEST['server_id']);
        $sp_promote   = self::getPromote();
        $promoteType  = self::getPromoteType();

        if (!empty($_GET['oauth_sp_promote']))
        {
            Log2::save_run_log("$CLIENT_IP|$request_port|$uid|$sid_toPlay", 'login');
            Log2::save_run_log("$CLIENT_IP|$request_port|$uid|$sid_toPlay|" . $_GET['oauth_sp_promote'], 'oauth_sp_promote');
        }
        else
        {
            Log2::save_run_log("$CLIENT_IP|$request_port|$uid|$sid_toPlay", 'login');
        }

        if (!empty($_GET['sp_promote']))
        {
            Log2::save_run_log("$CLIENT_IP|$request_port|$uid|$sid_toPlay|" . $_GET['sp_promote'] . "|{$lastSid}|$sid_r", 'new_sp_promote');
            Log2::save_run_log("$CLIENT_IP|$area_r|$uid|$sid_toPlay|" . $_GET['sp_promote'] . "|{$lastSid}|$sid_r", 'new_sp_test_promo');
        }
        Log2::save_run_log("$CLIENT_IP|$area_r|$uid|$sid_toPlay|{$lastSid}|$sid_r|$sp_promote|$promoteType", 'new_sp_test_promo2');
    }
}

?>