<?php

namespace App\Tools;

use App\Models\Property;
use Exception;
use GuzzleHttp;
use Illuminate\Support\Facades\DB;

class Util
{

    public static function parseLoopnetProperty($url)
    {
        if (!$url)
            return null;

        $dataSourceId = 1000;
        $html = new \simple_html_dom();
        $httpClient = new GuzzleHttp\Client();
        try {
            $content = $httpClient->get($url)->getBody()->getContents();
        } catch (Exception $e) {
            throw new Exception("访问 $url 出错！");
        }
        $html->load($content);

        $dataId = $html->find('#ProfileMainContent1_PropertyInfoFS1_lbPropertyID', 0)->plaintext;
        //先从数据库中查找
        if ($dataId) {
            $record = Property::where('DataSourceId', $dataSourceId)->where('DataId', $dataId)->first();
            if ($record)
                return $record;
        }

        //如果数据库中没有记录，从html中解析并保存到数据库
        //只采集特定类型房源
        $propertyType = $html->find('#topFSdata dd', 2)->plaintext;//房产类型
        $specTypes=['Multifamily','Office','Industrial','Land','Residential Income'];
        if(!in_array($propertyType,$specTypes)){
            throw new Exception('该类型的房源不采集哦！');
        }
        $record = new Property();
        $record->DataSourceId = $dataSourceId;
        $record->DataId = trim($dataId);
        $record->ReferenceUrl = $url;

        $listPrice = $html->find('#topFSdata dd', 0)->plaintext;//价格
        $record->ListPrice = str_replace(',', '', str_replace('$', '', $listPrice));
        $lotSqFt = $html->find('#topFSdata dd', 1)->plaintext;//面积
        $lotSqFt = str_ireplace('AC', '', $lotSqFt);
        $lotSqFt = str_replace(' ', '', $lotSqFt);
        $lotSqFt = $lotSqFt * 43560;
        $record->LotSqFt = $lotSqFt;
        $record->PropertyType = $propertyType;
        //$locationSrc = $html->find('#ifMap', 0)->src;
        //$lat = UrlUtil::getUrlParam($locationSrc, 'Lat');
        //$lng = UrlUtil::getUrlParam($locationSrc, 'Long');
        //$location = "$lat,$lng";
        $addressStr = $html->find('#ProfileMainContent1_PropertyAddress1_litPropertyFullAddress', 0)->plaintext;
        $addressRes = $httpClient->get('http://maps.googleapis.com/maps/api/geocode/json?address=' . $addressStr);
        $addressJson = json_decode($addressRes->getBody()->getContents());
        if ($addressJson->status == 'OK') {
            $addressObj = GoogleGeoHelper::getAddress($addressJson->results);
        }
        if ($addressObj) {
            $record->State = $addressObj->state;
            $record->County = $addressObj->county;
            $record->City = $addressObj->city;
            $record->Address = "$addressObj->streetNumber $addressObj->street";
            $record->PostalCode = $addressObj->postalCode;
            $record->Location = DB::raw("GeomFromText('POINT($addressObj->lng $addressObj->lat)')");
        }
        $record->Description = '';//描述
        foreach ($html->find('.detailsModule') as $desc) {
            if ($desc->first_child()->plaintext == 'Description') {
                foreach ($desc->find('p') as $p) {
                    $record->Description .= $p->plaintext;
                }
                break;
            }
        }
        $photos = $html->find('ul#wideCarousel>li>a.photo');//照片
        $photoUrls = [];
        foreach ($photos as $photo) {
            if (!StringUtil::equals($photo->href, '#')) {
                array_push($photoUrls, $photo->href);
            }
        }
        $record->PhotoUrls = implode(',', $photoUrls);
        $record->save();
        $html->clear();
        return $record;
    }

