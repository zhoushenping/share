<?php
!defined('IN_APP') and exit;

$server_handler = new Server($db);
$user_handler   = new User($db);
$oasgHelpContent = new OasgHelpContent($db);//app里内容
$helpContent = new HelpContent($db);//官网内容
$oasAdv = new Oas_adv($db);
$fileupload = new Fileupload();
$task_activecode = new Task_activecode($db);
$activecode = new Activecode($db);
$oas_admin_user = new Oas_admin_user($db);
$user_data = new Oas_users_count($db);
$cron = new Cron($db);
$oas_check_user = new Oas_check_user($db);
$oas_login_key = new Oas_Login_key($db);
$User_origin_count = new User_origin_count($db);
$user_pay_statistics = new User_pay_statistics($db);