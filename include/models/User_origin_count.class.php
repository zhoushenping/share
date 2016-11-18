<?php
    !defined('IN_APP') and exit;
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
    class User_origin_count extends Model
    {
        private $table = 'user_origin_count';
        
        public function __construct($db)
        {
            parent::__construct($db);
        }
        
        /*
         * 获取表记录总数函数
         * getUserOriginCount()函数需要一个数组类型的参数
         * 该参数保存了在做数据库查询时所需的where子句中各字段的参数
         * 该方法会依据传入的参数构建不同的where子句用于查询
         * 
         * 该函数的返回值为保存有表记录总数的二维数组
         * 
         * 如果以后需要添加依据其他字段进行查询的功能
         * 可以直接在该函数下添加判断$where数组参数的程序
         */
        public function getUserOriginCount($where = array())
        {
            /*调用参数过滤方法防止sql注入*/
            filterInput($where);
            
            /*构建基本sql语句*/
            $sql = "select count(*) as `count` from `{$this->table}`";
            
            /*判断传入的参数$where数组 并构建where子句 没有则不添加where子句*/
            /*判断$where参数是否为空*/
            if((!empty($where['date'])) || (!empty($where['sid'])))
            {
                /*如果不为空 添加where子句*/
                $sql .= ' where ';
                
                /*判断以'date'为键名的数组元素是否为空*/
                if(!empty($where['date']))
                {
                    /*以'date'为键名的数组元素不为空则增加oday字段的where子句*/
                    $sql .= " `oday` = '{$where['date']}'";
                }
                
                /*判断以'sid'为键名的数组元素是否为空*/
                if(!empty($where['sid']))
                {
                    /*以'sid'为键名的数组元素不为空则再次判断以'date'为键名的数组元素是否为空*/
                    if(!empty($where['date']))
                    {
                        /*'date'不为空 则直接在sql语句后添加 or 连结两个不同字段查询*/
                        $sql .= " and `sid` = '{$where['sid']}'";
                    }
                    else
                    {
                        /*'date'为空 则直接在sql语句后添加'sid'字段的where子句*/
                        $sql .= " `sid` = '{$where['sid']}'";
                    }
                }
            }
            return self::$db->query($sql);
        }
        
        /*
         * 获取表记录函数
         * getUserOrigin()函数可以传入三个参数
         * 保存有where子句字段值的$where数组元素
         * 查询的起始行数$start
         * 查询的偏移量$pageSize
         * 
         * 该函数返回值为保存有依据三个参数查询数据库记录的二维数组
         */
        public function getUserOrigin($where = array(), $start = 0, $pageSize = '')
        {
            /*调用参数过滤方法防止sql注入*/
            filterInput($where);
            
            /*构建基本sql语句*/
            $sql = "select * from `{$this->table}`";
            
            /*判断传入的参数$where数组 并构建where子句 没有则不添加where子句*/
            if((!empty($where['date'])) || (!empty($where['sid'])))
            {
                $sql .= ' where ';
                if(!empty($where['date']))
                {
                    $sql .= " `oday` = '{$where['date']}'";
                }
                if(!empty($where['sid']))
                {
                    if(!empty($where['date']))
                    {
                        $sql .= " and `sid` in ({$where['sid']})";
                    }
                    else
                    {
                        $sql .= " `sid` in ({$where['sid']})";
                    }
                }
            }
            /*添加order by排序子句*/
            if($where['sid'])
            {
                $sql .= " order by `sid` desc, `oday` desc";
            }
            else
            {
                $sql .= " order by `oday` desc, `otype1` desc";
            }
            
            /*判断$pageSize参数 添加limit子句 没有则不创建*/
            if($pageSize)
            {
                $sql .= " limit $start, $pageSize";
            }
            return self::$db->query($sql);
        }
        /*
         * 获取oday字段最大值函数
         * 因某些需求需要获取到oday字段的最大值作为$where子句的参数所以添加此函数
         */
        public function getMaxOday()
        {
            $sql = "select max(oday) as `max_oday` from `{$this->table}`";
            return self::$db->query($sql);
        }
        
        /*
         * getUserOriginSum()函数
         * 用于查询用户来源每日总计
         */
        public function getUserOriginSum()
        {
            $sql = "select `oday`, sum(otype1) as `otype1`, sum(otype2) as `otype2`, sum(otype3) as `otype3`, sum(otype4) as `otype4`, sum(otype5) as `otype5` from `{$this->table}` group by `oday` order by `oday` desc;";
            return self::$db->query($sql);
        }
    }
?>