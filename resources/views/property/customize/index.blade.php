@extends('layouts.app')
@section('pageTitle','房源标注')

@section('content')
    {{--<a href="/properties/customize/create">采集/标注</a>--}}
    <table id="dg"></table>
@endsection

@section('js')
    <script>
        $(function () {
            var toolbar = [{
                text: '采集/标注',
                iconCls: 'icon-add',
                handler: function () {
                    window.location = '/properties/customize/create';
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
                    window.location = '/properties/customize/' + selected.id + '/edit';
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
                            $.get('api/properties/customize/delete/' + selected.id, function () {
                                $.messager.show({
                                    title: ' ',
                                    msg: '删除成功！'
                                });
                            }).fail(function (e) {
                                $.messager.alert(' ', '删除失败！' + e.responseJSON.message, 'error');
                            });
                        }
                    });
                }
            }];

            $('#dg').datagrid({
                url: '/api/properties/customize',
                method: 'get',
                rownumbers: true,
                singleSelect: true,
                toolbar: toolbar,
                columns: [[
                    {field: 'listingID', title: 'Listing ID'},
                    {field: 'title', title: '标题'},
                    {field: 'format', title: '设备'},
                    {field: 'format', title: '地址'},
                    {field: 'city', title: '城市'},
                    {field: 'status', title: '州'},
                    {field: 'zipcode', title: '邮编'}
                ]]
            });
        });

    </script>
@endsection