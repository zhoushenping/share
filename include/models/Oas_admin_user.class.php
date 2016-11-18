<?php
!defined('IN_APP') and exit;
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of oas_admin_user
 *
 * @author Administrator
 */
class Oas_admin_user extends Model{
		
        private $table = 'oas_admin_user';

        public function __construct($db){
            parent::__construct($db);
        }
        
        /**
         * 设置后台账号
         * @param type $user
         */
        public function setAdminUser($user){
            if(empty($user)){
                return false;
            }
            filterInput($user);
            //先检查
            $uid = $user['uid'];
            $sql = "select * from `{$this->table}` where `uid` = {$uid}";
            $r = self::$db->query($sql);
            if(!empty($r)){
                //更新
                $up_sql = "update `{$this->table}` set `permissionid` = '".$user['permissionid']."',`m_time`=".time()." where `uid` = {$uid} limit 1";
                return self::$db->execute_sql($up_sql);
            }else{
               
                $in_sql = "insert into `{$this->table}`(`uid`,`permissionid`,`email`,`c_time`,`m_time`) values({$uid},'".$user['permissionid']."','".$user['email']."',".time().",".time().")";
                return self::$db->execute_sql($in_sql);
            }
            
        }
        
        /**
         * 通过ID返回用户信息
         * @param type $uid
         * @return boolean
         */
        public function getUserInfo($uid){
            if(!$uid){
                return FALSE;
            }
            filterInput($uid);
            $sql = "select * from `{$this->table}` where `uid`={$uid}";
            return self::$db->query($sql);
        }
        
}

?>