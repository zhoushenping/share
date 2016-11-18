<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of task_activecode
 *
 * @author Administrator
 */
!defined('IN_APP') and exit;
class Task_activecode extends Model{
    //put your code here
     private $table = 'task_activecode';

     public function __construct($db){
         parent::__construct($db);
     }
     
     /**
      * 通过用户ID返回
      * @param type $uid
      * @return boolean
      */
     public function getActiveCodeByUid($uid){
         if(!$uid){
             return false;
         }
         filterInput($uid);
         $sql  = "select * from `{$this->table}` where `uid`='$uid'";
         return self::$db->query($sql);
     }
     
      /**
         * 通过用户ID和游戏服ID返回激活码
         * @param type $uid
         * @param type $server_sid
         */
        public function getActivecode($uid){
            if(!$uid){
                return false;
            }
            filterInput($uid);
            $sql = "select `code` from `{$this->table}` where `uid`= '$uid'";
            return self::$db->query($sql);
        }
        
        /**
         * 返回一条数据
         * @return type
         */
        public function getOne(){
            $sql = "select `id`,`code` from `{$this->table}` where `uid` ='0' limit 1";
            return self::$db->query($sql);
        }
        
        /**
         * 更新激活码数据
         * @param type $uid
         * @param type $server_sid
         * @param type $id
         * @return boolean
         */
        public function updateActiveCode($uid,$id){
            if(!$uid || !$id){
                return false;
            }
            filterInput($uid);
            filterInput($id);
            $sql = "update `{$this->table}` set `uid` = '$uid',`get_time` ='".time()."' where `id` = '$id' limit 1";
            return self::$db->query($sql);
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
            $sql = "select count(*) as `count` from `{$this->table}`";
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
            if($uid!=''){
                $sql .= " `uid` = '".$uid."'";
            }
            
            if($server_sid!=''){
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
        
        /**/
        public function getTaskActiveCodeCount() {
            $sql = "select count(*) as `count` from `{$this->table}` where `uid` is null";
            return self::$db->query($sql);
        }

}

?>