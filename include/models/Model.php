<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Model
 *
 * @author wanglun
 */
class Model {
        /**
	 * 数据库链接对象
	 *
	 * @var object
	 */
	public static $db = null;
        
        /**
	 * 构造函数
	 *
	 */
	function __construct($dbc)
	{
		// 获取数据库操作对象
		if( self::$db == null )
		{
			self::$db = $dbc;
		}
	}

}

?>