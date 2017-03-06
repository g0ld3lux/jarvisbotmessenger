<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('site.title') }} | Admin</title>

    <!-- Styles -->
    <link href="{{ elixir('css/all.css') }}" rel="stylesheet">
    <style>
    .navbar-default {
        background-color: #03a9f4;
        border-color: transparent;
        }
    .navbar-default .navbar-nav > li > a:hover, .navbar-default .navbar-nav > li > a:focus {
    color: #ffcdd2;
    background-color: transparent;
    }
   
    </style>
</head>
<body id="app-layout">
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
                <ul class="nav navbar-nav">
                    <li{!! array_get($__rp, 'menu') == 'dashboard' ? ' class="active"' : '' !!}><a href="{{ route('admin.dashboard') }}"><i class="fa fa-btn fa-dashboard"></i>Dashboard</a></li>
                    <li{!! array_get($__rp, 'menu') == 'users' ? ' class="active"' : '' !!}><a href="{{ route('admin.users.index') }}"><i class="fa fa-btn fa-users"></i>Users</a></li>
                    <li{!! array_get($__rp, 'menu') == 'features' ? ' class="active"' : '' !!}><a href="{{ route('admin.features.index') }}"><i class="fa fa-btn fa-star"></i>Features</a></li>
                    <li{!! array_get($__rp, 'menu') == 'packages' ? ' class="active"' : '' !!}><a href="{{ route('admin.packages.index') }}"><i class="fa fa-btn fa-dropbox"></i>Packages</a></li>

                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="nav navbar-nav navbar-right">
                    <!-- Authentication Links -->
                    @if (Auth::guest())
                        <li><a href="{{ url('/login') }}">Login</a></li>
                        <li><a href="{{ url('/register') }}">Register</a></li>
                    @else
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                {{ Auth::user()->display_name }} <span class="caret"></span>
                            </a>

                            <ul class="dropdown-menu" role="menu">
                                <li><a href="{{ route('projects.index') }}"><i class="fa fa-btn fa-arrow-left"></i>Back to application</a></li>
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

    @yield('content')

    <!-- JavaScripts -->
    <script src="{{ elixir('js/all.js') }}"></script>

    @stack('scripts')
</body>
</html>
