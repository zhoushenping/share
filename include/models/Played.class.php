<?php
	!defined('IN_APP') and exit;
	/**
	* 题目
	*/
	class Played extends Model{
		
                private $table = 'user_played';
                private $play_table = 'oas_user_playgame_log';
                private $play_new = 'oas_play_new';
                private $origin_table = 'user_origin';
                
                public function __construct($db){
                    parent::__construct($db);
                }

                /**
                 * 获取用户玩过的游戏服
                 */
		public function getPlayedArr($uid,$server_sid=0){
			if(!empty($uid) and is_numeric($uid)){
                                filterInput($uid);
                                filterInput($server_sid);
				$sql =  " select `server_sid`,`game_code`,`id`,`last_play_time`,`login_type`,`server_name`,`uid` from `{$this->table}`  where `uid` = '$uid' and `server_sid` > 0 ";
                                if($server_sid>0){
                                    $sql .= " and `server_sid` < 2000 ";
                                }
                                $sql .= " order by `last_play_time` desc ";
				//print $sql;
				return self::$db->query($sql);				
			} else {
				return false;
			}
		}

        public function setPlayNew($uid,$sid){
            if(!$uid || !$sid){
                return false;
            }
            filterInput($uid);
            filterInput($sid);
            //filterInput($grade);
            $sql = "insert into  `{$this->play_new}`(`uid`,`sid`,`ctime`) values({$uid},{$sid},".time().")";

            return self::$db->execute_sql($sql);
        }
		
                /**
                 * 返回用户类型
                 * @param type $uid
                 * @param type $server_sid
                 */
                public function getPlayTypeByUid($uid,$server_sid){
                    filterInput($server_sid);
                    filterInput($uid);
                    $sql = "select * from `{$this->table}` where `uid`='{$uid}' and `server_sid`={$server_sid} limit 1";
                    return self::$db->query($sql);
                }


                /**
	     * 获取用户玩过的游戏服(可一次处理多个uid)
	     */
		public function getPlayedArrByUids($uids){
			if(is_array($uids) and !empty($uids)){
                            filterInput($uids);
				$sql =  " select `server_sid`,`game_code`,`id`,`last_play_time`,`login_type`,`server_name`,`uid` from `{$this->table}`  where ";
				foreach($uids as $uid){
					if(is_numeric($uid)) $sql .= "`uid` = '$uid' or ";
				}
				$sql  = substr($sql,0,-3);
                                $sql .= " and `server_sid` < 2000 ";
				$sql .= "order by `last_play_time` desc group by `uid`";
				return self::$db->query($sql);
			}else {
				return false;
			}
		}

		/**
		 * 添加玩游戏服信息
		 * 
		 */
		public function addPlayedRecord($uid,$server_sid,$server_name,$login_type=1){
                                if(empty($server_sid) || empty($server_name) || empty($uid)){
                                    return false;
                                }
                                filterInput($uid);
                                filterInput($server_sid);
                                filterInput($server_name);
                                filterInput($login_type);
				$sql =	" insert into `{$this->table}` set ";
				$sql .= " `uid` 	= '{$uid}' ";
				$sql .= ", `server_name`	= '{$server_name}' ";
				$sql .= ", `server_sid` = '{$server_sid}' ";
				$sql .= ", `login_type` = '{$login_type}' ";
				$sql .= ", `last_play_time` = ".time() ;
				$sql .= " ON DUPLICATE KEY UPDATE `last_play_time` = ".time().", `server_name`	= '{$server_name}', `login_type`='{$login_type}'"; 
				
				return self::$db->execute_sql($sql);
			
		}
		
                /**
                 * 记录用户玩游戏日志
                 * @param type $uid
                 * @param type $server_sid
                 * @param type $grade
                 * @param type $ip
                 */
                public function setUserPlayGameLog($uid,$server_sid,$grade,$ip){
                    if($uid){
                        filterInput($uid);
                    }
                    if($server_sid){
                        filterInput($server_sid);
                    }
                    if($grade){
                         filterInput($grade);
                    }

                    $sql_q = "select * from `{$this->play_table}` where `uid`='{$uid}' and `server_sid`='{$server_sid}'";
                    $msg = self::$db->query($sql_q);
                    
                    if(!empty($msg)){
                        //更新
                        $sql_m = "update `{$this->play_table}` set `grade` = '{$grade}',`m_time`=".time().",`m_ip`='{$ip}' where `uid`='{$uid}' and `server_sid`='{$server_sid}' limit 1";
                        return self::$db->execute_sql($sql_m);
                    }else{
                        //插入
                        $sql_i = "insert into  `{$this->play_table}`(`uid`,`server_sid`,`grade`,`c_time`,`c_ip`,`m_time`,`m_ip`) values(
                            '{$uid}','{$server_sid}','{$grade}',".time().",'".$ip."',".time().",'".$ip."')";
                        return self::$db->execute_sql($sql_i);
                    }
                }
                
                /**
                 * 返回好友信息
                 * @param type $uids
                 * @param type $sid
                 */
                public function getUserFriends($uids,$sid){
                    if($uids){
                        filterInput($uids);
                    }
                    $sql = "select * from `{$this->play_table}` where `server_sid` <2000 and `uid` in ({$uids}) order by `m_time` desc";
                    $f_results = self::$db->query($sql);
                    $f_temp = array();
                    if(!empty($f_results)){
                        foreach($f_results as $key=>$val){
                            if(!empty($f_temp[$val['uid']])){
                               $f_temp[$val['uid']] =  $f_temp[$val['uid']]['m_time'] > $val['m_time'] ?$f_temp[$val['uid']]:$val;
                            }else{
                                $f_temp[$val['uid']] = $val;
                            }
                        }
                        return $f_temp;
                    }else{
                        return array();
                    }
                }
                
                /**
                 * 返回经分系统数据
                 * @param type $time
                 * @param type $id
                 */
                public function getPlayLog($time = 0,$id = 0){
                    if(empty($time)){
                        return false;
                    }
                    filterInput($time);
                    $time = (int)$time;
                    $sql = "select * from `{$this->play_table}` where `m_time` > $time";
                    
                    return self::$db->query($sql);
                }
                
		public function getPlayedArrNew($uid,$server_sid=0){
			if(!empty($uid) and is_numeric($uid)){
                filterInput($uid);
                filterInput($server_sid);
				$sql =  " select * from `user_playgame_log` s1,server_list s2 where s1.server_sid = s2.server_sid and `uid` = $uid and s1.`server_sid` > 0 ";
                if($server_sid>0){
                	$sql .= " and s1.`server_sid` < 2000 ";
                }
                $sql .= " order by `m_time` desc ";
				//return $sql;
				return self::$db->query($sql);				
			} else {
				return false;
			}
		}

        public function setUserOrigin($uid,$sid,$otype){
            if(empty($uid) || empty($sid) || empty($otype)){
                return false;
            }
            filterInput($uid);
            filterInput($sid);
            filterInput($otype);
            $oday = date("Y-m-d");
            $sql = "select * from `{$this->origin_table}` where `sid`={$sid} and `uid` = {$uid} and `oday`='{$oday}'";
            $result = self::$db->query($sql);
            if(empty($result)){
                $in_sql = "insert into `{$this->origin_table}`(`uid`,`sid`,`oday`,`otype`,`ctime`) values({$uid},{$sid},'{$oday}',{$otype},".time().")";
                return self::$db->execute_sql($in_sql);
            }else{
                return false;
            }
        }
                
	}

?>