<?php
/**
 * @desc add play game log for ba system
 */

$ba_play_log_param = array();

//config info
$ba_play_log_param['lang'] 		= 'pt';
$ba_play_log_param['area'] 		= 'br';

//roleid and grade
$ba_play_log_param['roleid'] = '';
$ba_play_log_param['grade']  = 0;


$ba_play_log_userinfo = $myOASInfo;
$userInfobygrade      = Game::get_user_game_info($uid,$sid_toPlay);

$ba_play_log_param['roleid'] = (array)$userInfobygrade['id'];
$ba_play_log_param['grade']  = (array)$userInfobygrade['grade'];

//first play game, first play server, roll server
$ba_play_log_param['rolled']     = '0';
$ba_play_log_param['source_sid'] = '';

$lastSid        = PlayGameRecord::getLastSid($uid);
$g_first        = empty($lastSid) ? 'y' : 'n';
$s_first        = 'y';//将要玩的服 是否是第一次玩
$lastPlayRecord = PlayGameLog::getOneRecord($uid);//上次玩游戏的记录

if (!empty($lastSid))
{
    $s_first = PlayGameRecord::isSidPlayed($uid, $sid_toPlay) ? 'n' : 'y';

    //roll server
    if ($s_first == 'y')
    {
        $ba_play_log_param['rolled'] = ($_GET['roll'] != 'beidong' && !empty($_REQUEST['server_id'])) ? '1' : '2';
    }
}

//sp_promote info
$ba_play_log_param['sp_promote'] = !empty($_REQUEST['sp_promote']) ? $_REQUEST['sp_promote'] : (!empty($_COOKIE['oas_sp_promote']) ? $_COOKIE['oas_sp_promote'] : '');

//browser info: type and version
$ba_play_log_param['browser'] = BaLog::userBrowser();

//server_type
$ba_play_log_param['server_type'] = ($sid_toPlay < 2000) ? 'app' : 'home';

//user_from, is_bind info
$ba_play_log_param['user_from'] = isset($ba_play_log_userinfo['all_info']['user_from_ori']) ? $ba_play_log_userinfo['all_info']['user_from_ori'] : $ba_play_log_userinfo['all_info']['user_from'];
$ba_play_log_param['is_bind']   = ($ba_play_log_userinfo['all_info']['fb_bind'] == 'yes') ? 1 : 0;


//save log
$ba_play_game_data = array(
    'game_code' 				=> GAME_CODE_STANDARD,		     						//游戏代码
    'server_id'                 => $readyToRoll ? -1 : $sid_toPlay,                     //服id
    'uid' 						=> $uid,												//uid
    'roleid' 					=> $ba_play_log_param['roleid'][0],						//角色id
    'server_type' 				=> $ba_play_log_param['server_type'],					//服务器类型	平台服 FB服
    'area' 						=> $ba_play_log_param['area'],							//服地区
    'first_play_this_game' 		=> $g_first,		                        			//是否第一次玩该游戏 y n
    'first_play_this_server' 	=> $s_first,		                        			//是否第一次登录该服 y n
    'grade' 					=> $ba_play_log_param['grade'][0],						//等级
    'ip' 						=> Browser::get_client_ip(),							//ip
    'lang' 						=> $ba_play_log_param['lang'],							//语言
    'time' 						=> time(),												//时间戳
    'sp_promote' 				=> $ba_play_log_param['sp_promote'],					//广告代码
    'source' 					=> $play_game_entrance,									//位置       官网 登陆器  APP
    'browser_type' 				=> $ba_play_log_param['browser']['browser'],			//浏览器类型
    'browser_version' 			=> $ba_play_log_param['browser']['browser_version'],	//浏览器版本
    'rolled' 					=> $ba_play_log_param['rolled'],						//是否滚服		0 未滚服 1 主动滚服 2 被动滚服
    'source_sid'                => $lastSid,	                                        //来源服  上一次玩游戏的服
    'user_from'                 => $ba_play_log_param['user_from'],	                    //用户来自哪个平台
    'is_bind'                   => $ba_play_log_param['is_bind'],	                    //用户是否绑定oas平台账号 1已绑定，0未绑定

    //上次玩游戏的记录
    'lastPlaytime'              => $lastPlayRecord['m_time'],	                    //上次玩游戏的时间
    'lastGrade'                 => $lastPlayRecord['grade'],	                    //上次玩游戏的等级

    //补充信息
    'last_play_time'   	        => $lastPlayRecord['m_time'],	            			//来源服上次玩游戏时间
    'last_play_grade' 		    => $lastPlayRecord['grade'],	            			//来源服等级
    'user_selected_server'      => ServerNew::isVisibleServer(String::getInt($_REQUEST['server_id'])) ? 1 : 0,    //本次登录游戏是否主动选择服务器 0,1
    'login_through'             => $_GET['login_through'],                              //用户是从哪儿点击过来的
    'user_from_roll'            => (strpos($_GET['login_through'], 'roll') !== false) ? 1 : 0,                    //用户上一次访问app是否显示了被动滚服界面
//    'user_to_roll'              => $readyToRoll ? 1 : 0,                                //此次是否会向用户显示被动滚服界面
    'daysNotPlay'               => Roll::$info['daysNotPlay'],                          //是否将要滚服的判断参数
);

BaLog::save_play_game_log($ba_play_game_data, 'play');

function makeVipSubmitUrl($uid, $sid)
{
    $gamecode = GAME_CODE_STANDARD;
    $key      = 'SJFOJ293JDFOAJSOF12';
    $sign     = md5($gamecode . $sid . $uid . $key);

    return "//vipcore.oasgames.com/api/vip_user_sign_gamecode.php?uid=$uid&gamecode=$gamecode&serverid=$sid&signature=$sign";
}

?>

<script type="text/javascript" src="/static/common/jquery-1.7.2.min.js"></script>
<script type="text/javascript" src="/static/common/tools.php"></script>
<script>
    var sync_grade = <?=$readyToRoll ? 'false' : 'true'?>;//是否自动刷新等级
    ajaxRequest('<?=makeVipSubmitUrl($uid,$sid_toPlay)?>');

    //定时记录玩家等级log
    function save_ba_grade_log() {
        var url = '<?="/balog/ba_grade_log.php?uid=$uid&server_sid=$sid_toPlay&sp_promote={$ba_play_log_param['sp_promote']}"?>';
        $.getJSON(url);
    }

    if (sync_grade) {
        save_ba_grade_log();
        setInterval('save_ba_grade_log()', 300000);
    }
</script>