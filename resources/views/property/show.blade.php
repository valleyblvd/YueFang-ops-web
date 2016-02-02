@extends('layouts.app')
@section('pageTitle','房源详情')
@section('content')
    <a href="/properties">返回列表</a>
    <a href="/properties/{{$model->Id}}/edit">编辑</a>
    @include('property._detail')
@endsection