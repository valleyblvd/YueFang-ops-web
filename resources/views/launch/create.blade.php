@extends('layouts.app')

@section('content')
    <h2>添加Banner</h2>
    <a href="/launches">返回列表</a>
    <form method="POST" action="/launches">
        {!! csrf_field() !!}
        <div>
            <select name="type" onchange="changeType(this)">
                <option value="0" selected>launch screen image</option>
                <option value="1">launch ad image</option>
                <option value="2">guide image</option>
                <option value="3">home page html</option>
            </select>
        </div>
        <div id="formatWrapper">
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
        </div>
        <input type="text" name="url" placeholder="url"/>
        <input type="text" name="start_date" placeholder="开始日期(必填)"/>
        <input type="text" name="end_date" placeholder="结束日期(必填)"/>
        <input type="checkbox" name="active"/>启用
        <button type="submit">保存</button>
    </form>
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

        var changeType = function (select) {
            if ($(select).val() == 3) {
                $('#formatWrapper').hide();
                $('input[name=url]').attr('placeholder', 'url(必填)');
            } else {
                $('#formatWrapper').show();
                $('input[name=url]').attr('placeholder', 'url');
            }
        };
    </script>
@endsection