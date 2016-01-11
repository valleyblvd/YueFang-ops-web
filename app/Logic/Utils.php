<?php

namespace App\Logic;


class Utils
{
    /**
     * 生成一个GUID，方法来自于网络
     * http://blog.sina.com.cn/s/blog_61dfab6b0100ucj5.html
     * @return string
     */
    public static function newGuid(){
        mt_srand((double)microtime()*10000);//optional for php 4.2.0 and up.
        $charid = strtoupper(md5(uniqid(rand(), true)));
        $hyphen = chr(45);// "-"
        $uuid =substr($charid, 0, 8).$hyphen
            .substr($charid, 8, 4).$hyphen
            .substr($charid,12, 4).$hyphen
            .substr($charid,16, 4).$hyphen
            .substr($charid,20,12);
        return $uuid;
    }
}