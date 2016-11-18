<?php

/**
 * Created by PhpStorm.
 * User: shenping zhou
 * Date: 2016/5/9
 * Time: 18:02
 */
class ThreeYearSignConfig
{
    public static $signDateConfig = array(7, 15, 27);
    public static $eventBegin     = '2016-07-01';//online 0701
    public static $eventEnd       = '2016-08-31';//onliine 0831

    public static function getSignBonusConfig()
    {
        $ret = array();
        foreach (self::$signDateConfig as $i) {
            $ret['sign' . $i] = array('name_cn' => "当月签到{$i}天", 'name' => "Pacote acumulado de {$i} dias");
        }

        return $ret;
    }

    //每周从周几开始数
    public static function getWeekBegin()
    {
        $arr_fromSunday = array();//每周从周日开始算的国家 没有列入的话  从周一开始

        return in_array(GAME_CODE_STANDARD, $arr_fromSunday) ? 0 : 1;
    }

    public static function getSignBonusInfo()
    {
        return array(
            '2016-07' => array(
                7  => array(
                    'Pergaminho de Experiência Divina x3',
                    'Ordem de Punição Imperial x5',
                ),
                15 => array(
                    'Pedra Bestial x100',
                    'Pedra do Crescimento x50',
                    'Sangue de Zeus x30',
                ),
                27 => array(
                    'Pedra do Crescimento Avançado x300',
                    'Esfera de Energia Avançada x300',
                    'Proteção da Escuridão Nv.6 x1',
                ),
            ),
            '2016-08' => array(
                7  => array(
                    'Poção de Energia Avançado x20',
                    'Selo da Tenacidade x20',
                ),
                15 => array(
                    'Bolsa de Ouro Grande x20',
                    'Pacote Divino de Roupas Vermelhas x20',
                    'Esfera de Energia x50',
                ),
                27 => array(
                    'Material de tatuagem x1200',
                    'Pó da Lua x100',
                    'Pedra da Lua x100',
                ),
            ),
        );
    }

    static function isBeforeEvent()
    {
        return time() < Time::getDateFirstSecond(self::$eventBegin);
    }

    static function isAfterEvent()
    {
        return time() > Time::getDateLastSecond(self::$eventEnd);
    }

    static function getMinSignTime()
    {
        static $ret = 0;
        if ($ret == 0) {
            $ret = Time::getDateFirstSecond(self::$eventBegin);
        }

        return $ret;
    }

    static function getMaxSignTime()
    {
        static $ret = 0;
        if ($ret == 0) {
            $ret = Time::getDateLastSecond(self::$eventEnd);
        }

        return $ret;
    }
}
