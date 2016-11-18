<?php
!defined('IN_APP') and exit;
/**
 * Description of activecode
 *
 * @author wanglun
 */
class Activecode  extends Model{
        private $table     = 'activecode';
        private $oas_table = 'oas_activecode';

        public function __construct($db){
            parent::__construct($db);
        }
        
        /**
         * 通过用户ID和游戏服ID返回激活码
         * @param type $uid
         * @param type $server_sid
         */
        public function getActivecode($uid,$server_sid){
            if(!$uid || !$server_sid){
                return false;
            }
            filterInput($uid);
            filterInput($server_sid);
            $sql = "select `code` from `{$this->table}` where `uid`= '$uid' and `server` = '$server_sid'";
            return self::$db->query($sql);
        }
		
		public function getOasActivecode($uid,$server_sid){
            if(!$uid || !$server_sid){
                return false;
            }
            filterInput($uid);
            filterInput($server_sid);
            $server_sid = intval($server_sid);
            $sql = "select `code` from `{$this->oas_table}` where `uid`= '$uid' and `server` = '$server_sid'";
            return self::$db->query($sql);
        }
        
        /**
         * 返回一条数据
         * @return type
         */
        public function getOne(){
            $sql = "select `id`,`code` from `{$this->table}` where `uid` is null limit 1";
            return self::$db->query($sql);
        }
		
		public function getOasOne(){
            $sql = "select `id`,`code` from `{$this->oas_table}` where `uid` is null limit 1";
            return self::$db->query($sql);
        }
        
        /**
         * 更新激活码数据
         * @param type $uid
         * @param type $server_sid
         * @param type $id
         * @return boolean
         */
        public function updateActiveCode($uid,$server_sid,$id){
            if(!$uid || !$server_sid || !$id){
                return false;
            }
            filterInput($uid);
            filterInput($server_sid);
            filterInput($id);
            $sql = "update `{$this->table}` set `uid` = {$uid},`server` = {$server_sid},`get_time` =".time()." where `id` = {$id} limit 1";
            return self::$db->execute_sql($sql);
        }
		
		public function updateOasActiveCode($uid,$server_sid,$id){
            if(!$uid || !$server_sid || !$id){
                return false;
            }
            filterInput($uid);
            filterInput($server_sid);
            filterInput($id);
            $id = intval($id);
            $server_sid = intval($server_sid);
            $sql = "update `{$this->oas_table}` set `uid` = '{$uid}',`server` = {$server_sid},`get_time` =".time()." where `id` = {$id} limit 1";
            return self::$db->execute_sql($sql);
        }
        
        /**
         * 返回符合条件的激活码总数
         * @param type $server_sid
         * @param type $uid
         * @param type $locked
         */
        public function getNewCodeListCount($server_sid=0,$uid=0,$get_time=''){
            filterInput($uid);
            filterInput($server_sid);
            filterInput($get_time);
            $server_sid = intval($server_sid);
            $sql = "select count(*) as count from `{$this->table}`";
            if($uid || $server_sid || ($get_time||$get_time=="0")){
                $sql .= " where ";
            }
            if($uid>0){
                $sql .= " `uid` = '".$uid."'";
            }
            
            if($server_sid>0){
                if($uid){
                    $sql .= " and `server` = ".$server_sid;
                }else{
                    $sql .= " `server` = ".$server_sid;
                }
            }
            
             if($get_time){
                 if($uid || $server_sid){
                    $sql .= " and `uid` is not null ";
                }else{
                    $sql .= " `uid` is not null ";
                }
            }else if($get_time=="0"){
                if($uid || $server_sid){
                    $sql .= " and `uid` is null ";
                }else{
                    $sql .= " `uid` is null ";
                }
            }

            return self::$db->query($sql);
        }
        
        /**
         * 返回符合条件的激活码
         * @param type $server_sid
         * @param type $uid
         * @param type $locked
         * @param type $start
         * @param type $limit
         */
        public function getNewCodeList($server_sid=0,$uid=0,$get_time='',$start=0,$limit=''){
            filterInput($uid);
            filterInput($server_sid);
            filterInput($get_time);
            $server_sid = intval($server_sid);
            $sql = "select * from `{$this->table}`";
            if($uid || $server_sid ||  ($get_time||$get_time=="0")){
                $sql .= " where ";
            }
            if($uid>0){
                $sql .= " `uid` = '".$uid."'";
            }
            
            if($server_sid>0){
                if($uid){
                    $sql .= " and `server` = ".$server_sid;
                }else{
                    $sql .= " `server` = ".$server_sid;
                }
            }
            
             if($get_time){
                 if($uid || $server_sid){
                    $sql .= " and `uid` is not null ";
                }else{
                    $sql .= " `uid` is not null ";
                }
            }else if($get_time=="0"){
                if($uid || $server_sid){
                    $sql .= " and `uid` is null ";
                }else{
                    $sql .= " `uid` is null ";
                }
            }
            
            if($limit){
                $sql .= " limit ".$start.",".$limit;
            }
            
            return self::$db->query($sql);
        }
        
        /*
         * 查询未被领取的app激活码数量
         */
        public function getActiveCodeCount()
        {
            $sql = "select count(*) as `count` from `{$this->table}` where `uid` is null";
            return self::$db->query($sql);
        }
        
        /*
         * 查询未被领取的平台激活码数量
         */
        public function getOasActiveCodeCount()
        {
            $sql = "select count(*) as `count` from `{$this->oas_table}` where `uid` is null";
            return self::$db->query($sql);
        }
}

?>