@extends('layouts.app')

@section('content')
    <a href="/properties/ext">返回列表</a>
    <a href="/properties/ext/{{$record->id}}/edit">编辑</a>
    <div>{{$record->mlsId}}</div>
    <div>{{$record->tag}}</div>
    <div>{{$record->hot}}</div>
    <div>{{$record->recommended}}</div>
@endsection