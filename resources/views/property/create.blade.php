@extends('layouts.app')
@section('pageTitle','添加房源')
@section('content')
    <a href="/properties" class="easyui-linkbutton" data-options="iconCls:'icon-back'">返回列表</a>
    <br>
    @include('partial._error')
    <form id="createPropertyForm" method="post" action="/properties">
        {!! csrf_field() !!}
        @include('property._form')
    </form>
    <div style="text-align:center;padding:5px">
        <a href="javascript:void(0)" class="easyui-linkbutton" data-options="iconCls:'icon-save'"
           onclick="submit()">保存</a>
    </div>
@endsection
@section('js')
    <script>
        function submit() {
            $('#createPropertyForm').form('submit');
        }
    </script>
@endsection