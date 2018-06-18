@extends('layouts.frontEnd')

@section('pageTitle')
  Game jam
@endsection

@section('cssfiles')
   <link href="{{asset('css/game.css')}}" rel="stylesheet" type="text/css">
@endsection

@section('addClassesToBodyCover')
    one-game-container
@endsection

@section('content')
<div class="game-cover-image-wrap">
    <div class="game-cover-image" style="background-image: url('{{ asset($gameJam->path) }}')">
</div>
    
</div>
<div class="game-header">
    <div class="game-header-inner container">
        <div class="game-header-left float-left">
            <div>
                <h2 class="game-jam-header-title">{{ $gameJam->title }}</h2>
                <span>Hosted by <a href="{{ asset('/user/' . $gameJam->username) }}">{{ $gameJam->username }}</a></span>
            </div>
        </div>
        <div class="game-header-right float-right">
            <div class="row text-center">
                <div class="col-md-4">
                <div>{{ count($gameJam->participants) }}</div>
                <div>joined</div>
                </div>
                <div class="col-md-4">
                    <div>{{ $gameJam->countSubmissions }}</div>
                    <div>submissions</div>
                </div>
                <div class="col-md-4">
                    <div>{{ $gameJam->numOfViews }}</div>
                    <div>views</div>
                </div>
            </div>
        </div>
        <div class="clearfix"></div>
   </div>
</div>
<div class="game-content container">
        <!-- game jam content -->
    <div class="one-game-jam-content">
    @if($userCanEditAndDeleteGameJam)
        <a href="{{ asset('/game-jams/'.$gameJam->idGameJam.'/edit') }}" class="btn btn-primary" style="padding-left: 25px; padding-right: 25px;">Edit</a>
        <a href="#" id="btn-remove-game-jam" data-url="{{ asset('/game-jams/'.$gameJam->idGameJam.'/delete') }}" data-text="Are you sure you want to remove this game jam?" class="btn btn-danger">Remove</a>  
    @endif
    <div class="row">

        <div class="countdown-timer text-center">
            <h1 class="countdown-timer-title">
                @if($gameJam->startDate > time())
                    Starts in 
                @elseif($gameJam->startDate < time() && $gameJam->endDate > time())
                    Submissions due in
                @elseif($gameJam->votingEndDate > time())
                    Voting ends in
                @else
                    This game jam has ended.
                @endif 
            </h1>
            @if($gameJam->votingEndDate > time())
            <div id="clockdiv">
                <div>
                    <span class="days"></span>
                    <div class="smalltext">Days</div>
                </div>
                <div>
                    <span class="hours"></span>
                    <div class="smalltext">Hours</div>
                </div>
                <div>
                    <span class="minutes"></span>
                    <div class="smalltext">Minutes</div>
                </div>
                <div>
                    <span class="seconds"></span>
                    <div class="smalltext">Seconds</div>
                </div>
            </div>
            @endif

            <div class="game-jam-join-buttons">
                @if(!$userJoinedGameJam)
                <div class="game-jam-join-button-holder tooltip-hover-trigger">
                    <a
                            @if(session()->has('user'))

                                @if(\App\Http\Models\Roles::arrayOfRolesHasRoleByName(session()->get('roles')[0], 'jamDeveloper'))
                                    href="{{ asset('/game-jams/'.$gameJam->idGameJam.'/join') }}"
                                @else
                                    href="{{asset('/profile/edit')}}"
                                @endif

                            @else
                                href="{{asset('/login')}}"
                            @endif
                            class="game-jam-join-button" >Join game jam</a>

                    @if(session()->has('roles') && !\App\Http\Models\Roles::arrayOfRolesHasRoleByName(session()->get('roles')[0], 'jamDeveloper'))
                        <i class="generic-tooltip">Check roles in profile.</i>
                    @endif
                </div>
                @else
                <div class="game-jam-join-button-holder">
                    <a href="#" id="game-jam-leave-button" data-url="{{ asset('/game-jams/'.$gameJam->idGameJam.'/leave') }}" data-text="Are you sure you want to leave this game jam?" class="game-jam-leave-button">Leave game jam</a>
                </div>
                @endif
                @if($gameJam->startDate < time() && $gameJam->endDate > time() && $userJoinedGameJam)
                <div class="game-jam-join-button-holder">
                    <a href="{{ asset('/games/create/' . $gameJam->idGameJam) }}" class="game-jam-add-button">Add game submission</a>
                </div>
                @endif
            </div>
        </div>
        </div>

        <div class="game-jam-description">
            <h4>Description:</h4>
            <p>{{ $gameJam->description }}</p>
        </div>

        <div class="game-criteria">
            <h4>Criteria:</h4>
            @if(count($gameJam->criteria) > 0)
                <ul>
                    @foreach($gameJam->criteria as $criteria)
                        <li>{{ $criteria->name }}</li>
                    @endforeach
                </ul>
            @else
                <i>There is no criteria for this game jam.</i>
            @endif
        </div>

        <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
                <li class="active"><a href="#tab_1" data-toggle="tab">Overview</a></li>
                <li><a href="#tab_2" data-toggle="tab">Participants</a></li>
                <li><a href="#tab_3" data-toggle="tab">Game submissions</a></li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane active" id="tab_1">
                    <div class="game-jam-dates">
                        <div class="game-jam-date" data-date="{{$gameJam->startDate}}">
                            <em><!--{{date("l", $gameJam->startDate)}}--></em>
                            <strong><!--{{date("F", $gameJam->startDate)}}--></strong>
                            <span><!--{{date("j", $gameJam->startDate)}}--></span>
                            <i class="game-jam-date-time"></i>
                            <i class="game-jam-date-tooltip">Start date</i>
                        </div>
                        <div class="game-jam-date" data-date="{{$gameJam->endDate}}">
                            <em><!--{{date("l", $gameJam->endDate)}}--></em>
                            <strong><!--{{date("F", $gameJam->endDate)}}--></strong>
                            <span><!--{{date("j", $gameJam->endDate)}}--></span>
                            <i class="game-jam-date-time" ></i>
                            <i class="game-jam-date-tooltip">End date</i>
                        </div>
                        <div class="game-jam-date" data-date="{{$gameJam->votingEndDate}}">
                            <em><!--{{date("l", $gameJam->votingEndDate)}}--></em>
                            <strong><!--{{date("F", $gameJam->votingEndDate)}}--></strong>
                            <span><!--{{date("j", $gameJam->votingEndDate)}}--></span>
                            <i class="game-jam-date-time"></i>
                            <i class="game-jam-date-tooltip">Voting end date</i>
                        </div>
                    </div>
                    <div id="contentText" data-val="{{ $gameJam->content }}"></div>
                </div>
                <!-- /.tab-pane -->
                <div class="tab-pane" id="tab_2">
                    @if(count($gameJam->participants) > 0)
                        @foreach($gameJam->participants as $participant)
                            <div class="game-jam-participant-tab-row">
                                <img src="{{ asset($participant->avatarImagePath) }}"/>
                                <a href="{{ asset('/user/' . $participant->username) }}">{{ $participant->username }}</a>
                            </div>
                        @endforeach
                    @else
                        <i>There are no participants in this game jam.</i>
                    @endif
                </div>
                <div class="tab-pane" id="tab_3">
                    @if(count($gameJam->submissions) > 0)
                        @foreach($gameJam->submissions as $submission)
                            <div class="game-jam-submission-tab-row">
                                <div class="game-jam-submission-tab-row-info">
                                    <img src="{{ asset($submission->path) }}"/>
                                </div>
                                <div class="game-jam-submission-tab-row-info">
                                    <a href="{{ asset('/games/' . $submission->idGameSubmission) }}">{{ $submission->title }}</a>
                                    <p>by<a href="{{ asset('/user/' . $submission->username) }}">{{$submission->username}}</a></p>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <i>There are no game submissions in this game jam.</i>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('jsfiles')
