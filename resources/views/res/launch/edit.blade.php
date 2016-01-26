@extends('layouts.app')

@section('content')
    <h2>编辑开机启动资源</h2>
    <a href="/res/launch">返回列表</a>
    @include('partial._error')
    <form class="hasFormatField" method="POST" action="/res/launch/{{$model->id}}">
        {!! csrf_field() !!}
        <input type="hidden" name="_method" value="PUT">

        <div>
            <span id="launchType">{{$model->type}}</span>
            {{--<select name="type" onchange="changeType(this)">--}}
                {{--<option value="0" {{$record->type==0?'selected':''}}>launch screen image</option>--}}
                {{--<option value="1" {{$record->type==1?'selected':''}}>launch ad image</option>--}}
                {{--<option value="2" {{$record->type==2?'selected':''}}>guide image</option>--}}
                {{--<option value="3" {{$record->type==3?'selected':''}}>home page html</option>--}}
            {{--</select>--}}
        </div>
        <div id="formatWrapper">
            @include('res._checkFormatField_edit')
        </div>
        <input type="text" name="url" placeholder="url" value="{{$model->url}}"/>
        <input type="text" name="start_date" placeholder="开始日期" value="{{$model->start_date}}" required/>
        <input type="text" name="end_date" placeholder="结束日期" value="{{$model->end_date}}" required/>
        <label><input type="checkbox" name="active" {{$model->active==1?'checked':''}} />启用</label>
        <button type="submit">保存</button>
    </form>
@endsection

@section('js')
    <script>
        var type=$('#launchType').text();
        if(type==3){
            $('#formatWrapper').hide();
            $('input[name=url]').attr('placeholder', 'url(必填)');
        }

        var changeType = function (select) {
            if ($(select).val() == 3) {
                $('#formatWrapper').hide();
                $('input[name=url]').attr('placeholder', 'url(必填)');
            } else {
                $('#formatWrapper').show();
                $('input[name=url]').attr('placeholder', 'url');
            }
        };
    </script>
@endsection