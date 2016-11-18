<?

class ThreeYearCalendar
{
    //按月生成日历  月初月末会自动加上empty的date
    public static function makeCalendar($uid)
    {
        static $ret = array();
        if ($ret != array()) {
            return $ret;
        }

        $signDates = ThreeYearSign::getSignedDate($uid);

        $minCalendarTime = ThreeYearSignConfig::getMinSignTime();
        $maxCalendarTime = ThreeYearSignConfig::getMaxSignTime();

        foreach (Time::makeCalendar($minCalendarTime, min(time(), $maxCalendarTime)) as $month => $dates) {
            $ret[$month] = self::makeEmptyDatesBefore($dates);//加上月初前可能的空白

            foreach ($dates as $d) {
                $ret[$month][] = array('date' => $d, 'class' => self::makeClass($d, $signDates));
            }

            $ret[$month] = array_merge($ret[$month], self::makeEmptyDatesAfter($dates));//加上月末后可能的空白

            //如果原来生成的日历不足42天  则补上所缺的  不同场合下不一定有这个需求
            $count = count($ret[$month]);
            if ($count < 42) {
                $ret[$month] = array_merge($ret[$month], self::getEmptyDate(42 - $count));
            }
        }

        return $ret;
    }

    public static function makeEmptyDatesBefore($dates)
    {
        $w_d0 = date('w', strtotime($dates[0]));//该月第一天是周几
        $c    = $w_d0 - ThreeYearSignConfig::getWeekBegin();
        if ($c < 0) {
            $c += 7;
        }
        $ret = self::getEmptyDate($c);

        return $ret;
    }

    public static function makeEmptyDatesAfter($dates)
    {
        $w_d0 = date('w', strtotime($dates[count($dates) - 1]));//该月最后一天是周几
        $c    = 6 - ($w_d0 - ThreeYearSignConfig::getWeekBegin());
        if ($c == 7) {
            $c = 0;
        }

        $ret = self::getEmptyDate($c);

        return $ret;
    }

    private static function getEmptyDate($n)
    {
        $ret = array();
        for ($i = 1; $i <= $n; $i++) {
            $ret[] = array(
                'date'  => '',
                'class' => 'empty',
            );
        }

        return $ret;
    }

    private static function makeClass($d, $signDates)
    {
        $month       = substr($d, 0, 7);
        $time0_today = Time::getDateFirstSecond(date('Y-m-d'));

        $time0_d = strtotime($d);

        if (in_array($d, $signDates[$month])) {
            return ($d == date('Y-m-d')) ? 'today_signed' : 'passed_signed';
        }

        if ($time0_d > ThreeYearSignConfig::getMaxSignTime()) {
            return 'later';//日历中  在活动过期后的日期  都显示为 未来
        }

        if ($time0_d < ThreeYearSignConfig::getMinSignTime()) {
            return 'passed_unsigned';//日历中  在活动开始前的日期  都显示为 过去未签到
        }

        //过去 今天 未来
        if ($time0_d < $time0_today) {
            return 'passed_unsigned';
        }
        if ($d == date('Y-m-d')) {
            return 'today_unsigned';
        }
        if ($time0_d > $time0_today) {
            return 'later';
        }

        return 'later';
    }

    public static function makeWeekHead()
    {
        global $lang_week;//星期几的翻译  需要从周一到周日
        $lang = isset($lang_week[SYSTEM_LANG]) ? $lang_week[SYSTEM_LANG] : $lang_week['en'];
        $ret  = array();

        $begin_output = false;
        $end_output   = false;
        foreach ($lang as $k => $v) {
            if ($k == ThreeYearSignConfig::getWeekBegin()) {
                $begin_output = true;
            }

            if ($begin_output) {
                $ret[] = $v;
            }
        }

        foreach ($lang as $k => $v) {
            if ($k == ThreeYearSignConfig::getWeekBegin()) {
                $end_output = true;
            }

            if ($end_output == false) {
                $ret[] = $v;
            }
        }

        return $ret;
    }
}
