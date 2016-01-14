@extends('layouts.app')

@section('content')
    <a href="/properties">返回列表</a>
    <a href="/properties/{{$record->Id}}/edit">编辑</a>
    <div>{{$record->Id}}</div>
    <div>{{$record->DataSourceId}}</div>
    <div>{{$record->DataId}}</div>
    <div>{{$record->MLSNumber}}</div>
@endsection