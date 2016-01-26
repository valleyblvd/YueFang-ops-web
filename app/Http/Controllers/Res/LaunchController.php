<?php

namespace App\Http\Controllers\Res;

use App\Logic\LaunchResBiz;
use App\Logic\Utils;
use App\Models\LaunchRes;
use App\Models\ResourceVer;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;

class LaunchController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('res.launch.index', ['records' => LaunchResBiz::getAll()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('res.launch.create', ['formats' => $this->getResFormats()]);
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
            'formats' => 'required_if:type,0,1,2',
            'type' => 'required|int:0,1,2,3',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'url' => 'required_if:type,3'
        ]);

        $type = $request->input('type');

        $record = new LaunchRes();
        $record->type = $type;
        $record->url = $request->input('url');
        $record->start_date = $request->input('start_date');
        $record->end_date = $request->input('end_date');
        $record->active = $request->input('active') ? 1 : 0;
        if ($type == 3) {//home page html
            $record->format = '';
            $record->ext = 'html';
            $record->num = count(explode(';', $request->input('url')));
            $record->save();
            $ver = ResourceVer::where('resource_name', 'homepage')->first();
            if ($ver != null) {
                $ver->ver = time();
                $ver->save();
            }
        } else {
            $relativePathPrefix = Utils::getLaunchImgPath($type);
            $bannerCount = -1;
            $record->img = $relativePathPrefix;
            $formats = $request->input('formats');
            $record->format = implode(',', $formats);
            foreach ($formats as $format) {
                $imgs = $request->input($format);//img相对路径数组
                if (count($imgs) == 0)
                    return view('res.banner.create', ['formats' => $this->getResFormats()])->withErrors('您还没有上传图片！');
                if ($bannerCount > -1 && count($imgs) != $bannerCount) {
                    return view('res.banner.create', ['formats' => $this->getResFormats()])->withErrors('图片数量不一致！');
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
            $ver = ResourceVer::where('resource_name', 'launch_ver')->first();
            if ($ver != null) {
                $ver->ver = time();
                $ver->save();
            }
        }
        return Redirect::to('res/launch');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $record = LaunchResBiz::getOne($id);
        if ($record == null)
            return view('errors.404');
        return view('res.launch.show', ['record' => $record]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $model = LaunchResBiz::getOne($id);
        if ($model == null)
            return view('errors.404');
        return view('res.launch.edit', ['id' => $id, 'formats' => $this->getResFormats(), 'model' => $model]);
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
            'formats' => 'required_if:type,0,1,2',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'url' => 'required_if:type,3'
        ]);

        $model = LaunchRes::find($id);
        if ($model == null)
            return view('errors.404');

        $model->url = $request->input('url');
        $model->start_date = $request->input('start_date');
        $model->end_date = $request->input('end_date');
        $model->active = $request->input('active') ? 1 : 0;
        if ($model->type == 3) {//home page html
            $model->format = '';
            $model->ext = 'html';
            $model->num = count(explode(';', $request->input('url')));
            $model->save();
            $ver = ResourceVer::where('resource_name', 'homepage')->first();
            if ($ver != null) {
                $ver->ver = time();
                $ver->save();
            }
        } else {
            $relativePathPrefix = Utils::getLaunchImgPath($model->type);
            $bannerCount = -1;
            $model->img = $relativePathPrefix;
            $formats = $request->input('formats');
            $model->format = implode(',', $formats);
            foreach ($formats as $format) {
                $banners = $request->input($format);//banner相对路径数组
                if (count($banners) == 0)
                    return view('res.banner.edit', ['formats' => $this->getResFormats()])->withErrors('您还没有上传图片！');
                if ($bannerCount > -1 && count($banners) != $bannerCount) {
                    return view('res.banner.edit', ['formats' => $this->getResFormats()])->withErrors('图片数量不一致！');
                }
                $bannerCount = count($banners);
                $model->num = count($banners);
                foreach ($banners as $key => $banner) {
                    $ext = explode('.', $banner)[1];
                    $model->ext = $ext;
                    rename(env('UPLOAD_PATH_PREFIX') . $banner, env('UPLOAD_PATH_PREFIX') . $relativePathPrefix . '_' . $format . '_' . ($key + 1) . '.' . $ext);
                }
            }
            $model->save();
            $ver = ResourceVer::where('resource_name', 'launch_ver')->first();
            if ($ver != null) {
                $ver->ver = time();
                $ver->save();
            }
        }

        return Redirect::to('res/launch');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        LaunchRes::destroy($id);
        return Redirect::to('res/launch');
    }

    private static function getResFormats()
    {
        $formats = [];
        $formats[] = ['id' => 'ip4', 'name' => 'iPhone 4'];
        $formats[] = ['id' => 'ip5', 'name' => 'iPhone 5'];
        $formats[] = ['id' => 'ip6', 'name' => 'iPhone 6'];
        $formats[] = ['id' => 'ip6p', 'name' => 'iPhone 6 Plus'];
        return $formats;
    }
}
