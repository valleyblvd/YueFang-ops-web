@extends('layouts.app')

@section('content')
    <h2>编辑房源标注</h2>
    <a href="/properties/customize">返回列表</a>
    <form class="hasFormatField" method="POST" action="/properties/customize/{{$model->id}}">
        {!! csrf_field() !!}
        <input type="hidden" name="_method" value="PUT">
        @include('property.customize._form')
    </form>
    @include('partial._error')
@endsection