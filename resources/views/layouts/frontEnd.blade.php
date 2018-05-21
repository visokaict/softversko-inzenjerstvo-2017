<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Game Jams - @yield('pageTitle')</title>

    <link href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">

    <link href="{{asset('css/main.css')}}" rel="stylesheet" type="text/css">

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" integrity="sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp"
      crossorigin="anonymous">

  @yield('cssfiles')
</head>

<body>
  <nav class="navbar navbar-inverse" style="border-radius:0">
    <div class="container-fluid">
      <div class="navbar-header">
        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1"
          aria-expanded="false">
          <span class="sr-only">Toggle navigation</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="#" style="margin-right:10px">Slam Jam</a>
      </div>
      <!-- Collect the nav links, forms, and other content for toggling -->
      <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
        <ul class="nav navbar-nav">
          <li class="active">
            <a href="{{asset('/')}}">Game Jams
              <span class="sr-only">(current)</span>
            </a>
          </li>
          <li>
            <a href="{{asset('/games')}}">Games</a>
          </li>
          <li>
            <a href="{{asset('/about')}}">About</a>
          </li>
          <li>
            <a href="{{asset('/contact-us')}}">Contact us</a>
          </li>
        </ul>

        <form class="navbar-form navbar-left">
          <div class="input-group">
            <input type="text" class="form-control" placeholder="Search" name="q">
            <div class="input-group-btn">
              <button class="btn btn-default" type="submit">
                <i class="glyphicon glyphicon-search"></i>
              </button>
            </div>
          </div>
        </form>
        <ul class="nav navbar-nav navbar-right">
          <li>
            <a href="{{asset('/login')}}">Login</a>
          </li>
          <li>
            <a href="{{asset('/register')}}">Register</a>
          </li>
          <li>
            <a href="{{asset('/logout')}}">Logout</a>
          </li>
        </ul>
      </div>
      <!-- /.navbar-collapse -->
    </div>
    <!-- /.container-fluid -->
  </nav>

  <!-- Page Content -->
  <div class="container main-container">
      @yield('content')
  </div>
  <!-- /.container -->

<footer class="custom-footer">
<div class="footer" id="footer">
    <div class="container">
        <div class="row">
            <div class="col-lg-4 col-md-4 col-sm-6 col-xs-6">
                <h3> Slam Jam </h3>
                <p>Slam Jam is a place for hosting and participating in game jams online. Anyone can start hosting a game jam immediately.</p>

            </div>
            <div class="col-lg-4 col-md-4 col-sm-6 col-xs-6">
                <h3> Contact info </h3>
                <ul>
                    <li> <a href="#"> Lorem Ipsum </a> </li>
                    <li> <a href="#"> Lorem Ipsum </a> </li>
                    <li> <a href="#"> Lorem Ipsum </a> </li>
                    <li> <a href="#"> Lorem Ipsum </a> </li>
                </ul>
            </div>

            <div class="col-lg-4 col-md-4 col-sm-6 col-xs-6">
                <h3> Social links </h3>
                <ul class="social">
                    <li><a href="#"><i class="fab fa-facebook"></i></a></li>
                    <li><a href="#"><i class="fab fa-twitter"></i></a></li>
                    <li><a href="#"><i class="fab fa-google-plus"></i></a> </li>
                    <li><a href="#"><i class="fab fa-pinterest"></i></a> </li>
                    <li><a href="#"><i class="fab fa-youtube"></i></a> </li>
                </ul>
            </div>

        </div>
        <!--/.row-->
    </div>
    <!--/.container-->
</div>
<!--/.footer-->

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

  @yield('jsfiles')

</body>

</html>