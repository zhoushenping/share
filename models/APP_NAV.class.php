<?php

/**
 * Created by PhpStorm.
 * User: shenping zhou
 * Date: 2015/12/17
 * Time: 12:29
 */
class APP_NAV
{
    static function getConfig()
    {
        global $_LANG;
        $html_li                       = array();
        $html_li['play']['a_href']     = "";
        $html_li['play']['a_class']    = "play_game_a now_a";
        $html_li['play']['font_class'] = "game_ico";
        $html_li['play']['span_text']  = $_LANG['menu_play'];//
        $html_li['play']['ga_id']      = "fb_pgame";

        $html_li['pay']['a_href']     = "";
        $html_li['pay']['a_class']    = "pay_nav_a";
        $html_li['pay']['font_class'] = "money_ico";
        $html_li['pay']['span_text']  = $_LANG['menu_pay'];//
        $html_li['pay']['ga_id']      = "fb_pay";

//        $html_li['invite']['a_href']     = "";
//        $html_li['invite']['a_class']    = "davet_a";
//        $html_li['invite']['font_class'] = "share_ico";
//        $html_li['invite']['span_text']  = $_LANG['fb_menu_invite'];//
//        $html_li['invite']['ga_id']      = "fb_invite";

//        $html_li['fans']['a_href']     = "javascript:postToFeed();";
        $html_li['fans']['a_href']     = FANS_URL;
        $html_li['fans']['a_class']    = "face_a";
        $html_li['fans']['font_class'] = "like_ico";
        $html_li['fans']['span_text']  = $_LANG['fb_menu_fans'];//
        $html_li['fans']['ga_id']      = "fb_fans";

        $html_li['gm']['a_href']     = "";
        $html_li['gm']['a_class']    = "kefu_a";
        $html_li['gm']['font_class'] = "qa_ico";
        $html_li['gm']['span_text']  = "SAC";//
        $html_li['gm']['ga_id']      = "fb_cus";

        $html_li['chat']['li_class']   = "kf_li";
        $html_li['chat']['a_href']     = "";
        $html_li['chat']['a_class']    = "kf_ico";
        $html_li['chat']['font_class'] = "kf_ico";
        $html_li['chat']['span_text']  = "Suporte Online";//
        $html_li['chat']['ga_id']      = "fb_wchat";

        return $html_li;
    }

    static function make_li_each($item, $id)
    {
        $href       = (strpos($item['a_href'], 'http') !== false) ? $item['a_href'] : 'javascript:void(0);';
        $str_target = (strpos($item['a_href'], 'http') !== false) ? "target='_blank'" : "";
        $str_ga     = ($item['ga_id'] == '') ? "" : "onclick=\"ga_send(['app_v3','{$item['ga_id']}']);\"";
        echo "
        <li $str_ga  class='clearfix {$item['li_class']} {$id}'>
            <i class='left_i'></i>
            <a href='$href' class='{$item['a_class']}' $str_target>
                <font class='{$item['font_class']}'></font>
                <span><b></b>{$item['span_text']}</span>
            </a>
            <i class='right_i'></i>
        </li>
    ";
    }

    static function make_li()
    {
        foreach (self::getConfig() as $id => $item) self::make_li_each($item, $id);
    }
}