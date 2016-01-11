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
        return LaunchRes::all();
    }

    public static function getOne($id)
    {
        $record = LaunchRes::find($id);
        if ($record == null)
            return null;

        $model = new \stdClass();
        $model->id = $record->id;
        $model->type = $record->type;
        $model->url = $record->url;
        $model->start_date = $record->start_date;
        $model->end_date = $record->end_date;
        $model->active = $record->active;
        $model->resources = [];
        $model->formats = [];
        if ($record->type != 3) {
            $formats = explode(',', $record->format);
            foreach ($formats as $format) {
                $model->formats[] = $format;

                $resource = new \stdClass();
                $resource->format = $format;
                $resource->imgs = [];
                for ($i = 1; $i <= $record->num; $i++) {
                    $relativePath = $record->img . '_' . $format . '_' . $i . '.' . $record->ext;
                    $img = new \stdClass();
                    $img->relativePath = $relativePath;
                    $img->src = env('UPLOAD_URL') . $relativePath;
                    $resource->imgs[] = $img;
                }
                $model->resources[] = $resource;
            }
        }
        return $model;
    }
}