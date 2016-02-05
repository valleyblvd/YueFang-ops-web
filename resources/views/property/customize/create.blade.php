@extends('layouts.app')
@section('pageTitle','添加房源标注')
@section('content')
    <a id="btn" href="/properties/customize" class="easyui-linkbutton" data-options="iconCls:'icon-back'">返回列表</a><br>
    <br>
    @include('partial._error')
    <div id="tt" class="easyui-tabs">
        <div title="房源采集" style="padding:20px;">
            <div class="easyui-panel" title="通过MLSID或第三方网站URL获取房源" style="width:650px;">
                <div style="padding: 10px 20px;">
                    <form id="searchForm">
                        <select name="type" class="easyui-combobox">
                            <option value="0">MLSID</option>
                            <option value="1" selected>URL</option>
                        </select>
                        <input name="q" type="text" class="easyui-textbox" data-options="required:true"/>
                        <button type="submit" class="easyui-linkbutton"
                                data-options="iconCls:'icon-search'">获取
                        </button>
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
        </div>
        <div title="房源标注" data-options="" style="padding:20px;">
            <div class="easyui-panel" title="标注信息" style="width: 650px;">
                <div style="padding:10px 20px">
                    <form id="customizeForm" class="hasFormatField" method="post" action="/properties/customize"
                          onsubmit="return check()">
                        {!! csrf_field() !!}
                        @include('property.customize._form')
                        <button type="submit" class="easyui-linkbutton" data-options="iconCls:'icon-save'"
                                onsubmit="check()">保存
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        $('#searchForm').submit(function (e) {
            e.preventDefault();
            var form = $(this);
            if (!form.form('enableValidation').form('validate'))
                return false;
            var submitBtn = form.find('button[type=submit]').eq(0);
            submitBtn.linkbutton('disable');
            $.get('/properties/fetch', form.serialize(), function (data) {
                $('#searchResult').html(data.view);
                var lat, lng;
                try {
                    var s = data.model.Location.replace('POINT', '').replace('(', '').replace(')', '');
                    lat = s.split(' ')[0];
                    lng = s.split(' ')[1];
                } catch (e) {

                }
                $('#customizeForm').form('load', {
                    listingID: data.model.Id,
                    lat: lat,
                    lng: lng,
                    address: data.model.Address,
                    city: data.model.City,
                    state: data.model.State,
                    zipcode: data.model.PostalCode
                });
            }).error(function (xhr) {
                alert(xhr.responseJSON.message);
            }).complete(function () {
                submitBtn.linkbutton('enable');
            });
        });

        var check = function () {
            return $('#customizeForm').form('enableValidation').form('validate');
        }

    </script>
@endsection