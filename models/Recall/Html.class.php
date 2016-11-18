<?php

/**
 * Created by PhpStorm.
 * User: shenping zhou
 * Date: 2016/1/21
 * Time: 16:22
 */
class RecallHtml
{
    static function makeBonusTR($rs, $bonus_type = 'login')
    {
        global $lang;
        foreach ($rs as $date => $dailyBonus) {
            $date = RecallBonusBase::formatDate($date);
            foreach ($dailyBonus as $item) {
                $str_codeType = '';
                if ($bonus_type == 'login') {
                    $str_codeType = (strpos($item['code_type'], 'day') === false) ? $lang['accept_invite'] :
                        str_replace("day", " {$lang['days']}", $item['code_type']);
                }
                if ($bonus_type != 'login') {
                    $str_codeType = str_replace("coins", " {$lang['diamonds']}", $item['code_type']);
                }
                self::makeTR($date, $item['code'], $str_codeType);
            }
        }
    }

    static function makeEmptyTR()
    {
        echo "<tr height='7' class='empty_tr'><td></td><td></td><td></td></tr>";
    }

    static function makeTR($date, $bonus, $type)
    {
        echo "<tr height='30'><td>$date</td><td>$bonus</td><td>$type</td></tr>";
    }
}
