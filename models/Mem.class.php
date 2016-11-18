<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 15-5-23
 * Time: 下午8:46
 */
class Mem
{
    static function getConfig()
    {
        if (DEVELOP_MODE) {
            $arr = array(
                'server' => '10.1.5.3',
                'port'   => '11211',
            );
        }
        else {
            $arr = array(
                'server' => '192.168.10.23',
                'port'   => '11211',
            );
        }

        return $arr;
    }

    static function getMemHandle()
    {
        static $ret;
        if (!$ret) {
            $config = self::getConfig();

            $ret = new Memcache();
            $ret->connect($config['server'], $config['port']);
        }

        return $ret;
    }

    static function set($key, $value, $expire = 0)
    {
        if ($expire == 0) {
            $expire = 3600 * 24 * 7;
        }  //默认有效时间为7天
        if ($expire == 'forever') {
            $expire = 0;
        }      //可以设置为永不过期
        $handle = self::getMemHandle();
        $handle->set($key, $value, 0, $expire);
    }

    static function get($key)
    {
        $handle = self::getMemHandle();

        return $handle->get($key);
    }

    //多少秒后删除key为$key的元素
    static function delete($key, $after_secs = 0)
    {
        $handle = self::getMemHandle();
        $handle->delete($key, $after_secs);
    }

    static function replace($key, $value)
    {
        $handle = self::getMemHandle();
        $handle->replace($key, $value);
    }

    static function increase($key, $num = 1)
    {
        $handle = self::getMemHandle();
        $handle->increment($key, $num);
    }

    static function decrease($key, $num = 1)
    {
        $handle = self::getMemHandle();
        $handle->decrement($key, $num);
    }
}
