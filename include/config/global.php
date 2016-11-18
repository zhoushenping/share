<?php
header("Content-type: text/html; charset=utf-8");
header('P3P:CP="IDC DSP COR ADM DEVi TAIi PSA PSD IVAi IVDi CONi HIS OUR IND CNT"');/*使得IE接受第三方cookie*/
@session_start();
/* 初始化设置 */
@ini_set('memory_limit',        '64M');
@ini_set('session.cache_expire',  180);
@ini_set('session.use_cookies',   1);
@ini_set('session.auto_start',    0);

date_default_timezone_set("America/Sao_Paulo");
error_reporting(0);//E_ALL
//error_reporting(E_ALL);//E_ALL
define('GAME_CODE_STANDARD', 'lobr');
define("LANG_OAS", "pt-br");
define("SYSTEM_LANG","pt");
define('TEST', 1);
define('DEVELOP_MODE',1);//0=非开发模式(上线)	1=测试服上	2=本地开发
define('DB_SET','develop');//用那个数据库  online=线上  develop=开发
define("ODP_URL", "//odp.oasgames.com");
define("APP_ID",	"237995926316918");
define("APP_SECRET",  	"4197c1878adb12690aeeb0007271487c");
define("FB_URL",  "https://apps.facebook.com/legend_pt/");//可配置
define('GAME_NAME', 'Legend Online');

$domain_prex = TEST ? 'lobr' : 'lobr';//定义域名前缀
define('ZHUISUMA', time() . '_' . rand(100, 999));

// 要求定义好 _PATH_ 和 SCRIPT_NAME ，及定义 DS 为路径分隔符
if (!defined('DS'))		{ die("Error : (".realpath(__FILE__).") not defined 'DS' "); }
if (!defined('ROOT_PATH'))	{ die("Error : (".realpath(__FILE__).") not defined 'ROOT_PATH' "); }
if (!defined('SCRIPT_NAME'))	{ die("Error : (".realpath(__FILE__).") not defined 'SCRIPT_NAME' "); }
define('IN_APP', true);
/* Set the include path. */

define("CONFIG_PATH", ROOT_PATH.'include'.DS.'config'.DS);
define("VENDORS_PATH", ROOT_PATH.'include'.DS.'vendors'.DS);
define("MODELS_PATH", ROOT_PATH.'include'.DS.'models'.DS);
define("MAIL_PATH", ROOT_PATH.'include'.DS.'email'.DS);
define("LANG_PATH", ROOT_PATH.'include'.DS.'languages'.DS);
define("STATIC_PATH", ROOT_PATH.'static'.DS);

//公共函数
require (CONFIG_PATH . 'functions.php');

/* Include MySQL CONFIG File */
require (CONFIG_PATH . 'config.db.php');

/* Include count CONFIG File */
require (CONFIG_PATH . 'config.count.php');

//创建数据库类
require_once (VENDORS_PATH . 'db'.DS.'db.php');
$db = new db($oas_db_conf);

require_once(CONFIG_PATH.'config.php');
require_once(CONFIG_PATH.'config.AD.php');
require_once(CONFIG_PATH . 'config.rollserver.php');

define("GAME_CODE", "shenqu_br");
//模拟未来当前时间,以方便测试
if(DEVELOP_MODE){
    if(!empty($_REQUEST['date'])){
        $_SESSION['date'] = strtotime($_REQUEST['date']);
    }
    $_CURRENT_TIME = $_SESSION['date'] ? $_SESSION['date'] : time();
}else{
    $_CURRENT_TIME = time();
}
