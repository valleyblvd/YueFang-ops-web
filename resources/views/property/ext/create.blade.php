@extends('layouts.app')

@section('content')
    <h2>添加房源标签</h2>
    <a href="/properties/ext">返回列表</a>
    <form method="POST" action="/properties/ext">
        {!! csrf_field() !!}
        @include('property.ext._form')
    </form>
    @include('partial._error')
@endsection