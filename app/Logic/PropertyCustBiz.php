<?php

namespace App\Logic;


use App\Models\PropertyCustomize;

class PropertyCustBiz
{
    public static function getAll()
    {
        return PropertyCustomize::all();
    }

    public static function getOne($id)
    {
        $model = PropertyCustomize::find($id);
        if ($model == null)
            return null;
        return $model->toViewModel();
    }
}