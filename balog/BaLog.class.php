<?php
/*
 * 记录经分系统所需统计日志  : BA Log
 * 
 * @desc
 * log类型：1 平台注册Log
 * log类型：2 广告点击log
 * log类型：3 refer log
 * log类型：4 玩游戏log
 * log类型：5 支付相关log
 * log类型：6 玩家等级log
 * log类型：7 游戏在线log
 * log类型：8 登陆器下载log
 * log类型：9 平台登录Log
 * log类型：10 帐号绑定log
 * 
 * 
 * @author 张兴贺, 周申平, 刘志宇
 * 
 */

// landing position key for request and cookie
define('BA_LP_KEY_R', 'landing_position');
define('BA_LP_KEY_C', 'oas_landing_position');

class BaLog {

	// 玩游戏log ,type=4
	public static function save_play_game_log($info){
		
		if(!empty($_REQUEST[BA_LP_KEY_R])){
			$info['source'] = $_REQUEST[BA_LP_KEY_R];
			self::saveLandingPosition();
		}
		else if(!empty($_COOKIE[BA_LP_KEY_C])){
			$info['source'] = $_COOKIE[BA_LP_KEY_C];
		}
		
		$para_config = array(
			'game_code'					=>'',	//游戏代码
			'server_id'					=>'',	//服id
			'uid'						=>'',	//
			'roleid'					=>'',	//角色id
			'server_type'				=>'',	//服务器类型	home=平台服 app=FB服
			'area'						=>'',	//服地区 tr=土耳其 na=北美 等等
			'first_play_this_game'		=>'',	//是否第一次玩该游戏 y n
			'first_play_this_server'	=>'',	//是否第一次登录该服 y n
			'grade'						=>'',	//等级
			'ip'						=>'',	//
			'lang'						=>'',	//语言  tr=土耳其语  pt=葡萄牙语  es=西班牙语  等等
			'time'						=>'',	//时间戳
			'sp_promote'				=>'',	//广告代码
			'source'					=>'',	//位置       home=官网 client=登陆器  app=APP
			'browser_type'				=>'',	//	浏览器类型
			'browser_version'			=>'',	//  浏览器版本
			'rolled'					=>'',	//	是否滚服		0 未滚服 1 主动滚服 2 被动滚服
			'source_sid'				=>'',	//  来源服
			'user_from'				    =>'',	//  用户来源
		);
		/*foreach($para_config as $k=>$v){
			if(!isset($info[$k])){
				return false;
			}
		}*/

		$info2 = json_encode($info);
        ($info['server_id'] == -1) ? (BaLog::save_bas_log($info2, 'rollPageDisplay', 11)) : (BaLog::save_bas_log($info2, 'login', 4));
	}
	
	// 玩家等级log ,type=6
	public static function save_user_grade_log($info){

        if (empty($info['ip']))
        {
            $info['ip'] = $_SERVER['REMOTE_ADDR'];
        }

		$para_config = array(
			'game_code'		=>'',	//游戏代码
			'server_id'		=>'',	//服id
			'uid'			=>'',	//
			'roleid'		=>'',	//等级最高的角色的id
			'grade'			=>'',	//等级最高的角色的等级
			'time'			=>'',	//时间戳
			'other_roles'	=>'',	//其他角色的信息  值类似于 json_encode(array(2=>10,3=20,)) 表示另外两个的角色的id为2和3  等级为10和20
		);
		
		/*foreach($para_config as $k=>$v){
			if(!isset($info[$k])){
				return false;
			}
		}*/

		$info = json_encode($info);
		BaLog::save_bas_log($info, 'grade',6);
	}
	
	/*
	 * 广告点击log, type=2
	 * @data: array类型，包含信息(game_code, lang, ip, browser, browser_ver, c_time, ad_source, refer)
	 * @log_pre_name： string类型, log文件名前缀，不能包含下划线'_'
	 */
	public static function save_ad_click_log($data,$log_pre_name='click'){
		
		$log_type = 2;
		
		$param_config = array(
			'game_code',		//游戏code
			'lang',				//语言
			'ip',				//ip地址
			'browser',			//浏览器类型
			'browser_ver',		//浏览器版本
			'c_time',			//点击时间
			'ad_source',		//广告信息
			'refer',			//来源信息
		);
		
		//log name check
		if(strpos($log_pre_name, '_') !== false){
			return "log_pre_name can not include underline '_'";
		}
		
		//parameters check
		/*foreach($param_config as $val){
			if(!isset($data[$val])){
				return "param {$val} is lost!";
			}
		}*/
		
		$info = json_encode($data);
		BaLog::save_bas_log($info, $log_pre_name, $log_type);
	}
	
