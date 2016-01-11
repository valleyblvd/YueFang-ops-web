<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/1/11
 * Time: 21:38
 */

namespace App\Logic;


class ResUtils
{
    public static function getFormats()
    {
        $formats = [];
        $formats[] = ['id' => 'ip4', 'name' => 'iPhone 4'];
        $formats[] = ['id' => 'ip5', 'name' => 'iPhone 5'];
        $formats[] = ['id' => 'ip6', 'name' => 'iPhone 6'];
        $formats[] = ['id' => 'ip6p', 'name' => 'iPhone 6 Plus'];
        return $formats;
    }

    public static function getLaunchImgPath($type){
        switch($type){
            case 0:
                return 'images/launch_screen_'.time();
            case 1:
                return 'images/launch_ad_'.time();
            case 2:
                return 'images/guide_'.time();
            default:
                return null;
        }
    }
}