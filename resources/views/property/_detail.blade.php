<div>ListingId : {{$model->Id}}</div>
<div>DataSourceId : {{$model->DataSourceId}}</div>
<div>DataId : {{$model->DataId}}</div>
<div>MLSNumber : {{$model->MLSNumber}}</div>
<div>ListPrice : {{$model->ListPrice}}</div>
<div>State : {{$model->State}}</div>
<div>County : {{$model->County}}</div>
<div>City : {{$model->City}}</div>
<div>Address : {{$model->Address}}</div>
<div>PostalCode : {{$model->PostalCode}}</div>
<div style="max-width: 600px;;overflow: auto;white-space: nowrap;">Description : {{$model->Description}}</div>
<div>LotSqFt : {{$model->LotSqFt}}</div>
<div>Bedrooms : {{$model->Bedrooms}}</div>
<div>BathsFull : {{$model->BathsFull}}</div>
<div>BathsHalf : {{$model->BathsHalf}}</div>
<div>GarageSpaces : {{$model->GarageSpaces}}</div>
<div>Location : {{$model->Location}}</div>
<div style="max-width:600px;overflow: auto;white-space: nowrap;">
    @if($model->PhotoUrls)
        @foreach(explode(',',$model->PhotoUrls) as $url)
            <img src="{{$url}}" width="50" height="50"/>
        @endforeach
    @endif
</div>