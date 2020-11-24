<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <!-- BootstrapのCSS読み込み -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.14.0/css/all.css" integrity="sha384-HzLeBuhoNPvSl5KYnjx0BT+WB0QEEqLprO+NBkkk5gbc67FTaL7XIGa2w1L0Xbgc" crossorigin="anonymous">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">

</head>
<body>
    <div id="app">
        <nav class="navbar navbar-default navbar-static-top">
            <div class="container">
                <div class="navbar-header">

                    <!-- Collapsed Hamburger -->
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse" aria-expanded="false">
                        <span class="sr-only">Toggle Navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>

                    <!-- Branding Image -->
                    <a class="navbar-brand" href="{{ url('/') }}">
                    <i class="fas fa-heartbeat"></i> {{ config('app.name', 'Laravel') }}
                    </a>
                </div>

                <div class="collapse navbar-collapse" id="app-navbar-collapse">
                    <!-- Left Side Of Navbar -->
                    <ul class="nav navbar-nav" style= "margin: 0px; padding: -5px">
                        
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="nav navbar-nav navbar-right">
                    <!-- <ul class="nav navbar-nav navbar-right"> -->

                        <!-- Authentication Links -->
                        @guest
                            <li><a href="{{ route('login') }} " style= "text-align: right;">Login <i class="fas fa-sign-in-alt"></i></a></li>
                            <li><a href="{{ route('register') }}"style= "text-align: right;">Register <i class="fas fa-address-card"></i></a></li>
                        @else
                            <li class="dropdown">
                                @if(!empty(Auth::user()->pro_image))
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false" aria-haspopup="true" v-pre style= "text-align: right;">
                                <img src="{{ asset('storage/pro_image/'.Auth::user()->pro_image) }}" class="editpro_image"style= "width: 25px;
                                    height: 25px;
                                    background: #eee;
                                    border-radius: 50%;
                                    object-fit: cover;
                                    ">
                                {{ Auth::user()->name }} <span class="caret"></span>
                                </a>
                                @else
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false" aria-haspopup="true" v-pre style= "text-align: right;">
                                <img src="{{ asset('storage/noimage/noimage.png') }}" class="noimage" 
                                style= "width: 25px;
                                height: 25px;
                                background: #eee;
                                border-radius: 50%;
                                object-fit: cover;
                                "> 
                                {{ Auth::user()->name }} <span class="caret"></span>
                                </a>
                                @endif
 
                                <ul class="dropdown-menu">
                                    <li>
                                        <!-- <a href="{{route('users.edit', $user = \Auth::user())}}" class="item" style= "text-align: right; padding: 3px 35px;">プロフィール <i class="fas fa-user-circle"></i></i></a> -->
                                        <a href="{{ route('users.show', Auth::user()->id) }}" class="item" style= "text-align: right; padding: 3px 35px;">プロフィール <i class="fas fa-user-circle"></i></i></a>
                                        <a href="{{route('posts.create')}}" class="item" style= "text-align: right; padding: 3px 35px;">投稿する <i class="fas fa-comment-dots"></i></a>
                                        <a href="{{ route('logout') }}"
                                            onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();" style= "text-align: right; padding: 3px 35px;">
                                            Logout <i class="fas fa-sign-out-alt"></i>
                                        </a>

                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                        </form>
                                    </li>
                                </ul>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                    @yield('content')
                </div>
            </div>
        </div>
    </div>
 </div>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('js/open.js') }}"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    </body>
</html>
