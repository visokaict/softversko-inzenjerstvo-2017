@extends('layouts.frontEnd')

@section('pageTitle')
    Game Name
@endsection

@section('cssfiles')
    <link href="{{asset('css/game.css')}}" rel="stylesheet" type="text/css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css" rel="stylesheet"
          type="text/css">
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

    <div class="game-content container">
        <div class="game-content-left col-lg-8 col-md-8 col-sm-8 col-xs-12 float-left">
            <h4>Description:</h4>
            <p>{{$gameSubmission->description}}</p>
        </div>
        <div class="game-content-right col-lg-4 col-md-4 col-sm-4 col-xs-12 float-right">
            <h4>Badges:</h4>
            <div>
                Load bages with javascript
            </div>
        </div>
        <div class="clearfix"></div>
        <div class="game-comments col-md-12">
            <h4>Comments:</h4>
            <div>
                Load bages with javascript
            </div>
        </div>
    </div>
    <!-- -->
@endsection

@section('jsfiles')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
    <script>
        $(document).ready(function () {

            //sliders
            $('.owl-carousel').owlCarousel({
                loop: true,
                margin: 10,
                autoplay: true,
                autoplayHoverPause: true,
                responsive: {
                    0: {
                        items: 1
                    },
                    600: {
                        items: 3
                    },
                    1000: {
                        items: 5
                    }
                }
            });

            // todo
            // one function

            // scrolling navigation

            var scroll = Math.floor($(window).scrollTop() * 0.2 - 150);

            $(".game-cover-image").css("transform", "translate3d(0, " + scroll + "px, 0");

            $('.nav-tabs-custom ul.nav-tabs li a').click(function (e) {
                $('ul.nav-tabs li.active').removeClass('active');
                $(this).parent('li').addClass('active');
            })

            $(window).scroll(function () {
                scroll = Math.floor($(window).scrollTop() * 0.2 - 150);
                $(".game-cover-image").css("transform", "translate3d(0, " + scroll + "px, 0");
            });
        });
    </script>
@endsection