@extends('layouts.app')

@section('content')
    <h2>房源标注</h2>
    <a href="/properties/customize/create">添加</a>
    <table>
        <tbody>
        @foreach($records as $record)
            <tr>
                <td>{{$record->sub_cat_id}}</td>
                <td>{{$record->title}}</td>
                <td>{{$record->img}}</td>
                <td>{{$record->ext}}</td>
                <td>{{$record->format}}</td>
                <td>{{$record->num}}</td>
                <td>{{$record->lat}}</td>
                <td>{{$record->lng}}</td>
                <td>{{$record->address}}</td>
                <td>{{$record->city}}</td>
                <td>{{$record->state}}</td>
                <td>{{$record->zipcode}}</td>
                <td>{{$record->listingID}}</td>
                <td><a href="/properties/customize/{{$record->id}}">查看</a></td>
                <td><a href="/properties/customize/{{$record->id}}/edit">编辑</a></td>
                <td>
                    <form method="POST" action="/properties/customize/{{$record->id}}"
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