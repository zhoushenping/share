<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 15-5-24
 * Time: 下午7:27
 */
class AdminArticle
{
    //////////////////以下方法都只有admin后台才会触发///////////////////////////////////

    //清理掉memcache中的记录
    static function deleteMem()
    {
        $memKey = "Article_getAll";
        Mem::delete($memKey);
    }

    static function add($articleInfo)
    {
        //todo
        //$sql = "";
        //DBHandle::execute($sql);
        self::deleteMem();
    }

    static function delete($id)
    {
        //todo
        //$sql = "";
        //DBHandle::execute($sql);
        self::deleteMem();
    }

    static function update()
    {
        //todo
        //$sql = "";
        //DBHandle::execute($sql);
        self::deleteMem();
    }
}