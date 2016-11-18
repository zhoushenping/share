<?php
!defined('IN_APP') and exit;
$helpContent = new HelpContent($db);
$oasAdv = new Oas_adv($db);
$userSign = new User_sign($db);
$oas_server = new Server($db);
$played_handler = new Played($db);
$oasgHelpContent = new OasgHelpContent($db);
$oas_check_user = new Oas_check_user($db);

$activecode = new Activecode($db);





//登录器地址
define('LOGIN_ES', "http://download.iyi123.com/loginer/es/es/Mini_Login.zip");
?>