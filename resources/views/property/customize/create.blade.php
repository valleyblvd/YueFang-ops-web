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
            <form id="createForm" method="POST" action="/properties/customize">
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
                <input id="listingID" type="text" name="listingID" placeholder="listingID" readonly/>
                <label>title</label><input type="text" name="title" placeholder="标题" required/><br/><br/>
                <label>lat</label><input id="lat" type="text" name="lat" placeholder="lat"/>
                <label>lng</label><input id="lng" type="text" name="lng" placeholder="lng"/><br/><br/>
                <label>address</label><input id="address" type="text" name="address" placeholder="地址"/>
                <label>city</label><input id="city" type="text" name="city" placeholder="城市"/><br/><br/>
                <label>state</label><input id="state" type="text" name="state" placeholder="州"/>
                <label>zipcode</label><input id="zipcode" type="text" name="zipcode" placeholder="邮编"/>
                <hr/>
                @foreach($formats as $format)
                    <div id="{{$format['id']}}">
                        <label><input type="checkbox" class="format" name="formats[]"
                                      value="{{$format['id']}}"/>{{$format['name']}}</label>

                        <div class="imgList {{$format['id']}}">
                            <div class="clearfix" style="clear:both;"></div>
                        </div>
                        <div style="clear:both;"></div>
                        <button type="button" class="uploadBannerBtn" onclick="uploadBanner('{{$format['id']}}')">上传图片
                        </button>
                    </div>
                    <hr>
                @endforeach
                <button type="submit" style="float:right;">保存</button>
            </form>
        </div>
    </fieldset>

    <form id="uploadBannerForm" method="POST" action="/files" enctype="multipart/form-data" style="display:none;">
        {!! csrf_field() !!}
        <input type="file" name="file" onchange="submitUploadForm()"/>
    </form>
@endsection

@section('js')
    <script>
        $('#createForm').submit(function () {
            var form = $(this);
            //检查是否勾选设备
            var formats = form.find('input[name="formats[]"]:checked');
            if (!formats || formats.length == 0) {
                alert('请选择设备！');
                return false;
            }
            //如果有勾选设备，判断是否上传照片
            var imgNum = -1;//标志各个设备上传的照片个数是否一致
            var hasError = false;
            formats.each(function (i, e) {
                var value = $(e).val();
                var imgs = form.find('input[name="' + value + '[]"]');
                if (imgs.length == 0) {
                    alert('请您为选择的设备上传照片！');
                    hasError = true;
                    return false;
                }
                if (imgNum == -1) {
                    imgNum = imgs.length;
                } else {
                    if (imgNum != imgs.length) {
                        alert('各个设备照片数量不一致！');
                        hasError = true;
                        return false;
                    }
                }
            });
            return !hasError;
        });
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
                $('#searchResult').html(data.view);
                $('#listingID').val(data.record.Id);
                $('#lat').val(data.record.Lat);
                $('#lng').val(data.record.Lng);
                $('#address').val(data.record.Address);
                $('#city').val(data.record.City);
                $('#state').val(data.record.State);
                $('#zipcode').val(data.record.PostalCode);
            },
            complete: function () {
                $('#searchBtn').removeAttr('disabled');
            }
        });
    </script>
@endsection