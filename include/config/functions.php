<?php
	/*
	 * curl调用
	 */
	function post_request($url, $params=array()) {
        if ( strpos( $url , 'http' ) === false) $url = 'http:' . $url;
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/x-www-form-urlencoded"));
		//curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: text/html"));
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_TIMEOUT, 6);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);  
		curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params));  
		$result = curl_exec($ch);
                $httpinfo= curl_getinfo($ch);
		curl_close($ch);
		//print_r($httpinfo);
		$info = "{$httpinfo['http_code']}|$url|$result";
		//Log::save_run_log($info,'curl');
		if($httpinfo['http_code'] == 200){
			return $result;
		} else {
			return false;
		}
	}
	/**
	 * Curl 模拟POST 远程提交数据
	 * @param string $url
	 * @param mixed $data 有数据说明是发送是POST请求
	 * @return mixed
	 */
	function curlRequest($url,$data = ''){
        if ( strpos( $url , 'http' ) === false) $url = 'http:' . $url;
		$curl = curl_init(); 
		curl_setopt($curl, CURLOPT_URL, $url); 
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0); 
		curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 2); 
		curl_setopt($curl, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']); 
		curl_setopt($curl, CURLOPT_AUTOREFERER, 1); 
		if(!empty($data)){
			curl_setopt($curl, CURLOPT_POST, 1); 
			curl_setopt($curl, CURLOPT_POSTFIELDS, $data); 
		}
		curl_setopt($curl, CURLOPT_TIMEOUT, 6); 
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1); 
		$resultData = curl_exec($curl);
		$httpInfo= curl_getinfo($curl);
		//Log::save_run_log("{$httpInfo['http_code']}|$url|$resultData",'curl_common');
		if (curl_errno($curl)) {
			curl_close($curl);
			return false;
		}else{
			curl_close($curl);
			return $resultData;
		}
		
	}
        /**
         * 截取字符串，包括汉字
         * @param type $str
         * @param type $len
         * @return type
         */
        function utf_substr($str,$len)
        {
                for($i=0;$i<$len;$i++)
                {
                        $temp_str=substr($str,0,1);
                        if(ord($temp_str) > 127)
                        {
                                $i++;
                                if($i<$len)
                                {
                                        $new_str[]=substr($str,0,3);
                                        $str=substr($str,3);
                                }
                        }else{
                                $new_str[]=substr($str,0,1);
                                $str=substr($str,1);
                                }
                }
                return join($new_str);
        }

	
	function xml_unserialize(&$xml, $isnormal = FALSE) {
		$xml_parser = new XML($isnormal);
		$data = $xml_parser->parse($xml);
		$xml_parser->destruct();
		return $data;
	}
	
	/**
         * 获得请求端的xml
	 */
	function post_request_xml($url, $params=array()) {
		
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
		//curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/x-www-form-urlencoded"));
		curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: text/html"));
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_TIMEOUT, 3);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);  
		curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params));
		  
		$result = file_get_contents('php://input');
		
                $httpinfo= curl_getinfo($ch);
		curl_close($ch);;
		$info = "{$httpinfo['http_code']}|$url|$result";
		Log::save_run_log($info,'curl');
		if($httpinfo['http_code'] == 200){
			return $result;
		} else {
			return false;
		}
	}

        //重定向
        function redirect($url='',$msg=''){
            if($url){
                header('Location:./?act=index&method=redirect&redirect_url='.$url); 
            }
        }
	//调用https的地址
	function get_request_https($url){
        if ( strpos( $url , 'http' ) === false) $url = 'http:' . $url;
		$ch = curl_init();  
		curl_setopt($ch, CURLOPT_URL,$url);  
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);  
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);  
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);  
		curl_setopt($ch, CURLOPT_TIMEOUT, 15);
		
		$result = curl_exec($ch); 
	 	$httpinfo = curl_getinfo($ch);
	 	
		$info = "{$httpinfo['http_code']}|$url|$result";
		Log::save_run_log($info,'curlhttps');
		
		curl_close($ch);
		if($httpinfo['http_code'] == 200){
			return $result;
		} else {
			return false;
		}
	}



	/**
	 * 获得请求端的ip地址
	 */
	function  get_client_ip() {
		global  $_SERVER;
		if (!empty($_SERVER["HTTP_X_FORWARDED_FOR"])) {
			$ip  =  $_SERVER["HTTP_X_FORWARDED_FOR"];
		} elseif (!empty($_SERVER["HTTP_CLIENT_IP"])) {
			$ip  =  $_SERVER["HTTP_CLIENT_IP"];
		} else {
			$ip  =  $_SERVER["REMOTE_ADDR"];
		}
		return  $ip;
	}
	
	/**
         * 接口999操作失败
	 * forexample: response_999(__FILE__,__LINE__,__FUNCTION__,"SQL");
	 */
	function response_999($file,$line,$function,$err_type){
		$parameters = get_parameters();
		$file = strstr($file,"u.");
		$log = "|response:999|file:$file|line:$line|function:$function|err_type:$err_type|$parameters";
		Log::save_run_log($log,"run");
		echo "-999";
		exit;
	}
	/**
	 * 接口返回结果函数
	 */
	function response($result){
		echo $result;
		exit;
	}
	
	/**
	 * 取得精确时间值
	 */
	function microtime_float(){
   		list($usec, $sec) = explode(" ", microtime());
    	return ((float)$usec + (float)$sec);
	}
	
	
	/**
	 * 取得请求参数，并组成字符串
	 * 格式为 {parameter:value|parameter:value|parameter:value|parameter:value……………………}
	 */
	function get_parameters() {
		global $_GET,$_POST;
		$parameters = "";
		if($_GET){
			foreach($_GET as $key => $val){
				if($key == 'sign'){
					continue;
                                }else{
					$parameters .= "$key:$val|";
                                }
			}
		}
		if($_POST){
			foreach($_POST as $key => $val){
				if($key == 'sign'){
					continue;
                                }else{
					$parameters .= "$key:$val|";
                                }
			}
		}
		if(strlen($parameters) > 1 ){
			$parameters = substr($parameters,0,-1);
                }
		return "{".$parameters."}";
	}
	
        /**
         * 返回客户端使用浏览器语言
         * @return boolean
         */
	function get_browser_language()	{
		if(!empty($_SERVER['HTTP_ACCEPT_LANGUAGE'])){
			$accept_lang = explode(',', $_SERVER['HTTP_ACCEPT_LANGUAGE']);
			return $accept_lang[0];
		} else {
			return false;
		}
	}
	
	/**
         * 过滤
         * @param type $info
         * @return boolean
         */
	function filterInput(&$info){
		if(empty($info)) return false;
		if(is_array($info)){
			foreach ($info as $key=>$val){
				$info[$key] = addslashes($val);
			}
		} else {
			$info = addslashes($info);
		}
	}
	
	function matchSex($total_friend,$sex,$friends){

		$ran = rand(0,$total_friend-1);
		
		if($sex == 2) return $ran;
		if ($sex == 1 and $friends[$ran]['sex']=='male'){
			return $ran;
		} else if ($sex == 0 and $friends[$ran]['sex']=='female'){
			return $ran;
		} else {
			$ran =  matchSex($total_friend,$sex,$friends);
		}
	}
	
        /**
         * 获取参数公共函数
         * @global type $_GET
         * @return type
         */
	function get_GetParameters() {
		global $_GET;
		$parameters = "";
		if($_GET){
			foreach($_GET as $key => $val){
				$parameters .= "$key:$val|";
			}
		}
		if(strlen($parameters) > 1 ){
			$parameters = substr($parameters,0,-1);
                }
		return $parameters;
	}

	function getRandomIndexByWeight($weights){
		
		// Pretreat data
		$cnt  = count($weights);
		for ($i=0; $i<$cnt; $i++){
			$weights[$i] = $weights[$i];		
		}
		
		// Get a seed
		$seed = mt_rand(1,100);
		
		for($i = 0; $i < $cnt ; $i++ ){
			if( $i == 0){
				$indexs[$i] = $weights[$i]; 
			}
			else{
				$indexs[$i] = $indexs[$i -1] + $weights[$i];
			}
		}
		for($i=0; $i < $cnt ; $i++){
			if($seed <= $indexs[$i]){
				return $i;
			}
		}
		// 
		return 0;
	}
        
        /**
         * 以下是支付函数
         */
         /**
          * 返回登录游戏地址函数
          * @param type $uid
          * @param type $uname
          * @param type $serverinfo
          * @return string
          */
	function makeLoginUrl($uid,$uname,$serverinfo){
		$time 		= time();
		$password	= md5(rand(1,999));
		$login_key  = $serverinfo['server_inner_ip'];
		$sign 		= md5($uid.$password.$time.$login_key);
		$content 	= "$uid|$password|$time|$sign";
		
		$server_url = $serverinfo['server_url'];
		$site		= $serverinfo['server_secret_key'];
		
		$login_web	= $server_url."createlogin?content=$content&site=".$site;

		$rs	=	post_request($login_web);
		
		if("".$rs==='0'){
			$login_url = $server_url."client/game.jsp?user=$uid&key=$password&site=".$site;
			if($_SERVER['SERVER_PORT'] == 443 ){
				//$login_url = str_replace('http://','https://',$login_url);
			}			
			return $login_url;
		} else {
			return WARING_SERVER_URL;
		}

	}
        /**
         * 返回充值地址
         * @param type $uid
         * @param type $order_id
         * @param type $serverinfo
         * @param type $point
         * @param type $money
         * @param type $moneytype
         * @param type $payway
         * @return boolean|string
         */
	function makePayUrl($uid, $order_id, $serverinfo, $point, $money,
							$moneytype='USD', $payway='Facebook' ){
		
		$site		= $serverinfo['server_secret_key'];
		$server_url = $serverinfo['server_url'];
		$pay_key    = $serverinfo['server_public_ip'];
								
		$pay_web	= $server_url."loginselectlist?username=$uid&site=".$site;

		$xmlstr	=	post_request($pay_web);	
		
		$xml = new SimpleXMLElement($xmlstr);
		
		foreach($xml->Item as $item){
			if($item->attributes()->Site == $site)	$userid = $item->attributes()->ID;
		}
								
		$chargeID = $order_id;
		$key	  = md5(rand(1,999));
		$sign     = md5($chargeID.$uid.$point.$payway.$money.$moneytype.$pay_key);
		$content  = "$chargeID|$uid|$point|$payway|$money|$moneytype|$sign";
			
		$pay_url = $server_url."chargemoney?content=$content&site=".$site."&userid=$userid";
		
		return $pay_url;
		
	}
	
        /**
         * 返回一定格式数字
         * @param type $num
         * @return type
         */
	function formatNumber($num){
		if($num>0 and $num<10){
			return "00".$num;
		} else if ($num < 100 ){
			return "0".$num;
		} else {
			return $num;
		}
	}
	
        /**
         * 检查用户是否在黑名单里
         * @param type $uid
         * @param type $kill_user
         * @param type $chargebacks_url
         */
	function check_killuser($uid,$chargebacks_url){
		global $oas_check_user;
		$kill_user = $oas_check_user->killUser();
			if(in_array($uid,$kill_user)){
				header("Location:$chargebacks_url");
				exit;
			}
	}
	
        /**
         * 获取用户在游戏中的信息
         * @param type $uid
         * @param type $serverinfo
         * @return null
         */
	function get_user_game_info($uid,$serverinfo){
		$site		= $serverinfo['server_secret_key'];
		$server_url = $serverinfo['server_url'];
		$pay_key    = $serverinfo['server_public_ip'];
								
		$pay_web	= $server_url."loginselectlist?username=$uid&site=".$site;
		
		$xmlstr	=	post_request($pay_web);	
		
		if(strlen($xmlstr)<10){
			return null;
		}
		$xml = new SimpleXMLElement($xmlstr);
		
		$user_game_info = array();
		foreach($xml->Item as $item){
			$user_game_info['nick'] = $item->attributes()->NickName;
			$user_game_info['grade'] = $item->attributes()->Grade;
			$user_game_info['id'] = $item->attributes()->ID;
		}
		return $user_game_info;
	}
	
        /**
         * 返回用户邀请的好友
         * @global type $db
         * @param type $uid
         * @return type
         */
	function query_invited_uids($uid){
		global $db;
		$sql_str = "select `invited_uid` as c from 'oas_invite_record' where `uid`=$uid";
		$rs = $db->query($sql_str);
		$arr_invited_uids = array();
		if(!empty($rs)){
			foreach($rs as $item){
				$arr_invited_uids[] = $item['c'];
			}
		}
		return $arr_invited_uids;
	}
	
	
	/**
         * 支付页面用到的几个函数
         */	
	function server_pack($server_sid){
		global $db;
		$sql_server        ="select * from `oas_server_list` where `server_sid` = '$server_sid' ";
                $server_goods_pack = $db->query($sql_server);
	    
                return  $server_goods_pack;
	}

	function suit_list($server_pack_id){
		global $db;
		$sql_suit        = "select * from `oas_goods_suit` where `pack_id` = '$server_pack_id' ";		
		$suit_pack_list  = $db->query($sql_suit);
		return  $suit_pack_list;
	}
	
	function pack_goods($package_goods_list_detail){
		global $db;
		$sql_goods_list   = "select * from `oas_goods_list` where `goods_id` = '$package_goods_list_detail' ";		
		$goods_list       = $db->query($sql_goods_list);    
                return  $goods_list;
	}
	
	function ecall($arr){
		echo "<pre/>";
		print_r($arr);
		exit;
	}
	
	function getUserInfoAdvanced($info,$nameLength=20){
		if($info['val']['user_from']=='1' || $info['val']['user_from']=='5' ){
			$fb_user = true;
		}else{
			$fb_user = false;
		}
		
		$uid	=  $fb_user? $info['val']['snsUid']:$info['val']['id'];
		$uname  = !empty($info['val']['nickname'])?$info['val']['nickname']:$info['val']['uname'];
		$uemail = $info['val']['email'];
		
		$uname_full = $uname;
		if(!empty($uname)){
			if(strlen($uname)>$nameLength) {
				$uname = utf_substr($uname,$nameLength)."...";
			}
		}
		
		$output = array(
			'fb_user'=>$fb_user,
			'uid'=>$uid,
			'uname'=>$uname,
			'uname_full'=>$uname_full,
			'uemail'=>$uemail,
		);
		return $output;
	}
	
	function getUserInfo(){
           $oas_user = !empty($_COOKIE['oas_user'])?$_COOKIE['oas_user']:'';
           $passport_url = PASSPORT_URL."index.php?m=getLoginUser&oas_user=".$oas_user;
           $user_info = json_decode(post_request($passport_url),true);
           if(strtolower($user_info['status'])=='ok'){
               return $user_info;
           }else{
               return false;
           }
       }
	   
	function getUserInfobyZZL(){
        $oas_user = !empty($_COOKIE['oas_user'])?$_COOKIE['oas_user']:'';
        $passport_url = PASSPORT_URL."index.php?m=getLoginUser&oas_user=".$oas_user;
        $user_info = json_decode(post_request($passport_url),true);
        if(strtolower($user_info['status'])=='ok'){
            return $user_info;
        }else{
             return false;
        }
    }
	
	function assoc_unique($arr, $key)
     {
       	$tmp_arr = array();
       	foreach($arr as $k => $v)
      	{
         	if(in_array($v[$key], $tmp_arr))//搜索$v[$key]是否在$tmp_arr数组中存在，若存在返回true
	        {
	            unset($arr[$k]);
	        }
	      	else 
	      	{
	          	$tmp_arr[] = $v[$key];
	        }
     	}
    	return array_slice($arr,0,3);
   	}
	
	
?>