<?php
/**
 * @desc add download log for ba system
 */

    $ba_down_log_param 			  = array();
	
	$ba_down_log_param['browser'] = BaLog::userBrowser();
	
	$userInfo = getUserInfobyZZL();
	
	$ba_down_log_param['uid']     = empty($userInfo['val']['id']) ? '0' : $userInfo['val']['id'];
	
	$ba_down_log_param['ad_tag']  =	isset($_COOKIE['oas_sp_promote2'])	?	trim($_COOKIE['oas_sp_promote2'])	: '';
	
	
	if($play_game_entrance == 'homepage')
	{
		$ba_down_log_param['source'] = 'home';
	}
	else 
	{
		$ba_down_log_param['source'] = $play_game_entrance;
	}
	
	
	
	$ba_down_data = array(
			'download_location'		=>$ba_down_log_param['source'],				//下载位置
			'game_code'				=>'lobr',				//游戏code
			'login_client'			=>'LegendOnline(pt)',				//登录器名称
			'login_client_version'	=>'1.1',	//登录器版本
			'uid'					=>$ba_down_log_param['uid'],	//用户登陆后才可获取，用户在非登陆下也可下载登录器
			'advert_information'	=>$ba_down_log_param['ad_tag'],								//广告信息
			'browser'				=>$ba_down_log_param['browser']['browser'],							//浏览器
			'browser_version'		=>$ba_down_log_param['browser']['browser_version'],		//浏览器版本
			'ip'					=>Browser::get_client_ip(),			//用户IP
			'c_time'				=>time()					//创建时间
	);
	

	BaLog::save_download_log($ba_down_data, 'logindown');