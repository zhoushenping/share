<?php
	!defined('IN_APP') and exit;
	
	class HelpContent extends Model{
		
		private $table = 'oas_help_content';
		
		public function __construct($db){
                    parent::__construct($db);
                }
		
                /**
                 * 返回符合条件的数量
                 * @param type $class
                 */
                public function getListCount($class=''){
                    //echo $class;
			if(!empty($class)){
                                filterInput($class);
				$sql = "select count(*) as count from `{$this->table}` where `first_c`='$class' order by `id` desc ";
                               
				return self::$db->query($sql);
			} else {
				$sql = "select count(*) as count from `{$this->table}`  order by `id` desc ";
                             
				//echo $sql;
				return self::$db->query($sql);
			}
                }
                
                /**
                 * 返回内容列表页
                 * @param type $class
                 * @param type $start
                 * @param type $pageSize
                 * @return type
                 */
		public function getList($class='',$start=0,$pageSize=''){
			//echo $class;
			if(!empty($class)){
                                filterInput($class);
                                $sql = "select `id`,`first_c`,`title_out`, `title_in`,`order`,`status`,`time`,`m_time`,`arc_redirect`,`label` from `{$this->table}` where `first_c`={$class}  order by `id` desc ";
                                if($pageSize){
                                    $sql .= " limit ".$start.",".$pageSize;
                                }

				return self::$db->query($sql);
			} else {
				$sql = "select `id`,`first_c`,`title_out`,`title_in`, `order`,`status`,`time`,`m_time`,`arc_redirect`,`label` from `{$this->table}` order by `id` desc ";
                                if($pageSize){
                                    $sql .= " limit ".$start.",".$pageSize;
                                }
				
				return self::$db->query($sql);
			}
		}
		
                /**
                 * 通过ID更新数据
                 * @param type $id
                 * @return boolean
                 */
                public function updateInfo($id='',$status='Y'){
                    if($id){
                        filterInput($id);
                        filterInput($status);
                        $id = intval($id);
                        $sql ="update `{$this->table}` set `status` = '{$status}',`m_time`=".time()." where `id` = ".$id." limit 1";
                        return self::$db->execute_sql($sql);
                    }
                    return false;
                }
                
		/**
		* 获取内容信息
		*/
		public function getDetailInfo($id){
			if(empty($id) or !is_numeric($id)){
				return false;
			}
                        filterInput($id);
			$sql = "select `status`,`content`,`order`,`title_in`,`title_out`,`first_c`,`id`,`label`,`seo_keyword` from `{$this->table}` where id='$id' ";
			$rs = self::$db->query($sql);
			if($rs === false){
				return false;
			} else {
				return $rs[0];
			}
		}

		/**
		* 添加信息
		*/
		public function addBasicInfo($ContentInfo){
			filterInput($ContentInfo);
			
			$sql =	" insert into `{$this->table}` set ".
					" `first_c` 	= '{$ContentInfo['first_c']}',".
					" `title_out`	= '{$ContentInfo['title_out']}', ".
					" `title_in`	= '{$ContentInfo['title_in']}', ".
					" `order`		= '{$ContentInfo['order']}', ".
					" `content`		= '{$ContentInfo['content']}', ". 
					" `label`       = '{$ContentInfo['label']}', ".
					" `seo_keyword` = '{$ContentInfo['seo_keyword']}', ".
					" `time` = ".time().",".
					" `m_time` = ".time();        
				//echo $sql;	
			return self::$db->insert_sql($sql);
			
		}
		/**
		* 更新除文章之外的信息
		*/
		public function updateBasicInfo($ContentInfo){
			filterInput($ContentInfo);
                        $id = intval($ContentInfo['id']);
			$sql =	" update `{$this->table}` set ".
					" `first_c` 	= '{$ContentInfo['first_c']}',".
					" `title_out`	= '{$ContentInfo['title_out']}', ".
					" `title_in`	= '{$ContentInfo['title_in']}', ".
					" `order`		= '{$ContentInfo['order']}', ".
					" `status`		= '{$ContentInfo['status']}', ".
					" `content`		= '{$ContentInfo['content']}', ".
					" `seo_keyword`	= '{$ContentInfo['seo_keyword']}', ".
					" `m_time` = ".time().",".
                                        " `label`               = '{$ContentInfo['label']}' ".
					" where `id` = '{$id}' limit 1";
			//echo $sql;
			return self::$db->execute_sql($sql);
		}
		
		/**
		* 更新文章内容
		*/
		public function changeContent($id,$ContentInfo){
			if(empty($id) or !is_numeric($id)){
				return false;
			}
                        filterInput($id);
			filterInput($ContentInfo);
                        $id = intval($id);
			$sql =	" update `{$this->table}` set ".
					" `content`	= '$ContentInfo'".
					" where `id` 	= '{$id}' limit 1";
			//echo $sql;
			return self::$db->execute_sql($sql);
		}
                
                /**
                 * 返回符合条件的数据
                 * @param type $comlumn
                 * @param type $add_arr
                 */
                public function getAll($column=array(),$add_arr=array(),$in_arr=array(),$start=0,$limit=0,$desc=''){
                        if(empty($column) or empty($add_arr)){
				return false;
			}
                        filterInput($column);
                        //filterInput($add_arr);
                        
                        $str = '';
                        if(!empty($column) && is_array($column)){
                             $str = implode('`,`', $column);
                             $sql = "select `".$str."` from `{$this->table}` ";
                        }else if(is_string($column)){
                            $sql = "select ".$column." from `{$this->table}` ";
                        }else{
                            return false;
                        }
                       
                        //与条件
                        $add_str = '';
                        if(!empty($add_arr)){
                            $add_num = count($add_arr);
                            foreach($add_arr as $key=>$val){
                                if(!$val){
                                    $val = "''";
                                }
                                if($add_num-1 > 0){
                                    $add_str .= $key."= ".$val ." and ";
                                }else{
                                    $add_str .= $key."= ".$val;
                                }
                                $add_num--;
                            }
                            $sql .= " where ".$add_str;
                        }
                        
                        //子查询
                        $in_str = '';
                        if(!empty($in_arr)){
                              $in_num = count($in_arr);
                               foreach($in_arr as $key=>$val){
                                if($in_num-1 > 0){
                                    $in_str .= "`".$key."` in(".$val .") and ";
                                }else{
                                    $in_str .= "`".$key."` in(".$val.") ";
                                }

                                if($add_str){
                                    $in_str = " and ".$in_str;
                                }
                            }
                            $sql .= $in_str;
                        }
                        if($desc){
                               $sql .= " order by `".$desc."` desc";
                        }else{
                            $sql .= " order by  `time` desc";
                        }
                        if($limit){
                            $sql .= " limit ".$start.",".$limit;
                        }
                        return self::$db->query($sql);
                }
                
                /**
                 * 返回一定条件的总数
                 * @param type $first_c
                 */
                public function getCount($first_c=0){
                    if(!$first_c){
                        return false;
                    }
                    filterInput($first_c);
                    $sql = "select count(*) as count from `{$this->table}`  where `first_c`='{$first_c}' and `status`='Y'";
                    
                    return self::$db->query($sql);
                }
                
                /**
                 * 根据ID返回内容
                 * @param type $id
                 */
                public function getContentById($id=0){
                     if(!$id){
                        return false;
                     }
                     filterInput($id);
                     $sql = "select * from `{$this->table}`  where `id` = {$id} and `status`='Y'";
                     return self::$db->query($sql);
                }
               public function changeInfo($id='',$status='re'){
                    if($id){
                        filterInput($id);
                        filterInput($status);
                        $id = (int)$id;
                        $sql = "update `{$this->table}` set `label` = '{$status}',`m_time`=".time()." where `id` = ".$id." limit 1";
                        return self::$db->execute_sql($sql);
                    }
                }
                
                
                 /**
                 * 前端调用返回符合条件的数量
                 * @param type $class
                 */
                public function getListCounts($class=''){
                    //echo $class;
			if(!empty($class)){
                                filterInput($class);
                                $class = (int)$class;
				$sql = "select count(*) as count from `{$this->table}` where `first_c`='$class' and `status`= 'Y'  order by `order` desc ";
                               
				return self::$db->query($sql);
			} else {
				$sql = "select count(*) as count from `{$this->table}` where `status`= 'Y'  order by `first_c` desc, `order` desc ";
                             
				//echo $sql;
				return self::$db->query($sql);
			}
                }
                
                /**
                 * 前端调用
                 * @param type $class
                 * @param type $start
                 * @param type $pageSize
                 * @return type
                 */
                public function getLists($class='',$start=0,$pageSize=''){
			//echo $class;
			if(!empty($class)){
                                filterInput($class);
                                $class = (int)$class;
                                $sql = "select `id`,`first_c`,`title_out`, `title_in`,`order`,`status`,`time`,`m_time`,`arc_redirect` from `{$this->table}` where `first_c`={$class} and `status`='Y'  order by `time` desc ";
                                if($pageSize){
                                    $sql .= " limit ".$start.",".$pageSize;
                                }

				return self::$db->query($sql);
			} else {
				$sql = "select `id`,`first_c`,`title_out`,`title_in`, `order`,`status`,`time`,`m_time`,`arc_redirect` from `{$this->table}` where `status`='Y'  order by `time` desc,`first_c` desc, `order` desc ";
                                if($pageSize){
                                    $sql .= " limit ".$start.",".$pageSize;
                                }
				
				return self::$db->query($sql);
			}
		}

		public function getListCounts_byTwo()
        {
        	$sql = "select count(*) as count from `{$this->table}` where `first_c` in (1,2) and `status`= 'Y'  order by `first_c` desc, `order` desc ";
                     
			//echo $sql;
			return self::$db->query($sql);
		}
		
		public function getLists_byTwo($start=0,$pageSize='')
		{
			$sql = "select `id`,`first_c`,`title_out`,`title_in`, `order`,`status`,`time`,`m_time`,`arc_redirect` from `{$this->table}` where `first_c` in (1,2) and `status`='Y'  order by `time` desc,`first_c` desc, `order` desc ";
            if($pageSize)
            {
                $sql .= " limit ".$start.",".$pageSize;
            }
				
			return self::$db->query($sql);
		}
		
		public function getLists_byThree($id,$type,$class,$start=0,$pageSize=1)
		{
			if($type == 'desc')
			{
				$sql = "select `id`,`first_c`,`title_out`,`title_in`, `order`,`status`,`time`,`m_time`,`arc_redirect` from `{$this->table}` where id<$id and `first_c`='$class' and `status` = 'Y' order by `time` desc,`first_c` desc, `order` desc";
			}
			else 
			{
				$sql = "select `id`,`first_c`,`title_out`,`title_in`, `order`,`status`,`time`,`m_time`,`arc_redirect` from `{$this->table}` where id>$id and `first_c`='$class' and `status` = 'Y' order by `time` asc,`first_c` asc, `order` asc";
			}
			
	        if($pageSize)
	        {
	            $sql .= " limit ".$start.",".$pageSize;
	        }
				
			return self::$db->query($sql);
		}
	}
?>