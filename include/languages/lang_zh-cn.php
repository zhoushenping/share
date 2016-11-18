<?php 
	!defined('IN_APP') and exit;
	$_LANG['common_language'] = "简体中文";
	
	$_LANG['invite_message'] = '赶快邀请你的好友一起来玩吧，组队才叫那个爽！';
	$_LANG['invite_title'] = 'OAS-GAME';
        $_LANG['welcome'] ='欢迎';
	$_LANG['menu_invite'] = '邀请好友';
	$_LANG['menu_pay']   = '充值';
	$_LANG['menu_play']= "游戏";	
	$_LANG['menu_server']= "选服";	
	$_LANG['menu_kuanping']= "宽屏";	
	$_LANG['menu_kuanping_tip']= "如果您的显示器分辨率不够，点此扩展至全屏";	
	$_LANG['menu_help']= "攻略";	
	$_LANG['menu_twitter_follow']= "Follow";
	$_LANG['menu_earn'] = '赢钻石';
	$_LANG['menu_act_code'] = '奖';
	
	$_LANG['serverlist_list']= "服务器列表";
	$_LANG['serverlist_lastPlayed']= "上次访问的服务器";
	$_LANG['serverlist_recommand']= "推荐服务器";
	$_LANG['serverlist_recommand_notice_start']='';
	$_LANG['serverlist_recommand_notice_end']='';
	$_LANG['serverlist_list_hit']='选择新的服务器时，所有的字符信息将被复位（不影响信息从旧的服务器）';
	
	$_LANG['windowclose_hit'] = '在帝国的路径 \n\n'.
						'★ 结构elevamento? \n\n'.
						'★ 士兵是在生产 ? \n\n'.
						'★ 英雄是在训练中 ? \n\n'.
						'★ 我的是野生ocupamento ? \n\n'.
						'★ 今天已经牺牲 ? \n\n'.
						' 不要忘了添加到收藏夹帝国！ CTRL+ D直接添加.\n ';
	

	$_LANG['last_server']="最后登录服务器";
	$_LANG['recommend_server']="推荐服务器";
	$_LANG['all_server']="所有的服务器";
	
	$_LANG['normal']="正常";
	$_LANG['look_forward']="等待";
	$_LANG['maintain']="保持";
	$_LANG['login']="进入";
	
	
	$_LANG['pay_show_hit'] = "直流充电服务器:";
	$_LANG['footer_fan'] = '粉丝页';
	$_LANG['footer_report'] = "报告问题";
	$_LANG['foot_privacy']  = "隐私权政策";
	$_LANG['foot_provision'] ="服务条款";
	$_LANG['footer_copyright'] = ' © 2011 OASIS GAMES LIMITED. All rights reserved.';
	
	$_LANG['sign_credits'] = '签到积分'; 
	$_LANG['sign_sign'] = '签到';
	$_LANG['sign_signed'] = '已签到 ';
	$_LANG['sign_success']   = '签到成功';
	$_LANG['sign_hit']  = "签到有奖哦";
	$_LANG['goods_hit']  = "签到有奖哦，加油签";
	$_LANG['change_alert']  = "兑换成功";

	$_LANG['invite_head_title']= "选择你的朋友加入游戏";
	$_LANG['invite_point']= "邀请你的朋友一起玩!";
	$_LANG['invite_table_title']= "所有的朋友";
	$_LANG['invite_select']='选择所有';
	$_LANG['invite_sure']=' 确认';
	$_LANG['invite_cancel']='取消';
	$_LANG['invite_invite']='邀请';
		
	$_LANG['pay_mobile']= "";//
	$_LANG['pay_gold']= "钻石";
	$_LANG['pay_best']= "最好的折扣";
	$_LANG['pay_discount']='';//
	$_LANG['pay_song']="奖金";
	$_LANG['announcement']="Últimas noticias";
	$_LANG['pay_buy'] = '购买';
	$_LANG['logout']  ="退出";
	
	
	$_LANG['active_code']['title']  = "激活码页面";
	$_LANG['active_code'][0]  = "您已拥有激活码，请点击查询";
	$_LANG['active_code'][1]  = "恭喜，复制成功";
	$_LANG['active_code'][2]  = "查询激活码";
	$_LANG['active_code'][3]  = "领取激活码";
	$_LANG['active_code'][4]  = "你的激活码是";
	$_LANG['active_code'][5]  = "你的激活码是";
	$_LANG['active_code'][6]  = "您的UID为";
	$_LANG['active_code'][7]  = "当前服务器为";
	$_LANG['active_code'][8]  = "复制激活码";
	
	$_LANG['fbapp'][201]  = "您当前的分辨率不大于1024X768,建议您切换至宽屏模式，拥有更好游戏体验。";
        
		 //以下是邀请好友
    $invite_key = 'buagmeunxufe';//加密key
	$gifts['gift_1']['count15'] = 5;//该礼包需要*个受邀好友达到15级
	$gifts['gift_2']['count15'] = 10;
	$gifts['gift_3']['count15'] = 20;
	$gifts['gift_4']['count15'] = 40;

	$gifts['gift_1']['my_grade'] = 25;//该礼包需要自己达到*级
	$gifts['gift_2']['my_grade'] = 30;
	$gifts['gift_3']['my_grade'] = 35;
	$gifts['gift_4']['my_grade'] = 40;
	$my_lowest_grade = 25;/*领取礼包要自己达到的最低等级，这里就手动指定了*/

	
	$gifts['gift_1']['intro_long']['shenqu_cn'] = "玩家达到25级，至少5位被邀请人在游戏内达到15级。可以获得奖励：黄金10w，战魂10w";
	$gifts['gift_2']['intro_long']['shenqu_cn'] = "玩家达到30级，至少10位被邀请人在游戏内达到15级。可以获得奖励：黄金20w，战魂20w，灵魂水晶50";
	$gifts['gift_3']['intro_long']['shenqu_cn'] = "玩家达到35级，至少20位被邀请人在游戏内达到15级。可以获得奖励：黄金30w，战魂30w，灵魂水晶100";
	$gifts['gift_4']['intro_long']['shenqu_cn'] = "玩家达到40级，至少40位被邀请人在游戏内达到15级。可以获得奖励：黄金50w，战魂50w，灵魂水晶200";
	
	$gifts['gift_1']['intro']['shenqu_cn'] = "玩家达到25级，成功邀请5位好友";
	$gifts['gift_2']['intro']['shenqu_cn'] = "玩家达到30级，成功邀请10位好友";
	$gifts['gift_3']['intro']['shenqu_cn'] = "玩家达到35级，成功邀请20位好友";
	$gifts['gift_4']['intro']['shenqu_cn'] = "玩家达到40级，成功邀请40位好友";
	

	$lang_invite['big_header']['shenqu_cn'] = "邀请好友~赢取丰厚礼包";
	$lang_invite['big_header']['shenqu_br'] = "Convide Amigos e Ganhe Prêmios";
	$lang_invite['big_header']['shenqu_tr'] = "Arkadaşlarını Davet Et, Büyük Hediye Paketini Kazan";
	$lang_invite['big_header']['shenqu_es'] ="";

	$lang_invite[2]['shenqu_cn'] = "活动时间：长期有效";
	$lang_invite[2]['shenqu_br'] = "Tempo: Indeterminado";
	$lang_invite[2]['shenqu_tr'] = "Etkinlik Süresi: Sürekli";
	$lang_invite[2]['shenqu_es'] = "";

	$lang_invite[3]['shenqu_cn'] = "活动对象：所有玩家";
	$lang_invite[3]['shenqu_br'] = "Para: Todos os jogadores";
	$lang_invite[3]['shenqu_tr'] = "Katılım Şartı: Tüm Oyuncular";
	$lang_invite[3]['shenqu_es'] = "";

	$lang_invite[4]['shenqu_cn'] = "奖励";
	$lang_invite[4]['shenqu_br'] = "Prêmio";
	$lang_invite[4]['shenqu_tr'] = "Ödül";
	$lang_invite[4]['shenqu_es'] = "";

	$lang_invite[5]['shenqu_cn'] = "领取奖励";
	$lang_invite[5]['shenqu_br'] = "Coletar";
	$lang_invite[5]['shenqu_tr'] = "Ödülü Al";
	$lang_invite[5]['shenqu_es'] = "";

	$lang_invite[6]['shenqu_cn'] = "邀请好友";
	$lang_invite[6]['shenqu_br'] = "Convidar Amigos";
	$lang_invite[6]['shenqu_tr'] = "Arkadaşlarını Davet Et";
	$lang_invite[6]['shenqu_es'] = "";

	$lang_invite[7]['shenqu_cn'] = "您的等级";
	$lang_invite[7]['shenqu_br'] = "Seu Nível";
	$lang_invite[7]['shenqu_tr'] = "Seviyeniz";
	$lang_invite[7]['shenqu_es'] = "";

	$lang_invite[8]['shenqu_cn'] = "已邀请";
	$lang_invite[8]['shenqu_br'] = "No.de Convidados";
	$lang_invite[8]['shenqu_tr'] = "Davet edilen";
	$lang_invite[8]['shenqu_es'] = "";

	$lang_invite[9]['shenqu_cn'] = "领奖";
	$lang_invite[9]['shenqu_br'] = "RECEBER";
	$lang_invite[9]['shenqu_tr'] = "Ödül";
	$lang_invite[9]['shenqu_es'] = "";

        
    //app下半部分 start
    $activity_url[] = "https://www.facebook.com/notes/legend-online-portugu%C3%AAs/detonadosportal-dos-her%C3%B3is/377329892360706";
	$activity_url[] = "https://www.facebook.com/notes/legend-online-portugu%C3%AAs/detonadossistema-de-tarefas-da-legend-online/377337289026633";
	$activity_url[] = "https://www.facebook.com/notes/legend-online-portugu%C3%AAs/detonadoschef%C3%A3o-global-de-legend-online/377337825693246";
	$activity_url[] = "https://www.facebook.com/notes/legend-online-portugu%C3%AAs/detonadosmodos-de-jogar-no-campo-de-batalha/377343949025967";
	$activity_url[] = "https://www.facebook.com/notes/legend-online-portugu%C3%AAs/detonadoso-labirinto/377344145692614";
	$activity_url[] = "https://www.facebook.com/notes/legend-online-portugu%C3%AAs/detonadoscoliseu/377346369025725";
	$activity_url[] = "https://www.facebook.com/notes/legend-online-portugu%C3%AAs/detonadoslegend-online-introdu%C3%A7%C3%A3o-%C3%A0-fazenda/377346805692348";
	$activity_url[] = "https://www.facebook.com/note.php?saved&&note_id=377368689023493&id=330679823692380";
	
	$banner_left[0]['img'] = STATIC_URL."app/images/huangjin.jpg";
	$banner_left[0]['url'] = "http://lobr.oasgames.com/forum/viewtopic.php?f=3&t=32&p=37#p37";
	
	$banner_left[1]['img'] = STATIC_URL."app/images/banner_left1.jpg";
	$banner_left[1]['url'] = "http://lobr.oasgames.com/forum/viewtopic.php?f=3&t=33&p=38#p38";
	
	$banner_left[2]['img'] = STATIC_URL."app/images/gonghui.jpg";
	$banner_left[2]['url'] = "http://lobr.oasgames.com/forum/viewtopic.php?f=3&t=34";
	
	$banner_right[0]['img'] = STATIC_URL."app/images/zhandouli.jpg";
	$banner_right[0]['url'] = "http://lobr.oasgames.com/forum/viewtopic.php?f=3&t=35";
	
	$banner_right[1]['img'] = STATIC_URL."app/images/banner_right1.jpg";
	$banner_right[1]['url'] = "http://lobr.oasgames.com/forum/viewtopic.php?f=3&t=36";
	
	$banner_right[2]['img'] = STATIC_URL."app/images/banner_right2.jpg";
	$banner_right[2]['url'] = "http://lobr.oasgames.com/forum/viewtopic.php?f=3&t=37";
        
	$_LANG['time_out_give']   ="活动结束还有：";
	
	$_LANG['huobao'] = '今日火爆指数';
	$_LANG['huorekaiqi'] = '火热开启';
	$_LANG['yonghuxinxi'] = '用户信息';
	$_LANG['ninhao'] = '您好';
	$_LANG['denglushijian'] = '登录时间';
	$_LANG['shenqutuijian'] = '神曲推荐您进入';
	$_LANG['jieshouxiaoxi'] = '此邮箱用于接受支付相关信息';
	$_LANG['xiugai'] = '修改';
	$_LANG['youxiangweikong'] ='你的邮箱为空，不可修改!';
	$_LANG['geshibudui'] = '邮箱格式不对!';
	$_LANG['weikongbuketijiao'] ='你的邮箱为空，不可提交!';
	$_LANG['xiugaichenggong'] ='修改成功';
	
	 $_LANG['addFavorite'] = '添加到收藏夹';
	$_LANG['newer_help'] = '帮助初学者';
	$_LANG['fans_bar_info'] = '新闻主任';
	$_LANG['interact']   = '玩家互动';
	$_LANG['new_player']   = '新手指南';
	$_LANG['high_player']   = '高级演练';
	$_LANG['bbs_best']   = '论坛总结';
	$_LANG['notice']   = '活动公告';
	$_LANG['title_fb_plugin_left']   = '广告游戏';
	$_LANG['title_fb_plugin_right']  = '帖子';
	$_LANG['activity']        = '事件';
	$_LANG['characteristic']  = '游戏特色';
	$_LANG['hero_suit']  = '集英雄';
	$_LANG['banner_left']     = '留下文字横幅';
	$_LANG['banner_right']    = '横幅文字的权利';
	$_LANG['beginners_guide'] = "解决黑屏"; 
    $_LANG['Group'] ="组";
    $_LANG['safe']  ="帐户安全";
	
	
	$_LANG['content_class_name'][1]     = $_LANG['activity'];
	$_LANG['content_class_name'][2]     = $_LANG['new_player'];
	$_LANG['content_class_name'][3]     = $_LANG['characteristic'];
	$_LANG['content_class_name'][4]     = $_LANG['high_player'];
	$_LANG['content_class_name'][5]     = $_LANG['hero_suit'];
	
	$_LANG['skill'][1] = "下一等级";
	$_LANG['skill'][2] = "级";
	$_LANG['skill'][3] = "冷却时间";
	$_LANG['skill'][4] = "秒.";
	$_LANG['skill'][5] = "怒气消耗";
	$_LANG['skill'][6] = "领主 ";
	$_LANG['skill'][7] = "进入游戏";
	$_LANG['skill'][8] = "返回官网l";
	$_LANG['skill'][9] = "请输入1-80之间整数";
	$_LANG['skill'][10] = "技能点不足";

	//下面把中文后面的葡语替换成西语就成，中文不变 start
	$str = "	
                进入游戏	Entrar no Jogo
                返回官网	Voltar ao Site Oficial
                请输入1-80之间整数	Insira número par de 1-80
                下一等级	Próximo nível
                冷却时间  秒	Resfriamento   seg.
                怒气消耗	Consumo de fúria
                领主	Líder
                战士	Guerreiro
                法师	Feiticeiro
                射手	Arqueiro
                最新活动	Novos Eventos
                领取礼包	Coletar Pacote
                神曲官网	Site Oficial do Legend Online
                技能加点模拟器	Simulador de Pontos de Habilidades
                剩余技能点	Pontos Restantes
                设置等级	Configurar Nível
                战魂  	Espírito
                黄金 	Ouro
                公文包  	Doc. de Recompensa
                宝箱	Baú"; 
		//上面把中文后面的葡语替换成西语就成，中文不变 end

        //app下半部分 end
        
        
        //官网start
        $_LEGEND_ONLINE['login'] = '登录';
        $_LEGEND_ONLINE['welcome'] ='欢迎';
        $_LEGEND_ONLINE['logout'] ='退出';
        $_LEGEND_ONLINE['search'] ='搜索你想要的信息';
        $_LEGEND_ONLINE['register'] = '注册';
        $_LEGEND_ONLINE['username'] = 'Email';
        $_LEGEND_ONLINE['password'] = '密码';
        $_LEGEND_ONLINE['remempwd'] = '记住密码';
        $_LEGEND_ONLINE['logout'] = '退出';
        $_LEGEND_ONLINE['repwd'] = '再次输入';
        $_LEGEND_ONLINE['updatepwd'] = '修改密码';
        $_LEGEND_ONLINE['logintitle']='账号登陆';
        $_LEGEND_ONLINE['loginh1']= '登入';
        $_LEGEND_ONLINE['loginemail']='电子邮箱地址';
        $_LEGEND_ONLINE['loginpwd'] = '登陆密码';
        $_LEGEND_ONLINE['loginwarning'] = '因为您的安全考虑，请输入您在图片中搜看到的数字，这并非您的密码';
        $_LEGEND_ONLINE['qiandao'] = '签到';
        $_LEGEND_ONLINE['integral'] = '当前积分';
        $_LEGEND_ONLINE['usercenter'] = '用户中心';
        $_LEGEND_ONLINE['thelastserver'] = '上一次玩过的游戏服';
        $_LEGEND_ONLINE['myotherserver'] = '我的其他服务';
        $_LEGEND_ONLINE['notherserver'] = '你还没有玩其他服务器';
        $_LEGEND_ONLINE['safeinput '] = '安全输入';
        $_LEGEND_ONLINE['savelogin'] ='保持登陆状态';
        $_LEGEND_ONLINE['sublogin'] = '登陆';
        $_LEGEND_ONLINE['nologin'] = '无法登陆';
        $_LEGEND_ONLINE['learnhow'] = '学习如何';
        $_LEGEND_ONLINE['accnotexist'] = '帐号不存在';
        $_LEGEND_ONLINE['accexist'] = '帐号已存在';
        $_LEGEND_ONLINE['regallow'] = '可以注册';
        $_LEGEND_ONLINE['protectaccount'] = '保护自己的账号';
        $_LEGEND_ONLINE['nohaveacc'] = '还没有自己的账号么?';
        $_LEGEND_ONLINE['needoneacc'] = '需要一个账号么?';
        $_LEGEND_ONLINE['nowreg'] = '立即注册';
        $_LEGEND_ONLINE['forfreereg'] = '建立账号是快速、简单和免费的';
        $_LEGEND_ONLINE['regacc'] = '建立账号';
        $_LEGEND_ONLINE['index'] = '首页';
        $_LEGEND_ONLINE['game'] = '游戏';
        $_LEGEND_ONLINE['account'] = '账号';
        $_LEGEND_ONLINE['support'] = '支持';
        $_LEGEND_ONLINE['language'] ='中文';
        $_LEGEND_ONLINE['useterm'] ='使用条款';
        $_LEGEND_ONLINE['law'] ='法律';
        $_LEGEND_ONLINE['privacy'] = '隐私权政策';
        $_LEGEND_ONLINE['infringementnotice'] = '违反版权';
        $_LEGEND_ONLINE['copyright'] = '©2012 oas game, Inc. 版權所有';
        $_LEGEND_ONLINE['regtitle'] = '注册账号';
        $_LEGEND_ONLINE['getpasstitle'] = '找回密码';
        $_LEGEND_ONLINE['uppasstitle'] = '修改密码';
        $_LEGEND_ONLINE['usertitle'] = '个人中心';
        $_LEGEND_ONLINE['userinfo'] = '账号详细资料';
        $_LEGEND_ONLINE['useracount'] = '账号名称';
        $_LEGEND_ONLINE['usersex'] = '性别';
        $_LEGEND_ONLINE['fail'] = '男';
        $_LEGEND_ONLINE['mfail'] = '女';
        $_LEGEND_ONLINE['age'] = '生日';
        $_LEGEND_ONLINE['phone'] = '手机号';
        $_LEGEND_ONLINE['msn'] = 'MSN';
        $_LEGEND_ONLINE['email'] = '邮箱';
        $_LEGEND_ONLINE['usermsg'] = '可以与账号一致';
        $_LEGEND_ONLINE['upload'] = '上传';
        $_LEGEND_ONLINE['imgmsg'] = '请选择要上传的图片';
        $_LEGEND_ONLINE['submit'] = '确认';
        $_LEGEND_ONLINE['userProtocol'] ='用户注册服务协议';
        $_LEGEND_ONLINE['emailmsg1'] = '邮箱不能为空';
        $_LEGEND_ONLINE['emailmsg2'] = '邮箱格式不正确';
        $_LEGEND_ONLINE['resetpass'] = '重置密码';
        $_LEGEND_ONLINE['fastreg'] = '快速注册';
        $_LEGEND_ONLINE['getpassmsg1'] = '用户名不能为空';
        $_LEGEND_ONLINE['getpassmsg2'] = '用户名格式不正确,以邮箱格式填写';
        $_LEGEND_ONLINE['getpassmsg3'] = '用户名不存在';
        $_LEGEND_ONLINE['pwd'] = '原始密码';
        $_LEGEND_ONLINE['haveone'] = '已有帐号请直接登录';
        $_LEGEND_ONLINE['pwderrormsg'] = '原始密码有误';
        $_LEGEND_ONLINE['newpwd2'] = '输入新密码';
        $_LEGEND_ONLINE['renewpwd2'] = '确认密码';
        $_LEGEND_ONLINE['pwdlength'] = '密码长度为6-15';
        $_LEGEND_ONLINE['compwd'] = '前后密码不一致';
        $_LEGEND_ONLINE['errorlogin'] = '密码不正确，登陆失败！';
        $_LEGEND_ONLINE['errorreg'] = '该帐号已存在，注册失败';
        $_LEGEND_ONLINE['regnotice'] = '我们尊重你的隐私';
        $_LEGEND_ONLINE['guaranteeuser']='保障用户信息请阅读';
        $_LEGEND_ONLINE['OnlinePrivacyPolicy'] ='在线隐私政策';
        $_LEGEND_ONLINE['emailAddr'] ='邮箱地址';
        $_LEGEND_ONLINE['inputEmailAddr'] ='输入邮箱地址';
        $_LEGEND_ONLINE['reInputEmailAddr'] ='再次输入邮箱地址';
        $_LEGEND_ONLINE['password'] = '密 码';
        $_LEGEND_ONLINE['forgetpwd'] = '忘记密码';
        $_LEGEND_ONLINE['inputPassword'] = '输入密码';
        $_LEGEND_ONLINE['reInputPassword'] ='再次输入密码';
        $_LEGEND_ONLINE['accept'] ='同意';
        $_LEGEND_ONLINE['regGetNew'] ='注册来获得新闻和特别提供了从oas账户的电子邮件的地址。';
        $_LEGEND_ONLINE['cancel']='取消';
        $_LEGEND_ONLINE['indextitle']= 'oas game';
        $_LEGEND_ONLINE['copyrightdeclare']= '版权所有oas game';
        $_LEGEND_ONLINE['press'] ='出版';
        $_LEGEND_ONLINE['career']='职业生涯';
        $_LEGEND_ONLINE['legalDocument'] ='法律文件';
        $_LEGEND_ONLINE['contactUs']='联系我们';
        $_LEGEND_ONLINE['siteMap'] ='网站地图';
        $_LEGEND_ONLINE['allnews'] ='查看所有新闻';
        $_LEGEND_ONLINE['loading'] ='进行中。。。';
        $_LEGEND_ONLINE['explore'] ='探索';
        $_LEGEND_ONLINE['usercenter'] = '用户中心';
        $_LEGEND_ONLINE['dogame'] = '游戏激活';
        $_LEGEND_ONLINE['usermanage'] ='账号管理';
        $_LEGEND_ONLINE['mycenter'] = '个人中心';
        $_LEGEND_ONLINE['mysaveinfo'] ='个人安全资料';
        $_LEGEND_ONLINE['noaways'] = '防沉迷设置';
        $_LEGEND_ONLINE['paycenter'] ='充值中心';
        $_LEGEND_ONLINE['gamepay'] = '游戏充值';
        $_LEGEND_ONLINE['mempay'] = '充值记录';
        $_LEGEND_ONLINE['recommonserver'] = '推荐服务器';
        $_LEGEND_ONLINE['playserver'] = '玩过服务器';
        $_LEGEND_ONLINE['serverlist'] = '服务器列表';
        $_LEGEND_ONLINE['sqindextitle'] = '神曲_神曲官网_oas神曲网页游戏|激活码|职业|攻略|技能|神曲猎手－神曲2012';
        $_LEGEND_ONLINE['sqindexkey'] = '神曲,神曲官网,神曲新手卡,神曲礼包,神曲职业,神曲猎手,神曲2012';
        $_LEGEND_ONLINE['sqindexdes'] = '神曲官网-神曲一款角色扮演类的网页游戏，神曲首页，提供神曲下载，神曲BOSS攻略，神曲新手卡，神曲礼包，神曲职业，神曲论坛等一系列的详细游戏介绍，休闲娱乐，从oas开始。';
        $_LEGEND_ONLINE['sqservertitle'] = '神曲_神曲服务器列表_oas神曲服务器列表';
        $_LEGEND_ONLINE['sqserverkey'] = '神曲,神曲服务器列表,oas神曲,oas神曲服务器列表';
        $_LEGEND_ONLINE['sqserverdes'] = '神曲是一款角色扮演类的网页游戏，游戏强大的技能效果能给玩家带来精致细腻的游戏视觉感受。游戏中，玩家通过发展城池、招募军队与魔族进行抗衡，最后成为傲视一方的霸主。';
        $_LEGEND_ONLINE['sqnewtitle'] = '新闻公告-oas《神曲》官方网站';
        $_LEGEND_ONLINE['sqcontenttitle'] = '新闻公告-oas《神曲》官方网站';
        $_LEGEND_ONLINE['hotmsg'] = '今日火爆指数';
        $_LEGEND_ONLINE['hello'] = '您好';
        $_LEGEND_ONLINE['hotstart'] = '火爆开启';
        $_LEGEND_ONLINE['protittle'] = '职业介绍_《神曲》官方网站';
        $_LEGEND_ONLINE['prokey'] = '神曲,网页游戏，网页游戏，网络游戏，游戏平台，网页游戏平台，webgame，白领游戏，flash游戏，小游戏，策略游戏，战争游戏，最新网页游戏，免费网页游戏，休闲游戏，棋牌游戏，游戏论坛，RPG网页游戏';
        $_LEGEND_ONLINE['prodes'] = '网页游戏领先门户站';
        $_LEGEND_ONLINE['sq_gltitle'] = '神曲资料站_oasgames《神曲》官方网站';
        $_LEGEND_ONLINE['sq_glkey'] = '神曲,神曲官网,神曲新手卡,神曲礼包,神曲职业';
        $_LEGEND_ONLINE['sq_gldes'] = '神曲官网-神曲一款角色扮演类的网页游戏，神曲首页，提供神曲下载，神曲BOSS攻略，神曲新手卡，神曲礼包，神曲职业，神曲论坛等一系列的详细游戏介绍，休闲娱乐，从神曲开始。';
        $_LEGEND_ONLINE['game_info'] = '游戏资料库';
        $_LEGEND_ONLINE['footer_msg'] = '© 2012 OASIS GAMES LIMITED. Teklif Hakları OASIS GAMES LIMITED\'e Aittir.'; 
        $_LEGEND_ONLINE['footer_forum'] = 'Forum';
        $_LEGEND_ONLINE['footer_forumhref'] = 'http://lotr.oasgames.com/forum/';
        $_LEGEND_ONLINE['footer_giz'] = 'Gizlilik İlkeleri';
        $_LEGEND_ONLINE['footer_gizhref'] = '#';
        $_LEGEND_ONLINE['footer_hiz'] = 'Hizmet Koşulları';
        $_LEGEND_ONLINE['footer_hizhref'] = '#';
        $_LEGEND_ONLINE['footer_rap'] = 'Rapor Soruları';
        $_LEGEND_ONLINE['footer_raphref'] = 'mailto:trshenqu_support@oasgames.com';
        $_LEGEND_ONLINE['hot_newserver'] = '最火爆新服';
        $_LEGEND_ONLINE['game_intro'] = '游戏介绍';
        $_LEGEND_ONLINE['sq_radias'] = '神曲攻略';
        $_LEGEND_ONLINE['sq'] = '神曲';
        $_LEGEND_ONLINE['sq_describe'] = '是一款角色扮演类的网页游戏，游戏主要围绕城池发展、副本探索为主线而展开，作为城主的玩家通过发展城池、招募军队与魔族进行抗衡。在副本探索中玩家会经历各种不同的玩法，或追击、或逃亡、或逆袭等等，最后成为傲视一方的霸主。';
        $_LEGEND_ONLINE['sq_data'] = '神曲资料';
        $_LEGEND_ONLINE['more'] = '更多';
        $_LEGEND_ONLINE['Placement'] = '职业介绍';
        $_LEGEND_ONLINE['sq_login'] = '神曲登陆';
        $_LEGEND_ONLINE['login_time'] = '登陆时间';
        $_LEGEND_ONLINE['card'] = '激活码';
        $_LEGEND_ONLINE['news'] = '新闻';
        $_LEGEND_ONLINE['active'] = '活动';
        $_LEGEND_ONLINE['facebook'] = 'facebook';
        $_LEGEND_ONLINE['pay'] = '充值';
        $_LEGEND_ONLINE['location'] = '当前位置';
        $_LEGEND_ONLINE['homepage'] = '首页';
        $_LEGEND_ONLINE['lastpage'] = '末页';
        $_LEGEND_ONLINE['pre'] = '上一页';
        $_LEGEND_ONLINE['next'] = '下一页';
        $_LEGEND_ONLINE['navigation'] = '资料导航';
        $_LEGEND_ONLINE['intruction'] = '神曲入门';
        $_LEGEND_ONLINE['character'] = '神曲特色';
        $_LEGEND_ONLINE['sq_grow'] = '神曲成长';
        $_LEGEND_ONLINE['time'] = '时间';
        $_LEGEND_ONLINE['author'] = '作者';
        $_LEGEND_ONLINE['back'] = '返回';
        $_LEGEND_ONLINE['pre_posts'] = '上一篇';
        $_LEGEND_ONLINE['next_posts'] = '下一篇';
        $_LEGEND_ONLINE['pro_intro'] = '擅长物理攻击，霸气的连斩技，优秀的防御能力，副本中的坦克，团队的核心人物，适合任何阵型。';
        $_LEGEND_ONLINE['pro3_intro'] = '擅长物理攻击，炫目的特性技  卓越的暴击能力，远程狙击目标,强大的控局能力，削弱敌人目标。';
        $_LEGEND_ONLINE['pro5_intro'] = '擅长魔法伤害，华丽的魔法技，出色的范围输出能力，强大的DPS，超强的生存能力，出色的治疗能力。';
        $_LEGEND_ONLINE['pro_msg1'] = ' &middot; 肉盾系：能以各种防御技能来抵御强大的攻击，是团队中不可缺少的一员。<br />
                    &middot; 冲锋系：拥有华丽的连斩与强劲的旋风攻击，是战斗在最前线的无畏勇士。<br />
                    &middot; 推荐站位：前排位。';
        $_LEGEND_ONLINE['pro3_msg1'] = '&middot; 控制系：精通各种控制技能，以此削弱敌人的能力。<br />
                    &middot; 狙击系：擅长狙击技能，能发现敌人弱点，并进行远程狙杀。<br />
                    &middot; 推荐站位：中后排位。';
        $_LEGEND_ONLINE['pro5_msg1'] = '&middot; 治疗系：擅长各种治疗法术，总能在关键时候扭转战局。<br />
                    &middot; 冲锋系：毁灭系：以范围法术攻击来摧毁一切，是战场上最强力的DPS。<br />
                    &middot; 推荐站位：后排位。';
        $_LEGEND_ONLINE['Pro_charator'] = '职业特色';
        $_LEGEND_ONLINE['pro_flv'] = '职业技能展示视频';
        $_LEGEND_ONLINE['pro_equip'] = '装备展示';
        $_LEGEND_ONLINE['pro_mount'] = '坐骑展示';
        $_LEGEND_ONLINE['pro_equipes'] = 'EQUIPMENT DISPLAY';
        $_LEGEND_ONLINE['pro_mountes'] = 'RIDES EXHIBIT';
        $_LEGEND_ONLINE['kefu_email'] = '客服投诉邮箱';
        $_LEGEND_ONLINE['game_intro1'] = '游戏介绍';
        $_LEGEND_ONLINE['Scalable1'] = '可升级建筑';
        $_LEGEND_ONLINE['Reward1'] = '奖励系统';
        $_LEGEND_ONLINE['experience1'] = '提升经验';
        $_LEGEND_ONLINE['Privilege1'] = '特权系统';
        $_LEGEND_ONLINE['Fighting1'] = '战斗系统';
        $_LEGEND_ONLINE['Equipment1'] = '装备系统';
        $_LEGEND_ONLINE['Daily1'] = '简单日常';
        $_LEGEND_ONLINE['activities1'] = '每日活动';
        $_LEGEND_ONLINE['lastserver'] = '最近登陆的服:';
        $_LEGEND_ONLINE['sq_jd'] = '神曲加点';
        $_LEGEND_ONLINE['game_img'] = '截图游戏';
        $_LEGEND_ONLINE['Personagens'] = '字符';
        $_LEGEND_ONLINE['play'] = '开始游戏';
        $_LEGEND_ONLINE['goback'] = '返回官网';
        $_LEGEND_ONLINE['Soldier'] = '战士';
        $_LEGEND_ONLINE['Male_soldiers'] = '男战士';
        $_LEGEND_ONLINE['Woman_Warrior'] = '女战士';
        $_LEGEND_ONLINE['Archer'] = '射手';
        $_LEGEND_ONLINE['Male_shooter'] = '男射手';
        $_LEGEND_ONLINE['Female_shooter'] = '女射手';
        $_LEGEND_ONLINE['Master'] = '法师';
        $_LEGEND_ONLINE['Male_Master'] = '男法师';
        $_LEGEND_ONLINE['Female_mage'] = '女法师';
        $_LEGEND_ONLINE['server_list1'] = '服务器';
        $_LEGEND_ONLINE['server_list2'] = '玩';
        $_LEGEND_ONLINE['leer_more'] = '阅读更多';
        $_LEGEND_ONLINE['check_in_tishi'] = '此功能即将开启';
        //官网 end
        
        $_LANG['stop_server_bulletin'] = '你还没有玩过的游戏服';
        
         //2013-3-27新增 app
        $_LANG['server_is_not_start'] = '服务没有开启';
        $_LANG['app_like_on'] ='"Like" 我们的球迷每天收到的免费礼物!';
        $_LANG['introduce_act1'] = '该奖项的激活代码，您可以按照以下程序.';
        $_LANG['introduce_act2'] = '首先点击“事件”的游戏画面.';
        $_LANG['introduce_act3'] = '下面你将看到一个框，输入激活码.';
        $_LANG['introduce_act4'] = '结束时，输入激活代码，然后单击“更改”。然后通过电子邮件接收奖品.';
        
        //2013-3-27新增 官网
        $_LEGEND_ONLINE['common_swf_1'] = '数据游戏';
        $_LEGEND_ONLINE['common_swf_2'] = '收藏';
        $_LEGEND_ONLINE['common_swf_3'] = '已添加到您的收藏夹后，它会更容易访问的网站.';
        
        $_LEGEND_ONLINE['footer_1'] ='Türkçe';
        $_LEGEND_ONLINE['footer_2'] ='Português';
        
        $_LEGEND_ONLINE['loginReg_1'] = '通过官方网站登录'; 
        $_LEGEND_ONLINE['loginReg_2'] = 'E-mail'; 
        $_LEGEND_ONLINE['loginReg_3'] = '密码'; 
        $_LEGEND_ONLINE['loginReg_4'] = '保持连接'; 
        $_LEGEND_ONLINE['loginReg_5'] = '登录'; 
        $_LEGEND_ONLINE['loginReg_6'] = '注册'; 
        $_LEGEND_ONLINE['loginReg_7'] = '忘记密码'; 
        $_LEGEND_ONLINE['loginReg_8'] = '提供其他登录'; 
        $_LEGEND_ONLINE['loginReg_9'] = '与Facebook连接失败'; 
        $_LEGEND_ONLINE['loginReg_10'] = '通过Facebook登录'; 
        $_LEGEND_ONLINE['loginReg_11'] = '无法连接到与谷歌'; 
        $_LEGEND_ONLINE['loginReg_12'] = '通过谷歌登录'; 
        
        $_LEGEND_ONLINE['loginReg_13'] = '输入密码'; 
        $_LEGEND_ONLINE['loginReg_14'] = '再次输入密码'; 
        $_LEGEND_ONLINE['loginReg_15'] = '我同意服务条款'; 
        
        $_LEGEND_ONLINE['gamelist_1']  = '信息 Legend Online';
        $_LEGEND_ONLINE['gamelist_2']  = '游戏的介绍';
        $_LEGEND_ONLINE['gamelist_3']  = '游戏特色';
        $_LEGEND_ONLINE['gamelist_4']  = '游戏史诗';
        $_LEGEND_ONLINE['gamelist_5']  = '游戏设置';
        $_LEGEND_ONLINE['gamelist_6']  = '字符';
        $_LEGEND_ONLINE['gamelist_7']  = '战士（男）';
        $_LEGEND_ONLINE['gamelist_8']  = '战士（女）';
        $_LEGEND_ONLINE['gamelist_9']  = '弓手（男）';
        $_LEGEND_ONLINE['gamelist_10']  = '弓手（女）';
        $_LEGEND_ONLINE['gamelist_11']  = '法师（男）';
        $_LEGEND_ONLINE['gamelist_12']  = '法师（女）';
        
        //oasplay 下面要求附上相应的链接
        $_LEGEND_OASPLAY['menu_1']['name'] = '续';
        $_LEGEND_OASPLAY['menu_1']['url'] = 'http://lobr.oasgames.com/fbapp/pay/oaspay.php';
        $_LEGEND_OASPLAY['menu_2']['name'] = 'VIP';
        $_LEGEND_OASPLAY['menu_2']['url'] = 'https://www.facebook.com/Legend.Online.pt/app_334252196664364';
        $_LEGEND_OASPLAY['menu_3']['name'] = '奖';
        $_LEGEND_OASPLAY['menu_3']['url'] = 'http://lobr.oasgames.com/fbapp/?act=activecode&method=getActiveCode';
        $_LEGEND_OASPLAY['menu_4']['name'] = '服务器';
        $_LEGEND_OASPLAY['menu_4']['url'] = 'http://lobr.oasgames.com/legend_online/?a=sq&m=serverlist';
        $_LEGEND_OASPLAY['menu_5']['name'] = '游戏指南';
        $_LEGEND_OASPLAY['menu_5']['url'] = 'https://www.facebook.com/Legend.Online.pt/app_266126513499665';
        $_LEGEND_OASPLAY['menu_6']['name'] = '活动';
        $_LEGEND_OASPLAY['menu_6']['url'] = 'http://lobr.oasgames.com/forum/viewtopic.php?f=4&t=691&p=1065#p1065';
        $_LEGEND_OASPLAY['menu_7']['name'] = '社区';
        $_LEGEND_OASPLAY['menu_7']['url'] = 'http://lobr.oasgames.com/forum/viewtopic.php?f=1&t=815';
        $_LEGEND_OASPLAY['menu_8']['name'] = 'Legend Online';
        $_LEGEND_OASPLAY['menu_8']['url'] = 'http://lobr.oasgames.com/legend_online/';
        $_LEGEND_OASPLAY['menu_9']['name'] = '介绍';
        $_LEGEND_OASPLAY['menu_9']['url'] = 'http://lobr.oasgames.com/legend_online/?a=sq&m=gamelist#c';
        $_LEGEND_OASPLAY['menu_10']['name'] = '字符';
        $_LEGEND_OASPLAY['menu_10']['url'] = 'http://lobr.oasgames.com/legend_online/?a=sq&m=gamelist#c2';
        $_LEGEND_OASPLAY['menu_11']['name'] = '先进';
        $_LEGEND_OASPLAY['menu_11']['url'] = 'http://lobr.oasgames.com/legend_online/?a=sq&m=gamelist#c3';
        $_LEGEND_OASPLAY['menu_12']['name'] = '集';
        $_LEGEND_OASPLAY['menu_12']['url'] = 'http://lobr.oasgames.com/legend_online/?a=sq&m=gamelist#c4';
        $_LEGEND_OASPLAY['menu_13']['name'] = '军械';
        $_LEGEND_OASPLAY['menu_13']['url'] = 'http://lobr.oasgames.com/legend_online/?a=sq&m=lists&id=3';
        $_LEGEND_OASPLAY['menu_14']['name'] = '粉丝';
        $_LEGEND_OASPLAY['menu_14']['url'] = 'http://www.facebook.com/Legend.Online.pt?v=1';
        $_LEGEND_OASPLAY['menu_15']['name'] = '组';
        $_LEGEND_OASPLAY['menu_15']['url'] = 'https://www.facebook.com/groups/423951964317432/';
        $_LEGEND_OASPLAY['menu_16']['name'] = '论坛';
        $_LEGEND_OASPLAY['menu_16']['url']  = 'http://forum.lobr.oasgames.com/';
        $_LEGEND_OASPLAY['menu_17']['name'] = '赢钻石';
        $_LEGEND_OASPLAY['menu_17']['url'] = 'http://lobr.oasgames.com/fbapp/pay/sponsorpay/duijie.php?uname=oasuser&uemail=zhoushenping%40126.com';
        $_LEGEND_OASPLAY['menu_18']['name'] = '开盘';
        $_LEGEND_OASPLAY['menu_18']['url'] = 'http://lobr.oasgames.com/legend_online/event/OpenServer/index.php';
        $_LEGEND_OASPLAY['menu_19']['name'] = '享受圣诞';
        $_LEGEND_OASPLAY['menu_19']['url'] = 'http://lobr.oasgames.com/legend_online/event/Natal/';
        $_LEGEND_OASPLAY['menu_20']['name'] = '所有活动';
        $_LEGEND_OASPLAY['menu_20']['url'] = 'http://forum.lobr.oasgames.com/viewtopic.php?f=1&t=3339';
        
        
        //2013-4-10新增客户端
        $_LEGEND_CLIENT['title']      = 'Legend Online(我们游戏的西语名就是这个)';
        $_LEGEND_CLIENT['gonggao']    = '消息和活动';
        $_LEGEND_CLIENT['registrar']  = '注册';
        $_LEGEND_CLIENT['zhuce']      = '我忘记了密码';
        $_LEGEND_CLIENT['fail_f']     = "'失败':'连接到FB时候出错误'";
        $_LEGEND_CLIENT['fail_g']     = "'失败':'连接到谷歌时候出错误'";
        $_LEGEND_CLIENT['wenzi1']     = '密码不正确';
        $_LEGEND_CLIENT['wenzi2']     = '我们的服务器正好维护, 请稍等';
        $_LEGEND_CLIENT['huanyin']    = '欢迎';
        $_LEGEND_CLIENT['out']        = '离开';
        $_LEGEND_CLIENT['l_g']        = 'Legend Online';
        $_LEGEND_CLIENT['server']     = '服务器';
        $_LEGEND_CLIENT['tiaokuan1']  = '我同意服务条款';
        $_LEGEND_CLIENT['youxian']    = 'eslegend_support@oasgame.com';
        $_LEGEND_CLIENT['tiaokuan']   = '经过我们的调查，我们发现，收到钻石后，出现调换或者退款的步骤，为此，我们阻止了您的账号。如果您想做些生命，请通过以下邮箱，联系我们：eslegend_support@oasgame.com。很高想您能参与我们游戏！' ;       
        $_LEGEND_CLIENT['wenzi3']     = '提供 Sponsorpay:';
        $_LEGEND_CLIENT['wenzi4']     = '注册';
        $_LEGEND_CLIENT['wenzi5']     = '玩游戏';
        $_LEGEND_CLIENT['wenzi6']     = '达到第 10级';
        $_LEGEND_CLIENT['wenzi7']     = '完成任务';
        $_LEGEND_CLIENT['wenzi8']     = '您目前的级别是 {0}, ¡好运气!';
        $_LEGEND_CLIENT['wenzi9']     = '用户端名字不能包含空格';
        $_LEGEND_CLIENT['wenzi10']    = '邮件格式不正确';
        $_LEGEND_CLIENT['wenzi11']    = '现有账户';
        $_LEGEND_CLIENT['wenzi12']    = '密码应该包含6-15个字符';
        $_LEGEND_CLIENT['wenzi13']    = '密码不匹配';
        $_LEGEND_CLIENT['wenzi14']    = '信息不正确，请重新填写';
        $_LEGEND_CLIENT['wenzi15']    = '密码不正确, 登陆有误';
        $_LEGEND_CLIENT['wenzi16']    = '用户格式不正确，重新填写邮件格式';
        $_LEGEND_CLIENT['wenzi17']    = '消息和活动';
        $_LEGEND_CLIENT['wenzi18']    = '用户名位置不能空着';

        
        
        //4-15官网服务器列表新增
        //所有服：Todo
        //南美区：América del Sur 
        //北美区：América del Norte
        //欧洲区：Europa
        //下一页：Siguiente
        $_LEGEND_OASPLAY['menu_21']['name']='所有服';
        $_LEGEND_OASPLAY['menu_22']['name']='南美区';
        $_LEGEND_OASPLAY['menu_23']['name']='北美区';
        $_LEGEND_OASPLAY['menu_24']['name']='欧洲区';   
        $_LEGEND_OASPLAY['menu_25']['name']='上一页';
        $_LEGEND_OASPLAY['menu_26']['name']='下一页';
        
        
        
        //4-19,404yemian
        $_LANG['name401_1']='对不起！';
        $_LANG['name401_2']='您正试着打开的页面不存在';
        $_LANG['name401_3']='回到起始页面';
        $_LANG['name401_4']='去论坛';
        
        $_LANG['activecode_1'] = '粉丝';
        $_LANG['activecode_2'] = '注册';
        $_LANG['activecode_3'] = '最爱';
        $_LANG['activecode_4'] = '喜欢';
        $_LANG['activecode_5'] = '订阅';
        $_LANG['activecode_6'] = '领取礼物';
        
         //5-7 新版app
        $_LANG['tab_quanbu'] = "Todo";
        $_LANG['tab_bei'] = "México";
        $_LANG['tab_nan'] = "Sudamérica";
        $_LANG['tab_ou'] = "España";
        $_LANG['app_kong_ti'] = "Introduzca digital del servidor";
        $_LANG['app_friend_list']="Lista de Amigos";
        
        //5-8 新版app
        $_LANG['app_server_time']="Hora de servidor";
        $_LANG['app_country_xi']="Español";
        
        //5-10 新版app
        $_LANG['app_friend']="Elige a tus amigos, por favor";
        
            //5-13
        $_LANG['fast_play'] = "输入服务器编号，直达游戏";
        
          //5-15礼包提示文字
        $_LANG['gift_1'] ="El Jugador de Nivel 25, que haya invitado a 5 Amigos, y que estos hayan entrado a jugar y alcanzado el Nivel 15, podrán obtener la Recompensa de: 100 000 Oro, 100 000 Espíritu.";
        $_LANG['gift_2'] ="El Jugador de Nivel 30, que haya invitado a 10 Amigos, y que estos hayan entrado a jugar y alcanzado el Nivel 15, podrán obtener la Recompensa de: 200 000 Oro, 200 000 Espíritu, 50 Cianitas Espirituales.";
        $_LANG['gift_3'] ="El Jugador de Nivel 35, que haya invitado a 20 Amigos, y que estos hayan entrado a jugar y alcanzado el Nivel 15, podrán obtener la Recompensa de: 300 000 Oro, 300 000 Espíritu, 100 Cianitas Espirituales.";
        $_LANG['gift_4'] ="El Jugador de Nivel 40, que haya invitado a 40 Amigos, y que estos hayan entrado a jugar y alcanzado el Nivel 15, podrán obtener la Recompensa de: 500 000 Oro, 500 000 Espíritu, 200 Cianitas Espirituales.";
        $_LANG['gift_5'] ="Paso1: Nivel≧ 25, invitar a 5 amigos";
        $_LANG['gift_6'] ="Se o jogador atingir nível 25, convidar sucessivamente 5 amigos a participarem no jogo e se os Amigos que foram convidados atingirem nível 15. Poderá ganhar: 100000 Moedas de Ouro, 100000 Espíritos!";
        $_LANG['gift_7'] ="Paso2: Nivel≧ 30, invitar a 10 amigos";
        $_LANG['gift_8'] ="Se o jogador atingir nível 25, convidar sucessivamente 5 amigos a participarem no jogo e se os Amigos que foram convidados atingirem nível 15. Poderá ganhar: 100000 Moedas de Ouro, 100000 Espíritos!";
        $_LANG['gift_9'] ="Paso3: Nivel≧ 35, invitar a 20 amigos";
        $_LANG['gift_10'] ="Se o jogador atingir nível 25, convidar sucessivamente 5 amigos a participarem no jogo e se os Amigos que foram convidados atingirem nível 15. Poderá ganhar: 100000 Moedas de Ouro, 100000 Espíritos!";
        $_LANG['gift_11'] ="Paso4: Nivel≧ 40, invitar a 40 amigos";
        $_LANG['gift_12'] ="Se o jogador atingir nível 25, convidar sucessivamente 5 amigos a participarem no jogo e se os Amigos que foram convidados atingirem nível 15. Poderá ganhar: 100000 Moedas de Ouro, 100000 Espíritos!";
        $_LANG['gift_13'] ="Recibir";
        $_LANG['gift_14'] ="NO.de Invitados:";
        $_LANG['gift_15'] ="Tu Nivel:";
        
        
        //5月16日新增
        $_LANG['book_mark_message'] = "Agregar a favoritos";
?>