    public static function parseNewhomesourceProperty($url)
    {
        if (!$url)
            return null;

        $dataSourceId = 1001;
        $html = new \simple_html_dom();
        $httpClient = new GuzzleHttp\Client();
        try {
            $content = $httpClient->get($url)->getBody()->getContents();
        } catch (Exception $e) {
            throw new Exception("访问 $url 出错！");
        }
        $html->load($content);

        $planId = $html->find('#PlanId', 0)->value;
        //先从数据库中查找
        if ($planId) {
            $record = Property::where('DataSourceId', $dataSourceId)->where('DataId', $planId)->first();
            if ($record) {
                $html->clear();
                return $record;
            }
        }

        //如果数据库中没有记录，从html中解析并保存到数据库
        $record = new Property();
        $record->DataSourceId = $dataSourceId;
        $record->DataId = trim($planId);
        $record->ReferenceUrl = $url;

        $communityId = $html->find('#CommunityId', 0)->value;
        $specId = $html->find('#SpecId', 0)->value;
        //照片需要通过另外的API获取，必须的参数：communityId、planId、specId、isPreview
        $photoRes = $httpClient->post('http://www.newhomesource.com/detailgetgallery', [
            'form_params' => ['communityId' => $communityId, 'planId' => $planId, 'specId' => $specId, 'isPreview' => 'False']
        ]);
        $photoObj = json_decode($photoRes->getBody()->getContents());
        $photoUrls = [];
        foreach ($photoObj->PropertyMediaLinks as $photo) {
            //type:i是图片，v是视频
            if ($photo->Type == 'i')
                array_push($photoUrls, 'http://nhs-dynamic.bdxcdn.com/' . $photo->Url);
        }
        $record->PhotoUrls = implode(',', $photoUrls);
        //价格
        $listPrice = $html->find('#nhs_DetailsDescriptionAreaWrapper .nhs_DetailsPrice span', 0)->plaintext;
        $record->ListPrice = str_replace(',', '', str_replace('$', '', $listPrice));
        foreach ($html->find('#nhs_HomeDetailsHeaderBrandHomesSqFt ul li') as $li) {
            $text = $li->plaintext;
            if (StringUtil::containsIgnoreCase($text, 'Bedrooms')) {//卧室数
                $bedrooms = str_ireplace('Bedrooms', '', $text);
                $bedrooms = str_replace(' ', '', $bedrooms);
                $record->Bedrooms = $bedrooms;
            } else if (StringUtil::containsIgnoreCase($text, 'Bathrooms')) {//浴室数
                $bathrooms = str_ireplace('Bathrooms', '', $text);
                $bathrooms = str_replace(' ', '', $bathrooms);
                $record->BathsFull = intval($bathrooms);
                $record->BathsHalf = intval($bathrooms) == $bathrooms ? 0 : 1;
            } else if (StringUtil::containsIgnoreCase($text, 'sq.ft.')) {//面积
                $lotSqFt = str_ireplace('sq.ft.', '', $text);
                $lotSqFt = str_replace(',', '', $lotSqFt);
                $record->LotSqFt = $lotSqFt;
            } else if (StringUtil::containsIgnoreCase($text, 'Garages')) {//停车位
                $garageSpaces = str_ireplace('Garages', '', $text);
                $garageSpaces = str_replace(' ', '', $garageSpaces);
                $record->GarageSpaces = $garageSpaces;
            }
        }
        $description = $html->find('#nhs_DetailDescriptionArea', 0)->plaintext;
        $description = str_replace(' ', '', $description);
        $record->Description = $description;
        //解析坐标位置
        $jsonStr = $html->find('#nhs_HomeDetailv2 script', 0)->innertext;
        $obj = json_decode($jsonStr);
        $lat = $obj->Geo->latitude;
        $lng = $obj->Geo->longitude;
        $addressRes = $httpClient->get("http://maps.googleapis.com/maps/api/geocode/json?latlng=$lat,$lng");
        $addressJson = json_decode($addressRes->getBody()->getContents());
        if ($addressJson->status == 'OK') {
            $addressObj = GoogleGeoHelper::getAddress($addressJson->results);
        }
        if ($addressObj) {
            $record->State = $addressObj->state;
            $record->County = $addressObj->county;
            $record->City = $addressObj->city;
            $record->Address = "$addressObj->streetNumber $addressObj->street";
            $record->PostalCode = $addressObj->postalCode;
            $record->Location = DB::raw("GeomFromText('POINT($addressObj->lng $addressObj->lat)')");
        }
        $record->save();
        $html->clear();
        return $record;
    }
}