<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" type="image/png" href="{{asset('/favicon.png')}}"/>
    <title>Game Jams - @yield('pageTitle')</title>

    <link href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet"
          id="bootstrap-css">

    <link href="{{asset('css/main.css')}}" rel="stylesheet" type="text/css">

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css"
          integrity="sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp"
          crossorigin="anonymous">
    <script>var slamjam = window.slamjam = {}; </script>

    @yield('cssfiles')
</head>

<body>
<nav class="navbar navbar-inverse" style="border-radius:0">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                    data-target="#bs-example-navbar-collapse-1"
                    aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand nav-title" href="{{ asset('/') }}"><span>Slam Jam</span><img src="{{ asset('/images/logo.png') }}" class="slam-jam-logo" alt="Logo"/></a>
        </div>
        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav" id="navigation">
                @isset($navigation)
                    @foreach($navigation as $n)
                        @if(url($n->path) == Request::url())
                            <li class="active">
                                <a href="{{url($n->path)}}">{{ $n->name }}
                                    <span class="sr-only">(current)</span>
                                </a>
                            </li>
                        @else
                            <li><a href="{{ url($n->path) }}">{{ $n->name }}</a></li>
                        @endif
                    @endforeach
                @endisset

                @if(session()->has('roles'))
                    @if(\App\Http\Models\Roles::arrayOfRolesHasRoleByName(session()->get('roles')[0], 'admin'))
                        <li><a href="{{ asset('/admin') }}" style="color: red !important;">Admin panel</a></li>
                    @endif
                @endif

            </ul>

            <form class="navbar-form navbar-left">
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="Search" name="q" id="tbSearch">
                    <div class="input-group-btn">
                        <button class="btn btn-default" type="submit">
                            <i class="glyphicon glyphicon-search"></i>
                        </button>
                    </div>
                </div>
            </form>
            <ul class="nav navbar-nav navbar-right">
                @if(!session()->has('user'))
                    <li>
                        <a href="{{asset('/login')}}">Login</a>
                    </li>
                    <li>
                        <a href="{{asset('/register')}}">Register</a>
                    </li>
                @else
                        <li class="avatar-li">
                            <img src="{{ asset($userDataProvider->avatarImagePath) }}" class="user-nav-avatar" />
                        </li>
                        <li class="dropdown">
                            <a href="javascript:void(0)" class="dropdown-toggle" data-toggle="dropdown">
                                {{ session()->get('user')[0]->username }} <b class="caret"></b>
                            </a>
                            <ul class="dropdown-menu">
                                <li><a href="{{asset('/profile')}}"><span class="glyphicon glyphicon-user"></span> Profile</a></li>
                                <li class="divider"></li>
                                <li><a href="{{asset('/logout')}}"><span class="glyphicon glyphicon-off"></span> Logout</a></li>
                            </ul>
                        </li>
                @endif
            </ul>
        </div>
        <!-- /.navbar-collapse -->
    </div>
    <!-- /.container-fluid -->
</nav>

<!-- Page Content -->
<div class="container main-container">
    <div class="row">
        @if(session()->has('message'))
            <div class="col-md-offset-1 col-md-10 alert alert-info">{{session()->get('message')}}</div>
        @endif
    </div>

    @yield('content')
</div>
<!-- /.container -->

<footer class="custom-footer">
    <div class="footer" id="footer">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-md-4 col-sm-6 col-xs-6">
                    <h3> Slam Jam </h3>
                    <p>Slam Jam is a place for hosting and participating in game jams online. Anyone can start hosting a
                        game jam immediately.</p>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-6 col-xs-6">
                    <h3> Contact info </h3>
                    <ul class="list-no-style">
                        <li>Keas 69 Str.</li>
                        <li>15234, Chalandri</li>
                        <li>Athens,</li>
                        <li>Greece</li>
                        <li></li>
                        <li>+30-2106019311 (landline)</li>
                        <li>+30-6977664062 (mobile phone)</li>
                        <li>+30-2106398905 (fax)</li>
                    </ul>
                </div>

                <div class="col-lg-4 col-md-4 col-sm-6 col-xs-6">
                    <h3> Social links </h3>
                    <div class="center-block gray-color-social">
                        <a href="https://www.facebook.com/#"><i id="social-fb"
                                                                class="fab fa-facebook-square fa-3x social"></i></a>
                        <a href="https://twitter.com/#"><i id="social-tw"
                                                           class="fab fa-twitter-square fa-3x social"></i></a>
                        <a href="https://plus.google.com/#"><i id="social-gp"
                                                               class="fab fa-google-plus-square fa-3x social"></i></a>
                        <a href="https://www.pinterest.com/#"><i id="social-pr"
                                                                 class="fab fa-pinterest fa-3x social"></i></a>
                        <a href="https://www.youtube.com/#"><i id="social-yt"
                                                               class="fab fa-youtube fa-3x social"></i></a>
                    </div>
                </div>

            </div>
            <!--/.row-->
        </div>
        <!--/.container-->
    </div>
    <!--/.footer-->
    <br>
    <br>
    <div class="footer-bottom">
        <div class="container">
            <p class="pull-left"> Copyright © Slam Jam 2018. All right reserved. </p>
        </div>
    </div>
    <!--/.footer-bottom-->
</footer>

<!-- Bootstrap core JavaScript -->
<script src="{{asset('vendor/jquery/jquery.min.js')}}"></script>
<script src="{{asset('vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<script type="text/javascript">
    $("#tbSearch").focus(function () {
        $(this).addClass("expand-width");
        $(this).removeClass("shrink-width");
    });
    $("#tbSearch").blur(function () {
        $(this).addClass("shrink-width");
        $(this).removeClass("expand-width");
    });
</script>

@yield('jsfiles')

</body>

</html>