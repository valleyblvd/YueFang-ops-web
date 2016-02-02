<?php

namespace App\Tools;

use App\Exceptions\FunFangException;
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
            $content = $httpClient->get($url, [
                //'proxy' => 'tcp://qinhaoranwd:qqqqq11111@58.222.254.11:80'
            ])->getBody()->getContents();
        } catch (GuzzleHttp\Exception\RequestException $e) {
            throw new FunFangException("访问 $url 时出错！" . $e->getMessage());
        }
        $html->load($content);

        //对该页面进行简单的检查，判断是否有DataId
        $dataIdWrapper = $html->find('.property-timestamp', 0);
        if (!$dataIdWrapper)
            throw new FunFangException('您输入的URL可能不正确，解析失败！');
        $dataId = $dataIdWrapper->find('td', 0)->plaintext;
        $dataId = str_replace(' ', '', $dataId);
        $dataId = str_replace('ListingID:', '', $dataId);
        if (!$dataId)
            throw new FunFangException('未找到房源ID！');
        //先从数据库中查找
        if ($dataId) {
            $record = Property::where('DataSourceId', $dataSourceId)->where('DataId', $dataId)->first();
            if ($record)
                return $record;
        }

        //如果数据库中没有记录，从html中解析并保存到数据库
        //只采集特定类型房源
        $record = new Property();
        $record->DataSourceId = $dataSourceId;
        $record->DataId = trim($dataId);
        $record->ReferenceUrl = $url;

        $propertyTds = $html->find('.property-data', 0)->find('td');
        for ($i = 0; $i < count($propertyTds); $i = $i + 2) {
            $dataType = trim($propertyTds[$i]->plaintext);
            $dataValue = trim($propertyTds[$i + 1]->plaintext);
            if (StringUtil::equalsIgnoreCase('Price', $dataType)) {//价格
                $record->ListPrice = str_replace(',', '', str_replace('$', '', $dataValue));
            } else if (StringUtil::equalsIgnoreCase('Property Type', $dataType)) {//房产类型
                //指定采集的房源类型
                $specTypes = ['Multifamily', 'Office', 'Industrial', 'Land', 'Residential Income'];
                if (!in_array($dataValue, $specTypes)) {
                    throw new FunFangException('暂不采集该类型的房源！');
                }
                $record->PropertyType = $dataValue;
            } else if (StringUtil::equalsIgnoreCase('Lot Size', $dataType)) {//土地面积
                $lotSqFt = str_ireplace('AC', '', $dataValue);
                $lotSqFt = str_replace(' ', '', $lotSqFt);
                $lotSqFt = $lotSqFt * 43560;
                $record->LotSqFt = $lotSqFt;
            }
        }
        $addressStr = $html->find('.basic-info', 0)->find('h1', 0)->plaintext;
        $addressStr = str_replace('·', '', $addressStr);
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
            //$record->Location = DB::raw("GeomFromText('POINT($addressObj->lng $addressObj->lat)')");
            $record->Location = "$addressObj->lng,$addressObj->lat";
        }
        $record->Description = $html->find('.description', 0)->find('.row', 1)->plaintext;//描述
        $photos = $html->find('.carousel-wrapper', 0)->find('.carousel-inner', 0)->find('img');//照片
        $photoUrls = [];
        foreach ($photos as $photo) {
            if($photo->src)
                array_push($photoUrls, $photo->src);
            else
                array_push($photoUrls, $photo->getAttribute('lazy-src'));
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
            $contents = $httpClient->get($url)->getBody()->getContents();
        } catch (GuzzleHttp\Exception\RequestException $e) {
            throw new FunFangException("访问 $url 时出错！" . $e->getMessage());
        }
        $html->load($contents);

        $planIdEle = $html->find('#PlanId', 0);
        if (!$planIdEle)
            throw new FunFangException('您输入的URL可能不正确，解析失败！');
        $planId = $planIdEle->value;
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
                $structureSqFt = str_ireplace('sq.ft.', '', $text);
                $structureSqFt = str_replace(',', '', $structureSqFt);
                $record->StructureSqFt = $structureSqFt;
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
        $addressRes = $httpClient->get("http://ditu.google.cn//maps/api/geocode/json?latlng=$lat,$lng");
        $addressJson = json_decode($addressRes->getBody()->getContents());
        if ($addressJson->status == 'OK') {
            $addressObj = GoogleGeoHelper::getAddress($addressJson->results);
        }
        if ($addressObj) {
            $record->State = $addressObj->state;
            $record->County = $addressObj->county;
            $record->City = $addressObj->city;
            $streetNumber = property_exists($addressObj, 'streetNumber') ? $addressObj->streetNumber : '';
            $street = property_exists($addressObj, 'street') ? $addressObj->street : '';
            $record->Address = "$streetNumber $street";
            $record->PostalCode = $addressObj->postalCode;
            //$record->Location = DB::raw("GeomFromText('POINT($addressObj->lng $addressObj->lat)')");
            $record->Location = "$addressObj->lng,$addressObj->lat";
        }
        $record->save();
        $html->clear();
        return $record;
    }
}