<?php

namespace App\Http\Controllers\Property;

use App\Exceptions\FunFangException;
use App\Logic\Common;
use App\Logic\PropertyBiz;
use App\Logic\PropertyCustBiz;
use App\Logic\Utils;
use App\Models\PropertyCustomize;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class CustomizeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->toListView();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return $this->getCreateView();
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
            'sub_cat_id' => 'required|integer',
            'title' => 'required'
        ]);

        $subCatId = $request->input('sub_cat_id');
        $relativePathPrefix = Utils::getPropCustImgPath($subCatId);
        $listingID = $request->input('listingID');

        //检查该listingID是否已经标注过
        if ($listingID) {
            if (PropertyCustomize::where('listingID', $listingID)->first() != null)
                return $this->getCreateView()->withErrors('该房源已经标注过！');
        }

        $model = new PropertyCustomize();
        $model->listingID = $listingID;
        $model->sub_cat_id = $subCatId;
        $model->title = $request->input('title');
        $model->lat = $request->input('lat');
        $model->lng = $request->input('lng');
        $model->address = $request->input('address');
        $model->city = $request->input('city');
        $model->state = $request->input('state');
        $model->zipcode = $request->input('zipcode');
        $model->img = $relativePathPrefix;
        try {
            Common::handleFormats($request, $model, $relativePathPrefix);
        } catch (FunFangException $e) {
            return $this->getCreateView()->withErrors($e->getMessage());
        }
        $model->save();
        return $this->toListView();
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
        return $this->getEditView($record);
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
            'title' => 'required',
            'sub_cat_id' => 'required|integer'
        ]);

        $model = PropertyCustomize::find($id);
        if ($model == null)
            return view('errors.404');

        $subCatId = $request->input('sub_cat_id');
        $relativePathPrefix = Utils::getPropCustImgPath($subCatId);

        $model->listingID = $request->input('listingID');;
        $model->title = $request->input('title');
        $model->lat = $request->input('lat');
        $model->lng = $request->input('lng');
        $model->address = $request->input('address');
        $model->city = $request->input('city');
        $model->state = $request->input('state');
        $model->zipcode = $request->input('zipcode');
        $model->img = $relativePathPrefix;
        try {
            Common::handleFormats($request, $model, $relativePathPrefix);
        } catch (FunFangException $e) {
            return $this->getCreateView()->withErrors($e->getMessage());
        }
        $model->save();
        return $this->toListView();
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
        return $this->toListView();
    }

    /**
     * 转到列表页
     * @return mixed
     */
    public function toListView()
    {
        $models = PropertyCustBiz::getAll();
        return view('property.customize.index', ['models' => $models]);
    }

    /**
     * 获取创建视图
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    private function getCreateView()
    {
        return view('property.customize.create', [
            'model' => PropertyCustomize::getEmptyViewModel(),
            'formats' => Utils::getResFormats(),
            'cats' => PropertyBiz::getCats()
        ]);
    }

    /**
     * 获取编辑视图
     * @param $model
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    private function getEditView($model)
    {
        return view('property.customize.edit', [
            'model' => $model,
            'formats' => Utils::getResFormats(),
            'cats' => PropertyBiz::getCats()
        ]);
    }
}
