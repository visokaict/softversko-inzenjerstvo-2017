@extends('layouts.frontEnd')

@section('pageTitle')
    Game Jams
@endsection

@section('cssfiles')
    <link rel="stylesheet" href="https://rawgit.com/almende/vis/master/dist/vis-timeline-graph2d.min.css">
@endsection

@section('content')
    <header>
        <section class="about-us py-5 " id="about-us">
            <div class="mt-5">
                <div class="row">
                    <div class="container">
                        <h2 class="front-page-title text-center">Game Jams on Slam Jam</h2>
                        <hr style="border: 1px solid #eee;">
                        <p class="col-md-8 col-md-offset-2 text-center">Slam Jam is a place for hosting and
                            participating in game jams online. Anyone can start hosting a game jam immediately. Here you
                            can find some of the game jams that are going on.</p>
                    </div>
                    <div class="col-md-4 col-md-offset-4 tooltip-hover-trigger game-jam-host-holder">

                        <a
                                @if(session()->has('user'))

                                    @if(\App\Http\Models\Roles::arrayOfRolesHasRoleByName(session()->get('roles')[0], 'jamMaker'))
                                        href="{{asset('/game-jams/create')}}"
                                    @else
                                        href="{{asset('/profile/edit')}}"
                                    @endif

                                @else
                                    href="{{asset('/login')}}"
                                @endif
                                class="btn game-jam-host-button">Host your own Game Jam</a>

                        @if(session()->has('roles') && !\App\Http\Models\Roles::arrayOfRolesHasRoleByName(session()->get('roles')[0], 'jamMaker'))
                            <i class="generic-tooltip">Check roles in profile.</i>
                        @endif

                    </div>
                </div>
            </div>
        </section>
    </header>

    <!-- chart section -->
    <div class="container-fluid no-padding" id="container-chart">
        <div id="visualization">
            <h3 class="text-center no-game-jam hide" id="no-chart-game-jam">
                There is currently no active Game Jam.
            </h3>
        </div>
    </div>
    <!-- /chart section -->

    <!-- Page Content -->
    <div class="container-fluid no-padding">
        <h2 class="margin-bottom-40">Game Jams in progress</h2>
        <div class="game-jams-in-progress-container" id="game-jams-in-progress-container">
            @include('ajax.loadGameJamsInProgress')
        </div>

        <br>
        <hr style="border: 1px solid #eee;">
        <br>

        <h2 class="margin-bottom-40">Upcoming Game Jams</h2>
        <div class="game-jams-upcoming-container" id="game-jams-upcoming-container">
            @include('ajax.loadGameJamsUpcoming')
        </div>
    </div>
    <!-- /.container -->
@endsection

@section('jsfiles')
    <script src="https://rawgit.com/almende/vis/master/dist/vis.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            slamjam.gameJam.initChart();
            slamjam.gameJam.initGameJamItems();
        });
    </script>
@endsection