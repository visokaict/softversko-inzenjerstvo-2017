@extends('layouts.admin')

@section('title')
    Overview
@endsection

@section('content')
    <!-- cards -->
    <div class="row">
        <!-- users -->
        <div class="col-lg-3 col-md-6 col-sm-6">
            <div class="card card-stats">
                <div class="card-body ">
                    <div class="row">
                        <div class="col-5 col-md-4">
                            <div class="icon-big text-center icon-warning">
                                <i class="far fa-user" style="color: #8EB8E5;"></i>
                            </div>
                        </div>
                        <div class="col-7 col-md-8">
                            <div class="numbers">
                                <p class="card-category">Users</p>
                                <p class="card-title" id="stats_count_users">0</p>
                                <p></p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer ">
                    <hr>

                    <div class="stats">
                        <div class="row">
                            <div class="col-md-8" style="padding-right: 0px;">
                                <span id="stats_chart_users">Loading..</span>
                            </div>
                            <div class="col-md-4">
                                <a href="{{asset('/admin/users')}}" class="pull-right">
                                    <i class="fa fa-arrow-circle-right"></i>
                                </a>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <!-- game jams -->
        <div class="col-lg-3 col-md-6 col-sm-6">
            <div class="card card-stats">
                <div class="card-body ">
                    <div class="row">
                        <div class="col-5 col-md-4">
                            <div class="icon-big text-center icon-warning">
                                <i class="fa fa-cube" style="color: #A1E8CC;"></i>
                            </div>
                        </div>
                        <div class="col-7 col-md-8">
                            <div class="numbers">
                                <p class="card-category">Game Jams</p>
                                <p class="card-title" id="stats_count_gamejams">0</p>
                                <p></p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer ">
                    <hr>
                    <div class="stats">
                        <div class="row">
                            <div class="col-md-8" style="padding-right: 0px;">
                                <span id="stats_chart_gamejams">Loading..</span>
                            </div>
                            <div class="col-md-4">
                                <a href="{{asset('/admin/game-jams')}}" class="pull-right">
                                    <i class="fa fa-arrow-circle-right"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- game submissions -->
        <div class="col-lg-3 col-md-6 col-sm-6">
            <div class="card card-stats">
                <div class="card-body ">
                    <div class="row">
                        <div class="col-5 col-md-4">
                            <div class="icon-big text-center icon-warning">
                                <i class="fa fa-gamepad" style="color: #EA638C;"></i>
                            </div>
                        </div>
                        <div class="col-7 col-md-8">
                            <div class="numbers">
                                <p class="card-category">Games</p>
                                <p class="card-title" id="stats_count_games">0</p>
                                <p></p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer ">
                    <hr>
                    <div class="stats">
                        <div class="row">
                            <div class="col-md-8" style="padding-right: 0px;">
                                <span id="stats_chart_games">Loading..</span>
                            </div>
                            <div class="col-md-4">
                                <a href="{{asset('/admin/game-submissions')}}" class="pull-right">
                                    <i class="fa fa-arrow-circle-right"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- reports -->
        <div class="col-lg-3 col-md-6 col-sm-6">
            <div class="card card-stats">
                <div class="card-body ">
                    <div class="row">
                        <div class="col-5 col-md-4">
                            <div class="icon-big text-center icon-warning">
                                <i class="far fa-flag" style="color: #FB8B24;"></i>
                            </div>
                        </div>
                        <div class="col-7 col-md-8">
                            <div class="numbers">
                                <p class="card-category">Reports</p>
                                <p class="card-title" id="stats_count_reports">0</p>
                                <p></p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer ">
                    <hr>
                    <div class="stats">
                        <div class="row">
                            <div class="col-md-8" style="padding-right: 0px;">
                                <span id="stats_chart_reports">Loading..</span>
                            </div>
                            <div class="col-md-4">
                                <a href="{{asset('/admin/reports')}}" class="pull-right">
                                    <i class="fa fa-arrow-circle-right"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <br>
    <hr class="sick">
    <br>

    <div class="row">
        <!-- comments -->
        <div class="col-lg-3 col-md-6 col-sm-6">
            <div class="card card-stats">
                <div class="card-body ">
                    <div class="row">
                        <div class="col-5 col-md-4">
                            <div class="icon-big text-center icon-warning">
                                <i class="far fa-comments" style="color: #F865B0;"></i>
                            </div>
                        </div>
                        <div class="col-7 col-md-8">
                            <div class="numbers">
                                <p class="card-category">Comments</p>
                                <p class="card-title" id="stats_count_comments">0</p>
                                <p></p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer ">
                    <hr>
                    <div class="stats">
                        <div class="row">
                            <div class="col-md-8" style="padding-right: 0px;">
                                <span id="stats_chart_comments">Loading..</span>
                            </div>
                            <div class="col-md-4">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- download files -->
        <div class="col-lg-3 col-md-6 col-sm-6">
            <div class="card card-stats">
                <div class="card-body ">
                    <div class="row">
                        <div class="col-5 col-md-4">
                            <div class="icon-big text-center icon-warning">
                                <i class="far fa-file" style="color: #09E85E;"></i>
                            </div>
                        </div>
                        <div class="col-7 col-md-8">
                            <div class="numbers">
                                <p class="card-category">Download files</p>
                                <p class="card-title" id="stats_count_downloadfiles">0</p>
                                <p></p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer ">
                    <hr>
                    <div class="stats">
                        <div class="row">
                            <div class="col-md-8" style="padding-right: 0px;">
                                <span id="stats_chart_downloadfiles">Loading..</span>
                            </div>
                            <div class="col-md-4">

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- images -->
        <div class="col-lg-3 col-md-6 col-sm-6">
            <div class="card card-stats">
                <div class="card-body ">
                    <div class="row">
                        <div class="col-5 col-md-4">
                            <div class="icon-big text-center icon-warning">
                                <i class="far fa-images" style="color: #DB504A;"></i>
                            </div>
                        </div>
                        <div class="col-7 col-md-8">
                            <div class="numbers">
                                <p class="card-category">Images</p>
                                <p class="card-title" id="stats_count_images">0</p>
                                <p></p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer ">
                    <hr>
                    <div class="stats">
                        <div class="row">
                            <div class="col-md-8" style="padding-right: 0px;">
                                <span id="stats_chart_images">Loading..</span>
                            </div>
                            <div class="col-md-4">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- polls -->
        <div class="col-lg-3 col-md-6 col-sm-6">
            <div class="card card-stats">
                <div class="card-body ">
                    <div class="row">
                        <div class="col-5 col-md-4">
                            <div class="icon-big text-center icon-warning">
                                <i class="fas fa-clipboard-list" style="color: #E7EFC5;"></i>
                            </div>
                        </div>
                        <div class="col-7 col-md-8">
                            <div class="numbers">
                                <p class="card-category">Polls</p>
                                <p class="card-title" id="stats_count_polls">0</p>
                                <p></p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer ">
                    <hr>
                    <div class="stats">
                        <div class="row">
                            <div class="col-md-8" style="padding-right: 0px;">
                                <span id="stats_chart_polls">Loading..</span>
                            </div>
                            <div class="col-md-4">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



@endsection

@section('jsfiles')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-sparklines/2.1.2/jquery.sparkline.min.js"></script>
    <script>
        //stuff to init
        $(function () {
            // this is from admin.js
            slamjam.dashboard.initDashboard();


            /*
                        $('.sparkline').each(function () {
                            var $this = $(this);
                            $this.sparkline(myvalues, {
                                type: 'line',
                                height: $this.data('height') ? $this.data('height') : '90',
                                width: '100%',
                                lineColor: $this.data('linecolor'),
                                fillColor: $this.data('fillcolor'),
                                spotColor: $this.data('spotcolor')
                            });
                        });
            */

        });
    </script>
@endsection