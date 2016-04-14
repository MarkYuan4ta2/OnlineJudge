<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('title')</title>

    <!-- Fonts -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css" rel='stylesheet' type='text/css'>
    <link href="https://fonts.googleapis.com/css?family=Lato:100,300,400,700" rel='stylesheet' type='text/css'>

    <!-- Styles -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">


    <link href="{{ asset('themes/default/css/index.css') }}" rel="stylesheet" type="text/css">
    <!--各页面导入各自的样式表-->
    @yield('style')
    <link rel="shortcut icon" href="{{ asset('themes/default/images/ico/32.png') }}" sizes="32x32" type="image/png"/>
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="{{ asset('themes/default/images/ico/72.png') }}" type="image/png"/>
    <link rel="apple-touch-icon-precomposed" sizes="120x120" href="{{ asset('themes/default/images/ico/120.png') }}" type="image/png"/>
    <link rel="apple-touch-icon-precomposed" sizes="152x152" href="{{ asset('themes/default/images/ico/152.png') }}" type="image/png"/>


    <style>
        body {
            font-family: 'Lato';
        }

        .fa-btn {
            margin-right: 6px;
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
                    OnlineJudge
                </a>
            </div>

            <div class="collapse navbar-collapse" id="app-navbar-collapse">
                <!-- Left Side Of Navbar -->
                <ul class="nav navbar-nav">
                    <li><a href="{{ url('/problems') }}">{{ trans('messages.problems') }}</a></li>
                    <li><a href="{{ url('/submission') }}">{{ trans('messages.submission') }}</a></li>
                    <li><a href="{{ url('/contests') }}">{{ trans('messages.contests') }}</a></li>
                    <li><a href="{{ url('/groups') }}">{{ trans('messages.groups') }}</a></li>
                    <li><a href="{{ url('/help') }}">{{ trans('messages.help') }}</a></li>
                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="nav navbar-nav navbar-right">
                    <!-- Authentication Links -->
                    @if (Auth::guest())
                        <li><a href="{{ url('/login') }}">{{ trans('messages.login') }}</a></li>
                        <li><a href="{{ url('/register') }}">{{ trans('messages.register') }}</a></li>
                    @else
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                {{ Auth::user()->name }} <span class="caret"></span>
                            </a>

                            <ul class="dropdown-menu" role="menu">
                                @if(Auth::user()->is_admin)
                                    <li><a href="{{ url('/admin') }}"><i class="fa fa-btn"></i>Admin</a></li>
                                @endif
                                <li><a href="{{ url('/logout') }}"><i class="fa fa-btn fa-sign-out"></i>Logout</a></li>
                            </ul>

                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </nav>

    @yield('content')

    <!-- JavaScripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>

</body>
</html>
