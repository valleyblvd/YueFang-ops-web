<table cellpadding="5">
    <tr>
        <td colspan="2">
            <select name="sub_cat_id">
                @foreach($cats as $cat)
                    <optgroup label="{{$cat->name}}"></optgroup>
                    @foreach($cat->subCats as $subCat)
                        <option value="{{$subCat->id}}" {{$subCat->id==$model->sub_cat_id?'selected':''}}>{{$subCat->name}}</option>
                    @endforeach
                @endforeach
            </select>
        </td>
    </tr>
    <tr>
        <td>Listing ID：</td>
        <td><input class="easyui-textbox" type="text" name="listingID" data-options="required:true"
                   value="{{$model->listingID}}"/></td>
        <td>标题：</td>
        <td><input class="easyui-textbox" type="text" name="title" data-options="required:true"
                   value="{{$model->title}}"/></td>
    </tr>
    <tr>
        <td>经度：</td>
        <td><input class="easyui-textbox" type="text" name="lng" value="{{$model->lng}}"/></td>
        <td>纬度：</td>
        <td><input id="lat" class="easyui-textbox" type="text" name="lat" value="{{$model->lat}}"/></td>
    </tr>
    <tr>
        <td>地址：</td>
        <td><input class="easyui-textbox" type="text" name="address" value="{{$model->address}}"/></td>
        <td>城市：</td>
        <td><input class="easyui-textbox" type="text" name="city" value="{{$model->city}}"/></td>
    </tr>
    <tr>
        <td>州：</td>
        <td><input class="easyui-textbox" type="text" name="state" value="{{$model->state}}"/></td>
        <td>邮编：</td>
        <td><input class="easyui-textbox" type="text" name="zipcode" value="{{$model->zipcode}}"/></td>
    </tr>
    <tr>
        <td colspan="4" style="text-align: left;max-width: 650px;">
            @include('res._checkFormatField')
        </td>
    </tr>
</table>