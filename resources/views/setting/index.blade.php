@extends('layouts.app')

@section('content')
    <form method="POST" action="/setting/theme">
        {!! csrf_field() !!}
        <label>主题：</label>
        <select name="theme">
            <option value="default">Default</option>
            <option value="black">Black</option>
            <option value="bootstrap">Bootstrap</option>
            <option value="gray">Gray</option>
            <option value="metro">Metro</option>
        </select>
        <button type="submit">保存</button>
    </form>
@endsection