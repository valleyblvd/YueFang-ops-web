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
        return PropertyCustomize::findOrFail($id)->toViewModel();
    }
}