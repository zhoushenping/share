<?php
	!defined('IN_APP') and exit;
	/**
	* 题目
	*/
	class Order_placed extends Model {
		private $table = 'oas_user_order_placed';
		
                public function __construct($db){
                    parent::__construct($db);
                }
	    
	    /**
	     * 获取用户的订单号
	     */
		public function get_user_order($order_id){
			if(!empty($order_id) and is_numeric($order_id)){
                            filterInput($order_id);
				$sql =  " select `pay_way`,`order_id`,`game_code`,`uid`,`uname`,`uemail`,`server_sid`,`order_time`,`game_coins`,`amount`,`currency_code`,`order_status`,`payment_id` from `{$this->table}`  where `order_id` = '$order_id'";
				//print $sql;
				return self::$db->query($sql);				
			} else {
				return false;
			}
		}

		/**
		 * 添加用户信息进入user_order_placed,返回order_id
		 * 
		 */
		public function add_user_order($game_code,$uid,$uname,$uemail,$server_sid,$game_coins,$amount,$currency_code,$order_status,$pay_way,$payment_id){
                                filterInput($game_code);
                                filterInput($uid);
                                filterInput($uname);
                                filterInput($uemail);
                                filterInput($server_sid);
                                filterInput($game_coins);
                                filterInput($amount);
                                filterInput($currency_code);
                                filterInput($order_status);
                                filterInput($pay_way);
                                filterInput($payment_id);
				$sql =	" insert into `{$this->table}` set ";
				$sql .= " `game_code` 	= '{$game_code}' ";
				$sql .= ", `uid`	= '{$uid}' ";
				$sql .= ", `uname` = '{$uname}' ";
				$sql .= ", `uemail` = '{$uemail}' ";
				$sql .= ", `server_sid` = '{$server_sid}' ";
				$sql .= ", `game_coins` = '{$game_coins}' ";
				$sql .= ", `amount` = '{$amount}' ";
				$sql .= ", `currency_code` = '{$currency_code}' ";
				$sql .= ", `order_status` = '{$order_status}' ";
				$sql .= ", `pay_way` = '{$pay_way}' ";
				$sql .= ", `payment_id` = '{$payment_id}' ";
				$sql .= ", `order_time` = ".time() ;
				
				return self::$db->insert_sql($sql);
			
		}
		
	
/**
		 * 更新settled状态
		 */	
		public function updatePayOrderStatus($order_id,$status){
			if(empty($order_id) or !is_numeric($order_id)){
				return false;
			}
                        filterInput($order_id);
                        filterInput($status);
			$sql =	" update `{$this->table}` set `order_status` = '$status' where `order_id` = '$order_id' limit 1" ;
			return self::$db->execute_sql($sql);			
		}
	
	}
?>