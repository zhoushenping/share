<?

class ChristmasWishConfig
{
    static $config = array();

    static function init($arr)
    {
        foreach ($arr as $k => $v) {

            self::$config[$k] = $v;
        }
    }

    static function inWishTime($time)
    {
        if (self::inEventTime($time) == false) {
            return false;
        }

        $d  = date('Y-m-d', $time);
        $t0 = strtotime("$d " . self::$config['wishTimeBegin']);
        $t1 = strtotime("$d " . self::$config['wishTimeEnd']);

        return ($time >= $t0 && $time <= $t1);
    }

    static function inEventTime($time)
    {
        return ($time >= Time::getDateFirstSecond(self::$config['eventBegin'])
                && $time <= Time::getDateLastSecond(self::$config['eventEnd'])
        );
    }
}
