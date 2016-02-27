<div id="editDialog" class="easyui-dialog" title="添加国家" style="width:260px;height:230px;"
     data-options="modal:true,closed:true,
            buttons: [{
                id:'editSubmitBtn',
                text:'保存',
                iconCls:'icon-ok',
                handler:function(){
                    $('#editForm').submit();
                }
            },{
                text:'取消',
                handler:function(){
                    $('#editDialog').dialog('close');
                }
            }]">
    <form id="editForm">
        {!! csrf_field() !!}
        <table cellpadding="5">
            <tr>
                <td>英文：</td>
                <td><input id="editCountryNameEn" class="easyui-textbox" type="text" name="name_en" data-options="required:true"/></td>
            </tr>
            <tr>
                <td>中文：</td>
                <td><input id="editCountryNameCn" class="easyui-textbox" type="text" name="name_cn" data-options="required:true"/></td>
            </tr>
            <tr>
                <td>区号：</td>
                <td><input id="editCountryCallCode" class="easyui-textbox" type="text" name="call_code" data-options="required:true"/></td>
            </tr>
            <tr>
                <td>代码：</td>
                <td><input id="editCountryShort" class="easyui-textbox" type="text" name="short"/></td>
            </tr>
            <tr>
                <td></td>
                <td style="text-align: left;"><label><input id="editCountryActive" type="checkbox" name="active"/>启用</label></td>
            </tr>
        </table>
    </form>
</div>