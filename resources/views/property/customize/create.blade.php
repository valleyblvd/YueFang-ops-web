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
            <input name="q" type="text"/>
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
                <select name="sub_cat_id">
                    @foreach($cats as $cat)
                        <optgroup label="{{$cat->name}}"></optgroup>
                        @foreach($cat->subCats as $subCat)
                            <option value="{{$subCat->id}}">{{$subCat->name}}</option>
                        @endforeach
                    @endforeach
                </select><br/><br/>
                <lable>listingID</lable>
                <input id="listingID" type="text" name="listingID" placeholder="listingID"/>
                <label>标题：</label><input type="text" name="title" placeholder="标题" required/><br/><br/>
                <label>纬度：</label><input id="lat" type="text" name="lat" placeholder="纬度"/>
                <label>经度：</label><input id="lng" type="text" name="lng" placeholder="经度"/><br/><br/>
                <label>地址</label><input id="address" type="text" name="address" placeholder="地址"/>
                <label>城市</label><input id="city" type="text" name="city" placeholder="城市"/><br/><br/>
                <label>州</label><input id="state" type="text" name="state" placeholder="州"/>
                <label>邮编</label><input id="zipcode" type="text" name="zipcode" placeholder="邮编"/>
                <hr/>
                @include('res._checkFormatField')
                <button type="submit" style="float:right;">保存</button>
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