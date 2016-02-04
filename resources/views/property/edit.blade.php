@extends('layouts.app')
@section('pageTitle','编辑房源')
@section('content')
    <a href="/properties" class="easyui-linkbutton" data-options="iconCls:'icon-back'">返回列表</a>
    <br>
    <form id="editPropertyForm" method="post" action="/properties/{{$model->Id}}">
        {!! csrf_field() !!}
        <input type="hidden" name="_method" value="PUT"/>
        @include('property._form')
    </form>
    <div style="text-align:center;padding:5px">
        <a href="javascript:void(0)" class="easyui-linkbutton" data-options="iconCls:'icon-save'"
           onclick="submit()">保存</a>
    </div>
    @include('partial._error')
@endsection
@section('js')
    <script>
        function submit() {
            $('#editPropertyForm').form('submit');
        }
    </script>
@endsection