@extends('layouts.app')

@section('content')
    <a href="/res/launch">返回列表</a>
    <a href="/res/launch/{{$record->id}}/edit">编辑</a>
    <div>{{$record->type}}</div>
    @foreach($record->resources as $resource)
        <div>{{$resource->format}}</div>
        @foreach($resource->imgs as $img)
            <img src="{{$img->src}}" style="height:150px"/>
        @endforeach
        <hr>
    @endforeach
    <div>{{$record->url}}</div>
    <div>{{$record->start_date}}</div>
    <div>{{$record->end_date}}</div>
    <div>{{$record->active==1?'已启用':'已禁用'}}</div>

@endsection