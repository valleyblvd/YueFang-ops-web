@extends('layouts.app')

@section('content')
    <h2>添加房源</h2>
    <a href="/properties">返回列表</a>
    <form method="POST" action="/properties">
        {!! csrf_field() !!}
        <input type="text" name="DataSourceId" placeholder="DataSourceId"/>
        <input type="text" name="DataId" placeholder="DataId"/><br><br>
        <input type="text" name="ReferenceUrl" placeholder="ReferenceUrl"/>
        <input type="text" name="PhotoUrls" placeholder="PhotoUrls"/>
        <input type="text" name="MLSNumber" placeholder="MLSNumber"/><br><br>
        <input type="text" name="Status" placeholder="Status"/>
        <input type="text" name="StatusEnum" placeholder="StatusEnum"/><br><br>
        <input type="text" name="SaleType" placeholder="SaleType"/>
        <input type="text" name="SaleTypeEnum" placeholder="SaleTypeEnum"/><br><br>
        <input type="text" name="PropertyType" placeholder="PropertyType"/>
        <input type="text" name="PropertyTypeEnum" placeholder="PropertyTypeEnum"/><br><br>
        <input type="text" name="ListPrice" placeholder="ListPrice"/>
        <input type="text" name="SalePrice" placeholder="SalePrice"/>
        <input type="text" name="State" placeholder="State"/><br><br>
        <input type="text" name="County" placeholder="County"/>
        <input type="text" name="City" placeholder="City"/>
        <input type="text" name="Address" placeholder="Address"/><br><br>
        <input type="text" name="PostalCode" placeholder="PostalCode"/>
        <input type="text" name="Area" placeholder="Area"/>
        <input type="text" name="CrossStreets" placeholder="CrossStreets"/><br><br>
        <input type="text" name="Location" placeholder="Location"/>
        <input type="text" name="Description" placeholder="Description"/>
        <input type="text" name="YearBuilt" placeholder="YearBuilt"/><br><br>
        <input type="text" name="LotSqFt" placeholder="LotSqFt"/>
        <input type="text" name="StructureSqFt" placeholder="StructureSqFt"/>
        <input type="text" name="Bedrooms" placeholder="Bedrooms"/><br><br>
        <input type="text" name="BathsFull" placeholder="BathsFull"/>
        <input type="text" name="BathsHalf" placeholder="BathsHalf"/>
        <button type="submit">保存</button>
    </form>
    @include('partial._error')
@endsection