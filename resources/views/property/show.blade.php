@extends('layouts.app')

@section('content')
    <a href="/properties">返回列表</a>
    <a href="/properties/{{$model->Id}}/edit">编辑</a>
    @include('property._detail')
@endsection