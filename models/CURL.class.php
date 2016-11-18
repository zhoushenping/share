<?php

/**
 * Created by PhpStorm.
 * User: shenping zhou
 * Date: 2015/5/19
 * Time: 10:13
 */
class CURL
{
    static function Request($url, $data = '')
    {
        if(strpos($url,'http') === false) $url = 'http:'.$url;
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($curl, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
        curl_setopt($curl, CURLOPT_AUTOREFERER, 1);
	  curl_setopt($curl, CURLOPT_DNS_USE_GLOBAL_CACHE, false);//20150819为解决s273的bug而加
        if (!empty($data))
        {
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        }
        curl_setopt($curl, CURLOPT_TIMEOUT, 6);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $resultData = curl_exec($curl);
        $httpInfo   = curl_getinfo($curl);
        Log2::save_run_log("{$httpInfo['http_code']}|$url|$resultData", 'curl2');
        if (curl_errno($curl))
        {
            curl_close($curl);
            $ret = false;
        }
        else
        {
            curl_close($curl);
            $ret = $resultData;
        }

        return $ret;
    }

    static function getJson($url, $data = '')
    {
        $ret = array();
        $rs  = self::Request($url, $data);
        if ($rs !== false)
        {
            $rs = json_decode($rs, 1);
            if (is_array($rs)) $ret = $rs;
        }

        return $ret;
    }
}