<?php
!defined('IN_APP') and exit;
/**
 * Description of Cron
 *
 * @author Administrator
 */
class Cron extends Model{
        private $table = 'oas_users_count';
        private $table_users = 'users';
        private $origin_table = 'user_origin';
        private $origin_count_table = 'user_origin_count';
        private $user_pay_statistics_table = 'user_pay_statistics';
        
        public function __construct($db){
            parent::__construct($db);
        }
        
        /**
         * 统计每天的注册人数
         */
        public function setDayByDay(){
            $t = '-1 day';
            $time = date('Y-m-d', strtotime($t));
            $s_time = strtotime(date('Y-m-d 00:00:00',strtotime($t)));
            $e_time = strtotime(date('Y-m-d 23:59:59',strtotime($t)));
            //用户总数
            $sql_user = "select count(*) as `count`,count(distinct time_ip) as `ip`,`sp_promote_id` from `{$this->table_users}` where `time` >= {$s_time} and `time`< {$e_time} group by `sp_promote_id`";

            //$user_count = self::$db->query($sql_user);
            if(!empty($user_count)){
                foreach($user_count as $key=>$val){
                    $insert_sql = "insert into `{$this->table}`(`sp_promote_id`,`c_time`,`c_users`,`c_ip`,`c_date`) values(
                        '".$val['sp_promote_id']."','".$time."',".$val['count'].",".$val['ip'].",".time()."
                        )";
                    //self::$db->execute_sql($insert_sql);
                }
            }
            return true;
        }
        
        /**
         * 统计三天2次登录人数
         */
        public function setThreeDay(){
            $t = '-3 day';
            $time = date('Y-m-d', strtotime($t));
            $s_time = strtotime(date('Y-m-d 00:00:00',strtotime($t)));
            $e_time = strtotime(date('Y-m-d 23:59:59',strtotime($t)));
            //用户总数
            $sql_user = "select count(*) as `count`,`sp_promote_id` from `{$this->table_users}` where `time` >= {$s_time} and `time`< {$e_time} and `nums`>=2 group by `sp_promote_id`";
            
            $user_count = self::$db->query($sql_user);
            if(!empty($user_count)){
                foreach($user_count as $key=>$val){
                    $insert_sql = "update `{$this->table}` set `c_3`='".$val['count']."' where `sp_promote_id` = '".$val['sp_promote_id']."' and `c_time`='".$time."' limit 1";
                    //self::$db->execute_sql($insert_sql);
                }
            }
            return true;
        }
        
        /**
         * 统计7天三次登录人数
         */
        public function setSevenDay(){
            $t = '-7 day';
            $time = date('Y-m-d', strtotime($t));
            $s_time = strtotime(date('Y-m-d 00:00:00',strtotime($t)));
            $e_time = strtotime(date('Y-m-d 23:59:59',strtotime($t)));
            //用户总数
            $sql_user = "select count(*) as `count`,`sp_promote_id` from `{$this->table_users}` where `time` >= {$s_time} and `time`< {$e_time} and `nums`>=3 group by `sp_promote_id`";
            
            $user_count = self::$db->query($sql_user);
            if(!empty($user_count)){
                foreach($user_count as $key=>$val){
                    $insert_sql = "update `{$this->table}` set `c_7`='".$val['count']."' where `sp_promote_id` = '".$val['sp_promote_id']."' and `c_time`='".$time."' limit 1";
                    //self::$db->execute_sql($insert_sql);
                }
            }
            return true;
        }
        
        /**
         * 玩家来源每天统计
         */
        public function setUserOriginCount(){
            $t = '-1 day';
            $time = date('Y-m-d', strtotime($t));
            $s_time = strtotime(date('Y-m-d 00:00:00',strtotime($t)));
            $e_time = strtotime(date('Y-m-d 23:59:59',strtotime($t)));
            
            $sql = "select count(*) as `count`,`sid`,`oday`,`otype` from `{$this->origin_table}` where `ctime` >= {$s_time} and `ctime`< {$e_time} group by `oday`,`sid`,`otype`";

            $result = self::$db->query($sql);
          
            $temp = array();
            if(!empty($result)){
                foreach($result as $key=>$val){
                    $temp[$val['sid']]['oday'] = $val['oday'];
                    $temp[$val['sid']]['sid'] = $val['sid'];
                    $temp[$val['sid']]['otype1'] = $val['otype']==1?$val['count']:$temp[$val['sid']]['otype1'];
                    $temp[$val['sid']]['otype2'] = $val['otype']==2?$val['count']:$temp[$val['sid']]['otype2'];
                    $temp[$val['sid']]['otype3'] = $val['otype']==3?$val['count']:$temp[$val['sid']]['otype3'];
                    $temp[$val['sid']]['otype4'] = $val['otype']==4?$val['count']:$temp[$val['sid']]['otype4'];
                    $temp[$val['sid']]['otype5'] = $val['otype']==5?$val['count']:$temp[$val['sid']]['otype5'];
                }
            }
            if(!empty($temp)){
                foreach ($temp as $key=>$val){
                    $otype1 = !empty($val['otype1'])?$val['otype1']:0;
                    $otype2 = !empty($val['otype2'])?$val['otype2']:0;
                    $otype3 = !empty($val['otype3'])?$val['otype3']:0;
                    $otype4 = !empty($val['otype4'])?$val['otype4']:0;
                    $otype5 = !empty($val['otype5'])?$val['otype5']:0;
                    
                    $insert_sql = "insert into `{$this->origin_count_table}`(`oday`,`sid`,`otype1`,`otype2`,`otype3`,`otype4`,`otype5`,`ctime`) values('{$val['oday']}',{$val['sid']},{$otype1},{$otype2},{$otype3},{$otype4},{$otype5},".time().")";
                   self::$db->execute_sql($insert_sql);
                }
            }
            
            //删除30天前的数据
            $ts = '-30 day';
            $s_times = strtotime(date('Y-m-d 00:00:00',strtotime($ts)));
            $del_sql = "delete from `{$this->origin_table}` where `ctime`<= {$s_times}";
            self::$db->execute_sql($del_sql);
            exit;
        }
        
         /**
         * 玩家来源及累计付费情况
         */
        public function setUserPayStatistics(){
             //当前时间
             $now_time = time();
             
             $pay_url = "http://bas.oasgames.com/?a=ApiRechargeInfo";
             $post_pay_url = "http://bas.oasgames.com/?a=ApiRechargeInfo&m=uidRecharge";
             $game_code = "lobr";
             $us_proportion = 35;
             //获取每个服开服日期
             $min_sql = "SELECT min(`oday`) as `oday`,`sid` FROM `{$this->origin_count_table}` group by `sid`;";
             $min_result = self::$db->query($min_sql);
             if(!empty($min_result)){
                 foreach($min_result as $key=>$val){
                     $has_sql = "select * from `{$this->user_pay_statistics_table}` where `sid` = {$val['sid']}";
                     $has_result = self::$db->query($has_sql);
                     $is_null = false;//检查是否是第一次
                     if(empty($has_result)){
                            self::$db->insert_sql("insert into `{$this->user_pay_statistics_table}`(`sid`,`ctime`,`utime`) values({$val['sid']},{$now_time},{$now_time})");                          
                            $is_null = true;
                     }
                     $seven_time = strtotime($val['oday'])+7*86400;
                     $seven_day = date("Y-m-d",$seven_time);
                     if(time() <= $seven_time || $is_null){
                        //前7天广告推广用户数
                        $se_sql = "select sum(`otype1`) as `otype1`,sum(`otype3`) as `otype3`,sum(`otype5`) as `otype5` from `{$this->origin_count_table}` where `sid` = {$val['sid']} and `oday` >='{$val['oday']}' and `oday` < '{$seven_day}'";
 
                        $se_result = self::$db->query($se_sql);
                        $se_b_num = $se_result[0]['otype3']+$se_result[0]['otype5'];
                        self::$db->execute_sql("update `{$this->user_pay_statistics_table}` set `se_day_count` = {$se_result[0]['otype1']},`se_day_b_count`={$se_b_num},`utime`=".time()." where `sid` = {$val['sid']} limit 1");
                        
                        
                     }
                     
                     //记录其他用户数
                     $na_sql = "select sum(`otype2`) as `otype2`,sum(`otype4`) as `otype4` from `{$this->origin_count_table}` where `sid` = {$val['sid']} and `oday` >='{$val['oday']}'";
                     $na_result = self::$db->query($na_sql);
                     self::$db->execute_sql("update `{$this->user_pay_statistics_table}` set `na_day_count` = {$na_result[0]['otype2']},`na_day_z_count`={$na_result[0]['otype4']},`utime`=".time()." where `sid` = {$val['sid']} limit 1");
                     
                    //以下记录前7天广告，被动累计充值接口start
                    //1.前7天广告用户累计充值
                    $dy_day = strtotime($val['oday']);
                    $se_day = strtotime($seven_day);

                    $seven_pay_url = $pay_url."&m=adUserRecharge&datefrom={$dy_day}&dateto={$se_day}&gameCode={$game_code}&serverId={$val['sid']}";
                    $seven_pay_result = curlRequest($seven_pay_url);
                    $seven_pay_result = json_decode($seven_pay_result, true);
                    if(strtolower($seven_pay_result['status'])=="ok"){
                        $money = round(($seven_pay_result['val']/$us_proportion),2);
                        
                        self::$db->execute_sql("update `{$this->user_pay_statistics_table}` set `se_day_pay` = {$money},`utime`=".time()." where `sid` = {$val['sid']} limit 1");
                    }
                    //2,前7天被动用户累计充值，先获取用户id
                    $se_uid_sql = "select `uid` from `{$this->origin_table}` where `sid` = {$val['sid']} and `otype` in(3,5) and `oday` >= '{$val['oday']}' and `oday` < '{$seven_day}'  group by `uid`";
                    $se_uid_result = self::$db->query($se_uid_sql);
                    $uid_array = array();
                    $uid_str = "";
                    $pay_post = array(
                        'gameCode'=>$game_code,
                        'serverId'=>$val['sid']
                    );
                    if(!empty($se_uid_result)){
                        foreach($se_uid_result as $k=>$v){
                            $uid_array[] = $v['uid'];
                        }
                        $uid_count = count($uid_array);
                        if($uid_count<=5000){
                            $uid_str = implode(",", $uid_array);
                            $pay_post['uid'] = $uid_str;
                            $pay_post_result = curlRequest($post_pay_url,$pay_post);
                            $pay_post_result = json_decode($pay_post_result, true);
                            if(strtolower($pay_post_result['status'])=="ok"){
                                $money = round(($pay_post_result['val']/$us_proportion), 2);
                                self::$db->execute_sql("update `{$this->user_pay_statistics_table}` set `se_day_b_pay` = {$money},`utime`=".time()." where `sid` = {$val['sid']} limit 1");
                            }
                        }else{
                            $uid_array2 = array_chunk($uid_array, 5000);
                            $moneys = 0;
                            foreach($uid_array2 as $kk=>$vv){
                                //返回的充值累加
                                $uid_str = implode(",", $vv);
                                $pay_post['uid'] = $uid_str;
                                $pay_post_result = curlRequest($post_pay_url,$pay_post);
                                $pay_post_result = json_decode($pay_post_result, true);
                                if(strtolower($pay_post_result['status'])=="ok"){
                                    $temp = round(($pay_post_result['val']/$us_proportion), 2);
                                    $moneys = $moneys+$temp; 
                                }
                            }
                             self::$db->execute_sql("update `{$this->user_pay_statistics_table}` set `se_day_b_pay` = {$moneys},`utime`=".time()." where `sid` = {$val['sid']} limit 1");
                        }
                    }
                    //以下记录前7天广告，被动累计充值接口end
                     
                     
                     //以下记录自然，主动累计充值接口start
                     //1,自然用户累计充值接口调用

                    $na_pay_url = $pay_url."&m=naturalUserRecharge&datefrom={$dy_day}&gameCode={$game_code}&serverId={$val['sid']}";
                     $na_pay_result = curlRequest($na_pay_url);
                    $na_pay_result = json_decode($na_pay_result, true);
                    if(strtolower($na_pay_result['status'])=="ok"){
                        $money = round(($na_pay_result['val']/$us_proportion),2);
                        self::$db->execute_sql("update `{$this->user_pay_statistics_table}` set `na_day_pay` = {$money},`utime`=".time()." where `sid` = {$val['sid']} limit 1");
                    }
                     //2，主动滚服用户累计充值

                       $zh_uid_sql = "select `uid` from `{$this->origin_table}` where `sid` = {$val['sid']} and `otype`=4 and `oday` >= '{$val['oday']}' group by `uid`";
                        $zh_uid_result = self::$db->query($zh_uid_sql);
                        $zh_uid_array = array();
                        $zh_uid_str = "";
                        $zh_pay_count = 0;
                        if(!empty($zh_uid_result)){
                            foreach($zh_uid_result as $k=>$v){
                                $zh_uid_array[] = $v['uid'];
                            }
                            $zh_uid_count = count($zh_uid_array);
                            if($zh_uid_count<=5000){
                                $zh_uid_str = implode(",", $zh_uid_array);
                                $pay_post['uid'] = $zh_uid_str;//用户字符串
                                $zh_pay_post_result = curlRequest($post_pay_url,$pay_post);
                                $zh_pay_post_result = json_decode($zh_pay_post_result, true);
                                
                                if(strtolower($zh_pay_post_result['status'])=="ok"){
                                    $money = round(($zh_pay_post_result['val']/$us_proportion), 2);
                                    self::$db->execute_sql("update `{$this->user_pay_statistics_table}` set `na_day_z_pay` = {$money},`utime`=".time()." where `sid` = {$val['sid']} limit 1");
                                }
                            }else{
                                $zh_uid_array2 = array_chunk($zh_uid_array, 5000);
                                $moneys = 0;
                                foreach($zh_uid_array2 as $ks=>$vs){
                                    //返回的充值累加
                                     $zh_uid_str = implode(",", $vs);
                                     $pay_post['uid'] = $zh_uid_str;//用户字符串
                                    $zh_pay_post_result = curlRequest($post_pay_url,$pay_post);
                                    $zh_pay_post_result = json_decode($zh_pay_post_result, true);
                                    if(strtolower($zh_pay_post_result['status'])=="ok"){
                                        $temps = round(($zh_pay_post_result['val']/$us_proportion), 2);
                                        $moneys = $moneys + $temps; 
                                       
                                    }
                                }
                                 self::$db->execute_sql("update `{$this->user_pay_statistics_table}` set `na_day_z_pay` = {$moneys},`utime`=".time()." where `sid` = {$val['sid']} limit 1");
                            }
                        }
                     //以下记录自然，主动充值接口end
                     //以下记录总充值接口start
                     $total_pay_url = $pay_url."&m=totalRecharge&gameCode={$game_code}&serverId={$val['sid']}";
                     $total_pay_result = curlRequest($total_pay_url);
                     $total_pay_result = json_decode($total_pay_result, true);
                     if(strtolower($total_pay_result['status'])=="ok"){
                         $money = round(($total_pay_result['val']/$us_proportion), 2);
                         self::$db->execute_sql("update `{$this->user_pay_statistics_table}` set `total` = {$money},`utime`=".time()." where `sid` = '{$val['sid']}' limit 1");
                     }
                     //以下记录总充值接口end
                 }
             }
        }
}

?>