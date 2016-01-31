@extends('layouts.app')

@section('content')
    <h2>添加开机启动资源</h2>
    <a href="/res/launch">返回列表</a>
    @include('partial._error')
    <form class="hasFormatField" method="POST" action="/res/launch">
        {!! csrf_field() !!}
        @include('res.launch._form')
    </form>
@endsection