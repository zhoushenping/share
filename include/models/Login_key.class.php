<?php
!defined('IN_APP') and exit;
	
class Oas_Login_key extends Model{
        private $table = 'oas_login_key';

        public function __construct($db){
            parent::__construct($db);
        }
        
        /**
         * login_key列表
         */
        public function login_key_list(){
            $sql = "select * from `{$this->table}` order by `id` desc";
            
            return self::$db->query($sql);
        }
        
        
        /**
         * 搜索一行信息显示
         */
        public function loginKeyByid($id){
            if(!is_numeric($id)){
                return false;
            }
            filterInput($id);
            $sql = "select * from `{$this->table}` where `id` ={$id}";
            
            return self::$db->query($sql);
        }
                
       /**
         * 更新信息,`time`=".time().",`operator`={$operator}
         */
        public function updateLoginkey($login_key,$operator){
            filterInput($login_key);
            filterInput($operator);
            $sql = "update `{$this->table}` set `server_inner_ip`={$login_key['server_inner_ip']},`server_public_ip`={$login_key['server_public_ip']},`area`={$login_key['area']},`operator`='$operator',`time`=".time()." where `id` ={$login_key['id']} limit 1";
            
            return self::$db->query($sql);
        }         
                
         /**
         * 添加
         */
        public function addLoginke($login_key,$operator){
            filterInput($login_key);
            filterInput($operator);
            $sql = "insert into `{$this->table}`  set `server_inner_ip`={$login_key['server_inner_ip']},`server_public_ip`={$login_key['server_public_ip']},`area`={$login_key['area']},`operator`='$operator',`time`=".time();
            
            return self::$db->query($sql);
        }       
}

?>