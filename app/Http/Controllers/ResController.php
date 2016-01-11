<?php

namespace App\Http\Controllers;

use App\Logic\BannerResBiz;
use App\Models\BannerRes;
use App\Models\ResourceVer;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Tools\Utils;
use Illuminate\Support\Facades\Redirect;

class ResController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function indexBanner()
    {
        return view('res.banner.index', ['banners' => BannerResBiz::getAll()]);
    }

    public function showBanner($id)
    {
        $banner = BannerResBiz::getOne($id);
        if ($banner == null)
            return view('errors.404');
        return view('res.banner.show', ['banner' => $banner]);
    }

    public function createBanner()
    {
        return view('res.banner.create', ['formats' => BannerResBiz::getFormats()]);
    }

    public function storeBanner(Request $request)
    {
        $this->validate($request, [
            'formats' => 'required',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date'
        ]);

        $relativePathPrefix = 'images/banner_' . time();
        $bannerCount = -1;

        $bannerRes = new BannerRes();
        $bannerRes->style = 0;
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
                return view('res.banner.create', ['formats' => BannerResBiz::getFormats()])->withErrors('您还没有上传图片！');
            if ($bannerCount > -1 && count($banners) != $bannerCount) {
                return view('res.banner.create', ['formats' => BannerResBiz::getFormats()])->withErrors('图片数量不一致！');
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
        return Redirect::to('res/banners');
    }

    public function editBanner($id)
    {
        $bannerRes = BannerResBiz::getOne($id);
        if ($bannerRes == null)
            return view('errors.404');
        return view('res.banner.edit', ['id' => $id, 'formats' => BannerResBiz::getFormats(), 'banner' => $bannerRes]);
    }

    public function updateBanner($id, Request $request)
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
                return view('res.banner.create', ['formats' => BannerResBiz::getFormats()])->withErrors('您还没有上传图片！');
            if ($bannerCount > -1 && count($banners) != $bannerCount) {
                return view('res.banner.create', ['formats' => BannerResBiz::getFormats()])->withErrors('图片数量不一致！');
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
        return Redirect::to('res/banners/');
    }

    public function deleteBanner($id)
    {
        BannerRes::destroy($id);
        return Redirect::to('res/banners');
    }

    public function uploadFile(Request $request)
    {
        $file = $request->file('file');
        $ext = $file->getClientOriginalExtension();
        $relativePath = 'images/' . Utils::newGuid() . '.' . $ext;
        $file->move(env('UPLOAD_PATH_PREFIX') . 'images/', $relativePath);
        if ($request->ajax()) {
            return response()->json(['relativePath' => $relativePath, 'url' => env('UPLOAD_URL') . $relativePath]);
        }
        return '上传成功！';
    }
}
