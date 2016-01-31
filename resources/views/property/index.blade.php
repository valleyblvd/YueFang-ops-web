@extends('layouts.app')

@section('content')
    <h2>房源管理</h2>
    <a href="/properties/create">添加</a>
    <table>
        <tbody>
        <th>Id</th>
        <th>数据源Id</th>
        <th>Data Id</th>
        <th>MLSNumber</th>
        <th>坐标</th>
        <th colspan="3"></th>
        @foreach($records as $record)
            <tr>
                <td>{{$record->Id}}</td>
                <td>{{$record->DataSourceId}}</td>
                <td>{{$record->DataId}}</td>
                <td>{{$record->MLSNumber}}</td>
                <td>{{$record->Location}}</td>
                <td><a href="/properties/{{$record->Id}}">查看</a></td>
                <td><a href="/properties/{{$record->Id}}/edit">编辑</a></td>
                <td>
                    <form method="POST" action="/properties/{{$record->Id}}"
                          onsubmit="return confirm('您确定要删除吗？');">
                        {!! csrf_field() !!}
                        <input type="hidden" name="_method" value="DELETE"/>
                        <button type="submit">删除</button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    {!! $records->render() !!}
@endsection