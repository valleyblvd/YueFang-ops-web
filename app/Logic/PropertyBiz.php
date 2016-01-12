<?php

namespace App\Logic;


use App\Models\PropertyCat;

class PropertyBiz
{
    public static function getCats()
    {
        return PropertyCat::with('subcats')->get();
    }
}