<!DOCTYPE html>
<html>
    <head>
        <title>悦房-资源管理系统</title>
        <link href="/app.css" type="text/css" rel="stylesheet" />
    </head>
    <body>
        <div style="float:left;border-right:1px solid #999;padding:10px;">
            @include('partial._menu')
        </div>
        <div style="float:left;padding:10px;">
            @yield('content')
        </div>
        @include('res._uploadResForm')
        <script src="/lib/jquery-1.9.1.min.js"></script>
        <script src="/lib/jquery.form.js"></script>
        <script src="/lib/jquery.dragsort-0.5.2.min.js"></script>
        <script src="/js/util.js"></script>
        <script src="/js/app.js"></script>
        @yield('js')
    </body>
</html>