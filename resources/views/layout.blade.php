<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>@yield('title')</title>
    @section('header_scripts')
        {!!$this->css('ui_minicss::mini.css')!!}
        {!!$this->css('css/backend-1.0.css')!!}
        {!!$this->css('css/backend-dark.css')!!}
        {!!$this->css('css/themify-icons.css')!!}
        {!!$this->js('js/backend-1.0.js')!!}
        <script>
            function toggleTheme(){
                var results = document.cookie.match(/ui_backend_dark=(.+?)(;|$)/);
                if(results && results[1] === '1') {
                    document.body.classList.remove('dark');
                    document.cookie = "ui_backend_dark=0;path=/;max-age=31556926";
                } else {
                    document.body.classList.add('dark');
                    document.cookie = "ui_backend_dark=1;path=/;max-age=31556926";
                }

            }
        </script>

    @show
</head>
<body class="@if($this->core(\Symbiotic\Http\Cookie\CookiesInterface::class)->get('ui_backend_dark') === '1')dark@endif">
{{{$apps = $this->core(\Symbiotic\Apps\AppsRepositoryInterface::class)}}}
<div class="row" style="height: 100%">
    <input type="checkbox" id="sidebar-toggle" class="sidebar-check">
    <div class="sidebar">
        <div class="header-container">

        </div>
        <ul class="left-menu">

            @if($apps->has('settings'))
                <li>
                    <i class="ti-settings"></i>
                    <a href="{{$this->route('backend:settings::index')}}">Настройки</a>
                </li>
            @endif
            @if($apps->has('develop'))
                <li>
                    <i class="ti-panel"></i>
                    <a href="{{$this->route('backend:develop::index')}}">Develop</a>
                </li>
            @endif
            @if($apps->has('develop'))
                <li>
                    <i class="ti-trash"></i>
                    <a href="{{$this->route('backend:develop::cache.clean')}}">Очистка кеша</a>
                </li>
            @endif
            {{{$links = $this->event($this->core(\Symbiotic\UIBackend\Events\MainSidebar::class))}}}
            @foreach($links->getItems() as $html)
              <li>{!! $html !!}</li>
            @endforeach
        </ul>
    </div>
    <div class="col-sm-12 col-md container page-container">
        <div class="header-container">
            <label for="sidebar-toggle" class="button drawer-toggle persistent"></label>
            <div  class="col-md-6 row" style="float: right; ">
                <div class="row">
                    <div class="col-md-6 user-theme"><a href="#" onclick="toggleTheme();return false;"><i class="ti-shine"></i></a></div>
                    <div class="col-md-6 user-menu">
                        <i class="ti-user"></i>
                        <ul>
                            <li><a href="{{$this->route('auth_login::auth.logout')}}">Выйти</a></li>
                        </ul>
                    </div>
                </div>


            </div>
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