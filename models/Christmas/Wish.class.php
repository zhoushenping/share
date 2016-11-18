<?

class ChristmasWish
{
    const useMem = false;

    static function verifyMsg($wishMsg)
    {
        //匹配特征关键字 方便测试
        if (strpos($wishMsg, 'shortmsg') !== false || strpos($wishMsg, 'longmsg') !== false) {
            return false;
        }

        $length = mb_strlen($wishMsg);

        return ($length >= 20 && $length < 200);
    }
}
