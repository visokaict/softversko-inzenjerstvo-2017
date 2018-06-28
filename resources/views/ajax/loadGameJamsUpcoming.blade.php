<div class="game-jams-content">
    <div id="load" style="position: relative;">
        @if(count($upcomingGameJams))

            @foreach($upcomingGameJams as $gameJam)
                <div class="col-lg-4 col-sm-6 portfolio-item">
                    <div class="card h-100">
                        <a href="{{asset('game-jams/'. $gameJam->idGameJam)}}"><img class="card-img-top game-jams-item-img" style="height: 190px; object-fit: cover;" src="{{asset($gameJam->path)}}" alt="{{$gameJam->alt}}"></a>
                        <div class="card-body">
                            <h4 class="card-title">
                                <a href="{{asset('game-jams/'. $gameJam->idGameJam)}}">{{ $gameJam->title }}</a>
                            </h4>
                            <h6 class="card-subtitle mb-2 text-muted">Hosted by: <a href="{{asset('user/'. $gameJam->username)}}">{{ $gameJam->username }}</a></h6>
                            <p class="card-text margin-bottom-5">Starts in <span>
                                @if(($gameJam->startDate - time()) / 3600 > 24)
                                    {{ floor(($gameJam->startDate - time()) / 3600 / 24) . " days" }}
                                @else
                                    {{ ceil(($gameJam->startDate - time()) / 3600) . " hr" }}
                                @endif
                            </span></p>
                            <p class="card-subtitle mb-2 text-muted p-joind-submissions">{{$gameJam->countJoined}}<span> joined</span></p>
                        </div>
                    </div>
                </div>
            @endforeach

        @else
            <i>There are currently no game jams.</i>
        @endif

    </div>
    <div class="clearfix"></div>
</div>
<div class="row">
    <ul class="pagination pagination-game-jams" id="pagination-game-jams-upcoming">
        @for($i = 0; $i < ceil($gamesJamsUpcomingCount / 6); $i++)
            <li class="page-item @if($currentPageGameJamsUpcoming == $i + 1) {{ 'active' }} @endif"><a href="#" data-page="{{ $i + 1 }}" data-type="upcoming" class='page-link-game-jams-upcoming'>{{ $i + 1 }}</a></li>
        @endfor
    </ul>
</div>