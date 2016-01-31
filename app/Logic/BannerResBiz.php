<?php

namespace App\Logic;


use App\Models\BannerRes;

class BannerResBiz
{
    public static function getAll()
    {
        return BannerRes::all();
    }

    public static function getOne($id)
    {
        return BannerRes::findOrFail($id)->toViewModel();
    }
}