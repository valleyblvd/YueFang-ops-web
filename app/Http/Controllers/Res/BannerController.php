<?php

namespace App\Http\Controllers\Res;

use App\Exceptions\FunFangException;
use App\Logic\BannerResBiz;
use App\Logic\Common;
use App\Logic\Utils;
use App\Models\BannerRes;
use App\Models\ResourceVer;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;

class BannerController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('res.banner.index', ['banners' => BannerResBiz::getAll()]);
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
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date'
        ]);

        $relativePathPrefix = 'images/banner/banner_' . time();

        $model = new BannerRes();
        $model->url = $request->input('url');
        $model->start_date = $request->input('start_date');
        $model->end_date = $request->input('end_date');
        $model->active = $request->input('active') ? 1 : 0;
        $model->img = $relativePathPrefix;
        try {
            Common::handleFormats($request, $model, $relativePathPrefix);
        } catch (FunFangException $e) {
            return $this->getCreateView()->withErrors($e->getMessage());
        }
        $model->save();
        $ver = ResourceVer::where('resource_name', 'banner_ver')->first();
        if ($ver != null) {
            $ver->ver = time();
            $ver->save();
        }
        return Redirect::to('res/banner');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $banner = BannerResBiz::getOne($id);
        return view('res.banner.show', ['banner' => $banner]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $model = BannerResBiz::getOne($id);
        return view('res.banner.edit', ['id' => $id, 'formats' => Utils::getResFormats(), 'model' => $model]);
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
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date'
        ]);

        $relativePathPrefix = 'images/banner_' . time();

        $model = BannerRes::findOrFail($id);

        $model->url = $request->input('url');
        $model->start_date = $request->input('start_date');
        $model->end_date = $request->input('end_date');
        $model->active = $request->input('active') ? 1 : 0;
        $model->img = $relativePathPrefix;
        try {
            Common::handleFormats($request, $model, $relativePathPrefix);
        } catch (FunFangException $e) {
            return $this->getCreateView()->withErrors($e->getMessage());
        }
        $model->save();
        $ver = ResourceVer::where('resource_name', 'banner_ver')->first();
        if ($ver != null) {
            $ver->ver = time();
            $ver->save();
        }
        return Redirect::to('res/banner');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        BannerRes::destroy($id);
        return Redirect::to('res/banner');
    }

    private function getCreateView()
    {
        return view('res.banner.create', [
            'model' => BannerRes::getEmptyViewModel(),
            'formats' => Utils::getResFormats()
        ]);
    }
}
