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
                        <div id="gameNumOfDownloads">{{ $gameSubmission->numOfDownloads }}</div>
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
                <div class="col-md-4">
                    <a class="btn btn-primary"
                       href="{{asset('/games/'. $gameSubmission->idGameSubmission.'/edit')}}">Edit</a>
                    <a href="#" id="btn-remove-game-jam"
                       data-url="{{asset('/games/'. $gameSubmission->idGameSubmission.'/delete')}}"
                       data-text="Are you sure you want to remove this game?" class="btn btn-danger">Remove</a>
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
                        <div class="row download-row-game-submission">
                            <div>
                                <div class="col-md-3">
                                    {{--
                                    session()->has('user')
                                    // we can make that user needs to be logedin first to be able to download files
                                    --}}
                                    <a class="btn btn-block btn-social btn-bitbucket"
                                       href="{{asset('/download/'.$gameFiles->idDownloadFile)}}"
                                       onclick="slamjam.downloads.increment()">
                                        <i class="fa fa-download"></i>
                                        Download
                                    </a>
                                </div>
                                <div class="col-md-6" style="padding: 8px 0 0 8px;">{{$gameFiles->name}}</div>
                                <div class="col-md-3 text-right" style="padding: 8px 20px 0 8px;">
                                    {{\App\Http\Models\Utilities::FormatBytes($gameFiles->size)}}
                                    <i class="{{$gameFiles->classNameForIcon}}"></i>
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
                @elseif(!session()->has('user'))
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

                    </ul>

                    <!-- /one comment - Foreach -->
                </div>
                <!-- /Comments List -->
                <!-- report -->


            </div>
        </div>

        @if(session()->has('user'))
            <br>
            <br>
            <br>
            <br>
            <div class="row game-report">
                <div class="col-md-offset-2 col-md-8 col-xs-offset-0 col-xs-12">

                    <div class="panel-group" id="accordion">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h4 class="panel-title">
                                    <a class="accordion-toggle collapsed" data-toggle="collapse"
                                       data-parent="#accordion"
                                       href="#collapseOne">
                                        <i class="fa fa-flag"></i> Report
                                    </a>
                                </h4>
                            </div>
                            <div id="collapseOne" class="panel-collapse collapse">
                                <div class="panel-body">

                                    <form action="{{asset('/report')}}" method="POST" data-toggle="validator"
                                          role="form">
                                        {{ csrf_field() }}

                                        <input type="hidden" name="gameId" value="{{$gameSubmission->idGameSubmission}}">

                                        <div class="form-group">
                                            <label for="description">Reason for reporting this game:</label>
                                            <textarea class="form-control resize-vertical" rows="5" id="taReason"
                                                      name="taReason" required >{{old('taReason')}}</textarea>
                                            <div class="help-block with-errors"></div>
                                        </div>

                                        <div class="row">
                                            <div class="col-xs-12 col-xs-offset-0 col-md-4 col-md-offset-8">
                                                <button type="submit" class="btn btn-primary btn-block btn-flat">Submit
                                                    report
                                                </button>
                                            </div>
                                        </div>
                                    </form>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif


    </div>
    <!-- -->





@endsection

@section('jsfiles')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/jquery.magnific-popup.js"></script>
    <script src="https://cdn.rawgit.com/hustcc/timeago.js/e8354c59/dist/timeago.min.js"></script>
    <script>
        var idGameSubmission = "{{$gameSubmission->idGameSubmission}}";
        var idGameSubmissionUserCreatorId = "{{$gameSubmission->idUserCreator}}";
        $(document).ready(function () {
            slamjam.common.confirmBox($("#btn-remove-game-jam"));

            slamjam.games.initOneGamePage();
            slamjam.badges.initBadgesOnGamesPage();
            slamjam.comments.initGameSubmissionComments();
        });
    </script>

    <script>
        $(function () {
            $("#chat-label").click(function () {

                $('#live-chat').toggleClass('open-chat');
                $('#chat-label').toggleClass('open-chat-label');
                $('.live-chat-up-arrow').toggleClass('hide-up-arrow');
                $('.live-chat-down-arrow').toggleClass('show-down-arrow');

            });
        });
    </script>
@endsection