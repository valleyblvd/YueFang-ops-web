@extends('layouts.app')

@section('content')
    <h2>房源标注</h2>
    <a href="/properties/customize/create">采集/标注</a>
    <table>
        <tbody>
        @foreach($models as $model)
            <tr>
                <td>{{$model->sub_cat_id}}</td>
                <td>{{$model->title}}</td>
                <td>{{$model->img}}</td>
                <td>{{$model->ext}}</td>
                <td>{{$model->format}}</td>
                <td>{{$model->num}}</td>
                <td>{{$model->lat}}</td>
                <td>{{$model->lng}}</td>
                <td>{{$model->address}}</td>
                <td>{{$model->city}}</td>
                <td>{{$model->state}}</td>
                <td>{{$model->zipcode}}</td>
                <td>{{$model->listingID}}</td>
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