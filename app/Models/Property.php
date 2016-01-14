<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    protected $table = 'residences';
    public $timestamps = false;

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
        $this->Location = $request->input("Location");
        $this->Description = $request->input("Description");
        $this->YearBuilt = $request->input("YearBuilt");
        $this->LotSqFt = $request->input("LotSqFt");
        $this->StructureSqFt = $request->input("StructureSqFt");
        $this->Bedrooms = $request->input("Bedrooms");
        $this->BathsFull = $request->input("BathsFull");
        $this->BathsHalf = $request->input("BathsHalf");
    }
}
