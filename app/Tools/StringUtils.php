<?php

namespace App\Tools;


class StringUtils
{
    /**
     * 比较字符串，区分大小写
     * @param $str1
     * @param $str2
     * @return bool
     */
    public static function equals($str1, $str2)
    {
        return strcmp($str1, $str2) == 0;
    }

    /**
     * 比较字符串，不区分大小写
     * @param $str1
     * @param $str2
     * @return bool
     */
    public static function equalsIgnoreCase($str1, $str2)
    {
        return strcasecmp($str1, $str2) == 0;
    }
}