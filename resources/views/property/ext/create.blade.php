@extends('layouts.app')

@section('content')
    <h2>添加房源标签</h2>
    <a href="/properties/ext">返回列表</a>
    <form method="POST" action="/properties/ext">
        {!! csrf_field() !!}
        <input type="text" name="mlsId" placeholder="mlsId"/>
        <input type="text" name="tag" placeholder="标签"/>
        <label><input type="checkbox" name="hot"/>热门</label>
        <label><input type="checkbox" name="recommended"/>推荐</label>
        <button type="submit">保存</button>
    </form>
    @include('partial._error')
@endsection