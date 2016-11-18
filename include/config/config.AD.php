<?php
//对联广告以及玩游戏页面左边栏广告图片的url配置
	$img_website = "//lobr.oasgames.com";
	//官网左侧
	$AD_config['duilian']['left']['pt']['url'] = '//mob.oasgames.com/public/?a=service&m=redirect&position=web_duilian&src_url=http%3a%2f%2fmob.oasgames.com%2fmlopt%2flp.php';
	$AD_config['duilian']['left']['pt']['img'] = "$img_website/static/legend/images/duilian/0820/pt/100_300l.jpg?3";
	
	$AD_config['duilian']['left']['tr']['url'] = '//mob.oasgames.com/public/?a=service&m=redirect&position=web_duilian&src_url=http%3a%2f%2fmob.oasgames.com%2fmlotr%2flp.php';
	$AD_config['duilian']['left']['tr']['img'] = "$img_website/static/legend/images/duilian/0815/tr/100_300l.jpg?3";
	
	
	//官网右侧
	$AD_config['duilian']['right']['pt']['url'] = '//mob.oasgames.com/public/?a=service&m=redirect&position=web_duilian&src_url=http%3a%2f%2fmob.oasgames.com%2fmlopt%2flp.php';
	$AD_config['duilian']['right']['pt']['img'] = "$img_website/static/legend/images/duilian/0820/pt/100_300r.jpg?3";
	
	$AD_config['duilian']['right']['tr']['url'] = '//mob.oasgames.com/public/?a=service&m=redirect&position=web_duilian&src_url=http%3a%2f%2fmob.oasgames.com%2fmlotr%2flp.php';
	$AD_config['duilian']['right']['tr']['img'] = "$img_website/static/legend/images/duilian/0815/tr/100_300r.jpg?3";
	
	
	//玩游戏页面
	$AD_config['play']['pt']['url'] = '//mob.oasgames.com/public/?a=service&m=redirect&position=web_play_side&src_url=http%3a%2f%2fmob.oasgames.com%2fmlopt%2flp.php';
	$AD_config['play']['pt']['img'] = "$img_website/static/legend/images/duilian/0820/pt/120_180.jpg?2";
	
	$AD_config['play']['tr']['url'] = '//mob.oasgames.com/public/?a=service&m=redirect&position=web_play_side&src_url=http%3a%2f%2fmob.oasgames.com%2fmlotr%2flp.php';
	$AD_config['play']['tr']['img'] = "$img_website/static/legend/images/duilian/0815/tr/120_180.jpg?2";

	//开关
	$swith_AD_duilian = false;
	$swith_AD_play    = false;
	
	$AD_config['app_serverlist']['pt']['apple']['url'] = 'https://itunes.apple.com/br/app/legend-online-portugues/id710674994?mt=8';
	$AD_config['app_serverlist']['pt']['google']['url'] = 'https://play.google.com/store/apps/details?id=org.oasgames.lobr';
	$AD_config['app_serverlist']['tr']['apple']['url'] = 'https://itunes.apple.com/tr/app/legend-online-turkce/id806921933?mt=8';
	$AD_config['app_serverlist']['tr']['google']['url'] = 'https://play.google.com/store/apps/details?id=org.oasgames.lotr';