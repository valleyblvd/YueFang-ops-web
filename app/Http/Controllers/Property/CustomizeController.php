<?php

namespace App\Http\Controllers\Property;

use App\Logic\PropertyBiz;
use App\Logic\PropertyCustBiz;
use App\Logic\Utils;
use App\Models\PropertyCustomize;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;

class CustomizeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $records = PropertyCustBiz::getAll();
        return view('property.customize.index', ['records' => $records]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('property.customize.create', ['formats' => Utils::getResFormats(),'cats'=>PropertyBiz::getCats()]);
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
            'formats' => 'required',
            'sub_cat_id'=>'required|integer',
            'title'=>'required'
        ]);

        $subCatId=$request->input('sub_cat_id');//TODO:检查sub_cat_id是否存在
        $relativePathPrefix = Utils::getPropCustImgPath($subCatId);
        $bannerCount = -1;
        $formats = $request->input('formats');

        $record = new PropertyCustomize();
        $record->listingID=$request->input('listingID');;
        $record->sub_cat_id=$subCatId;
        $record->title=$request->input('title');
        $record->lat=$request->input('lat');
        $record->lng=$request->input('lng');
        $record->address=$request->input('address');
        $record->city=$request->input('city');
        $record->state=$request->input('state');
        $record->zipcode=$request->input('zipcode');
        $record->img = $relativePathPrefix;
        $record->format = implode(',', $formats);
        foreach ($formats as $format) {
            $imgs = $request->input($format);//banner相对路径数组
            if (count($imgs) == 0)
                return view('property.customize.create', ['formats' => Utils::getResFormats()])->withErrors('您还没有上传图片！');
            if ($bannerCount > -1 && count($imgs) != $bannerCount) {
                return view('property.customize.create', ['formats' => Utils::getResFormats()])->withErrors('图片数量不一致！');
            }
            $bannerCount = count($imgs);
            $record->num = count($imgs);
            foreach ($imgs as $key => $img) {
                $ext = explode('.', $img)[1];
                $record->ext = $ext;
                rename(env('UPLOAD_PATH_PREFIX') . $img, env('UPLOAD_PATH_PREFIX') . $relativePathPrefix . '_' . $format . '_' . ($key + 1) . '.' . $ext);
            }
        }
        $record->save();
        return Redirect::to('properties/customize');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $record = PropertyCustBiz::getOne($id);
        if ($record == null)
            return view('errors.404');
        return view('property.customize.show', ['record' => $record]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $record = PropertyCustBiz::getOne($id);
        if ($record == null)
            return view('errors.404');
        return view('property.customize.edit', ['id' => $id, 'formats' => Utils::getResFormats(), 'record' => $record]);
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
        $this->validate($request, [
            'formats' => 'required',
            'title'=>'required'
        ]);


        $bannerCount = -1;
        $formats = $request->input('formats');

        $record = PropertyCustomize::find($id);
        if ($record == null)
            return view('errors.404');

        $relativePathPrefix=Utils::getPropCustImgPath($record->sub_cat_id);

        $record->listingID=$request->input('listingID');;
        $record->title=$request->input('title');
        $record->lat=$request->input('lat');
        $record->lng=$request->input('lng');
        $record->address=$request->input('address');
        $record->city=$request->input('city');
        $record->state=$request->input('state');
        $record->zipcode=$request->input('zipcode');
        $record->img = $relativePathPrefix;
        $record->format = implode(',', $formats);
        foreach ($formats as $format) {
            $banners = $request->input($format);//banner相对路径数组
            if (count($banners) == 0)
                return view('property.customize.create', ['formats' => Utils::getResFormats()])->withErrors('您还没有上传图片！');
            if ($bannerCount > -1 && count($banners) != $bannerCount) {
                return view('property.customize.create', ['formats' => Utils::getResFormats()])->withErrors('图片数量不一致！');
            }
            $bannerCount = count($banners);
            $record->num = count($banners);
            foreach ($banners as $key => $banner) {
                $ext = explode('.', $banner)[1];
                $record->ext = $ext;
                rename(env('UPLOAD_PATH_PREFIX') . $banner, env('UPLOAD_PATH_PREFIX') . $relativePathPrefix . '_' . $format . '_' . ($key + 1) . '.' . $ext);
            }
        }
        $record->save();
        return Redirect::to('properties/customize');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        PropertyCustomize::destroy($id);
        return Redirect::to('properties/customize');
    }
}
