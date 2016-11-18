<?

class ChristmasWishBonusConfig
{
    const table = 'christmas_bonus_config';

    static function getConfig()
    {
        $ret = array();
        foreach (DBHandle::select(self::table) as $item) {
            $ret[$item['type']] = $item;
        }

        return $ret;
    }
}
