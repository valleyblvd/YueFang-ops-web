<?php

namespace App\Http\Controllers\Property;

use App\Logic\PropertyBiz;
use App\Models\Property;
use App\Tools\StringUtils;
use App\Tools\UrlUtils;
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
            'Description' => ''
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
        $domain = UrlUtils::getMainDomain($request->ref_url);
        $html = new \simple_html_dom();
        $httpClient = new GuzzleHttp\Client();
        $res = $httpClient->get($request->ref_url)->getBody()->getContents();
        $html->load($res);

        if (StringUtils::equalsIgnoreCase($domain, 'loopnet.com')) {
            $dataId = $html->find('#ProfileMainContent1_PropertyInfoFS1_lbPropertyID', 0)->plaintext;
            $listPrice = $html->find('#topFSdata dd', 0)->plaintext;
            $photos = $html->find('ul#wideCarousel>li>a.photo');
            $photoUrls = [];
            foreach ($photos as $photo) {
                var_dump($photo);
                if (!StringUtils::equals($photo, '#'))
                    array_push($photoUrls, $photo->href);
            }
            $html->clear();
            return view('property.create', [
                'DataSourceId' => 5,
                'DataId' => trim($dataId),
                'ReferenceUrl' => $request->ref_url,
                'ListPrice' => str_replace(',', '', str_replace('$', '', $listPrice)),
                'PhotoUrls' => implode(',', $photoUrls),
                'Bedrooms' => '',
                'BathFull' => '',
                'LotSqFt' => '',
                'GarageSpaces' => '',
                'Description' => ''
            ]);
        } else if (StringUtils::equalsIgnoreCase($domain, 'newhomesource.com')) {
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
            $bedrooms = null;
            $bathrooms = null;
            $lotSqFt = null;
            $garageSpaces = null;
            foreach ($html->find('#nhs_HomeDetailsHeaderBrandHomesSqFt ul li') as $li) {
                $text = $li->plaintext;
                //解析Bedrooms
                if (StringUtils::containsIgnoreCase($text, 'Bedrooms')) {
                    $bedrooms = str_ireplace('Bedrooms', '', $text);
                    $bedrooms = str_replace(' ', '', $bedrooms);
                } else if (StringUtils::containsIgnoreCase($text, 'Bathrooms')) {
                    $bathrooms = str_ireplace('Bathrooms', '', $text);
                    $bathrooms = str_replace(' ', '', $bathrooms);
                } else if (StringUtils::containsIgnoreCase($text, 'sq.ft.')) {
                    $lotSqFt = str_ireplace('sq.ft.', '', $text);
                    $lotSqFt = str_replace(',', '', $lotSqFt);
                    $lotSqFt = str_replace(' ', '', $lotSqFt);
                } else if (StringUtils::containsIgnoreCase($text, 'Garages')) {
                    $garageSpaces = str_ireplace('Garages', '', $text);
                    $garageSpaces = str_replace(' ', '', $garageSpaces);
                }
            }
            $description = $html->find('#nhs_DetailDescriptionArea', 0)->plaintext;
            $description = str_replace(' ', '', $description);
            $html->clear();
            return view('property.create', [
                'DataSourceId' => 6,
                'DataId' => $dataId,
                'ReferenceUrl' => $request->ref_url,
                'ListPrice' => str_replace(',', '', str_replace('$', '', $listPrice)),
                'PhotoUrls' => implode(',', $photoUrls),
                'Bedrooms' => $bedrooms,
                'BathFull' => $bathrooms,
                'LotSqFt' => $lotSqFt,
                'GarageSpaces' => $garageSpaces,
                'Description' => $description
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
                'Description' => ''
            ])->withErrors('Not supported data source.');
        }
    }
}
