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
                            <div class="item">
                                <a href="{{asset($screenShot->path)}}">
                                    <img src="{{asset($screenShot->path)}}" alt="game submission screenshot">
                                </a>
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

    @if(session()->has('user') && session()->get('user')[0]->idUser == $gameSubmission->idUser)
        <!-- edit and remove -->
            <div class="row">
                <div class="col-md-offset-8 col-md-4">
                    <button class="btn btn-primary pull-right" style="margin-left: 20px;">Delete game jam</button>
                    <a class="btn btn-primary pull-right"
                       href="{{asset('/games/'. $gameSubmission->idGameSubmission.'/edit')}}">Edit game jam</a>
                </div>
            </div>
            <br>
            <br>
        @endif


        <div class="row">
            <div class="col-md-8 col-xs-12">
                <div class="col-md-12 gs-min-height-100" style="padding: 0 0 30px 0;">
                    <h4>Downloads:</h4>
                    <br>

                    @foreach($gameSubmissionDownloadFiles as $gameFiles)
                        <div class="row">
                            <div>
                                <div class="col-md-3">
                                    {{--
                                    session()->has('user')
                                    // we can make that user needs to be logedin first to be able to download files
                                    --}}
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
                @if(session()->has('user') && session()->get('user')[0]->idUser != $gameSubmission->idUser)
                    <form class="row">
                        <div class="col-md-8 col-xs-8 col-sm-8">
                            <select class="form-control" id="gamesBadgesList">
                                <option selected disabled>Select game badge...</option>
                                @foreach($gameBadgesList as $gameBadge)
                                    <option value="{{$gameBadge->idGameBadges}}">{{$gameBadge->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <button type="button" class="btn btn-primary pull-right" id="btnAddBadge">
                                Add Badge
                            </button>
                        </div>
                    </form>
                @else
                    <i>Please <a href="{{asset('/login')}}">login</a> to add badge to this <b>game</b>.</i>
                @endif

                <br>
                <br>

                <div class="row" id="badgesRenderedList">

                    {{--
                    <!-- foreach -->
                    <div class="col-md-4 col-xs-6 col-sm-4">
                        <img style="width: 100%;" src="{{asset('images/badges/audio.png')}}" alt="badge name" title="badge name">
                    </div>
                    <!-- / foreach -->
                    --}}

                </div>
            </div>

        </div>
        <hr>
        <div class="row">
            <div class="col-md-offset-2 col-md-8 col-xs-offset-0 col-xs-12 gs-min-height-100"
                 style="background-color: #dfdfdf">
                <h4>Comments:</h4>
                <br>

                <!-- Add comment -->
                <!-- make it as one component and just insert it->
                <!-- javascript will decide where to put comment -->
                <div id="add-comment">

                    <div class="row">
                        <form class="col-md-12">
                            <div class="form-group">
                                <label>Post a new Comment</label>
                                <textarea class="form-control resize-vertical" rows="3" id="comment" name="comment"
                                          {{session()->has('user')? '': 'disabled' }} placeholder="{{session()->has('user')? 'Comment text...': 'Please login into your accout to post comments' }}"></textarea>
                            </div>
                            <div class="form-group">
                                @if(session()->has('user'))
                                    <button type="button" class="btn btn-primary pull-right" id="btnAddComment">
                                        Add Comment
                                    </button>
                                @else
                                    <a class="btn btn-primary pull-right" href="{{asset('/login')}}">Login to
                                        comment</a>
                                @endif
                            </div>
                        </form>
                    </div>

                </div>


                <!-- Comments List -->
                <div>

                    <ul id="comments-list" class="comments-list">


                        <li>
                            <div class="comment-main-level">
                                <!-- Avatar -->
                                <div class="comment-avatar"><img
                                            src="https://api.adorable.io/avatars/285/goran@gmail.com" alt=""></div>
                                <!-- Contenedor del Comentario -->
                                <div class="comment-box">
                                    <div class="comment-head">
                                        <h6 class="comment-name by-author"><a
                                                    href="http://creaticode.com/blog">goran</a></h6>
                                        <span>2018-05-26 02:06:16</span>

                                        {{--
                                        var timeagoInstance = timeago();
                                        timeagoInstance.format('2016-06-12');
                                        --}}

                                        <i class="fa fa-times"></i>
                                    </div>
                                    <div class="comment-content">
                                        Lorem ipsum dolor sit amet, consectetur adipisicing elit. Velit omnis animi et
                                        iure laudantium vitae, praesentium optio, sapiente distinctio illo?
                                    </div>
                                </div>
                            </div>
                        </li>


                        <li>
                            <div class="comment-main-level">
                                <!-- Avatar -->
                                <div class="comment-avatar"><img
                                            src="https://api.adorable.io/avatars/285/nikola@gmail.com" alt=""></div>
                                <!-- Contenedor del Comentario -->
                                <div class="comment-box">
                                    <div class="comment-head">
                                        <h6 class="comment-name"><a href="http://creaticode.com/blog">nikola</a></h6>
                                        <span> at 2018-05-26 02:06:16</span>
                                        <i class="fa fa-reply"></i>
                                        <i class="fa fa-heart"></i>
                                    </div>
                                    <div class="comment-content">
                                        Lorem ipsum dolor sit amet, consectetur adipisicing elit. Velit omnis animi et
                                        iure laudantium vitae, praesentium optio, sapiente distinctio illo?
                                    </div>
                                </div>
                            </div>
                        </li>
                    </ul>

                    <!-- /one comment - Foreach -->
                </div>
                <!-- /Comments List -->


            </div>
        </div>

    </div>
    <!-- -->
@endsection

@section('jsfiles')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/jquery.magnific-popup.js"></script>
    <script src="https://cdn.rawgit.com/hustcc/timeago.js/e8354c59/dist/timeago.min.js"></script>
    <script>
        var idGameSubmission = "{{$gameSubmission->idGameSubmission}}";
        $(document).ready(function () {
            slamjam.games.initOneGamePage();
            slamjam.badges.initBadgesOnGamesPage();
        });
    </script>
@endsection