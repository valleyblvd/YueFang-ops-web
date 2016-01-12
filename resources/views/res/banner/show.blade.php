@extends('layouts.app')

@section('content')
    <a href="/res/banner">返回列表</a>
    <a href="/res/banner/{{$banner->id}}/edit">编辑</a>
    @foreach($banner->resources as $resource)
        <div>{{$resource->format}}</div>
        @foreach($resource->imgs as $img)
            <img src="{{$img->src}}" style="height:150px"/>
        @endforeach
        <hr>
    @endforeach
    <div>{{$banner->url}}</div>
    <div>{{$banner->start_date}}</div>
    <div>{{$banner->end_date}}</div>
    <div>{{$banner->active==1?'已启用':'已禁用'}}</div>

@endsection