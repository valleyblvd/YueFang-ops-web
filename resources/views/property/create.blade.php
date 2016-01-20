@extends('layouts.app')

@section('content')
    <h2>添加房源</h2>
    <a href="/properties">返回列表</a>
    <br>
    <br>
    @include('partial._error')
    <fieldset>
        <legend>从第三方网站采集</legend>
        <form method="POST" action="/properties/ref">
            {!! csrf_field() !!}
            <input type="text" name="ref_url" placeholder="Url"/>
            <button type="submit">获取</button>
        </form>
        <div>
            <p>如：</p>

            <p>http://www.loopnet.com/xNet/MainSite/Listing/Profile/Profile.aspx?LID=19566204</p>

            <p>http://www.newhomesource.com/homedetail/planid-1085116</p>
        </div>
    </fieldset>
    <br>
    <form method="POST" action="/properties">
        {!! csrf_field() !!}
        <label>DataSourceId</label>
        <input type="text" name="DataSourceId" placeholder="DataSourceId" value="{{$DataSourceId}}"/>
        <label>DataId</label>
        <input type="text" name="DataId" placeholder="DataId" value="{{$DataId}}"/><br><br>
        <label>ReferenceUrl</label>
        <input type="text" name="ReferenceUrl" placeholder="ReferenceUrl" value="{{$ReferenceUrl}}"/>
        <label>PhotoUrls</label>
        <input type="text" name="PhotoUrls" placeholder="PhotoUrls" value="{{$PhotoUrls}}"/>
        <label>MLSNumber</label>
        <input type="text" name="MLSNumber" placeholder="MLSNumber"/><br><br>
        <label>Status</label>
        <input type="text" name="Status" placeholder="Status"/>
        <label>StatusEnum</label>
        <input type="text" name="StatusEnum" placeholder="StatusEnum"/><br><br>
        <label>SaleType</label>
        <input type="text" name="SaleType" placeholder="SaleType"/>
        <label>SaleTypeEnum</label>
        <input type="text" name="SaleTypeEnum" placeholder="SaleTypeEnum"/><br><br>
        <label>PropertyType</label>
        <input type="text" name="PropertyType" placeholder="PropertyType" value="{{$PropertyType}}"/>
        <label>PropertyTypeEnum</label>
        <input type="text" name="PropertyTypeEnum" placeholder="PropertyTypeEnum"/><br><br>
        <label>ListPrice</label>
        <input type="text" name="ListPrice" placeholder="ListPrice" value="{{$ListPrice}}"/>
        <label>SalePrice</label>
        <input type="text" name="SalePrice" placeholder="SalePrice"/>
        <label>State</label>
        <input type="text" name="State" placeholder="State"/><br><br>
        <label>County</label>
        <input type="text" name="County" placeholder="County"/>
        <label>City</label>
        <input type="text" name="City" placeholder="City"/>
        <label>Address</label>
        <input type="text" name="Address" placeholder="Address"/><br><br>
        <label>PostalCode</label>
        <input type="text" name="PostalCode" placeholder="PostalCode"/>
        <label>Area</label>
        <input type="text" name="Area" placeholder="Area"/>
        <label>CrossStreets</label>
        <input type="text" name="CrossStreets" placeholder="CrossStreets"/><br><br>
        <label>Location</label>
        <input type="text" name="Location" placeholder="Location" value="{{$Location}}"/>
        <label>Description</label>
        <input type="text" name="Description" placeholder="Description" value="{{$Description}}"/>
        <label>YearBuilt</label>
        <input type="text" name="YearBuilt" placeholder="YearBuilt"/><br><br>
        <label>LotSqFt</label>
        <input type="text" name="LotSqFt" placeholder="LotSqFt" value="{{$LotSqFt}}"/>
        <label>StructureSqFt</label>
        <input type="text" name="StructureSqFt" placeholder="StructureSqFt"/>
        <label>Bedrooms</label>
        <input type="text" name="Bedrooms" placeholder="Bedrooms" value="{{$Bedrooms}}"/><br><br>
        <label>BathsFull</label>
        <input type="text" name="BathsFull" placeholder="BathsFull" value="{{$BathFull}}"/>
        <label>BathsHalf</label>
        <input type="text" name="BathsHalf" placeholder="BathsHalf"/><br><br>
        <lable>GarageSpaces</lable>
        <input type="text" name="GarageSpaces" placeholder="GarageSpaces" value="{{$GarageSpaces}}"/>
        <lable>ParkingSpaces</lable>
        <input type="text" name="ParkingSpaces" placeholder="ParkingSpaces"/>
        <button type="submit">保存</button>
    </form>
@endsection