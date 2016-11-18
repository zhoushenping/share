<?php
!defined('IN_APP') and exit;
	
class User_sign extends Model{
        private $table = 'user_sign';

        public function __construct($db){
            parent::__construct($db);
        }
        
        /**
         * 返回用户签到次数
         * @param type $uid
         * @return boolean
         */
        public function getTimesByUid($uid=0){
            if(!$uid){
                return false;
            }
            filterInput($uid);
            $sql = "select `sign_times` from `user_sign` where `uid` = '{$uid}' limit 1";
            
            return self::$db->query($sql);
        }
}

?>