@extends('layouts.app')
@section('pageTitle','编辑房源标注')
@section('content')
    <a href="/properties/customize">返回列表</a>
    <form class="hasFormatField" method="POST" action="/properties/customize/{{$model->id}}">
        {!! csrf_field() !!}
        <input type="hidden" name="_method" value="PUT">
        @include('property.customize._form')
    </form>
    @include('partial._error')
@endsection