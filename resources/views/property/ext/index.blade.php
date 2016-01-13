@extends('layouts.app')

@section('content')
    <h2>房源标签</h2>
    <a href="/properties/ext/create">添加</a>
    <table>
        <tbody>
        @foreach($records as $record)
            <tr>
                <td>{{$record->mlsId}}</td>
                <td>{{$record->tag}}</td>
                <td>{{$record->hot}}</td>
                <td>{{$record->recommended}}</td>
                <td><a href="/properties/ext/{{$record->id}}">查看</a></td>
                <td><a href="/properties/ext/{{$record->id}}/edit">编辑</a></td>
                <td>
                    <form method="POST" action="/properties/ext/{{$record->id}}"
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