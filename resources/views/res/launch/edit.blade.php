@extends('layouts.app')

@section('content')
    <h2>编辑开机启动资源</h2>
    <a href="/res/launch">返回列表</a>
    @include('partial._error')
    <form class="hasFormatField" method="POST" action="/res/launch/{{$model->id}}">
        {!! csrf_field() !!}
        <input type="hidden" name="_method" value="PUT">
        @include('res.launch._form')
    </form>
@endsection