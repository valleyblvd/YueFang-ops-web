<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class PropertyExt extends Model
{
    protected $table = "property_ext";

    public function toViewModel()
    {
        $viewModel = new \stdClass();
        $viewModel->id = $this->id;
        $viewModel->mlsId = $this->mlsId;
        $viewModel->tag = $this->tag;
        $viewModel->hot = $this->hot;
        $viewModel->hot_display = $this->hot ? '热门' : '';
        $viewModel->recommended = $this->recommended;
        $viewModel->recommended_display = $this->recommended ? '推荐' : '';
        return $viewModel;
    }

    public static function getEmptyViewModel()
    {
        $emptyViewModel = new \stdClass();
        $emptyViewModel->mlsId = '';
        $emptyViewModel->tag = '';
        $emptyViewModel->hot = '';
        $emptyViewModel->recommended = '';
        return $emptyViewModel;
    }
}