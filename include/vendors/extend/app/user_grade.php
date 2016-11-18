<?php
/**
 * 推广员系统用户等级设置API
 */
$res = get_user_game_info($uid,$serverinfo);
$grade_id= !empty($res['grade'][0])?intval($res['grade'][0]):0;
if($grade_id>=30 && $grade_id<=33){
    $grade_url = BONUS_URL."index.php?m=dataSync.setPlayerGrade";
    $g_key = md5($uid.$grade_id."996F75B947B0081F72B3FE84ED04DCA9");
    $g_params = array(
        'uid'=> $uid,
        'grade' => $grade_id,
        'auth' =>$g_key
    );
  post_request($grade_url,$g_params);
}

//记录日志
$played_handler->setUserPlayGameLog($uid,$server_sid,$grade_id,get_client_ip());

?>