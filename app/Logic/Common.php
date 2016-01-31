<?php

namespace App\Logic;


use App\Exceptions\FunFangException;

class Common
{
    public static function handleFormats($request, $model, $relativePathPrefix)
    {
        $bannerCount = -1;

        $formats = $request->input('formats');
        $model->format = implode(',', $formats);
        foreach ($formats as $format) {
            $banners = $request->input($format);//banner相对路径数组
            if (count($banners) == 0)
                throw new FunFangException('您还没有上传图片！');
            if ($bannerCount > -1 && count($banners) != $bannerCount) {
                throw new FunFangException('图片数量不一致！');
            }
            $bannerCount = count($banners);
            $model->num = count($banners);
            foreach ($banners as $key => $banner) {
                $ext = explode('.', $banner)[1];
                $model->ext = $ext;
                rename(env('UPLOAD_PATH_PREFIX') . $banner, env('UPLOAD_PATH_PREFIX') . $relativePathPrefix . '_' . $format . '_' . ($key + 1) . '.' . $ext);
            }
        }
    }
}