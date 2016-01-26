@extends('layouts.app')

@section('content')
    <h2>编辑房源标注</h2>
    <a href="/properties/customize">返回列表</a>
    <form class="hasFormatField" method="POST" action="/properties/customize/{{$model->id}}">
        {!! csrf_field() !!}
        <input type="hidden" name="_method" value="PUT">
        @include('res._checkFormatField_edit')
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
    </script>
@endsection