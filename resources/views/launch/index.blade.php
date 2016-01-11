@extends('layouts.app')

@section('content')
    <h2>开机启动管理</h2>
    <a href="/launches/create">添加</a>
    <table>
        <tbody>
        @foreach($records as $record)
            <tr>
                <td>{{$record->type}}</td>
                <td>{{$record->ext}}</td>
                <td>{{$record->format}}</td>
                <td>{{$record->url}}</td>
                <td>{{$record->num}}</td>
                <td>{{$record->start_date}}</td>
                <td>{{$record->end_date}}</td>
                <td>{{$record->active?'已启用':'已禁用'}}</td>
                <td><a href="/launches/{{$record->id}}">查看</a></td>
                <td><a href="/launches/{{$record->id}}/edit">编辑</a></td>
                <td>
                    <form method="POST" action="/launches/{{$record->id}}"
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
@endsection