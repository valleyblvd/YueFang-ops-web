@extends('layouts.app')

@section('content')
    <h2>添加房源</h2>
    <a href="/properties">返回列表</a>
    <br>
    <br>
    @include('partial._error')
    <form method="POST" action="/properties">
        {!! csrf_field() !!}
        @include('property._form')
    </form>
@endsection