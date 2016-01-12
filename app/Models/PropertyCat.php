<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PropertyCat extends Model
{
    protected $table = 'property_cat';
    public $timestamps = false;

    public function subCats()
    {
        return $this->hasMany('App\Models\PropertySubCat', 'p_cat_id');
    }
}
