<?php

namespace App\Http\Controllers\Property;

use App\Logic\PropertyBiz;
use App\Models\Property;
use App\Tools\GoogleGeoHelper;
use App\Tools\HttpUtil;
use App\Tools\StringUtil;
use App\Tools\UrlUtil;
use App\Tools\Util;
use Illuminate\Auth\Access\Response;
use Illuminate\Http\Request;
use GuzzleHttp;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
use Mockery\CountValidator\Exception;

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
            'BathHalf' => '',
            'LotSqFt' => '',
            'StructureSqFt'=>'',
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
        $model = PropertyBiz::getOne($id);
        return view('property.show', ['model' => $model]);
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
     * 通过MLSID或第三方网站URL获取房源
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|string
     * @throws \Exception
     */
    public function fetch(Request $request)
    {
        $this->validate($request, [
            'type' => 'required',
            'q' => 'required'
        ]);
        //搜索内容
        $q = trim($request->q);
        //判断搜索类型
        if ($request->type == 0) {//MLSID
            $model = Property::where('MLSNumber', $q)->first();
            if ($model) {
                //return view('property._detail', ['record' => $record]);
                $view = view('property._detail', ['record' => $model]);
                return response()->json(['model' => $model, 'view' => $view]);
            }
            throw new Exception('未找到！');
        } else if ($request->type == 1) {//第三方网站URL
            $domain = UrlUtil::getMainDomain($q);
            if (StringUtil::equalsIgnoreCase($domain, 'loopnet.com')) {
                $model = Util::parseLoopnetProperty($q);
                $view = view('property._detail', ['model' => $model])->render();
                return response()->json(['model' => $model, 'view' => $view]);
            } else if (StringUtil::equalsIgnoreCase($domain, 'newhomesource.com')) {
                $model = Util::parseNewhomesourceProperty($q);
                $view = view('property._detail', ['model' => $model])->render();
                return response()->json(['model' => $model, 'view' => $view]);
            } else {
                throw new Exception('您输入的网站URL暂不支持！');
            }
        } else {
            throw new Exception('搜索类型错误！');
        }
    }
}
