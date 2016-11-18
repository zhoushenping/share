<?php
!defined('IN_APP') and exit;
class Oas_check_user extends Model{
		
        private $table = 'oas_check_user';

        public function __construct($db){
            parent::__construct($db);
        }
        
        /**
         * 获取所有黑名单,白名单,或按uid查询
         */
        public function getCheckuser($searchuid='',$start=0,$limit=''){
            $sql = "select * from `{$this->table}`";
            if($searchuid!=''){
                filterInput($searchuid);
                  $sql .= " where `uid`='".$searchuid."'";
            }
            if($limit!=''){
                  $sql .= " limit ".$start.",".$limit;
            }
            return self::$db->query($sql);
        }
        
        /**
         * 
         * 获取一条信息
         */
         public function getCheckUserInfoById($id=''){
            if(!$id){
                return false;
            }
            filterInput($id);
            $id = (int)$id;
            $sql = "select * from `{$this->table}` where `id`={$id}";
            return self::$db->query($sql);
        }
        /*
         * 修改信息
         */
        public function updateCheckUser($check_add_mdy,$operator=''){
            $userid = $check_add_mdy['id'];
			
            if(empty($userid) or !is_numeric($userid)){
                    return false;
            }else{
                    filterInput($check_add_mdy);
                    filterInput($operator);
                    $sql =	"update `{$this->table}` set  ";
                    (!empty($check_add_mdy['uid']))and	$sql .= " `uid` 	= '{$check_add_mdy['uid']}' ";
                    (!empty($check_add_mdy['type_id']))and	$sql .= ", `type_id` 	= '{$check_add_mdy['type_id']}' ";	
                    (!empty($operator))and	$sql .= ", `operator`= '{$operator}' ";			
                    $sql .= ", `time` = ".time()." where `id` = '$userid' limit 1" ;
                    return self::$db->execute_sql($sql);
            } 
        }
        
        /*
         * 添加黑名单
         */
        public function addCheckUser($check_add_mdy,$operator=''){	
                filterInput($check_add_mdy);
                filterInput($operator);
                $sql =	"insert into `{$this->table}` set ";
                (!empty($check_add_mdy['uid']))and	$sql .= " `uid` = '{$check_add_mdy['uid']}' ";
                (!empty($check_add_mdy['type_id']))and	$sql .= ", `type_id` 	= '{$check_add_mdy['type_id']}' ";
                (!empty($operator))and	$sql .= ", `operator`= '{$operator}' ";			
                $sql .= " , `time` = ".time() ;
                return self::$db->execute_sql($sql);
        }
        /*
         * 删除黑白名单用户ID
         */
        public function deleteCheckUser($id,$operator){
                if(empty($id) or !is_numeric($id)){
                    return false;
                }else{ 
                    $sql ="delete from `{$this->table}` where `id`={$id} limit 1";
                    return self::$db->execute_sql($sql);
                }
        }
        
        /*
         * 获取记录条数
         */
        public function getCheckCount(){
                $sql =  " select count(*) as `count` from `{$this->table}`";
                $rs = self::$db->query($sql);
                if($rs === false){
                    return false;
                } else {
                    return $rs;
                }
       }
       
       /*
        * 返回登录黑名单数组黑名单
        */
       public function killUser(){
            $sql = "select `uid` from `{$this->table}` where `type_id`=1";
            $rs = self::$db->query($sql);
            $killuser=array();
            if($rs){
            	    foreach($rs as $val){
            	    	array_push($killuser,$val['uid']);
            	    }
                    return $killuser;
            } else {
                    return $killuser;
            }
        }
        
/*
        * 返回登录白名单数组
        */
       public function whiteUser(){
            $sql = "select `uid` from `{$this->table}` where `type_id`=2";
            $rs = self::$db->query($sql);
            $whiteuser=array();
            if($rs){
            	    foreach($rs as $val){
            	    	array_push($whiteuser,$val['uid']);
            	    }
                    return $whiteuser;
            } else {
                    return $whiteuser;
            }
        }
}

?>