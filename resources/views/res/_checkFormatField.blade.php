@foreach($formats as $format)
    <div id="{{$format['id']}}">
        <label><input type="checkbox" class="format" name="formats[]"
                      value="{{$format['id']}}"/>{{$format['name']}}</label>

        <div class="imgList {{$format['id']}}">
            <div class="clearfix" style="clear:both;"></div>
        </div>
        <div style="clear:both;"></div>
        <button type="button" class="uploadResBtn" onclick="uploadRes('{{$format['id']}}')">上传图片
        </button>
    </div>
    <hr>
@endforeach