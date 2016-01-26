@extends('layouts.app')

@section('content')
    <h2>编辑Banner</h2>
    <a href="/res/banner">返回列表</a>
    @include('partial._error')
    <form class="hasFormatField" method="POST" action="/res/banner/{{$model->id}}">
        {!! csrf_field() !!}
        <input type="hidden" name="_method" value="PUT">
        @include('res._checkFormatField_edit')
        <input type="text" name="url" placeholder="url" value="{{$model->url}}"/>
        <input type="text" name="start_date" placeholder="开始日期" value="{{$model->start_date}}" required/>
        <input type="text" name="end_date" placeholder="结束日期" value="{{$model->end_date}}" required/>
        <label><input type="checkbox" name="active" {{$model->active==1?'checked':''}} />启用</label>
        <button type="submit">保存</button>
    </form>
@endsection

@section('js')
    <script>

    </script>
@endsection