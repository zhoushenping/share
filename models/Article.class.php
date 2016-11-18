<?php

/**
 * Created by PhpStorm.
 * User: shenping zhou
 * Date: 2015/5/21
 * Time: 17:40
 */
class Article
{
    const table = 'oas_help_content';

    static function getValid()
    {
        static $all = array();

        $str_columns = "`id`,`first_c`,`title_out`,`title_in`,`order`,`time`,`m_time`,`status`,`arc_redirect`,`is_top`,`label2`,`label`,`seo_keyword2`,`seo_keyword`";
        $str_columns = "`id`,`first_c`,`title_out`,`title_in`,`order`,`time`,`m_time`,`status`,`arc_redirect`,`is_top`,         `label`,               `seo_keyword`";
        if (empty($all)) {
            $rs = DBHandle::select(self::table, "1 ORDER BY `order` DESC,`time` DESC", $str_columns);
            foreach ($rs as $item) {
                if ($item['status'] != 'Y') {
                    continue;
                }
                $id       = $item['id'];
                $all[$id] = $item;
            }
        }

        return $all;
    }

    static function getValidId()
    {
        static $ret = array();
        if (empty($ret)) {
            $rs = DBHandle::select(self::table, "1 ORDER BY `order` DESC,`time` DESC", "`id`,`status`");
            foreach ($rs as $item) {
                if ($item['status'] != 'Y') {
                    continue;
                }
                $ret[] = $item['id'];
            }
        }

        return $ret;
    }

    static function getByType($type)
    {
        if (!is_array($type)) {
            $type = array($type);
        }

        $ret = array();
        foreach (self::getValid() as $item) {
            if (in_array($item['first_c'], $type)) {
                $ret[] = $item;
            }
        }

        return $ret;
    }

    //获取某篇文章的简要信息
    static function getBriefInfo($article_id)
    {
        $all = self::getValid();

        return $all[$article_id];
    }

    //获取某篇文章的所有信息
    static function getDetail($article_id)
    {
        String::_filterNoNumber($article_id);

        $rs             = DBHandle::select(self::table, "`id`=$article_id");
        $ret            = $rs[0];
        $ret['content'] = str_replace(
            '//www.oasgame.com/appadmin/resource/',
            '//lobr.oasgames.com/static/admin/images/',
            $ret['content']
        );
        $ret['content'] = str_replace(
            'http://lobr.oasgames.com/',
            '//lobr.oasgames.com/',
            $ret['content']
        );

        return $ret;
    }

    static function modifyHttpPrex($input)
    {
        $game = GAME_CODE_STANDARD;

        return str_replace(
            "http://{$game}.oasgames.com/static/admin/images/upload/",
            "//{$game}.oasgames.com/static/admin/images/upload/",
            $input
        );
    }

    static function getHotType($item)
    {
        $ret      = '';
        $t        = $item['m_time'];
        $time_new = time() - 3600 * 24 * 7;
        $time_now = time();
        if ($t >= $time_new && $t <= $time_now) {
            $ret = 'new';
        }
        if ($item['hot'] == 1) {
            $ret = 'hot';//todo 检查是否有hot这个字段
        }

        return $ret;
    }

    static function getURL($id)
    {
        return "/?method=content&id=$id";
    }
}
