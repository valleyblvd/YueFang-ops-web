@extends('layouts.app')

@section('content')
    <h2>添加Banner</h2>
    <a href="/res/banners">返回列表</a>
    <form method="POST" action="/res/banners">
        {!! csrf_field() !!}
        @foreach($formats as $format)
            <div id="{{$format['id']}}">
                <input type="checkbox" class="format" name="formats[]" value="{{$format['id']}}"/>{{$format['name']}}
                <div class="imgList {{$format['id']}}">
                    <div class="clearfix" style="clear:both;"></div>
                </div>
                <div style="clear:both;"></div>
                <button type="button" class="uploadBannerBtn" onclick="uploadBanner('{{$format['id']}}')">上传Banner
                </button>
            </div>
            <hr>
        @endforeach
        <input type="text" name="url" placeholder="url"/>
        <input type="text" name="start_date" placeholder="开始日期(必填)"/>
        <input type="text" name="end_date" placeholder="结束日期(必填)"/>
        <input type="checkbox" name="active"/>启用
        <button type="submit">保存</button>
    </form>
    @include('partial._error')
    <form id="uploadBannerForm" method="POST" action="/res/file" enctype="multipart/form-data" style="display:none;">
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
    </script>
@endsection