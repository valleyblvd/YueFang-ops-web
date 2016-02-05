@extends('layouts.app')
@section('pageTitle','编辑房源标注')
@section('content')
    <a href="/properties/customize">返回列表</a>
    <form id="customizeForm" class="hasFormatField" method="POST" action="/properties/customize/{{$model->id}}">
        {!! csrf_field() !!}
        <input type="hidden" name="_method" value="PUT">
        @include('property.customize._form')
        <button type="submit" class="easyui-linkbutton" data-options="iconCls:'icon-save'"
                onsubmit="check()">保存
        </button>
    </form>
    @include('partial._error')
@endsection
@section('js')
    <script>
        var check = function () {
            return $('#customizeForm').form('enableValidation').form('validate');
        }
    </script>
@endsection