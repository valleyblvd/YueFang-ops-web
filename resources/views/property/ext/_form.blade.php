<label>MLSID：</label><input type="text" name="mlsId" placeholder="mlsId" required value="{{$model->mlsId}}"/>
<label>标签：</label><input type="text" name="tag" placeholder="标签" required value="{{$model->tag}}"/>
<label><input type="checkbox" name="hot" {{$model->hot?'checked':''}}/>热门</label>
<label><input type="checkbox" name="recommended" {{$model->recommended?'checked':''}}/>推荐</label>
<button type="submit">保存</button>