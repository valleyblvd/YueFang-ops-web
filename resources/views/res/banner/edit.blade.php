@extends('layouts.app')

@section('content')
    <h2>编辑Banner</h2>
    <a href="/res/banner">返回列表</a>
    <form method="POST" action="/res/banner/{{$id}}">
        {!! csrf_field() !!}
        <input type="hidden" name="_method" value="PUT">
        @foreach($formats as $format)
            <div id="{{$format['id']}}">
                <input type="checkbox" class="format" name="formats[]" {{in_array($format['id'],$banner->formats)?'checked':''}} value="{{$format['id']}}" />{{$format['name']}}
                <div class="imgList {{$format['id']}}">
                    @foreach($banner->resources as $resource)
                        @if(strcasecmp($resource->format,$format['id'])==0)
                            @foreach($resource->imgs as $img)
                                <div class="imgWrapper">
                                    <img src="{{$img->src}}" style="height:150px;" />
                                    <input type="hidden" name="{{$format['id'].'[]'}}" value="{{$img->relativePath}}" /><br>
                                    <a href="javascript:;" onclick="deleteImg(this)">删除</a>
                                </div>
                            @endforeach
                            @break
                        @endif
                    @endforeach
                    <div class="clearfix" style="clear:both;"></div>
                </div>
                <div style="clear:both;"></div>
                <button type="button" class="uploadBannerBtn" onclick="uploadBanner('{{$format['id']}}')">上传图片
                </button>
            </div>
            <hr>
        @endforeach
        <input type="text" name="url" placeholder="url" value="{{$banner->url}}" />
        <input type="text" name="start_date" placeholder="开始日期" value="{{$banner->start_date}}" />
        <input type="text" name="end_date" placeholder="结束日期" value="{{$banner->end_date}}" />
        <label><input type="checkbox" name="active" {{$banner->active==1?'checked':''}} />启用</label>
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
            $('.imgList.' + format+' .clearfix').before('<div class="imgWrapper">' +
                    '<img src="' + data.url + '" style="height:150px;" />' +
                    '<input type="hidden" name="' + format + '[]" value="' + data.relativePath + '" /><br>' +
                    '<a href="javascript:;" onclick="deleteImg(this)">删除</a>' +
                    '</div>');
            uploadForm.data('format', '');
            uploadForm.resetForm();
            $('.imgList').dragsort('destroy');
            $('.imgList').dragsort({
                dragSelector:'.imgWrapper'
            });
        });

        var submitUploadForm = function () {
            uploadForm.submit();
        };

        var uploadBanner = function (format) {
            uploadForm.data('format', format);
            uploadForm.find('input[type=file]').click();
        };

        $('.imgList').dragsort({
            dragSelector: '.imgWrapper'
        });

        var deleteImg=function(delBtn){
            $(delBtn).parents('.imgWrapper').remove();
        };
    </script>
@endsection