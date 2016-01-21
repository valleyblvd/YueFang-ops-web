<?php
namespace App\Tools;


class StringUtil
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


    /**
     * 判断某个字符串中是否包含指定的字符串，区分大小写
     * @param $source
     * @param $spec
     * @return bool
     */
    public static function contains($source, $spec)
    {
        return strpos($source, $spec) !== false;
    }

    /**
     * 判断某个字符串中是否包含指定的字符串，不区分大小写
     * @param $source
     * @param $spec
     * @return bool
     */
    public static function containsIgnoreCase($source, $spec)
    {
        return stripos($source, $spec) !== false;
    }
}