<form method="POST" action="/login" >
    {!! csrf_field() !!}
    <input type="text" name="email" />
    <input type="password" name="password" />
    <button type="submit">登录</button>
</form>
@include('partial._error')
