<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class BannerRes extends Model
{
    protected $table = 'banner_res';

    public function toViewModel()
    {
        $viewModel = new \stdClass();
        $viewModel->id = $this->id;
        $viewModel->url = $this->url;
        $viewModel->start_date = $this->start_date;
        $viewModel->end_date = $this->end_date;
        $viewModel->active = $this->active;
        $viewModel->resources = [];
        $viewModel->formats = [];

        $formats = explode(',', $this->format);
        foreach ($formats as $format) {
            $viewModel->formats[] = $format;

            $resource = new \stdClass();
            $resource->format = $format;
            $resource->imgs = [];
            for ($i = 1; $i <= $this->num; $i++) {
                $relativePath = $this->img . '_' . $format . '_' . $i . '.' . $this->ext;
                $img = new \stdClass();
                $img->relativePath = $relativePath;
                $img->src = env('UPLOAD_URL') . $relativePath;
                $resource->imgs[] = $img;
            }
            $viewModel->resources[] = $resource;
        }
        return $viewModel;
    }

    public static function getEmptyViewModel()
    {
        $emptyViewModel = new \stdClass();
        $emptyViewModel->id = '';
        $emptyViewModel->url = '';
        $emptyViewModel->start_date = '';
        $emptyViewModel->end_date = '';
        $emptyViewModel->active = '';
        $emptyViewModel->resources = [];
        $emptyViewModel->formats = [];
        return $emptyViewModel;
    }
}