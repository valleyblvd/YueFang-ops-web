@extends('layouts.app')

@section('content')
    <h2>编辑房源标注</h2>
    <a href="/properties/customize">返回列表</a>
    <form id="editForm" method="POST" action="/properties/customize/{{$model->id}}">
        {!! csrf_field() !!}
        <input type="hidden" name="_method" value="PUT">
        @foreach($formats as $format)
            <div id="{{$format['id']}}">
                <input type="checkbox" class="format" name="formats[]"
                       {{in_array($format['id'],$model->formats)?'checked':''}} value="{{$format['id']}}"/>{{$format['name']}}
                <div class="imgList {{$format['id']}}">
                    @foreach($model->resources as $resource)
                        @if(strcasecmp($resource->format,$format['id'])==0)
                            @foreach($resource->imgs as $img)
                                <div class="imgWrapper">
                                    <img src="{{$img->src}}" style="height:150px;"/>
                                    <input type="hidden" name="{{$format['id'].'[]'}}"
                                           value="{{$img->relativePath}}"/><br>
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
        <input type="text" name="listingID" placeholder="listingID" value="{{$model->listingID}}" readonly/>
        <input type="text" name="title" placeholder="标题" value="{{$model->title}}"/>
        <input type="text" name="lat" placeholder="lat" value="{{$model->lat}}"/>
        <input type="text" name="lng" placeholder="lng" value="{{$model->lng}}"/><br/><br/>
        <input type="text" name="address" placeholder="地址" value="{{$model->address}}"/>
        <input type="text" name="city" placeholder="城市" value="{{$model->city}}"/>
        <input type="text" name="state" placeholder="州" value="{{$model->state}}"/>
        <input type="text" name="zipcode" placeholder="邮编" value="{{$model->zipcode}}"/>
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
        $('#editForm').submit(function () {
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

        $('.imgList').dragsort({
            dragSelector: '.imgWrapper'
        });

        var deleteImg = function (delBtn) {
            $(delBtn).parents('.imgWrapper').remove();
        };
    </script>
@endsection