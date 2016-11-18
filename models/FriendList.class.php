<?php

/**
 * Created by PhpStorm.
 * User: shenping zhou
 * Date: 2015/10/30
 * Time: 20:32
 */
class FriendList
{
    static function makeSixFriendPic($facebook_uid, $count = 7)
    {
        $friend_num = 0;

        $fb_res = myFacebook::getFriendsInfo($facebook_uid);

        $myMaxGrade  = PlayGameLog::getMaxGrade(UserMap::getPlayGameUid($facebook_uid));
        $friend_info = array();//好友信息
        $fr_uids     = array();//好友的facebook id
        $showed_uids = array();//已经显示的好友个数
        $arr_log     = array();//将好友的最大等级记录到日志
        foreach ($fb_res['data'] as $item)
        {
            $f_uid               = $item['id'];
            $friend_info[$f_uid] = $item;
            $fr_uids[]           = $f_uid;
        }

        $mapped_uids         = UserMap::getMappedPlayUids($fr_uids);
        $mapped_uids_flipped = array_flip($mapped_uids);

        $rs = PlayGameLog::getPlayRecordForMultiUser($mapped_uids, 2);

        foreach ($rs as $item)
        {
            if (in_array($item['uid'], $showed_uids)) continue;
            $friend_num++;
            self::makeFriendLi($friend_info, $mapped_uids_flipped[$item['uid']], $item['server_sid'], $item['grade']);
            $showed_uids[]         = $item['uid'];
            $arr_log[$item['uid']] = $item['grade'];
        }
        Log2::save_run_log("{$facebook_uid}_{$myMaxGrade}|" . json_encode($arr_log), 'app_friend_grades');//注意 早起有一段时间没有记录本人的最大等级

        if ($friend_num < $count)
        {
            for ($i = 0; $i < ($count - $friend_num); $i++) self::makeEmptyLi();
        }
    }

    //下面的2个私有方法中涉及的html不一定每个游戏都相同
    private static function makeFriendLi($friend_info, $f_uid, $sid, $lv)
    {
        $f_img = "https://graph.facebook.com/v2.2/$f_uid/picture?type=square";

        $f_name      = $friend_info[$f_uid]['name'];
        $f_name_show = utf_substr($f_name, 8);

        echo "<li>
                <em>S:{$sid}</em>
                <strong>Lv:{$lv}</strong>
                <img title='$f_name' src='$f_img' border='0' width='55' height='55'/>
                <p>$f_name_show</p>
              </li>";
    }

    private static function makeEmptyLi()
    {
        echo "<li class='last'><a href='#'>Name</a></li>";
    }
}