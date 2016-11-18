<?

class Simulate
{
    static function getLoginRs($ZHUISUMA_or_uid)
    {
        $dir      = LOG_DIR;
        $ZHUISUMA = '';
        $uid      = '';
        $arr_date = array();
        if (strpos($ZHUISUMA_or_uid, '_') != false) {
            //1474280518_453
            $ZHUISUMA   = $ZHUISUMA_or_uid;
            $temp       = explode('_', $ZHUISUMA);
            $time_end   = $temp[0];
            $date_count = 2;
            $keyWords   = $ZHUISUMA_or_uid;
        }
        else {
            //123456
            $keyWords   = $ZHUISUMA_or_uid;
            $time_end   = time();
            $date_count = 10;
        }

        for ($i = 0; $i <= $date_count; $i++) {
            $arr_date[] = date('Ymd', $time_end - $i * 86400);//可以搜索10天以内的登录信息
        }

        foreach ($arr_date as $date) {
            $contents = file("$dir/curl2_{$date}.log");
            foreach ($contents as $line) {
                if (strpos($line, 'getLoginUser') == false) {
                    continue;
                }

                if (strpos($line, 'ok') == false) {
                    continue;
                }

                if (strpos($line, $keyWords) != false) {
                    $str_json = substr($line, strpos($line, '{'));

                    return json_decode($str_json, 1);
                }
            }
        }

        return array();
    }
}
