<div>
    <select name="type" onchange="changeType(this)">
        <option value="0" {{$model->type==0?'selected':''}}>启动屏幕图片（iOS跳过）</option>
        <option value="1" {{$model->type==1?'selected':''}}>启动广告图片</option>
        <option value="2" {{$model->type==2?'selected':''}}>引导图片</option>
        <option value="3" {{$model->type==3?'selected':''}}>首页Html</option>
    </select>
</div>
<div id="formatWrapper">
    @include('res._checkFormatField')
</div>
<label>Url：</label><input type="text" name="url" placeholder="url" value="{{$model->url}}"/>
<label>开始日期* ：</label><input type="text" name="start_date" placeholder="开始日期(必填)" required
                             value="{{$model->start_date}}"/>
<label>结束日期* ：</label><input type="text" name="end_date" placeholder="结束日期(必填)" required value="{{$model->end_date}}"/>
<label><input type="checkbox" name="active" {{$model->active?'checked':''}}/>启用</label>
<button type="submit">保存</button>

@section('js')
    <script>
        var type = $('#launchType').text();
        if (type == 3) {
            $('#formatWrapper').hide();
            $('input[name=url]').attr('placeholder', 'url(必填)');
        }

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