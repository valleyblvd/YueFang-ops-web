@extends('layouts.app')

@section('content')
    <h2>编辑房源标注</h2>
    <a href="/properties/customize">返回列表</a>
    <form method="POST" action="/properties/customize/{{$id}}">
        {!! csrf_field() !!}
        <input type="hidden" name="_method" value="PUT">
        @foreach($formats as $format)
            <div id="{{$format['id']}}">
                <input type="checkbox" class="format" name="formats[]" {{in_array($format['id'],$record->formats)?'checked':''}} value="{{$format['id']}}" />{{$format['name']}}
                <div class="imgList {{$format['id']}}">
                    @foreach($record->resources as $resource)
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
        <input type="text" name="listingID" placeholder="listingID" value="{{$record->listingID}}"/>
        <input type="text" name="title" placeholder="标题" value="{{$record->title}}"/>
        <input type="text" name="lat" placeholder="lat" value="{{$record->lat}}"/>
        <input type="text" name="lng" placeholder="lng" value="{{$record->lng}}"/><br/><br/>
        <input type="text" name="address" placeholder="地址" value="{{$record->address}}"/>
        <input type="text" name="city" placeholder="城市" value="{{$record->city}}"/>
        <input type="text" name="state" placeholder="州" value="{{$record->state}}"/>
        <input type="text" name="zipcode" placeholder="邮编" value="{{$record->zipcode}}"/>
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