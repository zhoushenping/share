<?php
!defined('IN_APP') and exit;
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Invite_record
 *
 * @author wanglun
 */
class Invite_record extends Model{
		
        private $table = 'oas_invite_record';

        public function __construct($db){
            parent::__construct($db);
        }
        
        /**
         * 根据用户UID获取所邀请好友
         * @param type $uid
         */
        public function getInviteByUid($uid){
            if(!$uid){
                return FALSE;
            }
            filterInput($uid);
            $sql_str = "select `invited_uid` as `c` from `{$this->table}` where `uid`='$uid'";
            $rs = self::$db->query($sql_str);
            $arr_invited_uids = array();
            if(!empty($rs)){
                    foreach($rs as $item){
                            $arr_invited_uids[] = $item['c'];
                    }
            }
            return $arr_invited_uids;
        }
        
        /**
         * 插入邀请的好友
         * @param type $array
         * @return boolean
         */
        public function setInviteUid($array = array()){
            if(empty($array)){
                return false;
            }
            filterInput($array);
            $sql = "insert into `{$this->table}` (`uid`,`invite_time`,`invited_uid`) VALUES (".$array['uid'].",".$array['invite_time'].','.$array['invited_uid'].")";
            return self::$db->query($sql);
        }
}

?>