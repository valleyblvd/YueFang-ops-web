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
        $record = BannerRes::find($id);
        if ($record == null)
            return null;

        $banner = new \stdClass();
        $banner->id = $record->id;
        $banner->url = $record->url;
        $banner->start_date = $record->start_date;
        $banner->end_date = $record->end_date;
        $banner->active=$record->active;
        $banner->resources = [];
        $banner->formats = [];

        $formats = explode(',', $record->format);
        foreach ($formats as $format) {
            $banner->formats[]=$format;

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
            $banner->resources[] = $resource;
        }
        return $banner;
    }

    public static function getFormats()
    {
        $formats = [];
        $formats[] = ['id' => 'ip4', 'name' => 'iPhone 4'];
        $formats[] = ['id' => 'ip6p', 'name' => 'iPhone 6 Plus'];
        return $formats;
    }
}