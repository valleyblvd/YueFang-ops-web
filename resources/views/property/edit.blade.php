@extends('layouts.app')
@section('pageTitle','编辑房源')
@section('content')
    <a href="/properties">返回列表</a>
    <form method="POST" action="/properties/{{$model->Id}}">
        {!! csrf_field() !!}
        <input type="hidden" name="_method" value="PUT"/>
        @include('property._form')
    </form>
    @include('partial._error')
@endsection