	/**
	 * 游戏在线log, type=7
	 * @data: array类型，包含信息(game_code, sid, time, count, area)
	 * @log_pre_name： string类型, log文件名前缀，不能包含下划线'_'
	 */
	public static function save_game_online_log($data,$log_pre_name='online'){
			
		$log_type = '7';
		
		$param_config = array(
			'game_code',		//游戏code
			'sid',				//服务器id
			's_merge',			//和服id,多个id用逗号链接
			'time',				//统计时间
			'count',			//在线人数
			'area',				//服务器所在地区
		);
		
		//log name check
		if(strpos($log_pre_name, '_') !== false){
			return "log_pre_name can not include underline '_'";
		}
		
		//parameters check
		/*foreach($param_config as $val){
			if(!isset($data[$val])){
				return "param {$val} is lost!";
			}
		}*/
			
		$info = json_encode($data);
		BaLog::save_bas_log($info, $log_pre_name, $log_type);
	}
	
	/**
	 *  记录 BA 系统需要的log
	 *  时区处理： 统一使用 北京时区，不改变其他业务的时区
	 *  @info: json格式
	 */
	public static function save_bas_log($info,$file_pre_name,$log_type,$log_path='/data/basLog'){
        if (is_dir('e:/logs/')) $log_path = 'e:/logs/basLog';
        if(strpos($file_pre_name, '_') !== false){
            return "log_pre_name can not include underline '_'";
        }

		$former_timezone = date_default_timezone_get();
			
		// timezone set : Asia/Chongqing
		date_default_timezone_set('Asia/Chongqing');
			
		if(file_exists($log_path) == false) {
			mkdir($log_path);
			chmod($log_path,0777);
		}
		$file_name = $file_pre_name.'_'.$log_type.'_'.date('Ymd').'.log';
			
		$handle = fopen("$log_path/$file_name","a");
		$log = $info."\r\n";
		fwrite($handle,$log);
		fclose($handle);
			
		// timezone set : former timezone
		date_default_timezone_set($former_timezone);
	}
		
		
	/**
	 * 登陆器下载BA,LOG统计
	 * Enter description here ...
	 * @param unknown_type $data	array,	LOG数据
	 * @param unknown_type $log_pre_name	 string, log文件名前缀，不能包含下划线'_'
	 * @param	data 最后处理为json格式
	 */
	static function save_download_log($data,$log_pre_name='logindown')
	{
		//log type
		$log_type	=	'8';
		
		//conf key 用于验证
		$param_config = array(
			'download_location',	//下载位置  home=官网  app=APP game=游戏  lp_home=landingpage_home lp_app=landingpage_app
			'game_code',			//游戏code
			'login_client',			//登录器名称
			'login_client_version',	//登录器版本
			'uid',					//用户UID
			'advert_information',	//广告信息
			'browser',				//浏览器
			'browser_version',		//浏览器版本
			'ip',					//用户IP
			'c_time'				//创建时间
		);
		//log name check
		if(strpos($log_pre_name, '_') !== false){
			return "log_pre_name can not include underline '_'";
		}
		
		if(!is_array($data)){
			return 'Is data not array,error!';	
		}else{
			//parameters check
			/*foreach($param_config as $val)
			{
				if(!isset($data[$val])){
					return "param {$val} is lost!";
				}
			}*/
		}
		self::save_bas_log(json_encode($data), $log_pre_name, $log_type);
	}

    // 帐号绑定log ,type=10
    public static function save_account_bind_log($info,$log_pre_name='accountbind'){

        $para_config = array(
            'uuid',         // uid（用oas平台id）
            'user_from',    // 用户来自哪个平台, param 属性
            'time',         // 绑定时间
            'ip',           // ip
            'lang',         // 语种 pt、tr等
        );

        //log name check
        if(strpos($log_pre_name, '_') !== false){
            return "log_pre_name can not include underline '_'";
        }

        /*foreach($para_config as $k=>$v){
            if(!isset($info[$k])){
                return false;
            }
        }*/

        $info['appid'] = '2064257742';

        $info = json_encode($info);
        BaLog::save_bas_log($info, $log_pre_name,10);
    }

