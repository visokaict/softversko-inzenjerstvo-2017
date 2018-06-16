@extends('layouts.frontEnd')

@section('pageTitle')
    Game Name
@endsection

@section('cssfiles')
    <link href="{{asset('css/game.css')}}" rel="stylesheet" type="text/css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css" rel="stylesheet"
          type="text/css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/magnific-popup.min.css">
@endsection

@section('addClassesToBodyCover')
    one-game-container
@endsection

@section('content')
    <div class="game-cover-image-wrap">
        <div class="game-cover-image" style="background-image: url('{{ asset($gameSubmission->path) }}')">
        </div>
    </div>

    <div class="game-header">
        <div class="game-header-inner container">
            <div class="game-header-left float-left">
                <div>
                    <h2 class="game-jam-header-title">{{ $gameSubmission->title }}</h2>
                    <span>Submited by <a
                                href="{{ asset('/user/' . $gameSubmission->username) }}">{{ $gameSubmission->username }}</a></span>
                    <span style="color: #888;"> at {{ \App\Http\Models\Utilities::PrintDateTime( $gameSubmission->createdAt )}} </span>
                </div>
            </div>
            <div class="game-header-right float-right">
                <div class="row text-center">
                    <div class="col-md-8">
                        <div>{{ $gameSubmission->numOfDownloads }}</div>
                        <div>downloads</div>
                    </div>
                    <div class="col-md-4">
                        <div>{{ $gameSubmission->numOfViews }}</div>
                        <div>views</div>
                    </div>
                </div>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>

    <div class="game-header">
        <div class="game-header-inner container text-center">
            @if(count($gameSubmissionScreenShots))
                <div class="carousel-wrap">
                    <div class="owl-carousel">
                        @foreach($gameSubmissionScreenShots as $screenShot)
                            <div class="item"><img src="{{asset($screenShot->path)}}" alt="game submission screenshot">
                            </div>
                        @endforeach
                    </div>
                </div>
            @else
                <i>There is currently no screenshots for this game.</i>
            @endif

            <div class="clearfix"></div>
        </div>
    </div>

    <div class="game-content container" style="padding: 0 20px;">
        <div class="row">
            <div class="col-md-8 col-xs-12">
                <div class="col-md-12 gs-min-height-100" style="padding: 0 0 30px 0;">
                    <h4>Downloads:</h4>
                    <br>

                    @foreach($gameSubmissionDownloadFiles as $gameFiles)
                        <div class="row">
                            <div>
                                <div class="col-md-3">
                                    <button class="btn btn-block btn-social btn-bitbucket">
                                        <i class="fa fa-download"></i>
                                        Download
                                    </button>
                                </div>
                                <div class="col-md-6" style="padding: 8px 0 0 8px;">Text</div>
                                <div class="col-md-3" style="padding: 8px 0 0 8px;">
                                    2MB
                                    <i class="fab fa-windows"></i>
                                    <i class="fab fa-linux"></i>
                                    <i class="fab fa-android"></i>
                                    <i class="fab fa-apple"></i>
                                </div>
                            </div>
                        </div>
                    @endforeach

                </div>
                <div class="col-md-12 gs-min-height-100" style="padding: 0;">
                    <h4>Description:</h4>
                    <br>
                    <p>{{$gameSubmission->description}}</p>
                </div>
            </div>

            <div class="col-md-4 col-xs-12 gs-min-height-100">
                <h4>Badges:</h4>
                <br>

                //todo
            </div>

        </div>
        <hr>
        <div class="row">
            <div class="col-md-12 col-xs-12 gs-min-height-100">
                <h4>Comments:</h4>
                <br>
                //todo
            </div>
        </div>

    </div>
    <!-- -->
@endsection

@section('jsfiles')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/jquery.magnific-popup.js"></script>
    <script>
        $(document).ready(function () {
            slamjam.games.initOneGamePage();
        });
    </script>
@endsection