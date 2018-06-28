<!DOCTYPE html>
<html lang="en">

<head>
    <base href="{{ asset('/') }}">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" type="image/png" href="{{asset('/favicon.png?v=2')}}"/>
    <title>Game Jams - @yield('pageTitle')</title>

    <link href="https://fonts.googleapis.com/css?family=Ubuntu:400,700|Press+Start+2P" rel="stylesheet">

    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet"
          id="bootstrap-css">

    <link href="{{asset('css/main.css')}}" rel="stylesheet" type="text/css">

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css"
          integrity="sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp"
          crossorigin="anonymous">
    <script>
        var slamjam = window.slamjam = {};
        var base_url = window.base_url = "{{URL::to('/')}}";
        var base_url_api = window.base_url_api = "{{URL::to('/api')}}";
        @if(session()->has('user'))
        var __user = window.__user = {
            idUser: "{{$userDataProvider->idUser}}",
        };
        @endif

    </script>

    @yield('cssfiles')
</head>

<body>
<div class="modal-info">
    <div class="modal-info-inner">
        <div class="modal-info-header">
            <div class="modal-close">
                <i class="fas fa-times"></i>
            </div>
        </div>
        <div class="modal-info-content">
            <p class="modal-info-text">
                @if(session()->has('message'))
                    {{ session('message') }}
                @endif
            </p>
        </div>
        <div class="modal-confirm" id="modal-confirm">
            <a id="modal-confirm-yes" href="#" class="btn btn-danger">Yes</a>
            <a id="modal-confirm-no" class="btn btn-primary">No</a>
        </div>
    </div>
</div>
<!-- LOADER -->
<div class="loading-overlay" id="loading-overlay"><img src="{{ asset('/images/loading.svg') }}" /></div>
<!-- /LOADER -->

<nav class="navbar navbar-inverse @yield('addClassesToBodyCover')" style="border-radius:0">
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
            <a class="navbar-brand nav-title" href="{{ asset('/') }}"><img src="{{ asset('/images/logo.png') }}" class="slam-jam-logo"/><!--<span>Slam Jam</span>--></a>
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

            <form action="{{asset('/search')}}" method="GET" class="navbar-form navbar-left" data-toggle="validator" role="form">
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="Search" name="q" id="tbSearch" required>
                    <div class="input-group-btn">
                        <button class="btn btn-default" type="submit" title="Please first search something">
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

                                <li><a href="{{asset('/user/'. $userDataProvider->username .'/game-jams')}}"><span class="fa fa-cube"></span> My Game Jams</a></li>
                                <li><a href="{{asset('/user/'. $userDataProvider->username .'/games')}}"><span class="fa fa-gamepad"></span> My Game Submissions</a></li>
                                <li><a href="{{asset('/user/'. $userDataProvider->username .'/wins')}}"><span class="fa fa-trophy"></span> My Wins</a></li>

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
<div class="container main-container @yield('addClassesToBodyCover')">

    @if(session()->has('messages'))
        <div class="alert alert-success">
            <div>{{ session('messages') }}</div>
        </div>
    @endif

    <!--<div class="row alert-parent" id="alert-messages">
        @if(session()->has('message'))
            <div class="col-md-offset-1 col-md-10 alert alert-info">{{session()->get('message')}}</div>
        @endif
    </div>-->

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
    $(document).ready(function() {
        @if(session()->has('message'))
            $(".modal-info").css({"display": "block", "opacity": 1});
        @endif
        $(".modal-close, #modal-confirm-no").on("click", function() {
            $(".modal-info").animate({
                opacity: 0
            }, 150, function() {
                $(".modal-info").css("display", "none");
            });
        });
        $("#tbSearch").focus(function () {
            $(this).addClass("expand-width");
            $(this).removeClass("shrink-width");
        });
        $("#tbSearch").blur(function () {
            $(this).addClass("shrink-width");
            $(this).removeClass("expand-width");
        });
    });
</script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/1000hz-bootstrap-validator/0.11.9/validator.min.js"></script>
<script type="text/javascript" src="{{ asset('/js/main.js') }}"></script>

@yield('jsfiles')

</body>

</html>