	//获取浏览器信息
	static public function userBrowser(){
		
		if (empty($_SERVER['HTTP_USER_AGENT']))
	    {    //当浏览器没有发送访问者的信息的时候
	        return '';
	    }
	
	    $agent       = $_SERVER['HTTP_USER_AGENT'];   
	    $browser     = '';
	    $browser_ver = '';
		
	    if (preg_match('/MSIE\s([^\s|;]+)/i', $agent, $regs))
	    {
	        $browser     = 'IE';    //当匹配到了MSIE 的时候，取得数字的那一部分房在数组$regs里
	        $browser_ver = $regs[1];
	    }elseif(strpos($agent,"like Gecko") && strpos($agent,"Chrome")===false){
        	$browser 		="IE";
	    	$browser_ver	="11.0";
	    }
	    elseif (preg_match('/FireFox\/([^\s]+)/i', $agent, $regs))
	    {                           
	        $browser     = 'FireFox';                //当匹配到了firefox/的时候，取得后面紧跟的数字部分
	        $browser_ver = $regs[1];
	    }
	    elseif (preg_match('/Maxthon/i', $agent, $regs))
	    {
	        $browser     = '(IE' .$browser_ver. ') Maxthon';
	        $browser_ver = '';
	    }
	    elseif (preg_match('/Opera[\s|\/]([^\s]+)/i', $agent, $regs))
	    {
	        $browser     = 'Opera';
	        $browser_ver = $regs[1];
	    }
	    elseif (preg_match('/OmniWeb\/(v*)([^\s|;]+)/i', $agent, $regs))
	    {
	        $browser     = 'OmniWeb';
	        $browser_ver = $regs[2];
	    }
	    elseif (preg_match('/Netscape([\d]*)\/([^\s]+)/i', $agent, $regs))
	    {
	        $browser     = 'Netscape';
	        $browser_ver = $regs[2];
	    }elseif (preg_match('/Chrome\/([^\s]+)/i', $agent, $regs)){
	    	 $browser     = 'Chrome';
	         $browser_ver = $regs[1];
	    }
	    elseif (preg_match('/safari\/([^\s]+)/i', $agent, $regs))
	    {
	        $browser     = 'Safari';
	        $browser_ver = $regs[1];
	    }
	    elseif (preg_match('/NetCaptor\s([^\s|;]+)/i', $agent, $regs))
	    {
	        $browser     = '(IE' .$browser_ver. ') NetCaptor';
	        $browser_ver = $regs[1];
	    }
	    elseif (preg_match('/Lynx\/([^\s]+)/i', $agent, $regs))
	    {
	        $browser     = 'Lynx';
	        $browser_ver = $regs[1];
	    }
	
	    if (!empty($browser))
	    {
	       //return addslashes($browser . ' ' . $browser_ver);//转义引号
	       return array(
				'browser'    		=>$browser,
				'browser_version'	=>$browser_ver,
			);
	    }
	    else
	    {
	        return array(
				'browser'    		=>'Others',
				'browser_version'	=>'1',
			);
	    }   	
  	}
  	
  	// get refer for bas log
	public static function getAdRefer(){
		// Save refer log
		$refer = $_SERVER['HTTP_REFERER'];
		if(!empty($refer) && strpos($refer,'oasgames.com') === FALSE){
			return 	$refer;		
		}
		else{
			return '';
		}
	}
	
	// save landing position in cookie
	public static function saveLandingPosition($position=null){
		
		if(!empty($_REQUEST[BA_LP_KEY_R])){
			setcookie(BA_LP_KEY_C, $_REQUEST[BA_LP_KEY_R], 0, '/', 'oasgames.com');
		}
		else if(!empty($position) && empty($_COOKIE[BA_LP_KEY_C])){
			setcookie(BA_LP_KEY_C, $position, 0, '/', 'oasgames.com');
		}
	}
	
}// class end
