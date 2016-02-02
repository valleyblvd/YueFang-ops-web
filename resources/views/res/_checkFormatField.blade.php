@foreach($formats as $format)
    <div id="{{$format['id']}}">
        <label><input type="checkbox" class="format" name="formats[]"
                      {{in_array($format['id'],$model->formats)?'checked':''}} value="{{$format['id']}}"/>{{$format['name']}}
        </label>

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
        <button type="button" class="uploadResBtn easyui-linkbutton" onclick="uploadRes('{{$format['id']}}')">上传图片
        </button>
    </div>
    <hr>
@endforeach