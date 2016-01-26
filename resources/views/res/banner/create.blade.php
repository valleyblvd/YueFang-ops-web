@extends('layouts.app')

@section('content')
    <h2>添加Banner</h2>
    <a href="/res/banner">返回列表</a>
    @include('partial._error')
    <form class="hasFormatField" method="POST" action="/res/banner">
        {!! csrf_field() !!}
        @include('res._checkFormatField')
        <input type="text" name="url" placeholder="url"/>
        <input type="text" name="start_date" placeholder="开始日期(必填)" required/>
        <input type="text" name="end_date" placeholder="结束日期(必填)" required/>
        <label><input type="checkbox" name="active"/>启用</label>
        <button type="submit">保存</button>
    </form>
@endsection

@section('js')
    <script>

    </script>
@endsection