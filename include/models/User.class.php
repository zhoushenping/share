<?php
	!defined('IN_APP') and exit;
	
	class User extends Model{
                private $table = 'users';
		
		public function __construct($db){
                    parent::__construct($db);
                }


		/**
		* 判断用户是否存在
		*/
		public function isExist($uid){
			if(!empty($uid) and is_numeric($uid)){
                            filterInput($uid);
				$sql = "select count(*) as `c` from `{$this->table}` where `uid`='$uid' ";
				$rs  = self::$db->query_first_column($sql);
                                
				return $rs;
			} else {
				return false;
			}
		}
		/**
		* 获取用户信息
		*/
		public function getUserinfo($uid){
			if(empty($uid) or !is_numeric($uid)){
				return false;
			}
                        filterInput($uid);
			$sql = "select `uid` as `id`,`name`,`email`,`gender` from `{$this->table}` where `uid`='$uid' ";
			$rs = self::$db->query($sql);
			if($rs === false){
				return false;
			} else {
				return $rs[0];
			}
		}

		/**
		* 添加用户信息
		*/
		public function addUserByProfile($user_profile){
                    filterInput($user_profile);
			$gender = $user_profile['gender'] == 'female' ? '0':'1';
			$birthday = strtotime( $user_profile['birthday']);
			$sql =	" insert into `{$this->table}` set ".
					" `uid` 	= '{$user_profile['id']}',".
					" `name`	= '{$user_profile['name']}', ".
					" `email`	= '{$user_profile['email']}', ".
					" `app`		= 'play', ".
					" `locale`	= '{$user_profile['locale']}', ".
					" `timezone`= '{$user_profile['timezone']}', ".
					" `gender`	= '$gender', ".
					" `birthday`= '$birthday', ".
                                        " `sp_promote`= '{$user_profile['sp_promote']}', ".
                                        " `sp_promote_id`= '{$user_profile['sp_promote_id']}', ".
                                        " `time_ip`= '{$user_profile['time_ip']}', ".
                                        " `last_login_ip` = '{$user_profile['time_ip']}',".
                                        " `last_login`	= ".time().",".
					" `time` = ".time();
                       		
			return self::$db->insert_sql($sql);
			
		}
		/**
		* 更新用户信息
		*/
		public function updateByProfile($user_profile){
                    filterInput($user_profile);
			$gender = $user_profile['gender'] == 'female' ? '0':'1';
			$birthday =strtotime( $user_profile['birthday']);
			$sql =	" update {$this->table} set ".
					" `name`	= '{$user_profile['name']}', ".
					" `email`	= '{$user_profile['email']}', ".
					" `locale`	= '{$user_profile['locale']}', ".
					" `timezone`= '{$user_profile['timezone']}', ".
					" `gender`	= '$gender', ".
					" `birthday`= '$birthday' ".
					" where `uid` 	= '{$user_profile['id']}' limit 1";
			return self::$db->execute_sql($sql);
		}
		
		/**
		* 更新用户最后登录时间
		*/
		public function updateLastLogin($uid,$ip){
                    filterInput($ip);
                    filterInput($uid);
                    $u_sql = "select * from `{$this->table}` where `uid`='{$uid}'";
                    $user_info = self::$db->query($u_sql);
                     $str = "";
                    if(!empty($user_info)){
                        $user_info = array_shift($user_info);
                        $last_login = $user_info['last_login'];
                        $l_date = date("Y-m-d",$last_login);
                        $s_date = date("Y-m-d");
                        if($l_date!=$s_date){
                            $str = " `nums` = `nums`+1 ,";
                        }
                    }
			$sql =	" update `{$this->table}` set ".
					" `last_login`	= ".time().",".
                                        $str.
                                        " `last_login_ip` = '{$ip}'".
					" where `uid` 	= '{$uid}' limit 1";
			return self::$db->execute_sql($sql);
		}
	/**
		* 更新平台UID
		*/
		public function updateOasUid($uid,$oas_uid){
                    $u_sql = "select * from `{$this->table}` where `uid`='{$uid}'";
                    $user_info = self::$db->query($u_sql);
                    if(!empty($user_info)){
                        $user_info = array_shift($user_info);
                        if(empty($user_info['oas_uid'])){
                            $sql = "update `{$this->table}` set ".
					" `oas_uid`= '".$oas_uid.
					"' where `uid` 	= '{$uid}' limit 1";
                            return self::$db->execute_sql($sql);
                        }
                    }
                    return true;
		}
                
                /**
                 * 以下为后台调用
                 */
                
                /**
                 * 返回符合条件用户的总数
                 * @param type $where
                 */
                public function getUserListCount($where = array()){
                    filterInput($where);
                    $sql = "select count(*) as `count` from `{$this->table}` ";
                    if(!empty($where)){
                        foreach ($where as $key=>$val){
                            if($val){
                               $sql .= " where ";
                                break;
                            }
                        }
                    }
                    
                    if($where['uid']){
                         $sql .= " `uid` = '".$where['uid']."'";
                    }
                    
                 
                    
                    if($where['name']){
                         if($where['uid']){
                             $sql .= " and `name` = '".$where['name']."'";
                         }else{
                            $sql .= " `name` = '".$where['name']."'";
                         }
                    }
                    
                 
                    
                    if($where['email']){
                         if($where['uid']|| $where['name']){
                             $sql .= " and `email` = '".$where['email']."'";
                         }else{
                            $sql .= " `email` = '".$where['email']."'";
                         }
                    }
                    
                    
                    if($where['time1']){
                         if($where['uid'] || $where['name'] ||  $where['email']){
                             $sql .= " and  `time` >= ".$where['time1'];
                         }else{
                            $sql .= " `time` >= ".$where['time1'];
                         }
                    }
                    if($where['time2']){
                        if($where['uid'] ||$where['name'] || $where['email']  || $where['time1']){
                            $sql .= " and `time` <".$where['time2'];
                        }else{
                             $sql .= " `time` <".$where['time2'];
                        }
                    }
                    if($where['last_login1']){
                          if($where['uid'] || $where['name'] || $where['email'] || $where['time1'] || $where['time2']){
                              $sql .= " and `last_login` >= ".$where['last_login1'];
                          }else{
                              $sql .= " `last_login` >= ".$where['last_login1'];
                          }
                    }
                    if($where['last_login2']){
                        if($where['uid']  || $where['name'] || $where['email'] || $where['time1'] || $where['time2'] || $where['last_login1']){
                            $sql .= " and `last_login` < ".$where['last_login2'];
                        }else{
                            $sql .= " `last_login` < ".$where['last_login2'];
                        }
                    }
                    
                    return self::$db->query($sql);
                    
                }
                
                /**
                 * 返回符合条件的用户列表
                 * @param type $where
                 */
                public function getUserList($where = array(),$start = 0,$limit = ''){
                    filterInput($where);
                    $sql = "select * from `{$this->table}` ";
                   if(!empty($where)){
                        foreach ($where as $key=>$val){
                            if($val){
                               $sql .= " where ";
                               break;
                            }
                        }
                    }
                    if($where['uid']){
                         $sql .= " `uid` = '".$where['uid']."'";
                    }
                    
                    if($where['email']){
                         if($where['uid']|| $where['name']){
                             $sql .= " and `email` = '".$where['email']."'";
                         }else{
                            $sql .= " `email` = '".$where['email']."'";
                         }
                    }
                    
                    
                    if($where['time1']){
                         if($where['uid'] || $where['name'] ||  $where['email']){
                             $sql .= " and  `time` >= ".$where['time1'];
                         }else{
                            $sql .= " `time` >= ".$where['time1'];
                         }
                    }
                    if($where['time2']){
                        if($where['uid'] ||$where['name'] || $where['email']  || $where['time1']){
                            $sql .= " and `time` <".$where['time2'];
                        }else{
                             $sql .= " `time` <".$where['time2'];
                        }
                    }
                    if($where['last_login1']){
                          if($where['uid'] || $where['name'] || $where['email'] || $where['time1'] || $where['time2']){
                              $sql .= " and `last_login` >= ".$where['last_login1'];
                          }else{
                              $sql .= " `last_login` >= ".$where['last_login1'];
                          }
                    }
                    if($where['last_login2']){
                        if($where['uid']  || $where['name'] || $where['email'] || $where['time1'] || $where['time2'] || $where['last_login1']){
                            $sql .= " and `last_login` < ".$where['last_login2'];
                        }else{
                            $sql .= " `last_login` < ".$where['last_login2'];
                        }
                    }
                    
                     $sql .=" order by `id` desc ";
                    
                    if($limit){
                        $sql .= " limit ".$start.",".$limit;
                    }
               
                    return self::$db->query($sql);
                }
	}
?>