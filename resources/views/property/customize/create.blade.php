@extends('layouts.app')

@section('content')
    <h2>房源标注</h2>
    <a href="/properties/customize">返回列表</a>
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
            <form method="POST" action="/properties/customize">
                {!! csrf_field() !!}
                <select name="sub_cat_id">
                    @foreach($cats as $cat)
                        <optgroup label="{{$cat->name}}"></optgroup>
                        @foreach($cat->subCats as $subCat)
                            <option value="{{$subCat->id}}">{{$subCat->name}}</option>
                        @endforeach
                    @endforeach
                </select>
                @foreach($formats as $format)
                    <div id="{{$format['id']}}">
                        <input type="checkbox" class="format" name="formats[]"
                               value="{{$format['id']}}"/>{{$format['name']}}
                        <div class="imgList {{$format['id']}}">
                            <div class="clearfix" style="clear:both;"></div>
                        </div>
                        <div style="clear:both;"></div>
                        <button type="button" class="uploadBannerBtn" onclick="uploadBanner('{{$format['id']}}')">上传图片
                        </button>
                    </div>
                    <hr>
                @endforeach
                <input id="listingID" type="text" name="listingID" placeholder="listingID" disabled="disabled"/>
                <input type="text" name="title" placeholder="标题" required/>
                <input type="text" name="lat" placeholder="lat"/>
                <input type="text" name="lng" placeholder="lng"/><br/><br/>
                <input type="text" name="address" placeholder="地址"/>
                <input type="text" name="city" placeholder="城市"/>
                <input type="text" name="state" placeholder="州"/>
                <input type="text" name="zipcode" placeholder="邮编"/>
                <button type="submit">保存</button>
            </form>
        </div>
    </fieldset>

    @include('partial._error')
    <form id="uploadBannerForm" method="POST" action="/files" enctype="multipart/form-data" style="display:none;">
        {!! csrf_field() !!}
        <input type="file" name="file" onchange="submitUploadForm()"/>
    </form>
@endsection

@section('js')
    <script>
        var uploadForm = $('#uploadBannerForm');
        uploadForm.ajaxForm(function (data) {
            var format = uploadForm.data('format');
            $('.imgList.' + format + ' .clearfix').before('<div class="imgWrapper">' +
                    '<img src="' + data.url + '" style="height:150px;" />' +
                    '<input type="hidden" name="' + format + '[]" value="' + data.relativePath + '" /><br>' +
                    '<a href="javascript:;" onclick="deleteImg(this)">删除</a>' +
                    '</div>');
            uploadForm.data('format', '');
            uploadForm.resetForm();
            $('.imgList').dragsort('destroy');
            $('.imgList').dragsort({
                dragSelector: '.imgWrapper'
            });
        });

        var submitUploadForm = function () {
            uploadForm.submit();
        };

        var uploadBanner = function (format) {
            uploadForm.data('format', format);
            uploadForm.find('input[type=file]').click();
        };

        var deleteImg = function (delBtn) {
            $(delBtn).parents('.imgWrapper').remove();
        };

        $('#searchForm').ajaxForm({
            beforeSubmit: function () {
                $('#searchBtn').attr('disabled', 'disabled');
            },
            success: function (data) {
                $('#listingID').val(data.record.Id);
                $('#searchResult').html(data.view);
            },
            complete: function () {
                $('#searchBtn').removeAttr('disabled');
            }
        });
    </script>
@endsection