@extends('layouts.app')

@section('content')
    <h2>Banner广告管理</h2>
    <a href="/res/banner/create">添加</a>
    <table>
        <thead>
        <tr>
            <th>设备</th>
            <th>Url</th>
            <th>开始日期</th>
            <th>结束日期</th>
            <th colspan="3"></th>
        </tr>
        </thead>
        <tbody>
        @foreach($banners as $banner)
            <tr>
                <td>{{$banner->format}}</td>
                <td>{{$banner->url}}</td>
                <td>{{$banner->start_date}}</td>
                <td>{{$banner->end_date}}</td>
                <td>{{$banner->active?'已启用':'已禁用'}}</td>
                <td><a href="/res/banner/{{$banner->id}}">查看</a></td>
                <td><a href="/res/banner/{{$banner->id}}/edit">编辑</a></td>
                <td>
                    <form method="POST" action="/res/banner/{{$banner->id}}"
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