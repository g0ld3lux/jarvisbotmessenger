<!DOCTYPE html>
<html lang="en" ng-app="messengerBotApp">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('site.title') }}</title>

    <!-- Styles -->
    <link href="{{ elixir('css/all.css') }}" rel="stylesheet">

    <link rel="apple-touch-icon" sizes="57x57" href="{{ asset('apple-icon-57x57.png') }}">
    <link rel="apple-touch-icon" sizes="60x60" href="{{ asset('apple-icon-60x60.png') }}">
    <link rel="apple-touch-icon" sizes="72x72" href="{{ asset('apple-icon-72x72.png') }}">
    <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('apple-icon-76x76.png') }}">
    <link rel="apple-touch-icon" sizes="114x114" href="{{ asset('apple-icon-114x114.png') }}">
    <link rel="apple-touch-icon" sizes="120x120" href="{{ asset('apple-icon-120x120.png') }}">
    <link rel="apple-touch-icon" sizes="144x144" href="{{ asset('apple-icon-144x144.png') }}">
    <link rel="apple-touch-icon" sizes="152x152" href="{{ asset('apple-icon-152x152.png') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('apple-icon-180x180.png') }}">
    <link rel="icon" type="image/png" sizes="192x192"  href="{{ asset('android-icon-192x192.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="96x96" href="{{ asset('favicon-96x96.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicon-16x16.png') }}">
    <link rel="manifest" href="{{ asset('manifest.json') }}">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="{{ asset('ms-icon-144x144.png') }}">
    <meta name="theme-color" content="#ffffff">

    <style>
        [ng\:cloak], [ng-cloak], [data-ng-cloak], [x-ng-cloak], .ng-cloak, .x-ng-cloak {
            display: none !important;
        }
        .navbar-default {
        background-color: #03a9f4;
        border-color: transparent;
        }
        .navbar-default .navbar-nav > li > a:hover, .navbar-default .navbar-nav > li > a:focus {
        color: #ffcdd2;
        background-color: transparent;
        }

        html {
        height: 100%;
        }
        body {
        min-height: 100%;
        display: flex;
        flex-direction: column;
        }
        .container {
        flex: 1;
        }
        
    </style>

    <script type="text/javascript">
        var BASE_URL = "{{ url('/') }}";
    </script>

    @stack('head_scripts')
</head>
@yield('css')
<body id="app-layout" ng-cloak>
    <script>
        window.fbAsyncInit = function() {
            FB.init({
                appId      : '{{ config('services.facebook.client_id') }}',
                cookie     : true,
                xfbml      : true,
                version    : 'v2.6'
            });
        };

        (function(d, s, id){
            var js, fjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id)) {return;}
            js = d.createElement(s); js.id = id;
            js.src = "//connect.facebook.net/en_US/sdk.js";
            fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));
    </script>
    <nav class="navbar navbar-default navbar-static-top">
        <div class="container">
            <div class="navbar-header">

                <!-- Collapsed Hamburger -->
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                    <span class="sr-only">Toggle Navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>

                <!-- Branding Image -->
                <a class="navbar-brand" href="{{ url('/') }}">
                    <img src="{{ config('site.logo') }}" alt="{{ config('site.brand') }}" height="50" style="position:relative; margin-top:-15px;">
                </a>
            </div>

            <div class="collapse navbar-collapse" id="app-navbar-collapse">
                <!-- Left Side Of Navbar -->
                @if(Auth::user())
                <ul class="nav navbar-nav">
                    <li{!! array_get($__rp, 'menu') == 'dashboard' ? ' class="active"' : '' !!}><a href="{{ route('projects.index') }}">Dashboard</a></li>
                    @if(count($__menu_projects) > 0)
                        <li class="dropdown{{ array_get($__rp, 'menu') == 'projects' ? ' active' : '' }}">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                Bots <span class="caret"></span>
                            </a>

                            <ul class="dropdown-menu" role="menu">
                                @foreach($__menu_projects as $__menu_project)
                                    <li><a href="{{ route('projects.show', $__menu_project->id) }}">{{ $__menu_project->title }}</a></li>
                                @endforeach
                            </ul>
                        </li>
                    @endif
                </ul>
                @endif

                <!-- Right Side Of Navbar -->
                <ul class="nav navbar-nav navbar-right">
                    <!-- Authentication Links -->
                    @if (Auth::guest())
                        <li><a href="{{ url('/login') }}">Login</a></li>
                        <li><a href="{{ url('/register') }}">Register</a></li>
                    @else
                      @if(Auth::user()->isImpersonating())
                        <li><a href="{{ route('admin.users.deimpersonate', Auth::user()->id) }}">Stop Impersonate</a></li>
                      @endif
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                {{ Auth::user()->display_name }} <span class="caret"></span>
                            </a>

                            <ul class="dropdown-menu" role="menu">
                                <li><a href="{{ route('account.index') }}"><i class="fa fa-btn fa-user"></i>Account</a></li>
                                <li><a href="{{ url('/logout') }}"><i class="fa fa-btn fa-sign-out"></i>Logout</a></li>

                                @can('access.admin')
                                    <li role="separator" class="divider"></li>
                                    <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-btn fa-dashboard"></i>Admin panel</a></li>
                                @endcan
                            </ul>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </nav>

    @stack('ngTemplates')

    @yield('content')

    <footer>
        <div class="footer">
            <hr>
            <div class="text-right text-muted small">All Rights Reserve: {{ config('site.brand') }}</div>
        </div>
    </footer>

    @stack('modals')

    <!-- JavaScripts -->
    <script src="{{ elixir('js/all.js') }}"></script>

    @stack('scripts')
</body>
</html>
