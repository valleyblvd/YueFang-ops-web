<!DOCTYPE html>
<html>
    <head>
        <title>悦房美居-资源管理系统</title>
        <link href="/app.css" type="text/css" rel="stylesheet" />
    </head>
    <body>
        <div style="float:left;border-right:1px solid #999;padding:10px;">
            <dl>
                <dt>房源资源</dt>
                <dd><a href="">标签/标注</a></dd>
                <dd><a href="">图片管理/关联</a></dd>
                <dd><a href="">高收益房源采集</a></dd>
                <dt>静态资源</dt>
                <dd><a href="">开机图片管理</a></dd>
                <dd><a href="">开机广告管理</a></dd>
                <dd><a href="/banners">Banner广告管理</a></dd>
                <dd><a href="">国际电话区号管理</a></dd>
                <dt>用户</dt>
                <dd><a href="">经纪人</a></dd>
                <dt>客户端</dt>
                <dd><a href="/clients">安装统计</a></dd>
            </dl>
        </div>
        <div style="float:left;padding:10px;">
            @yield('content')
        </div>
        <script src="/lib/jquery-1.9.1.min.js"></script>
        <script src="/lib/jquery.form.js"></script>
        <script src="/lib/jquery.dragsort-0.5.2.min.js"></script>
        @yield('js')
    </body>
</html>