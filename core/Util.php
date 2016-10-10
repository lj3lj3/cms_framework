<?php

/**
 * Created by PhpStorm.
 * User: Daylemon
 * Date: 2016/10/10
 * Time: 16:58
 */
class Util
{
    const DATE_FORMATTED = 'Y-m-d H:i:s';

    public static function getFormattedDateForDB()
    {
        return date(Util::DATE_FORMATTED);
    }
}