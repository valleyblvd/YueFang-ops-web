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
        $record = PropertyCustomize::find($id);
        if ($record == null)
            return null;

        $model = new \stdClass();
        $model->id = $record->id;
        $model->sub_cat_id = $record->sub_cat_id;
        $model->title = $record->title;
        $model->lat = $record->lat;
        $model->lng = $record->lng;
        $model->address=$record->address;
        $model->city=$record->city;
        $model->state=$record->state;
        $model->zipcode=$record->zipcode;
        $model->listingID=$record->listingID;
        $model->resources = [];
        $model->formats = [];

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
        return $model;
    }
}