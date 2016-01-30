@extends('layouts.app')

@section('content')
    <h2>添加房源</h2>
    <a href="/properties">返回列表</a>
    <br>
    <br>
    @include('partial._error')
    {{--<fieldset>--}}
        {{--<legend>从第三方网站采集</legend>--}}
        {{--<form method="POST" action="/properties/ref">--}}
            {{--{!! csrf_field() !!}--}}
            {{--<input type="text" name="ref_url" placeholder="Url"/>--}}
            {{--<button type="submit">获取</button>--}}
        {{--</form>--}}
        {{--<div>--}}
            {{--<p>如：</p>--}}

            {{--<p>http://www.loopnet.com/xNet/MainSite/Listing/Profile/Profile.aspx?LID=19566204</p>--}}

            {{--<p>http://www.newhomesource.com/homedetail/planid-1085116</p>--}}
        {{--</div>--}}
    {{--</fieldset>--}}
    {{--<br>--}}
    <form method="POST" action="/properties">
        {!! csrf_field() !!}
        <label>DataSourceId</label>
        <input type="text" name="DataSourceId" placeholder="DataSourceId" value="{{$DataSourceId}}"/>
        <label>DataId</label>
        <input type="text" name="DataId" placeholder="DataId" value="{{$DataId}}"/><br><br>
        <label>数据源Url</label>
        <input type="text" name="ReferenceUrl" placeholder="ReferenceUrl" value="{{$ReferenceUrl}}"/>
        <label>照片Url（以逗号分开）</label>
        <input type="text" name="PhotoUrls" placeholder="PhotoUrls" value="{{$PhotoUrls}}"/>
        <label>MLSNumber</label>
        <input type="text" name="MLSNumber" placeholder="MLSNumber"/><br><br>
        <label>挂牌价</label>
        <input type="text" name="ListPrice" placeholder="ListPrice" value="{{$ListPrice}}"/>
        <label>成交价</label>
        <input type="text" name="SalePrice" placeholder="SalePrice"/>
        <label>州</label>
        <input type="text" name="State" placeholder="State" value="{{$State}}"/><br><br>
        <label>县/郡</label>
        <input type="text" name="County" placeholder="County" value="{{$County}}"/>
        <label>城市</label>
        <input type="text" name="City" placeholder="City" value="{{$City}}"/>
        <label>门牌号 街道名</label>
        <input type="text" name="Address" placeholder="Address" value="{{$Address}}"/><br><br>
        <label>邮编</label>
        <input type="text" name="PostalCode" placeholder="PostalCode" value="{{$PostalCode}}"/>
        <label>社区名</label>
        <input type="text" name="Area" placeholder="Area"/>
        <label>相邻街道</label>
        <input type="text" name="CrossStreets" placeholder="CrossStreets"/><br><br>
        <label>经纬度</label>
        <input type="text" name="Location" placeholder="Location" value="{{$Location}}"/>
        <label>房源描述</label>
        <input type="text" name="Description" placeholder="Description" value="{{$Description}}"/>
        <label>修建时间</label>
        <input type="text" name="YearBuilt" placeholder="YearBuilt"/><br><br>
        <label>土地面积（SqFt:平方英尺）</label>
        <input type="text" name="LotSqFt" placeholder="LotSqFt" value="{{$LotSqFt}}"/>
        <label>建筑面积</label>
        <input type="text" name="StructureSqFt" placeholder="StructureSqFt" value="{{$StructureSqFt}}"/>
        <label>卧室数</label>
        <input type="text" name="Bedrooms" placeholder="Bedrooms" value="{{$Bedrooms}}"/><br><br>
        <label>带浴缸的厕所数</label>
        <input type="text" name="BathsFull" placeholder="BathsFull" value="{{$BathFull}}"/>
        <label>不能洗澡的厕所数</label>
        <input type="text" name="BathsHalf" placeholder="BathsHalf" value="{{$BathHalf}}"/><br><br>
        <lable>车库数</lable>
        <input type="text" name="GarageSpaces" placeholder="GarageSpaces" value="{{$GarageSpaces}}"/>
        <lable>车位数</lable>
        <input type="text" name="ParkingSpaces" placeholder="ParkingSpaces"/>
        <button type="submit">保存</button>
    </form>
@endsection