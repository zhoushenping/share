<?php
!defined('IN_APP') and exit;

/**
 * Description of OasgHelpContent
 *
 * @author wanglun
 */
class OasgHelpContent extends Model{
		
        private $table = 'help_content';

        public function __construct($db){
            parent::__construct($db);
        }
        
        /**
         * 返回顶部公告
         */
        public function getOne(){
            $sql = "select * from `{$this->table}` where `first_c` = 6 and `status` = 1 order by `id` desc limit 1";
            return self::$db->query($sql);
        }
        
        /**
         * 返回条件
         * @param type $class
         * @return type
         */
        public function getListCount($class=''){
                //echo $class;
                if(!empty($class)){
                        filterInput($class);
                        $sql = "select count(*) as `count` from `{$this->table}` where `first_c`={$class}";
                       
                        return self::$db->query($sql);
                } else {
                        $sql = "select count(*) as `count`  from `{$this->table}`"; 
                        return self::$db->query($sql);
                }
        }

        
        /**
         * 查询返回条件的数据
         * @param type $class
         * @param type $start
         * @param type $pageSize
         * @return type
         */
        public function getList($class='',$start=0,$pageSize=''){
                //echo $class;
                if(!empty($class)){
                        filterInput($class);
                        $sql = "select `id`,`first_c`,`title_out`, `title_in`,`order`,`status`,`time`,`m_time`,`content`,`is_hot`,`is_new` from `{$this->table}` where `first_c`={$class}  order by `id` desc ";
                         if($pageSize){
                               $sql .= " limit ".$start.",".$pageSize;
                         }
                        return self::$db->query($sql);
                } else {
                        $sql = "select `id`,`first_c`,`title_out`,`title_in`, `order`,`status`,`time`,`m_time`,`content`,`is_hot`,`is_new` from `{$this->table}`  order by `id` desc ";
                        //echo $sql;
                         if($pageSize){
                                    $sql .= " limit ".$start.",".$pageSize;
                         }
                        return self::$db->query($sql);
                }
        }
        /**
         * 新增列表详情
         */
        public function getList_ag($class=''){
                if(!empty($class)){
                        filterInput($class);
                        $sql = "select `id`,`first_c`,`title_out`, `title_in`,`order`,`status`,`time`,`m_time`,`content`,`is_hot`,`is_new` from `{$this->table}` where `first_c`={$class} and `status`= '1'  order by `order` desc ";
                        return self::$db->query($sql);
                }
        }
        /**
          * 通过ID更新数据
          * @param type $id
          * @return boolean
          */
        public function updateInfo($id='',$status=1){
            if($id){
                filterInput($id);
                filterInput($status);
                $id = intval($id);
                $sql ="update `{$this->table}` set `status` = '{$status}',`m_time`=".time()." where `id` = ".$id." limit 1";
                return self::$db->execute_sql($sql);
            }
            return false;
        }

        public function getFirstList(){
                $sql = "select `first_c` from `{$this->table}` where `status`= '1' and `first_c` <= 5 group by `first_c` ";
                return self::$db->query($sql);
        }

        /**
        * 获取内容信息
        */
        public function getDetailInfo($id){
                if(empty($id) or !is_numeric($id)){
                        return false;
                }
                $sql = "select * from `{$this->table}` where id='$id' ";
                $rs = self::$db->query($sql);
                if($rs === false){
                        return false;
                } else {
                        return $rs[0];
                }
        }

        /**
        * 添加信息
        */
        public function addBasicInfo($ContentInfo){
                filterInput($ContentInfo);
                $sql =	" insert into `{$this->table}` set ".
                                " `first_c` 	= '{$ContentInfo['first_c']}',".
                                " `title_out`	= '{$ContentInfo['title_out']}', ".
                                " `title_in`	= '{$ContentInfo['title_in']}', ".
                                " `order`		= '{$ContentInfo['order']}', ".
                                  " `is_hot`		= '{$ContentInfo['is_hot']}', ".
                                  " `rurl`		= '{$ContentInfo['rurl']}', ".
                                " `content`		= '{$ContentInfo['content']}', ".        
                                " `m_time`		= '".time()."', ".       
                                " `time` = ".time();

                return self::$db->insert_sql($sql);

        }
        /**
        * 更新除文章之外的信息
        */
        public function updateBasicInfo($ContentInfo){
                filterInput($ContentInfo);
                $id = intval($ContentInfo['id']); 
                $sql =	" update `{$this->table}` set ".
                                " `first_c` 	= '{$ContentInfo['first_c']}',".
                                " `title_out`	= '{$ContentInfo['title_out']}', ".
                                " `title_in`	= '{$ContentInfo['title_in']}', ".
                                " `order`		= '{$ContentInfo['order']}', ".
                                " `status`		= '{$ContentInfo['status']}', ".
                                 " `is_hot`		= '{$ContentInfo['is_hot']}', ".
                                 " `rurl`		= '{$ContentInfo['rurl']}', ".
                                 " `content`		= '{$ContentInfo['content']}', ".   
                                " `m_time` = ".time().
                                " where `id` = '{$id}' limit 1";
                return self::$db->execute_sql($sql);
        }

        /**
        * 更新文章内容
        */
        public function changeContent($id,$ContentInfo){
                if(empty($id) or !is_numeric($id)){
                        return false;
                }
                filterInput($id);
                filterInput($ContentInfo);
                $id = intval($id);
                $sql =	" update {$this->table} set ".
                                " `content`	= '$ContentInfo'".
                                " where `id` 	= '{$id}' limit 1";
                //echo $sql;
                return self::$db->execute_sql($sql);
        }
        
        public function clientNews(){
        	$newslist = self::$db->query("select `id`,`content`,`title_out`,`title_in`,`time` from `oas_help_content`  where `first_c` in(1,2) and `status`='Y' order by `order` desc, `time` desc limit 0,5");
			$url = SITE_URL."?a=sq&m=content&id=";
			foreach($newslist as &$news){
				$news['link'] = $url.$news['id'];
				$news['content'] = stripslashes($news['content']);
				$news['content'] = htmlspecialchars($news['content']);
			}
			return $newslist;
        }
        
        /**
         * app顶部
         */
        public function getAppNotice(){
            $sql = "select * from `{$this->table}` where `first_c` = 6 and `status` = 1 order by `order` desc limit 1";
            return self::$db->query($sql);
        }
}

?>