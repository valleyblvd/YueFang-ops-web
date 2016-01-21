<?php

namespace App\Tools;

use GuzzleHttp;

class HttpUtil
{
    private static $guzzleClient;

    public static function getGuzzleClient()
    {
        if(!HttpUtil::$guzzleClient)
            HttpUtil::$guzzleClient=new GuzzleHttp\Client();
        return HttpUtil::$guzzleClient;
    }
}