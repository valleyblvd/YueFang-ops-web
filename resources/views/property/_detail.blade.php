<div>ListingId : {{$record->Id}}</div>
<div>DataSourceId : {{$record->DataSourceId}}</div>
<div>DataId : {{$record->DataId}}</div>
<div>MLSNumber : {{$record->MLSNumber}}</div>
<div>ListPrice : {{$record->ListPrice}}</div>
<div>State : {{$record->State}}</div>
<div>County : {{$record->County}}</div>
<div>City : {{$record->City}}</div>
<div>Address : {{$record->Address}}</div>
<div>PostalCode : {{$record->PostalCode}}</div>
<div style="max-width: 600px;;overflow: auto;white-space: nowrap;">Description : {{$record->Description}}</div>
<div>LotSqFt : {{$record->LotSqFt}}</div>
<div>Bedrooms : {{$record->Bedrooms}}</div>
<div>BathsFull : {{$record->BathsFull}}</div>
<div>BathsHalf : {{$record->BathsHalf}}</div>
<div>GarageSpaces : {{$record->GarageSpaces}}</div>
<div>Location : {{$record->Location}}</div>
<div style="max-width:600px;overflow: auto;white-space: nowrap;">
    @if($record->PhotoUrls)
        @foreach(explode(',',$record->PhotoUrls) as $url)
            <img src="{{$url}}" width="50" height="50"/>
        @endforeach
    @endif
</div>