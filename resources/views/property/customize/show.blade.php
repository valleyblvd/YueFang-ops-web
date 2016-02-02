@extends('layouts.app')
@section('pageTitle','房源标注详情')
@section('content')
    <a href="/properties/customize">返回列表</a>
    <a href="/properties/customize/{{$record->id}}/edit">编辑</a>
    <div>{{$record->sub_cat_id}}</div>
    @foreach($record->resources as $resource)
        <div>{{$resource->format}}</div>
        @foreach($resource->imgs as $img)
            <img src="{{$img->src}}" style="height:150px"/>
        @endforeach
        <hr>
    @endforeach
    <div>{{$record->listingID}}</div>
    <div>{{$record->title}}</div>
    <div>{{$record->lat}}</div>
    <div>{{$record->lng}}</div>
    <div>{{$record->address}}</div>
    <div>{{$record->city}}</div>
    <div>{{$record->state}}</div>
    <div>{{$record->zipcode}}</div>
@endsection