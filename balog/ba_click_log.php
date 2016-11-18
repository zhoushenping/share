<?php
/**
 * @desc add click log for ba system
 */

$ba_sp_promote = $_REQUEST['sp_promote'];//click 日志只关注这一个广告来源

if(!empty($ba_sp_promote)){
	
	$ba_click_log_param 			= array();
	
	/* config lang info */
	$ba_click_log_param['lang'] 	= 'pt';
	
	$ba_click_log_param['refer'] 	= BaLog::getAdRefer();
	$ba_click_log_param['browser'] 	= BaLog::userBrowser();
	
	$ba_click_data = array(
			'game_code' 	=> 'lobr',											//游戏code
			'lang' 			=> $ba_click_log_param['lang'],							//语言
			'ip' 			=> Browser::get_client_ip(),							//ip地址
			'browser' 		=> $ba_click_log_param['browser']['browser'],			//浏览器类型
			'browser_ver' 	=> $ba_click_log_param['browser']['browser_version'],	//浏览器版本
			'c_time' 		=> time(),												//点击时间
			'ad_source' 	=> $ba_sp_promote,		         						//广告信息
			'refer' 		=> $ba_click_log_param['refer'],						//来源信息
	);
	
	BaLog::save_ad_click_log($ba_click_data, 'click');
}