<select name="sub_cat_id">
    @foreach($cats as $cat)
        <optgroup label="{{$cat->name}}"></optgroup>
        @foreach($cat->subCats as $subCat)
            <option value="{{$subCat->id}}" {{$subCat->id==$model->sub_cat_id?'selected':''}}>{{$subCat->name}}</option>
        @endforeach
    @endforeach
</select><br/><br/>
<lable>listingID</lable>
<input id="listingID" type="text" name="listingID" placeholder="listingID" value="{{$model->listingID}}"/>
<label>标题：</label><input type="text" name="title" placeholder="标题" value="{{$model->title}}" required/><br/><br/>
<label>纬度：</label><input id="lat" type="text" name="lat" placeholder="纬度" value="{{$model->lat}}"/>
<label>经度：</label><input id="lng" type="text" name="lng" placeholder="经度" value="{{$model->lng}}"/><br/><br/>
<label>地址</label><input id="address" type="text" name="address" placeholder="地址" value="{{$model->address}}"/>
<label>城市</label><input id="city" type="text" name="city" placeholder="城市" value="{{$model->city}}"/><br/><br/>
<label>州</label><input id="state" type="text" name="state" placeholder="州" value="{{$model->state}}"/>
<label>邮编</label><input id="zipcode" type="text" name="zipcode" placeholder="邮编" value="{{$model->zipcode}}"/>
<hr/>
@include('res._checkFormatField')
<button type="submit" style="float:right;">保存</button>