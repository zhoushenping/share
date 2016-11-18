<?

class Points
{
    static function getPoints($uid)
    {
        if ($uid == 0) {
            return 0;
        }

        return rand(100, 999);//todo
    }
}
