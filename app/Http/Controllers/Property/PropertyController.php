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
            'ReferenceUrl'=>'',
            'ListPrice'=>''
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
        $html->load_file($request->ref_url);

        if (StringUtils::equalsIgnoreCase($domain, 'loopnet.com')) {
            $dataId = $html->find('#ProfileMainContent1_PropertyInfoFS1_lbPropertyID', 0)->plaintext;
            $listPrice=$html->find('#topFSdata dd',0)->plaintext;
            return view('property.create', [
                'DataSourceId' => 5,
                'DataId' => trim($dataId),
                'ReferenceUrl'=>$request->ref_url,
                'ListPrice'=>str_replace(',','',str_replace('$','',$listPrice))
            ]);
        } else if (StringUtils::equalsIgnoreCase($domain, 'newhomesource.com')) {
            $DataId = $html->find('#PlanId', 0)->value;
            $listPrice=$html->find('#nhs_DetailsDescriptionAreaWrapper .nhs_DetailsPrice span',0)->plaintext;
            return view('property.create', [
                'DataSourceId' => 6,
                'DataId' => $DataId,
                'ReferenceUrl'=>$request->ref_url,
                'ListPrice'=>str_replace(',','',str_replace('$','',$listPrice))
            ]);
        } else {
            return view('property.create', [
                'DataSourceId' => '',
                'DataId' => ''])->withErrors('Not supported data source.');
        }
    }
}
