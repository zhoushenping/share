<?php	
	
	define("LP_URL",WEB_URL);
	$from		    	= !empty($_GET['s'])?$_GET['s']:'0';
	$user_uid	    	= !empty($_COOKIE['user_uid'])?$_COOKIE['user_uid']:'0';
	list($uid,$utype)	= explode("|",$user_uid);

	if($from=='game' and (empty($utype) or $utype=="oas" )){
		echo "<script>top.location.href='".LP_URL."';</script>";
		exit(0);
	}else if($from=='game' and $utype=="fb"){
		echo "<script>top.location.href='".FB_URL."';</script>";
		exit(0);
	}