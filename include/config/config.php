<?php
//引用公共model专用配置文件
require_once(MODELS_PATH.'Model.php');
require_once(MODELS_PATH.'Server.class.php');
require_once(MODELS_PATH.'User.class.php');
require_once(MODELS_PATH.'HelpContent.class.php');
require_once(MODELS_PATH.'HelpNotice.class.php');
require_once(MODELS_PATH.'Order_placed.class.php');
require_once(MODELS_PATH.'Log.class.php');
require_once(MODELS_PATH.'Task_activecode.class.php');
require_once(MODELS_PATH.'Invite_record.class.php');
require_once(MODELS_PATH.'OasgHelpContent.class.php');
require_once(MODELS_PATH.'Activecode.class.php');
require_once(MODELS_PATH.'Oas_adv.class.php');
require_once(MODELS_PATH.'User_sign.class.php');
require_once(MODELS_PATH.'Oas_admin_user.class.php');
require_once(MODELS_PATH.'Fileupload.class.php');
require_once(MODELS_PATH.'Oas_users_count.class.php');
require_once(MODELS_PATH.'Cron.class.php');
require_once(MODELS_PATH.'Oas_check_user.class.php');
require_once(MODELS_PATH.'Login_key.class.php');
require_once(MODELS_PATH.'User_origin_count.class.php');
require_once(MODELS_PATH.'Played.class.php');
require_once(MODELS_PATH.'User_pay_statistics.class.php');
require_once(ROOT_PATH.'balog/BaLog.class.php');//经分日志类
//引入语言包
define("LANG", "_pt-br");
define("FB_JS_LANG", "pt_BR");
define("VERSION", "20151119");
define("GA_ACCOUNT", "UA-33361405-3");

//轮播地址
define("APP_LUNBO", "//plugins.oasgames.com/lunbo/weget/index.php?type_id=15");
define("OAS_LUNBO", "//plugins.oasgames.com/lunbo/weget/index.php?type_id=14");
define("CLIENT_LUNBO", "//plugins.oasgames.com/lunbo/weget/index.php?type_id=13");
$oaspay_config = array(
    //波兰
    1=>array(
        'server_inner_ip'=>'SNTTQ-16DD11-22-0Ploand-67n1dDFN-7ROAD21-shenng-111SHEN',
        'server_public_ip'=>'CSIT-16dd22-33-0668wu-67n-5Ploand44-7ROAD31-SHEANG-23SHEN'
    )
);
require_once(LANG_PATH.'lang_pt-br.php');

//自动导入类文件   命令行模式下此方法无效
function __autoload($className)
{
    $fileName1 = ROOT_PATH . "/models/" . $className . ".class.php";
    if (file_exists($fileName1)) {
        require_once $fileName1;
    }

    //使得可以自动加载目录内的类文件
    if (strpos($className, '_') !== false) {
        $temp     = String::replace_once('_', '/', $className);
        $fileName = ROOT_PATH . "/models/" . $temp . ".class.php";
        if (file_exists($fileName)) {
            require_once $fileName;
        }
    }

    $arr_dir = array('ThreeYear', 'VipPay', 'Recall', 'Christmas');
    foreach ($arr_dir as $i) {
        if (strpos($className, $i) === 0) {
            $className = str_replace($i, "$i/", $className);
            break;
        }
    }

    $fileName = ROOT_PATH . "/models/" . $className . ".class.php";
    if (file_exists($fileName)) {
        require_once $fileName;
    }
}
