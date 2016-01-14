<?php

namespace App\Http\Controllers\Property;

use App\Logic\PropertyExtBiz;
use App\Models\PropertyExt;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;

class ExtController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('property.ext.index',['records'=>PropertyExtBiz::getAll()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('property.ext.create');
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
            'mlsId' => 'required'
        ]);

        $record = new PropertyExt();
        $record->mlsId = $request->input('mlsId');
        $record->tag = $request->input('tag');
        $record->hot = $request->input('hot') ? 1 : 0;
        $record->recommended = $request->input('recommended') ? 1 : 0;
        PropertyExtBiz::store($record);
        return Redirect::to('properties/ext');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return view('property.ext.show',['record'=>PropertyExtBiz::getOne($id)]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('property.ext.edit', ['record' => PropertyExtBiz::getOne($id)]);
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
        $record = PropertyExt::find($id);
        if ($record == null)
            return view('errors.404');

        $record->mlsId = $request->input('mlsId');
        $record->tag = $request->input('tag');
        $record->hot = $request->input('hot') ? 1 : 0;
        $record->recommended = (bool)$request->input('recommended');
        PropertyExtBiz::store($record);
        return Redirect::to('properties/ext');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        PropertyExtBiz::delete($id);
        return Redirect::to('properties/ext');
    }
}
