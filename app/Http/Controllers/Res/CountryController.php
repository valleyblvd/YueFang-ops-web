<?php

namespace App\Http\Controllers\Res;

use App\Models\Country;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class CountryController extends Controller
{
    /**
     * 获取国家列表.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return Country::all();
        } else {
            return view('res.country.index');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
            'name_en' => 'required',
            'name_cn' => 'required',
            'call_code' => 'required'
        ]);

        $model = new Country();
        $model->name_en = $request->name_en;
        $model->name_cn = $request->name_cn;
        $model->short = $request->short;
        $model->call_code = $request->call_code;
        $model->active = $request->active ? 1 : 0;
        $model->save();
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

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
            'name_en' => 'required',
            'name_cn' => 'required',
            'call_code' => 'required'
        ]);

        $model = Country::findOrFail($id);
        $model->name_en = $request->name_en;
        $model->name_cn = $request->name_cn;
        $model->short = $request->short;
        $model->call_code = $request->call_code;
        $model->active = $request->active ? 1 : 0;
        $model->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Country::destroy($id);
    }
}
