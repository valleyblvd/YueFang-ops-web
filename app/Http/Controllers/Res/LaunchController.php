<?php

namespace App\Http\Controllers\Res;

use App\Exceptions\FunFangException;
use App\Logic\Common;
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
        return view('res.launch.index', ['models' => LaunchResBiz::getAll()]);
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
            'formats' => 'required_if:type,0,1,2',
            'type' => 'required|int:0,1,2,3',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'url' => 'required_if:type,3'
        ]);

        $type = $request->input('type');

        $model = new LaunchRes();
        $model->type = $type;
        $model->url = $request->input('url');
        $model->start_date = $request->input('start_date');
        $model->end_date = $request->input('end_date');
        $model->active = $request->input('active') ? 1 : 0;
        if ($type == 3) {//home page html
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
            $relativePathPrefix = Utils::getLaunchImgPath($type);
            $model->img = $relativePathPrefix;
            try {
                Common::handleFormats($request, $model, $relativePathPrefix);
            } catch (FunFangException $e) {
                return $this->getCreateView()->withErrors($e->getMessage());
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
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return view('res.launch.show', ['model' => LaunchResBiz::getOne($id)]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('res.launch.edit', [
            'formats' => $this->getResFormats(),
            'model' => LaunchResBiz::getOne($id)]);
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
            $model->img = $relativePathPrefix;
            try {
                Common::handleFormats($request, $model, $relativePathPrefix);
            } catch (FunFangException $e) {
                return $this->getCreateView()->withErrors($e->getMessage());
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

    private function getCreateView()
    {
        return view('res.launch.create', [
            'model' => LaunchRes::getEmptyViewModel(),
            'formats' => $this->getResFormats()
        ]);
    }
}
