<table>
    <tr>
        <td>数据源Id：</td>
        <td><input class="easyui-textbox" type="text" name="DataSourceId" value="{{$model->DataSourceId}}"
                   data-options="required:true"/></td>
        <td>DataId：</td>
        <td><input class="easyui-textbox" type="text" name="DataId" value="{{$model->DataId}}"
                   data-options="required:true"/>
        </td>
        <td>MLSNumber：</td>
        <td><input class="easyui-textbox" type="text" name="MLSNumber" value="{{$model->MLSNumber}}"/></td>
    </tr>
    <tr>
        <td>数据源Url：</td>
        <td><input class="easyui-textbox" type="text" name="ReferenceUrl" value="{{$model->ReferenceUrl}}"/></td>
        <td>照片Url（以逗号分开）：</td>
        <td><input class="easyui-textbox" type="text" name="PhotoUrls" value="{{$model->PhotoUrls}}"/></td>
    </tr>
    <tr>
        <td>挂牌价：</td>
        <td><input class="easyui-textbox" type="text" name="ListPrice" value="{{$model->ListPrice}}"/>
        </td>
        <td>成交价：</td>
        <td><input class="easyui-textbox" type="text" name="SalePrice"/></td>
    </tr>
    <tr>
        <td>州：</td>
        <td><input class="easyui-textbox" type="text" name="State" value="{{$model->State}}"/></td>
        <td>县/郡：</td>
        <td><input class="easyui-textbox" type="text" name="County" value="{{$model->County}}"/></td>
    </tr>
    <tr>
        <td>城市：</td>
        <td><input class="easyui-textbox" type="text" name="City" value="{{$model->City}}"/></td>
        <td>门牌号 街道名：</td>
        <td><input class="easyui-textbox" type="text" name="Address" value="{{$model->Address}}"/></td>
    </tr>
    <tr>
        <td>邮编：</td>
        <td><input class="easyui-textbox" type="text" name="PostalCode" value="{{$model->PostalCode}}"/></td>
        <td>社区名：</td>
        <td><input class="easyui-textbox" type="text" name="Area" value="{{$model->Area}}"/></td>
    </tr>
    <tr>
        <td>相邻街道：</td>
        <td><input class="easyui-textbox" type="text" name="CrossStreets" value="{{$model->CrossStreets}}"/></td>
        <td>经纬度：</td>
        <td><input class="easyui-textbox" type="text" name="Location" value="{{$model->Location}}"/></td>
    </tr>

    <tr>
        <td>修建时间：</td>
        <td><input class="easyui-textbox" type="text" name="YearBuilt" value="{{$model->YearBuilt}}"/></td>
        <td>土地面积（<a href="javascript:;" title="平方英尺" class="easyui-tooltip">SqFt</a>）：</td>
        <td><input class="easyui-textbox" type="text" name="LotSqFt" value="{{$model->LotSqFt}}"/></td>
        <td>建筑面积：</td>
        <td><input class="easyui-textbox" type="text" name="StructureSqFt" value="{{$model->StructureSqFt}}"/></td>
    </tr>
    <tr>
        <td>卧室数：</td>
        <td><input class="easyui-textbox" type="text" name="Bedrooms" value="{{$model->Bedrooms}}"/></td>
        <td>带浴缸的厕所数：</td>
        <td><input class="easyui-textbox" type="text" name="BathsFull" value="{{$model->BathFull}}"/></td>
        <td>不能洗澡的厕所数：</td>
        <td><input class="easyui-textbox" type="text" name="BathsHalf" value="{{$model->BathHalf}}"/></td>
    </tr>
    <tr>
        <td>车库数：</td>
        <td><input class="easyui-textbox" type="text" name="GarageSpaces" value="{{$model->GarageSpaces}}"/></td>
        <td>车位数：</td>
        <td><input class="easyui-textbox" type="text" name="ParkingSpaces" value="{{$model->ParkingSpaces}}"/></td>
    </tr>
    <tr>
        <td>房源描述：</td>
        <td><input class="easyui-textbox" type="text" name="Description" value="{{$model->Description}}"
                   data-options="multiline:true" style="height:60px;"/></td>
    </tr>
</table>