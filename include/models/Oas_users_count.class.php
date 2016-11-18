<?php
!defined('IN_APP') and exit;

/**
 * Description of oas_users_count
 *
 * @author Administrator
 */
class Oas_users_count extends Model{
		
        private $table = 'oas_users_count';

        public function __construct($db){
            parent::__construct($db);
        }
        
        /**
         * 返回总数
         * @param type $sp_promote_id
         * @return boolean
         */
        public function getUserAdvCount($sp_promote_id='',$c_time){
            if($sp_promote_id||$sp_promote_id!=""){
                filterInput($sp_promote_id);
            }
            if($c_time){
                filterInput($c_time);
            }
            $sql = "select count(*) as `count` from `{$this->table}`";
            
            if($sp_promote_id||$sp_promote_id!="" || $c_time){
                $sql .=" where ";
            }
            
            if($sp_promote_id||$sp_promote_id!=""){
                $sql .= " `sp_promote_id` = '".$sp_promote_id."'";
            }
            
            if($c_time){
                if($sp_promote_id||$sp_promote_id!=""){
                    $sql .= " and `c_time` = '".$c_time."'";
                }else{
                    $sql .= " `c_time` = '".$c_time."'";
                }
            }
            
            return self::$db->query($sql);
            
        }
        
        /**
         * 返回总数
         * @param type $sp_promote_id
         * @return boolean
         */
        public function getUserCount($sp_promote_id='',$c_time){
            if($sp_promote_id||$sp_promote_id!=""){
                filterInput($sp_promote_id);
            }
            if($c_time){
                filterInput($c_time);
            }
            $sql = "select sum(`c_users`) as `c_users`,sum(`c_ip`) as `c_ip`,sum(`c_3`) as `c_3`,sum(`c_7`) as `c_7` from `{$this->table}`";
            
            if($sp_promote_id||$sp_promote_id!="" || $c_time){
                $sql .=" where ";
            }
            
            if($sp_promote_id||$sp_promote_id!=""){
                $sql .= " `sp_promote_id` = '".$sp_promote_id."'";
            }
            
            if($c_time){
                if($sp_promote_id||$sp_promote_id!=""){
                    $sql .= " and `c_time` = '".$c_time."'";
                }else{
                    $sql .= " `c_time` = '".$c_time."'";
                }
            }
            
            return self::$db->query($sql);
            
        }
        
        /**
         * 返回列表
         * @param type $sp_promote_id
         * @param type $start
         * @param type $limit
         * @return boolean
         */
        public function getUserAdv($sp_promote_id,$c_time,$start=0,$limit=''){
             if($sp_promote_id||$sp_promote_id!=""){
                filterInput($sp_promote_id);
             }
             if($c_time){
                 filterInput($c_time);
             }
             $sql = "select * from `{$this->table}`";
            
             if($sp_promote_id||$sp_promote_id!="" || $c_time){
                $sql .=" where ";
            }
            
            if($sp_promote_id||$sp_promote_id!=""){
                $sql .= " `sp_promote_id` = '".$sp_promote_id."'";
            }
            
            if($c_time){
                if($sp_promote_id||$sp_promote_id!=""){
                    $sql .= " and `c_time` = '".$c_time."'";
                }else{
                    $sql .= " `c_time` = '".$c_time."'";
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