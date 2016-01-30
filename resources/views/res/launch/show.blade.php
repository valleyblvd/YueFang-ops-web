@extends('layouts.app')

@section('content')
    <a href="/res/launch">返回列表</a>
    <a href="/res/launch/{{$model->id}}/edit">编辑</a>
    <div>{{$model->type_display}}</div>
    @foreach($model->resources as $resource)
        <div>{{$resource->format}}</div>
        @foreach($resource->imgs as $img)
            <img src="{{$img->src}}" style="height:150px"/>
        @endforeach
        <hr>
    @endforeach
    <div>Url：{{$model->url}}</div>
    <div>开始日期：{{$model->start_date}}</div>
    <div>结束日期：{{$model->end_date}}</div>
    <div>启用：{{$model->active_display}}</div>

@endsection