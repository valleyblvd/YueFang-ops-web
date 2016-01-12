<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PropertySubCat extends Model
{
    protected $table = 'property_subcat';
    public $timestamps = false;

    public function cat()
    {
        return $this->belongsToMany('App\Models\PropertyCat','p_cat_id');
    }
}
