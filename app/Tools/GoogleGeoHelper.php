<?php

namespace App\Tools;


class GoogleGeoHelper
{
    public static function getAddress($results)
    {
        if (!$results)
            return null;

        foreach ($results as $result) {
            if (in_array('street_address', $result->types) || in_array('route', $result->types)) {//找到存放街道地址的节点
                return GoogleGeoHelper::parseResult($result);
            }
        }
        return null;
    }

    private static function parseResult($result)
    {
        $address = new \stdClass();
        if ($result->address_components) {
            foreach ($result->address_components as $comp) {
                $types = $comp->types;
                $name = $comp->long_name;
                if (in_array('country', $types)) {//国家 country
                    $address->country = $name;
                } else if (in_array('administrative_area_level_1', $types)) {//州 state,使用缩写
                    $address->state = $comp->short_name;
                } else if (in_array('administrative_area_level_2', $types)) {//县 county
                    $address->county = $name;
                } else if (in_array('locality', $types)) {//城市 city
                    $address->city = $name;
                } else if (in_array('route', $types)) {//街道 street
                    $address->street = $name;
                } else if (in_array('street_number', $types)) {//门牌号 streetNumber
                    $address->streetNumber = $name;
                } else if (in_array('postal_code', $types)) {//邮编
                    $address->postalCode = $name;
                }
            }
        }
        if ($result->geometry && $result->geometry->location) {//坐标
            $address->lat = $result->geometry->location->lat;
            $address->lng = $result->geometry->location->lng;
        }
        $address->fullAddress = $result->formatted_address;//完整地址
        return $address;
    }
}