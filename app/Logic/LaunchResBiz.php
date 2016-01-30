<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/1/11
 * Time: 21:26
 */

namespace App\Logic;


use App\Models\LaunchRes;

class LaunchResBiz
{
    public static function getAll()
    {
        return LaunchRes::all()->map(function ($model) {
            return $model->toViewModel();
        });
    }

    public static function getOne($id)
    {
        return LaunchRes::findOrFail($id)->toViewModel();
    }
}