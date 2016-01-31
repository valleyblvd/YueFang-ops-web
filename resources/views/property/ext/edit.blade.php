@extends('layouts.app')

@section('content')
    <h2>编辑房源标签</h2>
    <a href="/properties/ext">返回列表</a>
    <form method="POST" action="/properties/ext/{{$model->id}}">
        {!! csrf_field() !!}
        <input type="hidden" name="_method" value="PUT"/>
        @include('property.ext._form')
    </form>
    @include('partial._error')
@endsection