<?php
define("CONTROLLERS_PATH", ROOT_PATH.'legend_online'.DS.'controllers'.DS);
define("APP_PATH", ROOT_PATH.'legend_online'.DS);
define('TEMPLATE_DIR', APP_PATH.'view_201411'.DS);//note 定义Templates模板路径
define('TEMPLATE_DIR4', APP_PATH . 'view4' . DS);//note 定义Templates模板路径

define("FB_CENTER_URL", "https://www.facebook.com/Legend.Online.pt?v=1");//可配置
define("API_URL", WEB_URL.'oasplay'.DS.'api'.DS);
define('TR_SITE_URL','//lotr.oasgames.com/');
define('BR_SITE_URL','//lobr.oasgames.com/');

define("SITE_URL",       "//$domain_prex.oasgames.com/legend_online/");//可配置
define("APP_URL",        "//$domain_prex.oasgames.com/fbapp/");//可配置
define('OASPLAY_URL',    "//$domain_prex.oasgames.com/fbapp/oasplay.php");

if (is_dir('e:/logs/'))
{
    define("LOG_DIR", "e:/logs/lobr/");
}
else
{
    define("LOG_DIR", "/data/log/lobr.oasgames.com/legend");
}
define('FB_LIKE_URL',"");//可配置

define('LANG_URL','');//可配置
define('OAS_DOMAIN','oasgames.com');//不变
define('TWITTER_FOLLOW_URL','');

//seo优化
define("SUB_DRIRECT", WEB_URL.'legend_online');
define("PLATFORM",       "home");//所在的平台是app还是home
define("RESOURCE_PATH",WEB_URL."/legend_online/resource/");

require_once(VENDORS_PATH.'common'.DS.'Pagept_br.class.php');
require_once(CONFIG_PATH."common.legend.php");

$show_default_style = (time() > strtotime('2016-01-05') || $_GET['show_old_style'] == 1) ? true : false;
