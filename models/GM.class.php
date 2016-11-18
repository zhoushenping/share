<?php

/**
 * Created by PhpStorm.
 * User: shenping zhou
 * Date: 2016/1/7
 * Time: 11:49
 */
class GM
{
    static function getHost()
    {
        //测试:正式      host:10.1.9.191 server.oasgames.com
        return DEVELOP_MODE ? "//server.oasgames.com/" : "//support.oasgames.com/";
    }

    static function getURL()
    {
        return "//support.oasgames.com/?a=question&m=add&lang=pt&game_code=" . GAME_CODE_STANDARD;
    }
}
