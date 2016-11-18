<?php

	class Log {
	
		public function Log(){
			
		}
		/**
		*	记录业务相关的日志 统一格式
		*/
		public static function save_run_log($info,$file_pre_name="") {
			if(empty($file_pre_name)){
				$file_name = date("Ymd").".log";
			}else{
				$file_name = $file_pre_name."_".date("Ymd").".log";
			}
			Log::write_log($info,$file_name);
		}
		
		/**
		*	记录系统出错的日志
		*/
		public static function save_err_log($info) {
			$file_name = "error_".date("Ymd").".log";
			Log::write_log($info,$file_name);
		}
		
		/**
		*	将日志信息写入到文本文件
		*/
		private static function write_log($info,$file_name) {
			//不记录特定的日志  减少日志体积
			if(
				   strpos($info,'pay.oasgames.com/core/_action.php?msg=getBlackList')           !== false
				or strpos($info,'graph.facebook.com/v2.2/me?access_token')        					!== false
				or strpos($info,'graph.facebook.com/v2.2/me/friends?access_token')					!== false
				or strpos($info,'oasgames.com/loginselectlist')									!== false 
			){
				return false;
			}
			
			$path = LOG_DIR;
			if(file_exists($path) == false) {
				mkdir($path);
				chmod($path,0777);
			}
			$fp  = fopen("$path/$file_name","a");			
			$log = "[".date("Y-m-d H:i:s")."]|".$info."\r\n";
			fwrite($fp,$log);
			fclose($fp);
		}
	}
?>