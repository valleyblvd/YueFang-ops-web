@extends('layouts.app')

@section('content')
    <h2>房源标注</h2>
    <a href="/properties/customize/create">采集/标注</a>
    <table>
        <thead>
        <th>ListingID</th>
        {{--<th>分类</th>--}}
        <th>标题</th>
        <th>设备</th>
        <th>地址</th>
        <th>城市</th>
        <th>州</th>
        <th>邮编</th>
        <th colspan="3"></th>
        </thead>
        <tbody>
        @foreach($models as $model)
            <tr>
                <td>{{$model->listingID}}</td>
{{--                <td>{{$model->sub_cat_id}}</td>--}}
                <td style="max-width:200px;">{{$model->title}}</td>
                <td>{{$model->format}}</td>
                <td>{{$model->address}}</td>
                <td>{{$model->city}}</td>
                <td>{{$model->state}}</td>
                <td>{{$model->zipcode}}</td>
                <td><a href="/properties/customize/{{$model->id}}">查看</a></td>
                <td><a href="/properties/customize/{{$model->id}}/edit">编辑</a></td>
                <td>
                    <form method="POST" action="/properties/customize/{{$model->id}}"
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