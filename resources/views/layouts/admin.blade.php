<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">

        <!-- Favicon-->
        <link rel="icon" href="{{asset('/images/admin-favicon.png')}}" type="image/png">

        <meta name="csrf-token" content="{{ csrf_token() }}"/>
        <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" integrity="sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp" crossorigin="anonymous">
        <link href="https://fonts.googleapis.com/css?family=Anton|Roboto" rel="stylesheet"> 
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
        <link rel="stylesheet" href="{{ asset('css/admin.css') }}" type="text/css"/>
        <script>
            var base_url_api = window.base_url_api = "{{URL::to('/api')}}";
            var delete_url = window.delete_url = "{{ asset('admin/delete/') }}";
            var base_table_name = window.base_table_name = "{{ !empty($tableName) ? $tableName : null }}";
            var base_view_name = window.base_view_name = "{{ $viewName }}"
            var slamjam = {};
        </script>
        <title>Slam Jam - @yield('title') - Admin panel</title>
    </head>
    <body>
        <div class="modal-box modal-update-box" id="modal-update-box">
            <div class="modal-box-inner">
                <div class="modal-box-header">
                    <div class="modal-close">
                        <i class="fas fa-times"></i>
                    </div>
                </div>
                <div class="modal-box-content">
                    <div class="data-form">
                        <h3 id="form-title"></h3>
                        <div class="alert alert-danger" id="form-errors">
                            <a href="#" class="close" data-hide="alert" id="hide-form-errors" aria-label="close">&times;</a>
                            <span></span>
                        </div>
                        @yield('dataForm')
                    </div>
                </div>
                <div class="modal-confirm" id="modal-confirm">
                    <a id="modal-confirm-yes" href="#" data-operation="" class="btn btn-primary">Save</a>
                    <a id="modal-confirm-no" class="btn btn-danger">Cancel</a>
                </div>
            </div>
        </div>
        <!-- LOADER -->
        <div class="loading-overlay" id="loading-overlay"><img src="{{ asset('/images/loading.svg') }}" /></div>
        <!-- /LOADER -->
        <div class="main-container">
            <div class="menu-container">
                <div class="menu">
                    <h2 class="title"><a href="{{ asset('/') }}" target="_blank">SLAM JAM</a></h2>
                    <h3 class="sub-title">ADMIN PANEL</h3>
                    <p class="dashboards-title">DASHBOARDS</p>
                    <ul class="admin-menu-list">
                        @foreach($adminNav as $item)
                            <li @if($item['status'] == 'unfinished') class='strike-through' @endif @if(url('/admin/' . $item['url']) == $currentUrl) class="active" @endif><a href="{{ asset('/admin/' . $item['url']) }}">{{ $item['name'] }}</a></li>
                        @endforeach
                    </ul>
                </div>
                <div class="menu-open">
                    <span></span>
                    <a href="{{ asset('/logout') }}" class="admin-log-out">
                        <i class="fas fa-sign-out-alt has-tooltip"><i class="tooltip">Log out</i></i>
                    </a>
                </div>
            </div>
            <div class="main-content">
                <h2>@yield('title')</h2>
                <div class="main-commands">
                    @yield('commands')
                </div>
                <div class="content" id="content">
                    @yield('content')
                </div>
            </div>
        </div>
        @yield('jsfiles')
        <script src="{{asset('/js/admin.js')}}"></script>
    </body>
</html>