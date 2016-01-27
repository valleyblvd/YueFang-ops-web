<?php

namespace App\Logic;

use App\Models\Property;
use App\Models\PropertyCat;

class PropertyBiz
{
    public static function getOne($id)
    {
        return Property::findOrFail($id);
    }

    public static function getByPage()
    {
        return Property::orderBy('Id','DESC')->paginate(10);
    }

    public static function getCats()
    {
        return PropertyCat::with('subcats')->get();
    }

    public static function create($model)
    {
        $model->save();
    }

    public static function update($model)
    {
        $model->save();
    }

    public static function delete($id)
    {
        Property::destroy($id);
    }

}