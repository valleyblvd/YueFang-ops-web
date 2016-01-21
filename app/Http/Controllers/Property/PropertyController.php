<?php

namespace App\Http\Controllers\Property;

use App\Logic\PropertyBiz;
use App\Models\Property;
use App\Tools\GoogleGeoHelper;
use App\Tools\HttpUtil;
use App\Tools\StringUtil;
use App\Tools\UrlUtil;
use Illuminate\Http\Request;
use GuzzleHttp;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;

class PropertyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('property.index', ['records' => PropertyBiz::getByPage()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('property.create', [
            'DataSourceId' => '',
            'DataId' => '',
            'ReferenceUrl' => '',
            'ListPrice' => '',
            'PhotoUrls' => '',
            'Bedrooms' => '',
            'BathFull' => '',
            'LotSqFt' => '',
            'GarageSpaces' => '',
            'Description' => '',
            'PropertyType' => '',
            'State' => '',
            'County' => '',
            'City' => '',
            'Address' => '',
            'PostalCode' => '',
            'Location' => ''
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'DataSourceId' => 'required'
        ]);

        $model = new Property();
        $model->fromRequest($request);
        PropertyBiz::create($model);
        return Redirect::to('properties');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return view('property.show', ['record' => PropertyBiz::getOne($id)]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('property.edit', ['record' => PropertyBiz::getOne($id)]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $model = Property::find($id);
        $model->DataSourceId = $request->input("DataSourceId");
        $model->DataId = $request->input("DataId");
        $model->ReferenceUrl = $request->input("ReferenceUrl");
        $model->PhotoUrls = $request->input("PhotoUrls");
        $model->MLSNumber = $request->input("MLSNumber");
        $model->Status = $request->input("Status");
        $model->StatusEnum = $request->input("StatusEnum");
        $model->SaleType = $request->input("SaleType");
        $model->SaleTypeEnum = $request->input("SaleTypeEnum");
        $model->PropertyType = $request->input("PropertyType");
        $model->PropertyTypeEnum = $request->input("PropertyTypeEnum");
        $model->ListPrice = $request->input("ListPrice");
        $model->SalePrice = $request->input("SalePrice");
        $model->State = $request->input("State");
        $model->County = $request->input("County");
        $model->City = $request->input("City");
        $model->Address = $request->input("Address");
        $model->PostalCode = $request->input("PostalCode");
        $model->Area = $request->input("Area");
        $model->CrossStreets = $request->input("CrossStreets");
        $model->Location = $request->input("Location");
        $model->Description = $request->input("Description");
        $model->YearBuilt = $request->input("YearBuilt");
        $model->LotSqFt = $request->input("LotSqFt");
        $model->StructureSqFt = $request->input("StructureSqFt");
        $model->Bedrooms = $request->input("Bedrooms");
        $model->BathsFull = $request->input("BathsFull");
        $model->BathsHalf = $request->input("BathsHalf");
//        PropertyBiz::update($model);
        $model->save();
        return Redirect::to('properties');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        PropertyBiz::delete($id);
        return Redirect::to('properties');
    }

    /**
     * 从给定的URL中采集房源信息
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getFromRef(Request $request)
    {
        $this->validate($request, [
            'ref_url' => 'required|url'
        ]);

        $domain = UrlUtil::getMainDomain($request->ref_url);
        $html = new \simple_html_dom();
        $httpClient = HttpUtil::getGuzzleClient();
        $res = $httpClient->get($request->ref_url)->getBody()->getContents();
        $html->load($res);

        if (StringUtil::equalsIgnoreCase($domain, 'loopnet.com')) {
            $dataId = $html->find('#ProfileMainContent1_PropertyInfoFS1_lbPropertyID', 0)->plaintext;
            //TODO:先查询数据库，判断该房源是否在存在
            $listPrice = $html->find('#topFSdata dd', 0)->plaintext;//价格
            $lotSqFt = $html->find('#topFSdata dd', 1)->plaintext;//面积
            $lotSqFt = str_ireplace('AC', '', $lotSqFt);
            $lotSqFt = str_replace(' ', '', $lotSqFt);
            $lotSqFt = $lotSqFt * 43560;
            $propertyType = $html->find('#topFSdata dd', 2)->plaintext;//房产类型
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
                $state = $addressObj->state;
                $county = $addressObj->county;
                $city = $addressObj->city;
                $address = "$addressObj->streetNumber $addressObj->street";
                $postalCode = $addressObj->postalCode;
                $location = "GeomFromText('POINT($addressObj->lng $addressObj->lat)')";
            }
            $description = '';//描述
            foreach ($html->find('.detailsModule') as $desc) {
                if ($desc->first_child()->plaintext == 'Description') {
                    foreach ($desc->find('p') as $p) {
                        $description .= $p->plaintext;
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

            $html->clear();
            return view('property.create', [
                'DataSourceId' => 1001,
                'DataId' => trim($dataId),
                'ReferenceUrl' => $request->ref_url,
                'ListPrice' => str_replace(',', '', str_replace('$', '', $listPrice)),
                'PhotoUrls' => implode(',', $photoUrls),
                'Bedrooms' => '',
                'BathFull' => '',
                'LotSqFt' => $lotSqFt,
                'GarageSpaces' => '',
                'Description' => $description,
                'PropertyType' => $propertyType,
                'State' => $state,
                'County' => $county,
                'City' => $city,
                'Address' => $address,
                'PostalCode' => $postalCode,
                'Location' => $location
            ]);
        } else if (StringUtil::equalsIgnoreCase($domain, 'newhomesource.com')) {
            $planId = $html->find('#PlanId', 0)->value;
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
                    array_push($photoUrls, 'http://nhs-dynamic.bdxcdn.com' . $photo->Url);
            }

            $dataId = $planId;
            $listPrice = $html->find('#nhs_DetailsDescriptionAreaWrapper .nhs_DetailsPrice span', 0)->plaintext;
            foreach ($html->find('#nhs_HomeDetailsHeaderBrandHomesSqFt ul li') as $li) {
                $text = $li->plaintext;
                if (StringUtil::containsIgnoreCase($text, 'Bedrooms')) {//卧室数
                    $bedrooms = str_ireplace('Bedrooms', '', $text);
                    $bedrooms = str_replace(' ', '', $bedrooms);
                } else if (StringUtil::containsIgnoreCase($text, 'Bathrooms')) {//浴室数
                    $bathrooms = str_ireplace('Bathrooms', '', $text);
                    $bathrooms = str_replace(' ', '', $bathrooms);
                } else if (StringUtil::containsIgnoreCase($text, 'sq.ft.')) {//面积
                    $lotSqFt = str_ireplace('sq.ft.', '', $text);
                    $lotSqFt = str_replace(',', '', $lotSqFt);
                    $lotSqFt = str_replace(' ', '', $lotSqFt);
                } else if (StringUtil::containsIgnoreCase($text, 'Garages')) {//停车位
                    $garageSpaces = str_ireplace('Garages', '', $text);
                    $garageSpaces = str_replace(' ', '', $garageSpaces);
                }
            }
            $description = $html->find('#nhs_DetailDescriptionArea', 0)->plaintext;
            $description = str_replace(' ', '', $description);
            //解析坐标位置
            $jsonStr = $html->find('#nhs_HomeDetailv2 script', 0)->innertext;
            $obj = json_decode($jsonStr);
            $lat = $obj->Geo->latitude;
            $lng = $obj->Geo->longitude;
            $location = "GeomFromText('POINT($lng $lat)')";

            $html->clear();
            return view('property.create', [
                'DataSourceId' => 1002,
                'DataId' => $dataId,
                'ReferenceUrl' => $request->ref_url,
                'ListPrice' => str_replace(',', '', str_replace('$', '', $listPrice)),
                'PhotoUrls' => implode(',', $photoUrls),
                'Bedrooms' => $bedrooms,
                'BathFull' => $bathrooms,
                'LotSqFt' => $lotSqFt,
                'GarageSpaces' => $garageSpaces,
                'Description' => $description,
                'PropertyType' => '',
                'State' => '',
                'County' => '',
                'City' => '',
                'Address' => '',
                'PostalCode' => '',
                'Location' => $location
            ]);
        } else {
            $html->clear();
            return view('property.create', [
                'DataSourceId' => '',
                'DataId' => '',
                'ReferenceUrl' => '',
                'ListPrice' => '',
                'PhotoUrls' => '',
                'Bedrooms' => '',
                'BathFull' => '',
                'LotSqFt' => '',
                'GarageSpaces' => '',
                'Description' => '',
                'PropertyType' => '',
                'State' => '',
                'County' => '',
                'City' => '',
                'Address' => '',
                'PostalCode' => '',
                'Location' => ''
            ])->withErrors('Not supported data source.');
        }
    }
}
