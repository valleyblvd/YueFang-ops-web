@extends('layouts.app')

@section('content')
    <h2>房源标签</h2>
    <a href="/properties/ext/create">添加</a>
    <table>
        <thead>
        <th>MLSID</th>
        <th>标签</th>
        <th>热门</th>
        <th>推荐</th>
        <th colspan="3"></th>
        </thead>
        <tbody>
        @foreach($models as $model)
            <tr>
                <td>{{$model->mlsId}}</td>
                <td>{{$model->tag}}</td>
                <td>{{$model->hot_display}}</td>
                <td>{{$model->recommended_display}}</td>
                <td><a href="/properties/ext/{{$model->id}}">查看</a></td>
                <td><a href="/properties/ext/{{$model->id}}/edit">编辑</a></td>
                <td>
                    <form method="POST" action="/properties/ext/{{$model->id}}"
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
@endsection