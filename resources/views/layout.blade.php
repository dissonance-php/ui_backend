<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>@yield('title')</title>
    @section('header_scripts')
        {!!css('ui_minicss::mini.css')!!}
        {!!css('css/backend-1.0.css')!!}
        {!!css('css/themify-icons.css')!!}
        {!!js('js/backend-1.0.js')!!}
    @show
</head>
<body>
{{{$apps = \_S\core(\Symbiotic\Apps\AppsRepositoryInterface::class)}}}
<div class="row" style="height: 100%">
    <input type="checkbox" id="sidebar-toggle" class="sidebar-check">
    <div class="sidebar">
        <div class="header-container"></div>
        <ul class="left-menu">

            @if($apps->has('settings'))
                <li>
                    <i class="ti-settings"></i>
                    <a href="{{route('backend:settings::index')}}">Настройки</a>
                </li>
            @endif
            @if($apps->has('develop'))
                <li>
                    <i class="ti-panel"></i>
                    <a href="{{route('backend:develop::index')}}">Develop</a>
                </li>
            @endif
            @if($apps->has('develop'))
                <li>
                    <i class="ti-trash"></i>
                    <a href="{{route('backend:develop::cache.clean')}}">Очистка кеша</a>
                </li>
            @endif
            {{{$links = \_S\event(\_S\core(\Symbiotic\UIBackend\Events\MainSidebar::class))}}}
            @foreach($links->getItems() as $html)
              <li>{!! $html !!}</li>
            @endforeach
        </ul>
    </div>
    <div class="col-sm-12 col-md container page-container">
        <div class="header-container">
            <label for="sidebar-toggle" class="button drawer-toggle persistent"></label>
        </div>
        <div class="row">
            @hasSection('sidebar')
                <div class="col-sm-12 col-md sidebar-container">
                    <ul class="sidebar-nav">
                        @yield('sidebar')
                    </ul>
                </div>
                <div class="col-sm-12 col-md">
                    @yield('content')
                </div>
            @else
                @yield('content')
            @endif
        </div>
    </div>
</div>
</body>
</html>