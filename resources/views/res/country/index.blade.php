@extends('layouts.app')

@section('content')
    <table id="dg"></table>
    @include('res.country._create')
    @include('res.country._edit')

@endsection

@section('js')
    <script>
        $(function () {
            var toolbar = [{
                text: '添加',
                iconCls: 'icon-add',
                handler: function () {
                    $('#createForm').form('reset');
                    $('#createDialog').dialog('open');
                }
            }, {
                text: '编辑',
                iconCls: 'icon-edit',
                handler: function () {
                    var selected = $('#dg').datagrid('getSelected');
                    if (!selected) {
                        $.messager.alert(' ', '请选择您要编辑的记录！');
                        return;
                    }
                    resetEditForm();
                    $('#editCountryNameEn').textbox('setText',selected.name_en);
                    $('#editCountryNameEn').textbox('setValue',selected.name_en);
                    $('#editCountryNameCn').textbox('setText',selected.name_cn);
                    $('#editCountryNameCn').textbox('setValue',selected.name_cn);
                    $('#editCountryShort').textbox('setText',selected.short);
                    $('#editCountryShort').textbox('setValue',selected.short);
                    $('#editCountryCallCode').textbox('setText',selected.call_code);
                    $('#editCountryCallCode').textbox('setValue',selected.call_code);
                    if(selected.active)$('#editCountryActive').attr('checked', true);
                    $('#editDialog').dialog('open');
                }
            }, {
                text: '删除',
                iconCls: 'icon-remove',
                handler: function () {
                    var selected = $('#dg').datagrid('getSelected');
                    if (!selected) {
                        $.messager.alert(' ', '请选择您要删除的记录！');
                        return;
                    }
                    $.messager.confirm(' ', '您确定要删除该记录吗？', function (r) {
                        if (r) {
                            $.get('/res/country/delete/' + selected.id, function () {
                                $.messager.show({
                                    title: ' ',
                                    msg: '删除成功！',
                                    style: {
                                        right: '',
                                        top: document.body.scrollTop + document.documentElement.scrollTop,
                                        bottom: ''
                                    }
                                });
                                $('#dg').datagrid('reload');
                            }).fail(function (e) {
                                $.messager.alert(' ', '删除失败！' + e.responseJSON.message, 'error');
                            });
                        }
                    });
                }
            }];

            $('#dg').datagrid({
                url: '/res/country',
                method: 'get',
                rownumbers: true,
                singleSelect: true,
                toolbar: toolbar,
                striped: true,
                fit: true,
                columns: [[
                    {field: 'name_en', title: '英文'},
                    {field: 'name_cn', title: '中文'},
                    {field: 'short', title: '代码'},
                    {field: 'call_code', title: '区号'},
                    {field: 'active', title: '启用'}
                ]],
                onLoadError: function (e) {
                    alert('加载列表失败！' + e.responseJSON.message);
                }
            });

            $('#createForm').submit(function (e) {
                e.preventDefault();
                var form = $(this);
                if (!form.form('enableValidation').form('validate'))
                    return false;
                var submitBtn = $('#createSubmitBtn');
                submitBtn.linkbutton('disable');
                $.post('/res/country', form.serialize(), function(data){
                    form.form('reset');
                    $('#createDialog').dialog('close');
                    $('#dg').datagrid('reload');
                }).error(function (xhr) {
                    alert(xhr.responseJSON.message);
                }).complete(function () {
                    submitBtn.linkbutton('enable');
                });
            });

            $('#editForm').submit(function (e) {
                e.preventDefault();
                var form = $(this);
                if (!form.form('enableValidation').form('validate'))
                    return false;
                var submitBtn = $('#editSubmitBtn');
                submitBtn.linkbutton('disable');
                var id = $('#dg').datagrid('getSelected').id;
                $.post('/res/country/update/'+id, form.serialize(), function(data){
                    resetEditForm();
                    $('#editDialog').dialog('close');
                    $('#dg').datagrid('reload');
                }).error(function (xhr) {
                    alert(xhr.responseJSON.message);
                }).complete(function () {
                    submitBtn.linkbutton('enable');
                });
            });

            var resetEditForm = function(){
                $('#editForm').form('reset');
                $('#editCountryActive').attr('checked', false);
            };
        });
    </script>
@endsection