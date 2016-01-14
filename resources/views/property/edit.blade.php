@extends('layouts.app')

@section('content')
    <h2>编辑房源</h2>
    <a href="/properties">返回列表</a>
    <form method="POST" action="/properties/{{$record->Id}}">
        {!! csrf_field() !!}
        <input type="hidden" name="_method" value="PUT">
        <input type="text" name="DataSourceId" placeholder="DataSourceId" value="{{$record->DataSourceId}}"/>
        <input type="text" name="DataId" placeholder="DataId" value="{{$record->DataId}}"/><br><br>
        <input type="text" name="ReferenceUrl" placeholder="ReferenceUrl" value="{{$record->ReferenceUrl}}"/>
        <input type="text" name="PhotoUrls" placeholder="PhotoUrls" value="{{$record->PhotoUrls}}"/>
        <input type="text" name="MLSNumber" placeholder="MLSNumber" value="{{$record->MLSNumber}}"/><br><br>
        <input type="text" name="Status" placeholder="Status" value="{{$record->Status}}"/>
        <input type="text" name="StatusEnum" placeholder="StatusEnum" value="{{$record->Status}}"/><br><br>
        <input type="text" name="SaleType" placeholder="SaleType" value="{{$record->SaleType}}"/>
        <input type="text" name="SaleTypeEnum" placeholder="SaleTypeEnum" value="{{$record->SaleTypeEnum}}"/><br><br>
        <input type="text" name="PropertyType" placeholder="PropertyType" value="{{$record->PropertyType}}"/>
        <input type="text" name="PropertyTypeEnum" placeholder="PropertyTypeEnum" value="{{$record->PropertyTypeEnum}}"/><br><br>
        <input type="text" name="ListPrice" placeholder="ListPrice" value="{{$record->ListPrice}}"/>
        <input type="text" name="SalePrice" placeholder="SalePrice" value="{{$record->SalePrice}}"/>
        <input type="text" name="State" placeholder="State" value="{{$record->State}}"/><br><br>
        <input type="text" name="County" placeholder="County" value="{{$record->County}}"/>
        <input type="text" name="City" placeholder="City" value="{{$record->City}}"/>
        <input type="text" name="Address" placeholder="Address" value="{{$record->Address}}"/><br><br>
        <input type="text" name="PostalCode" placeholder="PostalCode" value="{{$record->PostalCode}}"/>
        <input type="text" name="Area" placeholder="Area" value="{{$record->Area}}"/>
        <input type="text" name="CrossStreets" placeholder="CrossStreets" value="{{$record->CrossStreets}}"/><br><br>
        <input type="text" name="Location" placeholder="Location" value="{{$record->Location}}"/>
        <input type="text" name="Description" placeholder="Description" value="{{$record->Description}}"/>
        <input type="text" name="YearBuilt" placeholder="YearBuilt" value="{{$record->YearBuilt}}"/><br><br>
        <input type="text" name="LotSqFt" placeholder="LotSqFt" value="{{$record->LotSqFt}}"/>
        <input type="text" name="StructureSqFt" placeholder="StructureSqFt" value="{{$record->StructureSqFt}}"/>
        <input type="text" name="Bedrooms" placeholder="Bedrooms" value="{{$record->Bedrooms}}"/><br><br>
        <input type="text" name="BathsFull" placeholder="BathsFull" value="{{$record->BathsFull}}"/>
        <input type="text" name="BathsHalf" placeholder="BathsHalf" value="{{$record->BathsHalf}}"/>
        <button type="submit">保存</button>
    </form>
    @include('partial._error')
@endsection

@section('js')
    <script>
    </script>
@endsection