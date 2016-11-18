<?php
/*
 *  滚服规则配置
 *
 * */
// 是否要求来自广告
define('RSR_NEED_FROM_AD', 'need_from_ad');
// 起始等级
define('RSR_GRADE_FROM', 'grade_from');
// 结束等级
define('RSR_GRADE_TO', 'from_to');
// 不活跃天数(数值单位为:秒)
define('RSR_UNACTIVE_DAY', 'unactive_day');

// 滚服规则配置
$_GAME_ROLL_SERVER_RULES = array(

    //1-20级老用户，1天（含）以上未登录，滚服
    array(
        RSR_NEED_FROM_AD => true,
        RSR_GRADE_FROM   => -1,
        RSR_GRADE_TO     => 20,
        RSR_UNACTIVE_DAY => 1,
    ),

    //1-20级老用户，1天（含）以上未登录，滚服
    array(
        RSR_NEED_FROM_AD => false,
        RSR_GRADE_FROM   => -1,
        RSR_GRADE_TO     => 20,
        RSR_UNACTIVE_DAY => 1,
    ),

    //21-40级老用户，7天（含）以上未登录，滚服
    array(
        RSR_NEED_FROM_AD => true,
        RSR_GRADE_FROM   => 21,
        RSR_GRADE_TO     => 40,
        RSR_UNACTIVE_DAY => 7,
    ),

    //21-40级老用户，7天（含）以上未登录，滚服
    array(
        RSR_NEED_FROM_AD => false,
        RSR_GRADE_FROM   => 21,
        RSR_GRADE_TO     => 40,
        RSR_UNACTIVE_DAY => 7,
    ),
);