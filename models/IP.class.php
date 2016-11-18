<?php

/**
 * Created by PhpStorm.
 * User: shenping zhou
 * Date: 2015/10/21
 * Time: 15:08
 */
class IP
{
    static function getCountry($ip = '')
    {
        if ($ip == '') $ip = Browser::get_client_ip();
        $ret = self::fromPHP($ip);
        if ($ret == '') $ret = self::fromOnline($ip);

        return $ret;
    }

    //从线上取值
    static function fromOnline($ip = '')
    {
        static $ret = array();
        if ($ip == '') $ip = Browser::get_client_ip();
        $md5 = md5($ip);

        if ($ret[$md5] == '')
        {
            $rs        = CURL::getJson("//www.oasgames.com/service/geoip/?ip=$ip");
            $ret[$md5] = $rs['val']['country_code'];
        }

        return $ret[$md5];
    }

    //从php取值
    static function fromPHP($ip = '')
    {
        if ($ip == '') $ip = Browser::get_client_ip();
        $arr         = array();
        $arr['TR'][] = '10.1.5.11';

        $ret = '';
        foreach ($arr as $country => $country_ips)
        {
            if (in_array($ip, $country_ips)) $ret = $country;
        }

        return $ret;
    }

    static function fromDB()
    {
        //todo
    }
}