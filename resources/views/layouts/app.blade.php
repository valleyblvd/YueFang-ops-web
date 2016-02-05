<!DOCTYPE html>
<html>
<head>
    <title>悦房 - @yield('pageTitle')</title>
    <link href="/css/normalize.css" type="text/css" rel="stylesheet"/>
    <link href="/lib/easyui/themes/{{\Illuminate\Support\Facades\Cookie::get('theme')?\Illuminate\Support\Facades\Cookie::get('theme'):'default'}}/easyui.css"
          type="text/css" rel="stylesheet"/>
    <link href="/lib/easyui/themes/icon.css" type="text/css" rel="stylesheet"/>
    <link href="/css/app.css" type="text/css" rel="stylesheet"/>
    <link href="/css/easyui.ext.css" type="text/css" rel="stylesheet"/>
</head>
<body>
<div class="easyui-layout" style="height: 100%;">
    <div data-options="region:'north'" style="height:50px">
        <h3>悦房美居 - 资源管理系统</h3>
    </div>
    <div data-options="region:'west',split:true" title="导航菜单" style="overflow: hidden;width: 200px;">
        @include('partial._menu')
    </div>
    <div data-options="region:'center',title:'@yield('pageTitle') '" style="padding:1px;">
        @yield('content')
    </div>
</div>
@include('res._uploadResForm')
<script src="/lib/jquery.min.js"></script>
<script src="/lib/easyui/jquery.easyui.min.js"></script>
<script src="/lib/easyui/themes/locale/easyui-lang-zh_CN.js"></script>
<script src="/lib/jquery.form.js"></script>
<script src="/lib/jquery.dragsort-0.5.2.min.js"></script>
<script src="/js/util.js"></script>
<script src="/js/app.js"></script>
@yield('js')
<script>
    $('body').show();
</script>
</body>
</html>