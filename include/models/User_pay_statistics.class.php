<?php
    !defined('IN_APP') and exit;
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
    /*
     * User_pay_statistics表的数据模型
     */
    class User_pay_statistics extends Model{
        private $table = 'user_pay_statistics';
        
        public function __constructor($db){
            parent::__construct($db);
        }
        
        /*查询数据库所有记录函数*/
        public function getUserPayStatistics(){
            $sql = "select * from `{$this->table}`";
            return self::$db->query($sql);
        }
    }
?>