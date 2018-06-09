<div class="game-jams-content">
    <div id="load" style="position: relative;">
        @foreach($inProgressGameJams as $gameJam)
            <div class="col-lg-4 col-sm-6 portfolio-item">
                <div class="card h-100">
                    <a href="{{asset('game-jams/'. $gameJam->idGameJam)}}"><img class="card-img-top" style="height: 190px; object-fit: cover;" src="{{asset($gameJam->path)}}" alt="{{$gameJam->alt}}"></a>
                    <div class="card-body">
                        <h4 class="card-title">
                            <a href="{{asset('game-jams/'. $gameJam->idGameJam)}}">{{ $gameJam->title }}</a>
                        </h4>
                        <h6 class="card-subtitle mb-2 text-muted">Hosted by: <a href="{{asset('users/'. $gameJam->username)}}">{{ $gameJam->username }}</a></h6>
                        <p class="margin-bottom-5">Submissions closes in: <span>
                            @if(($gameJam->endDate - time()) / 3600 > 24)
                                {{ floor(($gameJam->endDate - time()) / 3600 / 24) . " days" }}
                            @else
                                {{ ceil(($gameJam->endDate - time()) / 3600) . " hr" }}
                            @endif
                        </span></p>
                        <div class="progress">
                            <div class="progress-bar" role="progressbar" aria-valuenow="50" aria-valuemin="0"
                                    aria-valuemax="100" style="width: {{ floor(((time() - $gameJam->startDate) / ($gameJam->endDate - $gameJam->startDate)) * 100) }}%;">
                            </div>
                        </div>
                        <p class="card-subtitle mb-2 text-muted p-joind-submissions">X<span> joined</span> Y <span>submissions</span>
                        </p>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    <div class="clearfix"></div>
</div>
<div class="row">
    <ul class="pagination" id="pagination-game-jams-in-progress">
        @for($i = 0; $i < ceil($gamesJamsInProgressCount / 6); $i++)
            <li class="page-item @if($currentPageGameJamsInProgress == $i + 1) {{ 'active' }} @endif"><a href="#" data-page="{{ $i + 1 }}" class='page-link-game-jams-in-progress'>{{ $i + 1 }}</a></li>
        @endfor
    </ul>
</div>