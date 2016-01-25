<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PropertyCustomize extends Model
{
    protected $table = 'property_customize';
    public $timestamps = false;

    public function toViewModel()
    {
        $viewModel=new \stdClass();
        $viewModel->id = $this->id;
        $viewModel->sub_cat_id = $this->sub_cat_id;
        $viewModel->title = $this->title;
        $viewModel->lat = $this->lat;
        $viewModel->lng = $this->lng;
        $viewModel->address=$this->address;
        $viewModel->city=$this->city;
        $viewModel->state=$this->state;
        $viewModel->zipcode=$this->zipcode;
        $viewModel->listingID=$this->listingID;
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
}
