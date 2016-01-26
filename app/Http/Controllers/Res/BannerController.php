<?php

namespace App\Http\Controllers\Res;

use App\Logic\BannerResBiz;
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
        return view('res.banner.create', ['formats' => Utils::getResFormats()]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'formats' => 'required',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date'
        ]);

        $relativePathPrefix = 'images/banner_' . time();
        $bannerCount = -1;

        $bannerRes = new BannerRes();
        $bannerRes->url = $request->input('url');
        $bannerRes->start_date = $request->input('start_date');
        $bannerRes->end_date = $request->input('end_date');
        $bannerRes->active = $request->input('active') ? 1 : 0;
        $bannerRes->img = $relativePathPrefix;
        $formats = $request->input('formats');
        $bannerRes->format = implode(',', $formats);
        foreach ($formats as $format) {
            $banners = $request->input($format);//banner相对路径数组
            if (count($banners) == 0)
                return view('res.banner.create', ['formats' => Utils::getResFormats()])->withErrors('您还没有上传图片！');
            if ($bannerCount > -1 && count($banners) != $bannerCount) {
                return view('res.banner.create', ['formats' => Utils::getResFormats()])->withErrors('图片数量不一致！');
            }
            $bannerCount = count($banners);
            $bannerRes->num = count($banners);
            foreach ($banners as $key => $banner) {
                $ext = explode('.', $banner)[1];
                $bannerRes->ext = $ext;
                rename(env('UPLOAD_PATH_PREFIX') . $banner, env('UPLOAD_PATH_PREFIX') . $relativePathPrefix . '_' . $format . '_' . ($key + 1) . '.' . $ext);
            }
        }
        $bannerRes->save();
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $banner = BannerResBiz::getOne($id);
        if ($banner == null)
            return view('errors.404');
        return view('res.banner.show', ['banner' => $banner]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $model = BannerResBiz::getOne($id);
        if ($model == null)
            return view('errors.404');
        return view('res.banner.edit', ['id' => $id, 'formats' => Utils::getResFormats(), 'model' => $model]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
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
        $bannerCount = -1;

        $bannerRes = BannerRes::find($id);
        if ($bannerRes == null)
            return view('errors.404');

        $bannerRes->url = $request->input('url');
        $bannerRes->start_date = $request->input('start_date');
        $bannerRes->end_date = $request->input('end_date');
        $bannerRes->active = $request->input('active') ? 1 : 0;
        $bannerRes->img = $relativePathPrefix;
        $formats = $request->input('formats');
        $bannerRes->format = implode(',', $formats);
        foreach ($formats as $format) {
            $banners = $request->input($format);//banner相对路径数组
            if (count($banners) == 0)
                return view('res.banner.edit', ['formats' => Utils::getResFormats()])->withErrors('您还没有上传图片！');
            if ($bannerCount > -1 && count($banners) != $bannerCount) {
                return view('res.banner.edit', ['formats' => Utils::getResFormats()])->withErrors('图片数量不一致！');
            }
            $bannerCount = count($banners);
            $bannerRes->num = count($banners);
            foreach ($banners as $key => $banner) {
                $ext = explode('.', $banner)[1];
                $bannerRes->ext = $ext;
                rename(env('UPLOAD_PATH_PREFIX') . $banner, env('UPLOAD_PATH_PREFIX') . $relativePathPrefix . '_' . $format . '_' . ($key + 1) . '.' . $ext);
            }
        }
        $bannerRes->save();
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        BannerRes::destroy($id);
        return Redirect::to('res/banner');
    }
}
