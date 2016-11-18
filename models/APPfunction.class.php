<?php
/**
 * Created by PhpStorm.
 * User: shenping zhou
 * Date: 2015/5/21
 * Time: 19:13
 */
class APPfunction
{
    //编制APP右上角 其它语言的神曲的链接
    static function makeTopOtherLanguageLink()
    {
        $top_otherLanguage_link = array(
            'lotr' => array('tr', 'Türkçe'),
            'lobr' => array('pt', 'Português'),
            'loes' => array('es', 'Español'),
            'lopl' => array('pl', 'Polski'),

            'lonl' => array('nl', 'Nederlands'),
            'losv' => array('sv', 'Svenska'),
            'lode' => array('de', 'Deutsch'),
        );
        foreach ($top_otherLanguage_link as $k => $v)
        {
            if ($k == GAME_CODE_STANDARD) continue;
            echo "<tr>
                    <th colspan='2'><a href='javascript:void(0)' onclick='href_fb{$v[0]}();'>{$v[1]}</a></th>
                </tr>";
        }
    }
}