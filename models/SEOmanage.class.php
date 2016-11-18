<?php

class SEOmanage
{
    const table                = 'seo_manage';
    const PAY_SEO_API_SECU_KEY = '308bc6c3f1b3c1855afb01422ef5fe5f';
    const PAY_SEO_API          = "http://pay.oasgames.com/payment/api/getSEOApi.php";

    static function treatSubmit()
    {
        //线上模式才将pay seo设置同步到支付平台
        if (!DEVELOP_MODE) {
            self::syncPaySEO();
        }
        global $_config_seo_manage;

        $arr_column = array(
            'seo_title',
            'seo_keyword',
            'seo_description'
        );

        /*将数据写入本地数据表*/
        foreach ($_config_seo_manage as $typeID => $none) {
            $arr_temp = array();
            foreach ($arr_column as $column_name) {
                $arr_temp[$column_name] = trim($_REQUEST[$column_name . '_' . $typeID]);
            }

            $action = (self::queryOne($typeID) == array()) ? 'insert' : 'update';

            if ($action == 'insert') {
                self::insert($typeID, $arr_temp);
            }
            if ($action == 'update') {
                self::update($typeID, $arr_temp);
            }
        }
    }

    private static function insert($typeID, $arr_temp)
    {
        $arr_temp['seo_type']    = $typeID;
        $arr_temp['update_time'] = time();

        DBHandle::MyInsert(self::table, Mysql::makeInsertString($arr_temp));
    }

    private static function update($typeID, $arr_temp)
    {
        $old_record = self::queryOne($typeID);
        $update     = myArray::trimSameItem($arr_temp, $old_record);//不更新相同的值

        if (!empty($update)) {
            $update['update_time'] = time();
            DBHandle::update(self::table, Mysql::makeInsertString($update), "`seo_type`=$typeID");
        }
    }

    static function queryOne($typeID)
    {
        $ret = array();

        foreach (self::queryALL() as $item) {
            if ($typeID == $item['seo_type']) {
                $ret = $item;
            }
        }

        foreach ($ret as $k => $v) {
            $ret[$v] = stripslashes($v);
        }

        return $ret;
    }

    static function queryALL($refresh = false)
    {
        static $ret = -1;
        if ($refresh || $ret == -1) {
            $ret = DBHandle::select(self::table);
        }

        return $ret;
    }

    static function getValue($typeID, $column_name, $default = '')
    {
        $rs  = self::queryOne($typeID);
        $ret = !empty($rs[$column_name]) ? $rs[$column_name] : $default;

        //return substr($ret, 0, 200);
        return $ret;
    }

//////下面的方法都是pay seo相关的
    private static function syncPaySEO()
    {
        $oldValue = self::getPaySEO();
        $action   = ($oldValue == array()) ? 'add' : 'update';
        $url      = self::PAY_SEO_API . "?msg=$action";

        $new_title    = trim($_REQUEST['seo_title_11']);
        $new_keywords = trim($_REQUEST['seo_keyword_11']);
        $new_desc     = trim($_REQUEST['seo_description_11']);

        //如果将执行更新操作，但是值都相等，则不执行更新
        if ($action == 'update') {
            if (
                $oldValue['seo_title'] == $new_title
                && $oldValue['seo_keywords'] == $new_keywords
                && $oldValue['seo_description'] == $new_desc
            ) {
                return false;
            }
        }

        $access_time = time();
        $reqData     = array(
            'game_code'       => GAME_CODE_STANDARD,
            'access_time'     => $access_time,
            'token'           => md5(md5(GAME_CODE_STANDARD . $access_time) . self::PAY_SEO_API_SECU_KEY),
            'seo_title'       => $new_title,
            'seo_keywords'    => $new_keywords,
            'seo_description' => $new_desc,
            'seo_content'     => '',
        );

        return CURL::getJson($url, $reqData);
    }

    private static function getPaySEO()
    {
        $access_time = time();
        $reqData     = array(
            'game_code'   => GAME_CODE_STANDARD,
            'access_time' => $access_time,
            'token'       => md5(md5(GAME_CODE_STANDARD . $access_time) . self::PAY_SEO_API_SECU_KEY)
        );
        $rs          = CURL::getJson(self::PAY_SEO_API . "?msg=search", $reqData);

        return $rs['val'];
    }
}
