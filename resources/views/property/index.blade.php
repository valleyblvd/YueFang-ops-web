@extends('layouts.app')

@section('content')
    <h2>房源管理</h2>
    <a href="/properties/create">添加（采集）</a>
    <table>
        <tbody>
        @foreach($records as $record)
            <tr>
                <td>{{$record->Id}}</td>
                <td>{{$record->DataSourceId}}</td>
                <td>{{$record->DataId}}</td>
                <td>{{$record->MLSNumber}}</td>
                <td><a href="/properties/{{$record->Id}}">查看</a></td>
                <td><a href="/properties/{{$record->Id}}/edit">编辑</a></td>
                <td>
                    <form method="POST" action="/properties/{{$record->Id}}"
                          onsubmit="return confirm('您确定要删除吗？');">
                        {!! csrf_field() !!}
                        <input type="hidden" name="_method" value="DELETE" />
                        <button type="submit">删除</button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    {!! $records->render() !!}
@endsection