@extends('layouts.app')

@section('content')
    <h2>房源标注</h2>
    <a href="/properties/customize">返回列表</a>
    @include('partial._error')
    <fieldset>
        <legend>通过MLSID或第三方网站URL获取房源</legend>
        <form id="searchForm" method="GET" action="/properties/fetch">
            <select name="type">
                <option value="0">MLSID</option>
                <option value="1" selected>URL</option>
            </select>
            <input name="q" type="text" required/>
            <button id="searchBtn" type="submit">获取</button>
        </form>
    </fieldset>
    <fieldset>
        <legend>房源信息/结果</legend>
        <div id="searchResult">

        </div>
    </fieldset>
    <fieldset>
        <legend>标注信息</legend>
        <div>
            <form class="hasFormatField" method="POST" action="/properties/customize">
                {!! csrf_field() !!}
                @include('property.customize._form')
            </form>
        </div>
    </fieldset>
@endsection

@section('js')
    <script>
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