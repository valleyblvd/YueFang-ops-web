@extends('layouts.app')

@section('content')
    <h2>Banner广告管理</h2>
    <a href="/banners/create">添加</a>
    <table>
        <tbody>
        @foreach($banners as $banner)
            <tr>
                <td>{{$banner->ext}}</td>
                <td>{{$banner->format}}</td>
                <td>{{$banner->url}}</td>
                <td>{{$banner->num}}</td>
                <td>{{$banner->start_date}}</td>
                <td>{{$banner->end_date}}</td>
                <td>{{$banner->active?'已启用':'已禁用'}}</td>
                <td><a href="/banners/{{$banner->id}}">查看</a></td>
                <td><a href="/banners/{{$banner->id}}/edit">编辑</a></td>
                <td>
                    <form method="POST" action="/banners/{{$banner->id}}"
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