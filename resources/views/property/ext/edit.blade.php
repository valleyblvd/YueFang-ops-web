@extends('layouts.app')

@section('content')
    <h2>编辑房源标签</h2>
    <a href="/properties/ext">返回列表</a>
    <form method="POST" action="/properties/ext/{{$record->id}}">
        {!! csrf_field() !!}
        <input type="hidden" name="_method" value="PUT">
        <input type="text" name="mlsId" placeholder="mlsId" value="{{$record->mlsId}}"/>
        <input type="text" name="tag" placeholder="标签" value="{{$record->tag}}"/>
        <label><input type="checkbox" name="hot" {{$record->hot?'checked':''}}/>热门</label>
        <label><input type="checkbox" name="recommended" {{$record->recommended?'checked':''}}/>推荐</label>
{{--        <label><input type="checkbox" name="recommended" {{checked($record->recommended)}}/>推荐</label>--}}
        <button type="submit">保存</button>
    </form>
    @include('partial._error')
@endsection

@section('js')
    <script>
    </script>
@endsection