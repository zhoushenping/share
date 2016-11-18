<?php

	!defined('IN_APP') and exit;
	/**
	* 题目
	*/
	class Server extends Model {
		
		private $table = 'server_list';
		
                 public function __construct($db){
                    parent::__construct($db);
                }
                /**
                 * 获取服务器列表
                 */
		public function getServerListByGameCode(){
				$sql =  " select * from `{$this->table}` where `valid` < 2  order by `server_sid` ";
				return self::$db->query($sql);	
		}
                
		/**
                * 获取服务器列表(不含平台服)
                */
		public function getServerListByGameCode_normal($t=0){
                                $t = (int)$t;
				$sql =  " select * from `{$this->table}` where `valid` < 2";
                                if($t>0){
                                    $sql .=  " and `server_sid`>2000 ";
                                }else{
                                    $sql .= " and `server_sid`<2000 ";
                                }
                                $sql .= " order by `server_sid` ";
				return self::$db->query($sql);	
		}
                /**
                * 获取服务器列表
                */
		public function getServerListBytuijian(){
				$sql =  " select * from `{$this->table}`  where `recommand` = '1' ";
				return self::$db->query($sql);	
		}
		/**
                * 获取服务器详情
                */
		public function getServer($server_sid){
			if( !empty($server_sid) and is_numeric($server_sid)){
                            filterInput($server_sid);
				$sql =  " select * from `{$this->table}`  where `server_sid` = '$server_sid' ";
				$rs = self::$db->query($sql);
				if($rs === false){
					return false;
				} else {
					return $rs[0];
				}
			} else {
				return false;
			}
		}
		
		/**
                * 获取服务器详情(可查询多个服务器的信息)
                */
		public function getServerBySids($sids){
			if(is_array($sids) and !empty($sids)){
				$sql =  " select * from `{$this->table}` where ";
				foreach($sids as $sid){
					if(is_numeric($sid)) $sql .= "`server_sid` = '$sid' or ";
				}
				$sql  = substr($sql,0,-3);
				$rs = self::$db->query($sql);
				if($rs === false){
					return false;
				} else {
					foreach($rs as $item){
						$arr_output[$item['server_sid']] = $item;
					}
					return $arr_output;
				}
			} else {
				return false;
			}
		}
                
                 /**
                 * 返回最大值
                 * @param type $t
                 * @return type
                 */
                public function getMaxServerId($t=''){
				$sql =  " select max(server_sid) as `server_sid` from `{$this->table}` where `valid` < 2";
                                if($t==''){
                                    $sql .= "  and `server_sid`<2000";
                                }else{
                                    $sql .="  and `server_sid`>2000";
                                }
				return self::$db->query($sql);	
		}
		
                /**
                 * 根据自增ID获取服务器信息
                 * @param type $id
                 */
                public function getServerInfoById($id=''){
                    if(!$id){
                        return false;
                    }
                    filterInput($id);
                    $id = (int)$id;
                    $sql = "select * from `{$this->table}` where `server_id`=".$id." limit 1";

                    return self::$db->query($sql);
                    
                    
                }
                
                /**
                 * 返回符合条件的总数
                 * @param type $valid
                 * @param type $recommand_oas
                 * @param type $recommand
                 * @return boolean
                 */
                public function getServerCount($valid='',$recommand_oas='',$recommand='',$server_sid=''){
                        $sql =  " select count(*) as `count` from `{$this->table}`";
                        
                        if($valid!='' || $recommand_oas!='' || $recommand!='' || $server_sid!=''){
                            $sql .= " where ";
                        }
                        if($valid!=''){
                            filterInput($valid);
                            $valid = (int)$valid;
                            $sql .= " `valid` = ".$valid;
                        }
                        if($recommand_oas!=''){
                            filterInput($recommand_oas);
                            $recommand_oas = (int)$recommand_oas;
                            if($valid!=''){
                                $sql .=" and `recommand_oas` = ".$recommand_oas;
                            }else{
                                $sql .=" `recommand_oas` = ".$recommand_oas;
                            }
                        }
                        
                        if($recommand!=''){
                            filterInput($recommand);
                            $recommand = (int)$recommand;
                             if($valid!='' || $recommand_oas!=''){
                                 $sql .=" and `recommand` = ".$recommand;
                             }else{
                                 $sql .=" `recommand` = ".$recommand;
                             }
                        }
                        if($server_sid!=''){
                            filterInput($server_sid);
                            $server_sid = (int)$server_sid;
                            if($valid!=''|| $recommand_oas!=''|| $recommand!=''){
                                $sql .=" and `server_sid` = ".$server_sid;
                            } else {
                                $sql .=" `server_sid` = ".$server_sid; 
                            }
                        }
                       
			$rs = self::$db->query($sql);
			if($rs === false){
				return false;
			} else {
                            return $rs;
			}
                }
                
		/**
                * 获取所有服务器详情
                */
		public function getServerAll($valid='',$recommand_oas='',$recommand='',$start=0,$limit='',$server_sid=''){
			$sql =  " select * from `{$this->table}`";
                        if($valid!='' || $recommand_oas!='' || $recommand!='' || $server_sid!=''){
                            $sql .= " where ";
                        }
                        if($valid!=''){
                            filterInput($valid);
                            $valid = (int)$valid;
                            $sql .= " `valid` = ".$valid;
                        }
                        if($recommand_oas!=''){
                            filterInput($recommand_oas);
                            $recommand_oas = (int)$recommand_oas;
                            if($valid!=''){
                                $sql .=" and `recommand_oas` = ".$recommand_oas;
                            }else{
                                $sql .=" `recommand_oas` = ".$recommand_oas;
                            }
                        }
                        
                        if($recommand!=''){
                            filterInput($recommand);
                            $recommand = (int)$recommand;
                             if($valid!='' || $recommand_oas!=''){
                                 $sql .=" and `recommand` = ".$recommand;
                             }else{
                                 $sql .=" `recommand` = ".$recommand;
                             }
                        }
                        if($server_sid!=''){
                            filterInput($server_sid);
                            $server_sid = (int)$server_sid;
                            if($valid!=''|| $recommand_oas!=''|| $recommand!=''){
                                $sql .=" and `server_sid` = ".$server_sid;
                            } else {
                                $sql .=" `server_sid` = ".$server_sid; 
                            }
                        }
                        $sql .= " order by `server_id` desc";
                        if($limit!=''){
                            $sql .= " limit ".$start.",".$limit;
                        }

                       
			$rs = self::$db->query($sql);
			if($rs === false){
				return false;
			} else {
                            if(!empty($rs)){
				foreach($rs as $item){
					$arr_output[$item['server_sid']] = $item;
				}
				return $arr_output;
                            }
                            return false;
			}
		}
		
		/**
                * 获取所有有效服务器详情
                */
		public function getServerValid(){
			$sql =  " select * from `{$this->table}` where `valid`='1'";
			$rs = self::$db->query($sql);
			if($rs === false){
				return false;
			} else {
				foreach($rs as $item){
					$arr_output[$item['server_sid']] = $item;
				}
				return $arr_output;
			}
		}

		/**
		 * 删除服信息
		 */
		public function delServer($server_id,$operator = ''){
			if(empty($server_id) or !is_numeric($server_id) or empty($operator)){
				return false;
			}
                        filterInput($server_id);
                        filterInput($operator);
			$sql =	" update `{$this->table}` set `valid` = '0'  ";
			(!empty($operator))	and	$sql .= ", `operator`	= '{$operator}' ";			
			$sql .= ", `modify_time` = ".time()." where `server_id` = '$server_id' limit 1" ;
			return self::$db->execute_sql($sql);
			
		}
                
		/**
		 * 设置推荐服信息
		 */
		public function setRecommandServer($server_id,$operator = ''){
			if(empty($server_id) or !is_numeric($server_id) or empty($operator)){
				return false;
			}
                        filterInput($server_id);
                        filterInput($operator);
			$sql =	" update `{$this->table}` set `recommand` = '1'  ";
			(!empty($operator))	and	$sql .= ", `operator`	= '{$operator}' ";			
			$sql .= ", `modify_time` = ".time()." where `server_id` = '$server_id' limit 1" ;
			return self::$db->execute_sql($sql);
			
		}

		private function validateinfo($serverinfo){
			$s = $serverinfo;
			if( empty($s['server_sid']) or empty($s['server_name'])){
				return false;
			} else {
				return true;
			}
		}
                
                 /**
                 * 新增获取不同地区服务器列表带分页
                 */
		public function getServerListAreaByGameCode($area="",$start=0,$pagesize=""){
                                filterInput($area);
				$sql =  " select * from `{$this->table}` where `valid` < 2";
                                if($area){
                                $sql .= " and `area`=".$area;  
                                }
                                $sql .= " order by `server_sid`"; 
                                if(!empty($pagesize)){
                                $sql .= " limit ".$start.",".$pagesize;  
                                }
				return self::$db->query($sql);	
		}
                
                /**
                 * 新增地区信息
                 */
		public function getareaList(){
				$sql =  " select `area` from `{$this->table}` group by `area`";
				return self::$db->query($sql);	
		}
	}

?>