<script src="https://cdnjs.cloudflare.com/ajax/libs/showdown/1.8.6/showdown.min.js"></script>
<script>
    window.addEventListener("load", function(){
        var scroll = Math.floor($(window).scrollTop() * 0.2 - 150);

        $(".game-cover-image").css("transform", "translate3d(0, " + scroll + "px, 0");

        $('.nav-tabs-custom ul.nav-tabs li a').click(function (e) {
            $('ul.nav-tabs li.active').removeClass('active');
            $(this).parent('li').addClass('active');
        })

        $(window).scroll(function(){
            scroll = Math.floor($(window).scrollTop() * 0.2 - 150);
            $(".game-cover-image").css("transform", "translate3d(0, " + scroll + "px, 0");
        });

        slamjam.common.confirmBox($("#btn-remove-game-jam"));
        slamjam.common.confirmBox($("#game-jam-leave-button"));

        $(".game-jam-date").each(function(){
            var formattedDate = slamjam.common.getDateComponents(new Date($(this).attr("data-date") * 1000));
            $(this).find("em").html(formattedDate.dayName);
            $(this).find("strong").html(formattedDate.monthName);
            $(this).find("span").html(formattedDate.day);
            $(this).find(".game-jam-date-time").html(formattedDate.time);
        });
    });
   
    function getTimeRemaining(endtime) {
        var t = Date.parse(endtime) - Date.parse(new Date());
        var seconds = Math.floor((t / 1000) % 60);
        var minutes = Math.floor((t / 1000 / 60) % 60);
        var hours = Math.floor((t / (1000 * 60 * 60)) % 24);
        var days = Math.floor(t / (1000 * 60 * 60 * 24));
        return {
            'total': t,
            'days': days,
            'hours': hours,
            'minutes': minutes,
            'seconds': seconds
        };
    }

    function initializeClock(id, endtime) {
        var clock = document.getElementById(id);
        var daysSpan = clock.querySelector('.days');
        var hoursSpan = clock.querySelector('.hours');
        var minutesSpan = clock.querySelector('.minutes');
        var secondsSpan = clock.querySelector('.seconds');

        function updateClock() {
            var t = getTimeRemaining(endtime);

            daysSpan.innerHTML = t.days;
            hoursSpan.innerHTML = ('0' + t.hours).slice(-2);
            minutesSpan.innerHTML = ('0' + t.minutes).slice(-2);
            secondsSpan.innerHTML = ('0' + t.seconds).slice(-2);

            if (t.total <= 0) {
                clearInterval(timeinterval);
            }
        }

        updateClock();
        var timeinterval = setInterval(updateClock, 1000);
    }

    var deadline = new Date(Date.parse(new Date()) + @if($gameJam->startDate > time())
            {{ $gameJam->startDate - time() }} 
        @elseif($gameJam->startDate < time() && $gameJam->endDate > time())
            {{ $gameJam->endDate - time() }}
        @else
            {{ $gameJam->votingEndDate - time() }}
        @endif 
    * 1000);
    initializeClock('clockdiv', deadline);

    var converter = new showdown.Converter(),
    $contentText = $("#contentText"),
    text = $contentText.attr('data-val'),
    html = converter.makeHtml(text);
    
    $contentText.html(html);
</script>
@endsection