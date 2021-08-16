<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>@yield('title')</title>
    @section('header_scripts')
        {!!css('ui_minicss::mini.css')!!}
        {!!css('css/backend-1.0.css')!!}
        {!!js('js/backend-1.0.js')!!}
    @show
</head>
<body>

<div class="row">
        <div class="col-sm-12 col-md-2 sidebar">
            <div style="height: 50px;background-color: #333;"></div>
            <ul class="menu">
                @section('sidebar') @show
            </ul>
        </div>
        <div class="col-sm-12 col-md">
            <div style="height: 50px;background-color: #444;"></div>
            <div class="container ">
             @yield('content')
            </div>
        </div>
</div>
</body>
</html>