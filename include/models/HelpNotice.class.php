<?php
	!defined('IN_APP') and exit;
	
	class HelpNotice extends Model{
		
		private $table = 'oas_help_notice';
		
		public function __construct($db){
                    parent::__construct($db);
                }
		
		
		/**
		* 添加通知
		*/
		public function addNotice($info){
			filterInput($info);
			$sql =	" insert into `{$this->table}` set ".
					" `title` 	= '{$info['title']}',".
					" `link`	= '{$info['link']}' ";				
					
			return self::$db->insert_sql($sql);
		}

		
		/**
		* 更新用户信息
		*/
		public function updateNotice($info){
			filterInput($userinfo);
			filterInput($info);
			$sql =	" update `{$this->table}` set ".
					" `title` 	= '{$info['title']}',".
					" `status`	= '{$info['status']}', ". 
					" `link`	= '{$info['link']}' ". 
					" where `id` = '{$info['id']}' limit 1";				
					
			return self::$db->execute_sql($sql);
		}
		
		/**
		* 更新用户最后登录时间
		*/
		public function getAllNotice(){
			
			$sql =	" select `order`,`link`,`title`,`status`,`id` from `{$this->table}` ";
			//echo $sql;
			return self::$db->query($sql);
		}

	}
	
	
?>