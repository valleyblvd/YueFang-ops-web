@extends('layouts.app')

@section('content')
    <h2>添加Banner</h2>
    <a href="/res/banner">返回列表</a>
    @include('partial._error')
    <form class="hasFormatField" method="POST" action="/res/banner">
        {!! csrf_field() !!}
        @include('res.banner._form')
    </form>
@endsection