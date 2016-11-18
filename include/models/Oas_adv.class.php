<?php
!defined('IN_APP') and exit;
	
class Oas_adv extends Model{
        private $table = 'oas_adv';

        public function __construct($db){
            parent::__construct($db);
        }
        
        /**
         * 返回焦点图列表
         * @param type $type_id
         * @param type $status
         */
        public function getAdvList($type_id=5,$status='Y',$start=0,$limit=4){
            if(!$type_id){
                return FALSE;
            }
            filterInput($type_id);
            $sql = "select `link`,`imgurl` from `{$this->table}` where `status`='".$status."' 
                                and `imgurl`!='' and `type_id`=".$type_id." order by `order` desc limit ".$start.",".$limit;
            return self::$db->query($sql);
        }
        
        /**
         * 返回焦点图列表
         * @param type $type_id
         * @param type $status
         */
        public function getAdvLists($type_id=5,$status='Y',$start=0,$limit=4){
            if(!$type_id){
                return FALSE;
            }
            filterInput($type_id);
            filterInput($status);
            $sql = "select `title`,`width`,`height`,`second`,`link`,`imgurl` from {$this->table} where `status`='".$status."' 
                                and `imgurl`!='' and `type_id`=".$type_id." order by `id` desc limit ".$start.",".$limit;
            return self::$db->query($sql);
        }
        
        /**
         * 后台调用返回焦点图列表
         * @param type $type_id
         * @param type $start
         * @param type $limit
         * @return boolean
         */
        public function getAdminAdvList($type_id='',$start=0,$limit=''){
            
            $sql = "select * from `{$this->table}`"; 
            if($type_id){
                filterInput($type_id);
                $sql .= " where `type_id`=".$type_id;
            }
            $sql .=" order by `type_id` desc,`id` desc";
            if($limit){
                $sql .= " limit ".$start.",".$limit; 
            }
            return self::$db->query($sql);
        }
        
        /**
         * 返回总数
         * @param type $type_id
         * @return type
         */
        public function getAdminAdvListCount($type_id = ''){
            $sql = "select count(*) as `count` from `{$this->table}`"; 
            if($type_id){
                filterInput($type_id);
                $sql .= " where `type_id`=".$type_id;
            }
            return self::$db->query($sql);
        }
        
        /**
         * 更新状态
         * @param type $id
         * @param type $status
         * @return boolean
         */
        public function updateAdv($id = '',$status='Y'){
            if($id){
                filterInput($id);
                filterInput($status);
                $sql ="update `{$this->table}` set `status` = '{$status}',`m_time`=".time()." where `id` = ".$id." limit 1";
                return self::$db->execute_sql($sql);
            }
            return false;
        }
        
        /**
         * 根据ID返回焦点图信息
         * @param type $id
         * @return boolean
         */
        public function getAdvById($id = ''){
            if(!$id){
                return false;
            }
            filterInput($id);
            $sql = "select * from `{$this->table}` where `id` = ".$id;
            return self::$db->query($sql);
        }
        
        /**
         * 更新焦点图
         * @param type $focuses
         */
        public function updateAdvInfo($focuses = array()){
            if(empty($focuses)){
                return false;
            }
            filterInput($focuses);
            
            $sql =	" update `{$this->table}` set ".
                              " `title` 	= '{$focuses['title']}',".
                              " `imgurl`	= '{$focuses['imgurl']}', ".
                              " `link`	= '{$focuses['link']}', ".
                              " `type_id`		= '{$focuses['type_id']}', ".        
                              " `height`		= '{$focuses['height']}', ".     
                              " `width`		= '{$focuses['width']}', ".   
                              " `second`		= '{$focuses['second']}', ". 
                               " `status`		= '{$focuses['status']}', ". 
                              " `m_time`		= ".time().
                              " where `id` = '{$focuses['id']}' limit 1";
                return self::$db->execute_sql($sql);
        }
        
        /**
         * 添加焦点图
         * @param type $focuses
         */
        public function addAdvInfo($focuses = array()){
            if(empty($focuses)){
                return false;
            }
            filterInput($focuses);
            $sql =	" insert into `{$this->table}` set ".
                              " `title` 	= '{$focuses['title']}',".
                              " `imgurl`	= '{$focuses['imgurl']}', ".
                              " `link`	= '{$focuses['link']}', ".
                              " `type_id`		= '{$focuses['type_id']}', ".        
                              " `height`		= '{$focuses['height']}', ".     
                              " `width`		= '{$focuses['width']}', ".   
                              " `second`		= '{$focuses['second']}', ". 
                              " `status`		= '{$focuses['status']}', ". 
                              " `m_time`		= '".time()."', ".       
                              " `c_time` = ".time();
                return self::$db->insert_sql($sql);

        }
        
}

?>