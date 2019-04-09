<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>
            @section("title")
                Defend Your Money App
            @show
        </title>

        @section('stylesheets')
            @if (config('app.env') === 'local')
                <link href="/css/app.css" rel="stylesheet" type="text/css">
            @else
                <link href="/css/app.{!! config('app.version_hash') !!}.css" rel="stylesheet" type="text/css">
            @endif
        @show

        @section('javascript-head')
            <script>
                window.appEnv = window.appEnv || {};
                window.appEnv.baseUrl = "{!! config('app.url') !!}";
                window.appEnv.clientPlatform = 'web';
            </script>
        @show

    </head>
    <body>
        <div id="vueApp">
            <div class="vueOnePage">
                <router-view></router-view>
            </div>
        </div>

        @section('javascript-footer')
            @if (config('app.env') === 'local')
                <script type="text/javascript" src="/js/app.js"></script>
                <script id="__bs_script__">//<![CDATA[
                    document.write("<script async src='http://HOST:3000/browser-sync/browser-sync-client.js?v=2.18.6'><\/script>".replace("HOST", location.hostname));
                    //]]>
                </script>
             @else
                <script type="text/javascript" src="/js/app.{!! config('app.version_hash') !!}.js"></script>
            @endif
        @show
    </body>
</html>
