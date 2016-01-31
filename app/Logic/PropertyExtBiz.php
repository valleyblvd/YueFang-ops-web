<?php

namespace App\Logic;


use App\Models\PropertyExt;

class PropertyExtBiz
{
    public static function getAll()
    {
        return PropertyExt::all()->map(function ($model) {
            return $model->toViewModel();
        });
    }

    public static function getOne($id)
    {
        return PropertyExt::findOrFail($id);
    }

    public static function store($model)
    {
        $model->save();
    }

    public static function delete($id)
    {
        PropertyExt::destroy($id);
    }
}