<?

class RecommendServer
{
    //获取推荐服
    static function getOneAreaRecommendServer($area_r)
    {
        $serverlist = ServerNew::getVisibleServer();

        $temp = array();
        foreach ($serverlist as $server)
        {
            if ($area_r != 0 and $server['area'] != $area_r) continue;

            $sid    = $server['server_sid'];
            $weight = self::getWeight($sid);

            if (self::isRecommend($sid))
            {
                $temp[$sid] = $weight;
            }
        }

        return myArray::getRandByWeight($temp);
    }

    //获取区域内的推荐服列表
    static function getAreaRecommendServers($area_r = 0)
    {
        if ($area_r == 0) $area_r = 'all';
        static $serverlist = array();
        if (empty($serverlist)) $serverlist = ServerNew::getVisibleServer();

        $recommand_servers = array();
        foreach ($serverlist as $server)
        {
            $sid  = $server['server_sid'];
            $area = $server['area'];
            if (self::isRecommend($sid))
            {
                $recommand_servers['all'][] = ServerNew::getServerInfo($sid);
                $recommand_servers[$area][] = ServerNew::getServerInfo($sid);
            }
        }

        return $recommand_servers[$area_r];
    }

    static function isRecommend($sid)
    {
        $serverInfo = ServerNew::getServerInfo($sid);
        $recommand  = (defined('PLATFORM') and PLATFORM == 'app') ? $serverInfo['recommand'] : $serverInfo['recommand_oas'];

        return ($recommand == 1);
    }

    static function getWeight($sid)
    {
        $serverInfo = ServerNew::getServerInfo($sid);
        $weight     = (defined('PLATFORM') and PLATFORM == 'app') ? $serverInfo['weight_fbapp'] : $serverInfo['weight_oas'];

        return $weight;
    }

    static function getDefaultSid($area_r = 0)
    {
        $ret = self::getOneAreaRecommendServer($area_r);
        if (empty($ret)) $ret = ServerNew::getMaxAreaSid($area_r);

        return $ret;
    }

    static function getDefaultSidForOldUser($uid)
    {
        $last_sid   = PlayGameRecord::getLastSid($uid);
        $area_r     = Promote::getAreaFromPromote();
        $area_last  = ServerNew::getSidArea($last_sid);
        $area_toUse = ($area_r != 0) ? $area_r : $area_last;

        return self::getDefaultSid($area_toUse);
    }
}

?>