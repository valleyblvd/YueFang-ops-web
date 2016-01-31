@extends('layouts.app')

@section('content')
    <h2>开机启动管理</h2>
    <a href="/res/launch/create">添加</a>
    <table>
        <thead>
        <tr>
            <th>类型</th>
            <th>平台</th>
            <th>开始日期</th>
            <th>结束日期</th>
            <th>启用</th>
            <th colspan="3">
            </th>
        </tr>
        </thead>
        <tbody>
        @foreach($models as $model)
            <tr>
                <td>{{$model->type_display}}</td>
                <td>{{$model->format}}</td>
                <td>{{$model->start_date}}</td>
                <td>{{$model->end_date}}</td>
                <td>{{$model->active_display}}</td>
                <td><a href="/res/launch/{{$model->id}}">查看</a></td>
                <td><a href="/res/launch/{{$model->id}}/edit">编辑</a></td>
                <td>
                    <form method="POST" action="/res/launch/{{$model->id}}"
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