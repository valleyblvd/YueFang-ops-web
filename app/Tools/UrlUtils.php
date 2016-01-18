<?php

namespace App\Tools;


class UrlUtils
{
    /**
     * 获取指定url的一级域名
     * @param $url
     * @return string
     */
    public static function getMainDomain($url)
    {
        $host = parse_url($url, PHP_URL_HOST);
        $host = explode('.', $host);
        $host = array_reverse($host);
        return "$host[1].$host[0]";
    }
}