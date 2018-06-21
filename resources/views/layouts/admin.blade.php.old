<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <title>Slam Jam Admin - @yield("pageTitle")</title>
    
        <!-- Favicon-->
        <link rel="icon" href="../favicon.ico" type="image/x-icon">
    
        <!-- Google Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Roboto:400,700&subset=latin,cyrillic-ext" rel="stylesheet" type="text/css">
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css">
    
        <!-- Bootstrap Core Css -->
        <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
    
        <!-- Waves Effect Css -->
        <link href="https://cdn.jsdelivr.net/npm/node-waves@0.7.6/dist/waves.min.css" rel="stylesheet" />
    
        <!-- Animation Css -->
        <link href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.min.css" rel="stylesheet" />
    
        <!-- Custom Css -->
        <link href="https://cdn.rawgit.com/gurayyarar/AdminBSBMaterialDesign/46c70c12/css/style.min.css" rel="stylesheet">
    
        <!-- AdminBSB Themes. You can choose a theme from css/themes instead of get all themes -->
        <link href="https://cdn.rawgit.com/gurayyarar/AdminBSBMaterialDesign/46c70c12/css/themes/theme-purple.min.css" rel="stylesheet" />
    
        <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
        @yield("styles")
    </head>

    <body class="theme-red">
    
<div class="page-loader-wrapper">
    <div class="loader">
        <div class="preloader">
            <div class="spinner-layer pl-red">
                <div class="circle-clipper left">
                    <div class="circle"></div>
                </div>
                <div class="circle-clipper right">
                    <div class="circle"></div>
                </div>
            </div>
        </div>
        <p>Please wait...</p>
    </div>
</div>
    
        <div class="overlay"></div>
    
        <nav class="navbar">
            <div class="container-fluid">
                <div class="navbar-header">
                    <a href="javascript:void(0);" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse" aria-expanded="false"></a>
                    <a href="javascript:void(0);" class="bars"></a>
                <a class="navbar-brand" href="{{-- route("home") --}}">Blog - Dashboard</a>
                </div>
                <div class="collapse navbar-collapse" id="navbar-collapse">
                    <ul class="nav navbar-nav navbar-right">
                        <li><a href="#">Logout</a></li>
                    </ul>
                </div>
            </div>
        </nav>
    
        <section>
    
    
            <!-- Left Sidebar -->
<aside id="leftsidebar" class="sidebar">
    <div class="user-info">
        <div class="image">
            <img src="{{ asset("admin/images/user.png") }}" width="48" height="48" alt="User" />
        </div>
        <div class="info-container">
            <div class="name" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">{{-- session()->get('user')->first_name . " " . session()->get('user')->last_name  --}}</div>
            <div class="email">{{-- session()->get('user')->email --}}</div>
        </div>
    </div>
    <!-- Menu -->
        <div class="menu">
            <ul class="list">
                <li class="header">MAIN NAVIGATION</li>
                <li>
                    <a href="{{-- route("home") --}}">
                        <i class="material-icons">home</i>
                        <span>Back to website</span>
                    </a>
                </li>
                <li class="active">
                    <a href="javascript:void(0);" class="menu-toggle">
                        <i class="material-icons">person</i>
                        <span>Users</span>
                    </a>
                    <ul class="ml-menu">
                        <li>
                            <a href="{{-- route("users.create") --}}">Add</a>
                        </li>
                        <li>
                            <a href="{{-- route("users.index") --}}">Show</a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="javascript:void(0);" class="menu-toggle">
                        <i class="material-icons">menu</i>
                        <span>Navigation</span>
                    </a>
                    <ul class="ml-menu">
                        <li>
                            <a href="{{-- route("navigation.create") --}}">Add</a>
                        </li>
                        <li>
                            <a href="{{-- route("navigation.index") --}}">Show</a>
                        </li>
                    </ul>
                </li>
                
            </ul>
        </div>
        <!-- #Menu -->
        <!-- Footer -->
        <div class="legal">
            <div class="copyright">
                &copy; 2016 - 2017 <a href="javascript:void(0);">AdminBSB - Material Design</a>.
            </div>
            <div class="version">
                <b>Version: </b> 1.0.5
            </div>
        </div>
        <!-- #Footer -->
    </aside>
    <!-- #END# Left Sidebar -->
    
    
        </section>
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="card">
                            <div class="header">
                                <h2>
                                    {{-- $title --}}
                                    <small>{{-- $subtitle --}}</small>
                                </h2>
                                <ul class="header-dropdown m-r--5">
                                    <li class="dropdown">
                                        <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                            <i class="material-icons">more_vert</i>
                                        </a>
                                        <ul class="dropdown-menu pull-right">
                                            <li><a href="{{-- route($indexRoute) --}}">Show All</a></li>
                                            <li><a href="{{-- route($createRoute) --}}">Add New</a></li>
                                        </ul>
                                    </li>
                                </ul>
                            </div>
                            <div class="body">
                                @yield("content")
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </section>


        <!-- Jquery Core Js -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>

<!-- Bootstrap Core Js -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.6/js/bootstrap.min.js"></script>

<!-- Select Plugin Js -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/js/bootstrap-select.min.js"></script>

<!-- Slimscroll Plugin Js -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jQuery-slimScroll/1.3.0/jquery.slimscroll.min.js"></script>

<!-- Waves Effect Plugin Js -->
<script src="https://cdn.jsdelivr.net/npm/node-waves@0.7.6/dist/waves.min.js"></script>

<!-- Custom Js -->
<script src="https://cdn.rawgit.com/gurayyarar/AdminBSBMaterialDesign/46c70c12/js/admin.js"></script>

<!-- Demo Js -->
<script src="https://cdn.rawgit.com/gurayyarar/AdminBSBMaterialDesign/46c70c12/js/demo.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

@yield("scripts")

<script>
    @if(Session::has('error'))
    toastr.error("{{ Session::get("error") }}")
    @endif

    @if(Session::has('success'))
    toastr.success("{{ Session::get("success") }}")
    @endif

    @if($errors->any())
    @foreach($errors->all() as $err)
    toastr.info("{{ $err }}");
    @endforeach
    @endif
</script>
   

</body>
</html>