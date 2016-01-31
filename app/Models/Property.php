<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Property extends Model
{
    protected $table = 'residences';
    protected $primaryKey = 'Id';
    public $timestamps = false;

    //geometry类型字段作为text返回
    //http://stackoverflow.com/questions/22360969/laravel-model-with-point-polygon-etc-using-dbraw-expressions
    //https://www.codetutorial.io/geo-spatial-mysql-laravel-5/
    /*开始Geometry的处理*/
    protected $geometryFields = ['Location'];
    protected $geometryAsText = true;

    public function setLocationAttribute($value)
    {
        $this->attributes['Location'] = DB::raw("POINT($value)");
    }

    public function getLocationAttribute($value)
    {
        $loc = substr($value, 6);
        $loc = preg_replace('/[ ,]+/', ',', $loc, 1);
        return substr($loc, 0, -1);
    }

    public function newQuery($excludeDeleted = true)
    {
        if (!empty($this->geometryFields) && $this->geometryAsText === true) {
            $raw = '';
            foreach ($this->geometryFields as $column) {
                $raw .= 'AsText(`' . $this->table . '`.`' . $column . '`) as `' . $column . '`, ';
            }
            $raw = substr($raw, 0, -2);
            return parent::newQuery($excludeDeleted)->addSelect('*', DB::raw($raw));
        }
        return parent::newQuery($excludeDeleted);
    }

    /*结束Geometry的处理*/

    public function fromRequest($request)
    {
        $this->DataSourceId = $request->input("DataSourceId");
        $this->DataId = $request->input("DataId");
        $this->ReferenceUrl = $request->input("ReferenceUrl");
        $this->PhotoUrls = $request->input("PhotoUrls");
        $this->MLSNumber = $request->input("MLSNumber");
        $this->Status = $request->input("Status");
        $this->StatusEnum = $request->input("StatusEnum");
        $this->SaleType = $request->input("SaleType");
        $this->SaleTypeEnum = $request->input("SaleTypeEnum");
        $this->PropertyType = $request->input("PropertyType");
        $this->PropertyTypeEnum = $request->input("PropertyTypeEnum");
        $this->ListPrice = $request->input("ListPrice");
        $this->SalePrice = $request->input("SalePrice");
        $this->State = $request->input("State");
        $this->County = $request->input("County");
        $this->City = $request->input("City");
        $this->Address = $request->input("Address");
        $this->PostalCode = $request->input("PostalCode");
        $this->Area = $request->input("Area");
        $this->CrossStreets = $request->input("CrossStreets");
        $this->Location = DB::raw($request->input("Location"));
        $this->Description = $request->input("Description");
        $this->YearBuilt = $request->input("YearBuilt");
        $this->LotSqFt = $request->input("LotSqFt");
        $this->StructureSqFt = $request->input("StructureSqFt");
        $this->Bedrooms = $request->input("Bedrooms");
        $this->BathsFull = $request->input("BathsFull");
        $this->BathsHalf = $request->input("BathsHalf");
    }

    public static function getEmptyViewModel()
    {
        $emptyViewModel = new \stdClass();
        $emptyViewModel->DataSourceId = '';
        $emptyViewModel->DataId = '';
        $emptyViewModel->ReferenceUrl = '';
        $emptyViewModel->ListPrice = '';
        $emptyViewModel->PhotoUrls = '';
        $emptyViewModel->Bedrooms = '';
        $emptyViewModel->BathFull = '';
        $emptyViewModel->BathHalf = '';
        $emptyViewModel->LotSqFt = '';
        $emptyViewModel->StructureSqFt = '';
        $emptyViewModel->GarageSpaces = '';
        $emptyViewModel->Description = '';
        $emptyViewModel->PropertyType = '';
        $emptyViewModel->State = '';
        $emptyViewModel->County = '';
        $emptyViewModel->City = '';
        $emptyViewModel->Address = '';
        $emptyViewModel->PostalCode = '';
        $emptyViewModel->Location = '';
        return $emptyViewModel;
    }
}
