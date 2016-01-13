<?php

namespace App\Logic;


class Utils
{
    /**
     * 生成一个GUID，方法来自于网络
     * http://blog.sina.com.cn/s/blog_61dfab6b0100ucj5.html
     * @return string
     */
    public static function newGuid()
    {
        mt_srand((double)microtime() * 10000);//optional for php 4.2.0 and up.
        $charid = strtoupper(md5(uniqid(rand(), true)));
        $hyphen = chr(45);// "-"
        $uuid = substr($charid, 0, 8) . $hyphen
            . substr($charid, 8, 4) . $hyphen
            . substr($charid, 12, 4) . $hyphen
            . substr($charid, 16, 4) . $hyphen
            . substr($charid, 20, 12);
        return $uuid;
    }

    public static function getResFormats()
    {
        $formats = [];
        $formats[] = ['id' => 'ip4', 'name' => 'iPhone 4,iPhone 5,iPhone 6,'];
        //$formats[] = ['id' => 'ip5', 'name' => 'iPhone 5'];
        //$formats[] = ['id' => 'ip6', 'name' => 'iPhone 6'];
        $formats[] = ['id' => 'ip6p', 'name' => 'iPhone 6 Plus'];
        return $formats;
    }

    public static function getLaunchImgPath($type)
    {
        $img = 'images/';
        switch ($type) {
            case 0:
                $img .= 'launch_screen';
                break;
            case 1:
                $img .= 'launch_ad';
                break;
            case 2:
                $img .= 'guide';
                break;
        }
        return $img . '_' . time();
    }

    public static function getPropCustImgPath($subCatId)
    {
        $img = 'images/';
        switch ($subCatId) {
            case 1:
            case 2:
            case 3:
            case 4:
            case 5:
            case 6:
            case 7:
            case 8:
            case 9:
            case 10:
            case 11:
            case 15:
                $img .= 'edu/yiju';
                break;
            case 12:
                $img .= 'landscape/Disney';
                break;
            case 13:
                $img.='landscape/SiliconValley';
                break;
            case 14:
                $img.='landscape/Hollywood';
                break;
            case 16:
                $img.='landscape/Caltech';
                break;
            case 17:
                $img.='landscape/Stanford';
                break;
        }
        return $img . '_' . time();
    }
}