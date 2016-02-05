<div>ListingId ： {{$model->Id}}</div>
<div>DataSourceId ： {{$model->DataSourceId}}</div>
<div>DataId ： {{$model->DataId}}</div>
<div>数据源Url ： {{$model->ReferenceUrl}}</div>
<div>MLSNumber ： {{$model->MLSNumber}}</div>
<div> 房源类型 ： {{$model->PropertyType}}</div>
<div>挂牌价 ： {{$model->ListPrice}}</div>
<div>州 ： {{$model->State}}</div>
<div>县/郡 ： {{$model->County}}</div>
<div>城市 ： {{$model->City}}</div>
<div>门牌号 街道名 ： {{$model->Address}}</div>
<div>邮编 ： {{$model->PostalCode}}</div>
<div style="max-width: 600px;overflow: auto;white-space: nowrap;">房源描述 ： {{$model->Description}}</div>
<div>土地面积： {{$model->LotSqFt}} SqFt</div>
<div>建筑面积： {{$model->StructureSqFt}} SqFt</div>
<div>卧室数 ： {{$model->Bedrooms}}</div>
<div>带浴缸的厕所数 ： {{$model->BathsFull}}</div>
<div>能洗澡的厕所数 ： {{$model->BathsHalf}}</div>
<div>车库数 ： {{$model->GarageSpaces}}</div>
<div>车位数 ： {{$model->ParkingSpaces}}</div>
<div>经纬度 ： {{$model->Location}}</div>
<div style="max-width:600px;overflow:auto;white-space:nowrap;">
    @if($model->PhotoUrls)
        @foreach(explode(',',$model->PhotoUrls) as $url)
            <img src="{{$url}}" width="50" height="50"/>
        @endforeach
    @endif
</div>