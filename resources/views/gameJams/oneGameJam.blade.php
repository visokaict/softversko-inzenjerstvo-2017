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

<div class="game-cover-image">
    <p class="text-center">SLIDER</p>
</div>
<div class="game-header">
    <div class="game-header-inner container">
        <div class="game-header-left float-left">
            <h2 class="game-jam-header-title">Optical Jam #5</h2>
            <div>
                Hosted by <a href="#">Some guy</a>
            </div>
        </div>
        <div class="game-header-right float-right">
            <div class="row text-center">
                <div class="col-md-4">
                <div>123</div>
                <div>joined</div>
                </div>
                <div class="col-md-4">
                    <div>10</div>
                    <div>submissions</div>
                </div>
                <div class="col-md-4">
                    <div>1000</div>
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
    <div class="row">

        <div class="countdown-timer text-center">
            <h1>Starts in</h1>
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
            <div class="game-jam-join-button-holder">
                <button class="game-jam-join-button">Join game jam</button>
            </div>
            
        </div>
        </div>

        <div class="game-jam-description">Description</div>

        <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
            <li class="active"><a href="#tab_1" data-toggle="tab">Overview</a></li>
            <li><a href="#tab_2" data-toggle="tab">Participants</a></li>
            </ul>
            <div class="tab-content">
            <div class="tab-pane active" id="tab_1">
                
                
                <div id="contentText" data-val="#hello, markdown!"></div>

                <h4>Criterias: </h4>
                <ul>
                <li>Gameplay</li>
                <li>Design</li>
                </ul>


            </div>
            <!-- /.tab-pane -->
            <div class="tab-pane" id="tab_2">
                load them with ajax, only once
                only like image and maybe username 
                with href to ther pprofile
            </div>
            
            </div>
        </div>

        
    </div>
    </div>
</div>

  


@endsection


@section('jsfiles')
<script>
  $('.nav-tabs-custom ul.nav-tabs li a').click(function (e) {
    $('ul.nav-tabs li.active').removeClass('active')
    $(this).parent('li').addClass('active')
  })
</script>

<script>
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

  var deadline = new Date(Date.parse(new Date()) + 105 * 24 * 60 * 60 * 1000);
  initializeClock('clockdiv', deadline);
</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/showdown/1.8.6/showdown.min.js"></script>
<script>
  var converter = new showdown.Converter(),
  $contentText = $("#contentText"),
  text = $contentText.attr('data-val'),
  html      = converter.makeHtml(text);
  
  $contentText.html(html);
</script>
@endsection