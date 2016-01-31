<label>DataSourceId</label>
<input type="text" name="DataSourceId" placeholder="DataSourceId" value="{{$model->DataSourceId}}"/>
<label>DataId</label>
<input type="text" name="DataId" placeholder="DataId" value="{{$model->DataId}}"/><br><br>
<label>数据源Url</label>
<input type="text" name="ReferenceUrl" placeholder="数据源Url" value="{{$model->ReferenceUrl}}"/>
<label>照片Url（以逗号分开）</label>
<input type="text" name="PhotoUrls" placeholder="照片Url" value="{{$model->PhotoUrls}}"/>
<label>MLSNumber</label>
<input type="text" name="MLSNumber" placeholder="MLSNumber"/><br><br>
<label>挂牌价</label>
<input type="text" name="ListPrice" placeholder="挂牌价" value="{{$model->ListPrice}}"/>
<label>成交价</label>
<input type="text" name="SalePrice" placeholder="成交价"/>
<label>州</label>
<input type="text" name="State" placeholder="州" value="{{$model->State}}"/><br><br>
<label>县/郡</label>
<input type="text" name="County" placeholder="县/郡" value="{{$model->County}}"/>
<label>城市</label>
<input type="text" name="City" placeholder="城市" value="{{$model->City}}"/>
<label>门牌号 街道名</label>
<input type="text" name="Address" placeholder="门牌号 街道名" value="{{$model->Address}}"/><br><br>
<label>邮编</label>
<input type="text" name="PostalCode" placeholder="邮编" value="{{$model->PostalCode}}"/>
<label>社区名</label>
<input type="text" name="Area" placeholder="社区名"/>
<label>相邻街道</label>
<input type="text" name="CrossStreets" placeholder="相邻街道"/><br><br>
<label>经纬度</label>
<input type="text" name="Location" placeholder="经纬度" value="{{$model->Location}}"/>
<label>房源描述</label>
<input type="text" name="Description" placeholder="房源描述" value="{{$model->Description}}"/>
<label>修建时间</label>
<input type="text" name="YearBuilt" placeholder="修建时间"/><br><br>
<label>土地面积（SqFt:平方英尺）</label>
<input type="text" name="LotSqFt" placeholder="土地面积" value="{{$model->LotSqFt}}"/>
<label>建筑面积</label>
<input type="text" name="StructureSqFt" placeholder="建筑面积" value="{{$model->StructureSqFt}}"/>
<label>卧室数</label>
<input type="text" name="Bedrooms" placeholder="卧室数" value="{{$model->Bedrooms}}"/><br><br>
<label>带浴缸的厕所数</label>
<input type="text" name="BathsFull" placeholder="带浴缸的厕所数" value="{{$model->BathFull}}"/>
<label>不能洗澡的厕所数</label>
<input type="text" name="BathsHalf" placeholder="不能洗澡的厕所数" value="{{$model->BathHalf}}"/><br><br>
<lable>车库数</lable>
<input type="text" name="GarageSpaces" placeholder="车库数" value="{{$model->GarageSpaces}}"/>
<lable>车位数</lable>
<input type="text" name="ParkingSpaces" placeholder="车位数"/>
<button type="submit">保存</button>