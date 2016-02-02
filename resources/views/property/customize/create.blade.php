@extends('layouts.app')
@section('pageTitle','添加房源标注')
@section('content')
    <a id="btn" href="/properties/customize" class="easyui-linkbutton" data-options="iconCls:'icon-back'">返回列表</a><br>
    <br>
    @include('partial._error')
    <div class="easyui-panel" title="通过MLSID或第三方网站URL获取房源" style="width:650px;">
        <div style="padding: 10px 20px;">
            <form id="searchForm" method="get" action="/properties/fetch">
                <select name="type" class="easyui-combobox">
                    <option value="0">MLSID</option>
                    <option value="1" selected>URL</option>
                </select>
                <input name="q" type="text" class="easyui-textbox" data-options="required:true"/>
                <a id="searchBtn" href="javascript:void(0)" class="easyui-linkbutton"
                   data-options="iconCls:'icon-search'"
                   onclick="submitForm1()">保存</a>
            </form>

        </div>
    </div>
    <br>
    <div class="easyui-panel" title="房源信息/结果" style="width:650px;">
        <div style="padding: 10px 20px;">
            <div id="searchResult">

            </div>
        </div>
    </div>
    <br>
    <div class="easyui-panel" title="标注信息" style="width:650px;">
        <div style="padding:10px 20px">
            <form id="ff" class="hasFormatField" method="post" action="/properties/customize">
                {!! csrf_field() !!}
                @include('property.customize._form')
            </form>
            <div style="text-align:center;padding:5px">
                <a href="javascript:void(0)" class="easyui-linkbutton" data-options="iconCls:'icon-save'"
                   onclick="submitForm()">保存</a>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        function submitForm1() {
            $('#searchForm').form('submit');
        }

        function submitForm() {
            $('#ff').form('submit');
        }

        $('#searchForm').ajaxForm({
            beforeSubmit: function () {
                $('#searchBtn').attr('disabled', 'disabled');
            },
            success: function (data) {
                $('#searchResult').html(data.view);
                $('#listingID').val(data.model.Id);
                $('#lat').val(data.model.Lat);
                $('#lng').val(data.model.Lng);
                $('#address').val(data.model.Address);
                $('#city').val(data.model.City);
                $('#state').val(data.model.State);
                $('#zipcode').val(data.model.PostalCode);
            },
            complete: function () {
                $('#searchBtn').removeAttr('disabled');
            }
        });
    </script>
@endsection