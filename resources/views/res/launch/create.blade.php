@extends('layouts.app')

@section('content')
    <h2>添加开机启动资源</h2>
    <a href="/res/launch">返回列表</a>
    @include('partial._error')
    <form class="hasFormatField" method="POST" action="/res/launch">
        {!! csrf_field() !!}
        <div>
            <select name="type" onchange="changeType(this)">
                <option value="0" selected>launch screen image</option>
                <option value="1">launch ad image</option>
                <option value="2">guide image</option>
                <option value="3">home page html</option>
            </select>
        </div>
        <div id="formatWrapper">
            @include('res._checkFormatField')
        </div>
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