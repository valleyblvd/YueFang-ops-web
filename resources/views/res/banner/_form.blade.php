@include('res._checkFormatField')
<label>Url：</label><input type="text" name="url" placeholder="url" value="{{$model->url}}"/>
<label>开始日期：</label><input type="text" name="start_date" placeholder="开始日期" value="{{$model->start_date}}" required/>
<label>结束日期：</label><input type="text" name="end_date" placeholder="结束日期" value="{{$model->end_date}}" required/>
<label><input type="checkbox" name="active" {{$model->active?'checked':''}} />启用</label>
<button type="submit">保存</button>