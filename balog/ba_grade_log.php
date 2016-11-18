<?php
/**
 * @desc add grade log for ba system
 */
include_once('../admin/define.php');
require_once(ROOT_PATH.'include'.DS.'config'.DS.'global.php');
require_once(ROOT_PATH.'include'.DS.'config'.DS.'functions.php');
require_once(ROOT_PATH.'include'.DS.'config'.DS.'config.legend.php');

$_SESSION['session_update_time'] = time();//使得session一直活跃

$uid = $_REQUEST['uid'];
$sid = $_REQUEST['server_sid'];

$userInfo = Game::get_user_game_info($uid, $sid);


$ba_grade_log_param['grade']     = (array)$userInfo['grade'];
$ba_grade_log_param['id']        = (array)$userInfo['id'];

//sp_promote info
$ba_grade_log_param['sp_promote'] = !empty($_REQUEST['sp_promote']) ? $_REQUEST['sp_promote'] : (!empty($_COOKIE['oas_sp_promote']) ? $_COOKIE['oas_sp_promote'] : '');
$grade = $ba_grade_log_param['grade'][0];

if(!empty($userInfo)){
	$ba_grade_data = array(
			'game_code' 	=> 'lobr',	//游戏代码
			'server_id' 	=> $sid,		//服务器 id
			'uid' 			=> $uid,		//user id
			'roleid' 		=> !empty($ba_grade_log_param['id'][0]) ? $ba_grade_log_param['id'][0] : '',		//角色 id
			'grade' 		=> $grade,		//等级
			'time' 			=> time(),		//时间
			'other_roles' 	=> '', //其他角色等级信息
            'sp_promote' 	=> $ba_grade_log_param['sp_promote'],    //广告代码
	);
	
	BaLog::save_user_grade_log($ba_grade_data,'grade');
}

PlayGameLog::updateRecord($uid, $sid, $grade);
Log::save_run_log("uid:".$uid."|server_sid:".$sid."|".$grade,'grade');