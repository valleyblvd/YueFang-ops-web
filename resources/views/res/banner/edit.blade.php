@extends('layouts.app')

@section('content')
    <h2>编辑Banner</h2>
    <a href="/res/banner">返回列表</a>
    @include('partial._error')
    <form class="hasFormatField" method="POST" action="/res/banner/{{$model->id}}">
        {!! csrf_field() !!}
        <input type="hidden" name="_method" value="PUT">
        @include('res.banner._form')
    </form>
@endsection